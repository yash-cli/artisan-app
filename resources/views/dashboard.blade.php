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
                        </div>
                    @endrole

                    @hasanyrole('teacher|admin')
                        <div class="mb-4">
                            <a href="{{ route('students.index') }}" class="btn btn-success">Manage Students</a>
                        </div>
                    @endhasanyrole

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
