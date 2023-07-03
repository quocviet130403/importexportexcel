<?php

namespace App\Imports;

use App\Models\Event;
use App\Models\Guest;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class GuestImport implements ToModel, WithChunkReading, WithValidation, SkipsOnError, WithStartRow
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private int $eventId;
    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }
    public function model(array $row)
    {
        $qrcode = strtoupper(md5($row[0] . $row[1] . $this->eventId . Carbon::now()->timestamp));
        $listcheckMSSVEvent = Event::find($this->eventId)->guests()->pluck('mssv')->toArray();

        if (!in_array($row[1], $listcheckMSSVEvent)) {
            $tempDir = storage_path('app/public/files/excel/');
            if (!file_exists($tempDir)) {
                mkdir($tempDir);
            }

            $qrCode = QrCode::format('png')->size(200)->generate(route('client.storeQR', $qrcode));
            $image = \Intervention\Image\Facades\Image::make($qrCode->toHtml());
            $filename = Str::slug($row[0]) . '-' . $row[1] . '-' . $this->eventId . '.png';
            $imagePath = $tempDir . $filename;
            $image->save($imagePath);

            // $image_path = url('/storage/files/excel/' . $filename);

            // return new Guest([
            //     'fullname' => $row[0],
            //     'mssv' => $row[1],
            //     'qrcode' => $qrcode,
            //     'event_id' => $this->eventId
            // ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
    public function rules(): array
    {
        return [
            '0' => ['required'],
            '1' => ['required']
        ];
    }
    public function chunkSize(): int
    {
        return 50; // Set the chunk size for reading data
    }
}
