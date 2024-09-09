@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.course.index',$id) }}">Back to list</a>
        @if (session('message'))
        <div class="alert alert-success">
            <strong>Success!</strong> {{session('message')}}
          </div>
        @endif
        <h1>Create form module course</h1>
        <form method="POST" action="{{ route('admin.moduleCourse.store',$id) }}">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{old('title')}}" placeholder="Enter title" name="title">
                @error('title')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAchive" name="status" value="1" checked>
                    <label class="form-check-label" for="checkAchive">Status</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
