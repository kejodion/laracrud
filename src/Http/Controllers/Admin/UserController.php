<?php

namespace Kjjdion\Laracrud\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:Admin']);
    }

    public function index()
    {
        $html = app('datatables.html')->columns([
            ['title' => 'Name', 'data' => 'name'],
            ['title' => 'Email', 'data' => 'email'],
            ['title' => 'Role', 'data' => 'role'],
            ['title' => '', 'data' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);
        $html->ajax(route('admin.users.datatables'));
        $html->setTableAttribute('id', 'users_datatables');

        return view('laracrud::admin.users.index', compact('html'));
    }

    public function datatables()
    {
        $datatables = datatables(User::query())
            ->editColumn('actions', function ($user) {
                return view('laracrud::admin.users.datatables.actions', compact('user'));
            })
            ->rawColumns(['actions']);

        return $datatables->toJson();
    }

    public function createModal()
    {
        return view('laracrud::admin.users.create');
    }

    public function create()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
        ]);

        $user = User::create(array_merge(request()->all(), ['password' => Hash::make(request()->input('password'))]));

        return response()->json([
            'flash_now' => ['success', 'User created!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function updateModal(User $user)
    {
        return view('laracrud::admin.users.update', compact('user'));
    }

    public function update(User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $user->update(request()->all());

        return response()->json([
            'flash_now' => ['success', 'User updated!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function passwordModal(User $user)
    {
        return view('laracrud::admin.users.password', compact('user'));
    }

    public function password(User $user)
    {
        request()->validate([
            'new_password' => 'required|confirmed',
        ]);

        $user->update(['password' => Hash::make(request()->input('new_password'))]);

        return response()->json([
            'flash_now' => ['success', 'Password updated!'],
            'dismiss_modal' => true,
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json([
            'flash_now' => ['success', 'User deleted!'],
            'reload_datatables' => true,
        ]);
    }
}