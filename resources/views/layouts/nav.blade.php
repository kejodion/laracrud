@can('Admin')
    <li class="nav-item{!! request()->is('admin/users') ? ' active' : '' !!}">
        <a href="{{ route('admin.users') }}" class="nav-link">Users</a>
    </li>
@endcan