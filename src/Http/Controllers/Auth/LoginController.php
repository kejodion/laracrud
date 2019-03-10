<?php

namespace Kjjdion\Laracrud\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest_role')->except('logout');
    }

    public function loginPage()
    {
        return view('laracrud::auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'redirect' => route(Str::snake($user->role)),
        ]);
    }

    protected function loggedOut(Request $request)
    {
        return response()->json([
            'redirect' => route('login'),
        ]);
    }
}