<?php

namespace Kjjdion\Laracrud\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
}