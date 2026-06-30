@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Dashboard</h4>
                    <p class="mb-1">Welcome, <strong>{{ auth()->user()->name ?? 'User' }}</strong>.</p>
                    <p class="text-muted mb-4">{{ auth()->user()->email }}</p>

                    @role('admin')
                        <div class="mb-4">
                            <a href="{{ route('teachers.index') }}" class="btn btn-primary">Manage Teachers</a>
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-primary ms-2">Manage Announcements</a>
                        </div>
                    @endrole

                    @hasanyrole('teacher|admin')
                        <div class="mb-4">
                            <a href="{{ route('students.index') }}" class="btn btn-success">Manage Students</a>
                            @role('teacher')
                                <a href="{{ route('teacher.announcements.index') }}" class="btn btn-outline-success ms-2">Manage Announcements</a>
                            @endrole
                        </div>
                    @endhasanyrole

                    <div class="mb-4">
                        <a href="{{ route('announcements.index') }}" class="btn btn-info text-white">View Announcements</a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
