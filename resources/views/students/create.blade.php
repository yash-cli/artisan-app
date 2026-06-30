@extends('layouts.app')

@section('title', 'Create Student')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Create Student</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('students.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Student Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Student Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="button" id="add-parent-btn" class="btn btn-outline-success btn-sm">Add Parents</button>
                            <button type="button" id="remove-parent-btn" class="btn btn-outline-danger btn-sm d-none">Remove Parents</button>
                            <input type="hidden" name="has_parent" id="has_parent" value="{{ old('has_parent', '0') }}">
                        </div>

                        <div id="parent-fields" class="d-none border p-3 rounded mb-4 bg-light">
                            <h6 class="mb-3 text-muted">Parent Information</h6>
                            <div class="form-group mb-3">
                                <label for="parent_name" class="form-label">Parent Name</label>
                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" id="parent_name" name="parent_name" value="{{ old('parent_name') }}">
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label for="parent_email" class="form-label">Parent Email</label>
                                <input type="email" class="form-control @error('parent_email') is-invalid @enderror" id="parent_email" name="parent_email" value="{{ old('parent_email') }}">
                                @error('parent_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#add-parent-btn').click(function() {
                $('#parent-fields').removeClass('d-none');
                $(this).addClass('d-none');
                $('#remove-parent-btn').removeClass('d-none');
                $('#has_parent').val('1');
            });

            $('#remove-parent-btn').click(function() {
                $('#parent-fields').addClass('d-none');
                $(this).addClass('d-none');
                $('#add-parent-btn').removeClass('d-none');
                $('#has_parent').val('0');
                $('#parent_name').val('');
                $('#parent_email').val('');
            });

            @if(old('has_parent') == '1' || $errors->has('parent_name') || $errors->has('parent_email'))
                $('#add-parent-btn').trigger('click');
            @endif
        });
    </script>
@endpush
