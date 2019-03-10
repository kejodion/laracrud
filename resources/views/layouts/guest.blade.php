@extends('laracrud::layouts.app')

@section('parent-content')
    <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-lg-4">
                <h2 class="text-center mb-3">
                    <i class="fal {{ config('laracrud.icon') }} text-primary"></i> {{ config('app.name') }}
                </h2>

                <div class="card mb-5">
                    <div class="card-body">
                        @yield('child-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection