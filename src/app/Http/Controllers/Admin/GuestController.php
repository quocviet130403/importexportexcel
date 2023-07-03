<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GuestExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\GuestImport;
use App\Jobs\ExportGuest;
use App\Models\Campus;
use App\Models\Guest;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function list()
    {
        $user = Auth::user();
        $events = $user->is_admin() ? Event::orderBy('created_at', 'desc')->get() : $user->campus->events()->orderBy('created_at', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function index()
    {
        //
        // $guests = Guest::all();
        // return view('admin.guests.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $events = Event::all();
        return view('admin.guests.create', compact('events'));
    }

    public function createImport($eventId)
    {
        return view('admin.guests.create', compact('eventId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'file_excel' => 'required|mimes:csv,xlsx,xls',
            'event_id' => 'required'
        ]);


        $import = Excel::import(new GuestImport($request->event_id), $request->file('file_excel'));

        return redirect()->route('guest.show', $request->event_id)->with(['level' => 'success', 'message' => 'Thêm thành công!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = Auth::user();
        if (!$user->is_admin()) {
            $listEventId = $user->campus->events()->pluck('id')->toArray();
            if (!in_array($id, $listEventId)) {
                return redirect()->route('event.list')->with(['level' => 'error', 'message' => 'Bạn không có quyền!']);
            }
        }
        $event = Event::find($id);
        if ($event) {
            $guests = $event->guests ?? [];
            return view('admin.guests.index', compact('guests', 'event'));
        }
        return redirect()->back()->with(['level' => 'error', 'message' => 'Sự kiện thông tồn tại']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guest = Guest::find($id);
        if ($guest) {
            return view('admin.guests.update', compact('guest'));
        }
        return back()->with(['level' => 'error', 'message' => 'Không tồn tại']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guest = Guest::find($id);

        if ($guest) {
            if ($request->updateGuest) {
                $this->validate($request, [
                    'fullname' => 'required',
                    'mssv' => [
                        'required',
                        Rule::unique('guests')->where('id', '<>', $guest->id)->where(function ($query) use ($guest) {
                            return $query->where('event_id', $guest->event->id);
                        })
                    ]
                ]);
                $guest->update([
                    'fullname' => $request->fullname,
                    'mssv' => $request->mssv
                ]);
            } else {
                $guest->update(['status' => $request->status]);
            }
        }
        return back()->with(['level' => 'success', 'message' => 'Update thành công']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::find($id);
        if ($guest) {
            $guest->delete();
            return back()->with(['level' => 'success', 'message' => 'Xóa thành công']);
        }
        return back()->with(['level' => 'error', 'message' => 'Không tồn tại']);
    }

    public function deleteAll($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            $event->guests->each(function($item) {
                $item->delete();
            });
        }
        return back()->with(['level' => 'success', 'message' => 'Xóa thành công']);
    }

    public function downloadQrCodes($eventId)
    {
        // echo "Bao Tri";
        // return;
        $event = Event::find($eventId);

        $guests = $event->guests;
        $tempDir = public_path('image-qr-');
        if (!file_exists($tempDir)) {
            mkdir($tempDir);
        }

        $qrCodePaths = [];
        foreach ($guests as $index => $guest) {
            $qrCode = QrCode::format('png')->size(200)->generate(route('client.storeQR', $guest->qrcode));
            $image = Image::make($qrCode->toHtml());

            // $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $guest->fullname);
            // $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $guest->fullname);
            // $slug = strtolower(trim($slug, '-'));
            // $name = $slug . '-' . $guest->mssv . '-' . $guest->event->id;

            $path = $tempDir . Str::slug($guest->fullname) . '-' . $guest->mssv . '.png';
            $image->save($path);
            $qrCodePaths[] = $path;
        }

        $zipPath = public_path(Str::slug($event->name) . '.zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($qrCodePaths as $path) {
                $filename = basename($path);
                $zip->addFile($path, $filename);
            }
            $zip->close();
        }

        foreach ($qrCodePaths as $path) {
            unlink($path);
        }
        rmdir($tempDir);

        // Download the zip file
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function createEvent()
    {
        $user = Auth::user();
        $campus = Campus::all();
        return view('admin.events.create', compact('user', 'campus'));
    }

    public function storeEvent(Request $request)
    {

        $campus = Campus::find($request->campus_id) ?? Auth::user()->campus;

        $dataValidate = [
            'name' => 'required',
            'image' => 'required',
            'pointX' => 'required',
            'pointY' => 'required',
            'fontSize' => 'required',
            'colorText' => 'required'
        ];

        if (Auth::user()->is_admin()) $dataValidate['campus_id'] = 'required';

        $slugEvent = Str::slug($request->name);
        $listSlugEvent = $campus->events()->pluck('slug')->toArray();
        if (in_array($slugEvent, $listSlugEvent)) {
            $slugEvent = $slugEvent. '-' . Carbon::now()->timestamp;
        }

        $this->validate($request, $dataValidate);

        // $campus->events->each(function ($event) {
        //     $event->update(['status' => 'DISABLE']);
        // });

        Event::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $request->image,
            'pointX' => $request->pointX,
            'pointY' => $request->pointY,
            'campus_id' => $campus->id,
            'fontSize' => $request->fontSize,
            'colorText' => $request->colorText,
            'status' => $request->status
        ]);

        return back()->with(['level' => 'success', 'message' => 'Thêm thành công']);
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        if ($event) {
            $event->delete();
            return back()->with(['level' => 'success', 'message' => 'Xóa thành công']);
        }
        return back()->with(['level' => 'error', 'message' => 'Không tồn tại']);
    }

    public function export($slugEvent)
    {
        $event = Event::where('slug', $slugEvent)->first();
        return Excel::download(new GuestExport($event->id), $slugEvent . '-' . Carbon::now()->timestamp . '.xlsx');
        // dispatch(new ExportGuest($slugEvent));
        // return redirect()->back()->with('success', 'Exporting to Excel queued.');

    }

    public function editEvent($id)
    {
        $event = Event::find($id);
        $user = Auth::user();
        $campus = Campus::all();
        return view('admin.events.edit', compact('event', 'user', 'campus'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::find($id);

        if ($event) {

            $dataValidate = [
                'name' => 'required',
                'image' => 'required',
                'pointX' => 'required',
                'pointY' => 'required',
                'fontSize' => 'required',
                'colorText' => 'required'
            ];

            if (Auth::user()->is_admin()) $dataValidate['campus_id'] = 'required';

            //check slug exxist
            $slugEvent = Str::slug($request->name);
            if ($event->slug !== $slugEvent) {
                $listSlugEvent = $event->campus->events()->where('id', '!=', $id)->pluck('slug')->toArray();
                if (in_array($slugEvent, $listSlugEvent)) {
                    $slugEvent = $slugEvent. '-' . Carbon::now()->timestamp;
                }
            }


            $this->validate($request, $dataValidate);

            // $campus->events->each(function ($event) {
            //     $event->update(['status' => 'DISABLE']);
            // });

            $event->update([
                'name' => $request->name,
                'slug' => $slugEvent,
                'image' => $request->image,
                'pointX' => $request->pointX,
                'pointY' => $request->pointY,
                'fontSize' => $request->fontSize,
                'colorText' => $request->colorText,
                'campus_id' => $event->campus->id,
                'status' => $request->status
            ]);
            return back()->with(['level' => 'success', 'message' => 'Update thành công']);

        }

        return back()->with(['level' => 'error', 'message' => 'Không tồn tại']);
    }
}
