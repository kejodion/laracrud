<?php

namespace Kjjdion\Laracrud\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateModal()
    {
        return view('laracrud::auth.profile');
    }

    protected function update()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);

        auth()->user()->update(request()->all());

        return response()->json([
            'flash_after' => ['success', 'Profile updated!'],
            'reload_page' => true,
        ]);
    }

    public function passwordModal()
    {
        return view('laracrud::auth.password');
    }

    protected function password()
    {
        request()->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);

        auth()->user()->update(['password' => Hash::make(request()->input('new_password'))]);

        return response()->json([
            'flash_now' => ['success', 'Password updated!'],
            'dismiss_modal' => true,
        ]);
    }
}