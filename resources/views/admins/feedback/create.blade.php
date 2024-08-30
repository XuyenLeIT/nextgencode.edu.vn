@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.feedback.index') }}">Back to list</a>
        <h1>Create form feedback</h1>
        <form method="POST" action="{{ route('admin.feedback.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="avatar" class="form-label">Avatar:</label>
                <input type="file" class="form-control" name="avatar">
                @error('avatar')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" name="content">{{old('content')}}</textarea>
                @error('content')
                    <p class="text-danger">{{ $message }}</p>
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
                        {{ (old('status') == null || old('status'))? '' : 'checked' }}>
                    <label class="form-check-label" for="check2">DisActive</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
@endsection
