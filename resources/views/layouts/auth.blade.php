@extends('laracrud::layouts.app')

@section('parent-content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a href="{{ url('/') }}" class="navbar-brand">
                <i class="fal {{ config('laracrud.icon') }}"></i> {{ config('app.name') }}
            </a>
            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @include('laracrud::layouts.nav')
                    <li class="nav-item dropdown">
                        <a href="#" id="userDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('profile') }}" class="dropdown-item{{ request()->is('profile') ? ' active' : '' }}">Profile</a>
                            <a href="{{ route('password') }}" class="dropdown-item{{ request()->is('password') ? ' active' : '' }}">Password</a>
                            <form method="POST" action="{{ route('logout') }}" data-ajax-form>
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @yield('child-content')
    </div>
@endsection