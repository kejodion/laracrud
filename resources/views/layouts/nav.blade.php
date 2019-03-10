<li class="nav-item{!! request()->is('admin/users') ? ' class="active"' : '' !!}">
    <a href="{{ route('admin.users') }}" class="nav-link">Users</a>
</li>