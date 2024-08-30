@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.course.index',$id) }}">Back to list</a>
        <h1>Create form achive course</h1>
        <form method="POST" action="{{ route('admin.achiveCourse.store',$id) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" placeholder="Enter title" name="title">
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="" cols="30" rows="10" name="description"></textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="thumbnail" class="form-label">Thumbnail:</label>
                <input type="file" class="form-control" name="thumbnail">
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
