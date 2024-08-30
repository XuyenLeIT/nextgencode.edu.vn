@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1>Outline of module</h1>
        <a class="btn btn-primary" href="{{ route('admin.course.detail', $id) }}">Back to list</a>
        <div class="d-flex align-items-center justify-content-between mt-2">
            {{-- <h4>Module course: {{$moduleCourse->title}}</h4> --}}
            {{-- admin.moduleOutline.create --}}
            <a class="btn btn-primary" href="{{route('admin.moduleOutline.create')}}">Add item ouline module</a>
        </div>
        <table class="table outline-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th width="20%">Title</th>
                    <th>Status</th>
                    <th width="20%">Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outlines as $item)
                {{-- @dd($item->module_courses()) --}}
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            {{ $item->status }}
                        </td>
                        <td>
                            <span class="ouline-des">{{ $item->description }}</span>
                        </td>
                        <td>
                            <a class="btn btn-warning" href="{{route("admin.moduleOutline.edit",$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-danger" href="{{route("admin.moduleOutline.delete",$item->id)}}"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
