@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 80px; height: 80px; font-size: 32px; font-weight: bold; text-transform: uppercase;">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                    </div>
                    
                    <h2 class="font-weight-bold mb-1">Welcome, {{ auth()->user()->name ?? 'User' }}!</h2>
                    <p class="text-muted mb-4">{{ auth()->user()->email }}</p>
                    
                    <span class="badge badge-pill badge-primary px-4 py-2 mb-4" style="font-size: 14px;">
                        Role: {{ ucfirst(auth()->user()->roles->first()?->name ?? 'User') }}
                    </span>

                    <hr class="my-4">

                    <p class="text-muted">Use the navigation bar at the top to access your management dashboards, view announcements, or log out of your session.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
