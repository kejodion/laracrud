@extends('laracrud::layouts.app')

@section('parent-content')
    <nav class="navbar navbar-dark bg-primary">
        <a href="{{ url('/') }}" class="navbar-brand">
            <i class="fal {{ config('laracrud.icon') }}"></i> {{ config('app.name') }}
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" id="userDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                    {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('profile') }}" class="dropdown-item{{ request()->is('profile') ? ' active' : '' }}">Profile</a>
                    <a href="{{ route('password') }}" class="dropdown-item{{ request()->is('password') ? ' active' : '' }}">Password</a>
                    <form method="POST" action="{{ route('logout') }}" data-ajax-form>
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @include('laracrud::layouts.nav')
            </ul>
        </div>
    </nav>

    <div class="container my-4">
        @yield('child-content')
    </div>
@endsection