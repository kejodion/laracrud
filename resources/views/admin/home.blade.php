@extends('laracrud::layouts.auth')

@section('title', 'Home')
@section('child-content')
    <h2 class="mb-3">@yield('title')</h2>

    <div class="card">
        <div class="card-body">
            You are logged in!
        </div>
    </div>
@endsection