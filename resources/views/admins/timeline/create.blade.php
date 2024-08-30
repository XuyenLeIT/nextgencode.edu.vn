@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.timeline.index') }}">Back to list</a>
        <h1>Create form Timeline</h1>
        <form method="POST" action="{{ route('admin.timeline.store') }}">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">title:</label>
                <input type="text" class="form-control" name="title" value="{{old('title')}}">
                @error('title')
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
                <label for="type" class="form-label">Type:</label>
                <select class="form-select" name="type">
                    <option selected value="">--Select Type--</option>
                    <option value="1">Back End</option>
                    <option value="2">Front End</option>
                  </select>
                @error('type')
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
