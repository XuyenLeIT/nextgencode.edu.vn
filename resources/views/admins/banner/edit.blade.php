@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        @if (session('info'))
            <div class="alert alert-success">
                <strong>Info!</strong>{{ session('info') }}
            </div>
        @endif
        <h1>Update form carausel</h1>
        <form method="POST" action="{{ route('admin.banner.update', $banner) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{ old('title', $banner->title) }}"
                    placeholder="Enter title" name="title">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="image" class="form-label">CurrentImage:</label>
                <input type="hidden" value="{{ $banner->image }}" name="imageExisting">
                <img src="{{ $banner->image }}" class="img-thumbnail" width="100" />
            </div>
            <div class="mb-3 mt-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" name="image">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="sortContent" class="form-label">sortContent:</label>
                <textarea class="form-control" placeholder="Enter sortContent" rows="5" name="sortContent">{{ old('sortContent', $banner->sortContent) }}</textarea>
                @error('sortContent')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check1" name="status" value="1"
                        {{ old('status', $banner->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="check1">Active</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="promotion" class="form-label">Promotion:</label>
                <input type="text" class="form-control" value="{{ old('promotion', $banner->promotion) }}"
                    placeholder="Enter promotion" name="promotion">
                @error('promotion')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="startDate" class="form-label">startDate:</label>
                <input type="date" class="form-control" value="{{ old('startDate', $banner->startDate) }}"
                    placeholder="Enter startDate" name="startDate">
                @error('startDate')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="course_id" class="form-label">Course:</label>
                <select class="form-select" name="course_id">
                    <option value="">--Choose course--</option>
                    @foreach ($courses as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $banner->course_id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
