@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.course.index') }}">Back to list</a>
        <h1>Edit form achive course</h1>
        <form method="POST" action="{{ route('admin.achiveCourse.update',$achiveCourse) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" 
                value="{{$achiveCourse->title}}"
                placeholder="Enter title" name="title">
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="" cols="30" rows="10" name="description">{{$achiveCourse->description}}</textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="thumbnail" class="form-label">Thumbnail:</label>
                <input type="file" class="form-control" name="thumbnail">
            </div>
            <div class="mb-3 mt-3">
                <label for="thumbnail" class="form-label">Current Image:</label>
                <input type="hidden" value="{{$achiveCourse->thumbnail}}" name="thumbnailExisted">
                <img src="{{$achiveCourse->thumbnail}}" width="100" class="thumbnail"/>
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                        id="checkAchive" name="status" value="1" {{$achiveCourse->status?"checked":""}}>
                    <label class="form-check-label" for="checkAchive">Status</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
