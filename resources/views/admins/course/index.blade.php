@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        @if (!empty($success))
        <div class="alert alert-success">
            <strong>Success!</strong>{{ $success }}
        </div>
        @endif
        <a class="btn btn-primary" href="{{ route('admin.course.create') }}">Create a new course</a>
        <h1>Course List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Image</th>
                    <th>StartDate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->duration }}</td>
                        <td>
                            @if ($item->thumbnail)
                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}" width="100">
                            @endif
                        </td>
                        <td>
                            {{ $item->startDate }}
                        </td>
                        <td>
                            <a class="btn btn-info" href="{{route("admin.course.detail",$item->id)}}"><i class="fa-solid fa-circle-info"></i></a>
                          <a class="btn btn-warning" href="{{route("admin.course.edit",$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        setTimeout(function() {
            // Closing the alert 
            $('.alert').alert('close');
            console.log("alo 123");
        }, 2000);
    </script>
@endsection

