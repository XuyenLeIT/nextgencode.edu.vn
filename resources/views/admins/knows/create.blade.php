@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.knows.index') }}">Back to list</a>
        <h1>Create form Knows</h1>
        <form method="POST" action="{{ route('admin.knows.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{old('title')}}" placeholder="Enter title" name="title">
            </div>
            <div class="mb-3 mt-3">
                <label for="sort_content" class="form-label">Sort content:</label>
                <textarea type="text" id="sort_content" class="form-control" rows="4" name="sort_content">{{old('sort_content')}}</textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="thumbnail" class="form-label">Thumbnail:</label>
                <input type="file" class="form-control" name="thumbnail">
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check1" name="status" value="1" checked>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Description:</label>
                <textarea type="text" id="description" class="form-control" rows="10" name="description">{{old('description')}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        $('#description').summernote({
            tabsize:2,
            height:300
        });
        let markupStr = $('#summernote').summernote('code');
        console.log("markupStr: ",markupStr);
    </script>
@endsection
