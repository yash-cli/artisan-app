@extends('layouts.app')

@section('title', 'Manage Announcements')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Manage Announcements (Teacher)</h5>
                    <a href="{{ route('teacher.announcements.create') }}" class="btn btn-primary btn-sm">Create Announcement</a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Target Audience</th>
                                    <th>Posted By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $index => $announcement)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $announcement->title }}</td>
                                        <td>{{ Str::limit($announcement->description, 50) }}</td>
                                        <td>
                                            @php
                                                $targetLabel = match($announcement->type->value) {
                                                    'student' => 'Students Only',
                                                    'parents' => 'Parents Only',
                                                    'student_and_parents' => 'Students & Parents',
                                                    default => $announcement->type->value
                                                };
                                            @endphp
                                            <span class="badge bg-light text-dark border">{{ $targetLabel }}</span>
                                        </td>
                                        <td>{{ $announcement->user->name }}</td>
                                        <td>
                                            <a href="{{ route('teacher.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('teacher.announcements.destroy', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No announcements found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
