@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        {{-- <a class="btn btn-primary" href="{{ route('admin.moduleCourse.create',$id) }}">Back to list</a> --}}
        <h1>Create form module outline</h1>
        <form method="POST" action="{{ route('admin.moduleOutline.store') }}">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{ old('title') }}" placeholder="Enter title" name="title">
                @error('title')
                    <p class="text-danger">{$message}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check1" name="status" value="1" checked
                        {{ old('status') ? 'checked' : '' }}>
                    <label class="form-check-label" for="check1">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check2" name="status" value="0"
                        {{ old('status') ? '' : 'checked' }}>
                    <label class="form-check-label" for="check2">DisActive</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" cols="30" rows="10" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-danger">{$message}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        $('#description').summernote({
            tabsize: 2,
            height: 300
        });
    </script>
@endsection
