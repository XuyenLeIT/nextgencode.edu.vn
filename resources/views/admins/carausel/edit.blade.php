@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.carausel.index') }}">Back to list</a>
        <h1>Create form carausel</h1>
        @if (session('info'))
        <div class="alert alert-success">
            <strong>Info!</strong> {{ session('info') }}
        </div>
    @endif
        <form method="POST" action="{{ route('admin.carausel.update', $carausel) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{ old('title', $carausel->title) }}"
                    placeholder="Enter title" name="title">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" name="image">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="image" class="form-label">Current Image:</label>
                <input type="hidden" value="{{ $carausel->image }}" name="imageExisting">
                <img src="/{{ $carausel->image }}" width="100" class="thumbnail" />
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" placeholder="Enter des" rows="5" name="description">{{ old('description', $carausel->description) }}</textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check1" name="status"
                        value="1" {{ old('status',$carausel->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="check1">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check2" name="status"
                        value="0" {{ !old('status',$carausel->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="check2">DisActive</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
