@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.course.index') }}">Back to list</a>
        @if (session('info'))
        <div class="alert alert-success">
            <strong>Info!</strong> {{session('info')}}
          </div>
        @endif
        <h1>Create form course</h1>
        <form method="POST" action="{{ route('admin.course.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" value="{{ old('name') }}" placeholder="Enter name"
                    name="name">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="duration" class="form-label">Duration:</label>
                <input type="number" class="form-control" value="{{ old('duration') }}" placeholder="Enter duration"
                    name="duration">
                @error('duration')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="startDate" class="form-label">StartDate:</label>
                <input type="date" class="form-control" value="{{ old('startDate') }}" placeholder="Enter startDate"
                    name="startDate">
                @error('startDate')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="thumbnail" class="form-label">Thumbnail:</label>
                <input type="file" class="form-control" name="thumbnail">
                @error('thumbnail')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="letter" class="form-label">Letter:</label>
                <input type="file" class="form-control" name="letter">
                @error('letter')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Type Learn:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check1" name="typeLearn"
                        value="1" {{ old('typeLearn') ? 'checked' : '' }}>
                    <label class="form-check-label" for="check1">Online</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check2" name="typeLearn"
                        value="0" {{ !old('typeLearn') ? 'checked' : '' }}>
                    <label class="form-check-label" for="check2">Offline</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="status1" name="status"
                        value="1" {{ old('status') ? 'checked' : '' }}>
                    <label class="form-check-label" for="status1">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="status2" name="status"
                        value="0" {{ !old('status') ? 'checked' : '' }}>
                    <label class="form-check-label" for="status2">DisActive</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="stunumber" class="form-label">Quantity Student:</label>
                <input type="text" class="form-control" value="{{ old('stunumber') }}" placeholder="Enter quantity student"
                    name="stunumber">
                @error('stunumber')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="hourday" class="form-label">Hour day(h):</label>
                <input type="number" class="form-control" value="{{ old('hourday') }}" placeholder="Enter hourday"
                    name="hourday">
                @error('hourday')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="dayweek" class="form-label">Day Week:</label>
                <input type="number" class="form-control" value="{{ old('dayweek') }}" placeholder="Enter quantity student"
                    name="dayweek">
                @error('dayweek')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="class" class="form-label">Class:</label>
                <input type="text" class="form-control" value="{{ old('class') }}" placeholder="Enter class"
                    name="class">
                @error('class')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
