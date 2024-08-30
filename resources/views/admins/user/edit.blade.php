@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{ route('admin.user.index') }}">Back to list</a>
        <h1>Update Form User</h1>
        <form method="POST" action="{{ route('admin.user.update',$user) }}">
            @csrf
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" value="{{ old('name',$user->name) }}" placeholder="Enter name"
                    name="name">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" value="{{ old('phone',$user->phone) }}" placeholder="Enter phone"
                    name="phone">
                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 mt-3">
                <label for="role" class="form-label">Course:</label>
                <select class="form-select" name="course_id">
                    <option value="">---Choose course---</option>
                    @foreach ($courses as $item)
                        <option value="{{ $item->id }}" {{$item->id==$user->course_id?'selected':''}}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
