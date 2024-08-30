@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <h1>Create form carausel</h1>
        <form method="POST" action="{{ route('admin.banner.store') }}"
             enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" 
                value="{{old('title')}}" placeholder="Enter title" name="title">
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
                <label for="sortContent" class="form-label">sortContent:</label>
                <textarea class="form-control" placeholder="Enter sortContent" rows="5" name="sortContent">{{old('sortContent')}}</textarea>
                @error('sortContent')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check1"
                       name="status" value="1"  {{old('status')?'checked':''}}>
                    <label class="form-check-label" for="check1">Active</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="promotion" class="form-label">promotion:</label>
                <input type="text" class="form-control" 
                value="{{old('promotion')}}" placeholder="Enter promotion" name="promotion">
                @error('promotion')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="startDate" class="form-label">startDate:</label>
                <input type="date" class="form-control" 
                value="{{old('startDate')}}" placeholder="Enter startDate" name="startDate">
                @error('startDate')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
