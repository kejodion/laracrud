@extends('laracrud::layouts.guest')

@section('title', 'Login')
@section('child-content')
    <form method="POST" action="{{ route('login') }}" data-ajax-form>
        @csrf

        <div class="form-group">
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
        </div>

        <div class="form-group">
            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" placeholder="Password">
        </div>

        <div class="form-group form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input"{{ old('remember') ? ' checked' : '' }}>
            <label for="remember" class="form-check-label">Remember</label>
        </div>

        <button type="submit" class="btn btn-block btn-round btn-primary">Login</button>
    </form>
@endsection