<!doctype html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>@yield('title', '')</title>
    @stack('styles')
</head>

<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">School App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    @role('admin')
                    <li class="nav-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('teachers.index') }}">Manage Teachers</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.announcements.index') }}">Manage Announcements</a>
                    </li>
                    @endrole

                    @hasanyrole('teacher|admin')
                    <li class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('students.index') }}">Manage Students</a>
                    </li>
                    @endhasanyrole

                    @role('teacher')
                    <li class="nav-item {{ request()->routeIs('teacher.announcements.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('teacher.announcements.index') }}">Manage Announcements</a>
                    </li>
                    @endrole

                    <li class="nav-item {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('announcements.index') }}">View Announcements</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item text-light mr-3">
                        {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->roles->first()?->name ?? 'User') }})
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="form-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    @yield('content')

    @include('layouts.script')
    @stack('scripts')
</body>

</html>