@extends('laracrud::layouts.modal')

@section('title', 'Update User')
@section('content')
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" data-ajax-form>
        @csrf
        @method('PATCH')

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value=""></option>
                    @foreach(config('laracrud.roles') as $role)
                        <option value="{{ $role }}"{{ old('role', $user->role) == $role ? ' selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-round btn-primary">Save</button>
            <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection