@extends('layouts.app')

@section('title', 'Create Announcement')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Create Announcement (Teacher)</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('teacher.announcements.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label d-block">Target Audience <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('targets') is-invalid @enderror" type="checkbox" name="targets[]" value="student" id="target_student" {{ is_array(old('targets')) && in_array('student', old('targets')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="target_student">Students</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('targets') is-invalid @enderror" type="checkbox" name="targets[]" value="parents" id="target_parents" {{ is_array(old('targets')) && in_array('parents', old('targets')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="target_parents">Parents</label>
                            </div>
                            @error('targets')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('teacher.announcements.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
