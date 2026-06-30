@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Announcements Feed</h5>
                    <span class="badge bg-secondary">{{ ucfirst(auth()->user()->roles->pluck('name')->first() ?? 'User') }} View</span>
                </div>
                <div class="card-body p-4">
                    @if($announcements->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <p class="mb-0">No announcements found.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($announcements as $announcement)
                                <div class="list-group-item py-4 px-0 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="mb-1 text-primary">{{ $announcement->title }}</h5>
                                        <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-2 text-dark" style="white-space: pre-line;">{{ $announcement->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center text-muted">
                                        <small>Posted by: <strong>{{ $announcement->user->name }}</strong> ({{ ucfirst($announcement->user->roles->pluck('name')->first() ?? 'User') }})</small>
                                        @hasanyrole('admin|teacher')
                                            <span class="badge bg-light text-secondary border">Target: {{ str_replace('_', ' & ', $announcement->type->value) }}</span>
                                        @endhasanyrole
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
