@extends('layouts.admin')

@section('title', 'Des course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.course.index') }}">Back to list</a>
        <h4>Create form Des Course</h4>
        <form method="POST" action="{{ route('admin.desCourse.update', $desC) }}">
            @csrf
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" value="{{ old('title', $desC->title) }}" placeholder="Enter title"
                    name="title">
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check1" name="status"
                        value="{{ old('status', $desC->status) }}" {{ $desC->status ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Description:</label>
                <textarea type="text" id="description" class="form-control" rows="10" name="description">{{ old('description', $desC->description) }}</textarea>
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
                    deletedImages.push(target[0].src);
                    $('#deleted_images').val(JSON.stringify(deletedImages));
                }
            }
        });
    </script>
@endsection
