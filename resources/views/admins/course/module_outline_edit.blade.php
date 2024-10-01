@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        {{-- <a class="btn btn-primary" href="{{ route('admin.moduleCourse.create',$id) }}">Back to list</a> --}}
        <h1>Edit form module outline</h1>
        <form method="POST" action="{{ route('admin.moduleOutline.update', $outline) }}">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{ $outline->title }}" placeholder="Enter title"
                    name="title">
                @error('title')
                    <p class="text-danger">{$message}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check1" name="status" value="1" checked
                        {{ old('status', $outline->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="check1">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="check2" name="status" value="0"
                        {{ old('status', $outline->status) ? '' : 'checked' }}>
                    <label class="form-check-label" for="check2">DisActive</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" cols="30" rows="10" name="description">{{ $outline->description }}</textarea>
                @error('description')
                    <p class="text-danger">{$message}</p>
                @enderror
            </div>
            <input type="hidden" name="deleted_images" id="deleted_images">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
     <script>
        $('#description').summernote({
            tabsize: 2,
            height: 300,
            callbacks: {
                onMediaDelete: function(target) {
                    let deletedImages = $('#deleted_images').val();
                    deletedImages = deletedImages ? JSON.parse(deletedImages) : [];
                    console.log("target[0].src: ",target[0].src);
                    deletedImages.push(target[0].src);
                    $('#deleted_images').val(JSON.stringify(deletedImages));
                }
            }
        });
    </script>
@endsection
