<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'regex:/^(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/'
            ],
            'type' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'campus_id' => $request->type === 'ADMIN' ? null : $request->campus_id
        ]);

        return redirect()->route('user.index', $request->event_id)->with(['level' => 'success', 'message' => 'Success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'passwordOld' => 'required',
            'password' => [
                'required',
                'regex:/^(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/'
            ],
        ]);

        if (Hash::check($request->passwordOld, Auth::user()->password)) {
            User::find(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
            return back()->with(['level' => 'success', 'message' => 'Success']);
        }
        return back()->with(['level' => 'error', 'message' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return back()->with(['level' => 'success', 'message' => 'Success']);
        }
        return back()->with(['level' => 'error', 'message' => 'Error']);
    }

    public function changePass()
    {
        $user = Auth::user();
        return view('admin.users.update', compact('user'));
    }
}
