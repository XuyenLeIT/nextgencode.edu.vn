@extends('layouts.admin')
@section('title', 'Knowledge Page')
@section('content')
    <div class="container">
        @if (!empty($success))
        <div class="alert alert-success">
            <strong>Success!</strong>{{ $success }}
        </div>
        @endif
        <a class="btn btn-primary" href="{{ route('admin.knows.create') }}">Create a new Knows</a>
        <h1>Knowledge List</h1>
        <table class="table knowtable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th width="20%">Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($knows as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @if ($item->thumbnail)
                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}" width="100">
                            @endif
                        </td>
                        <td><span class="des-know">{{ $item->description }}</span></td>
                       
                        <td>
                            {{ $item->status }}
                        </td>
                        <td>
                        <a class="btn btn-warning" href="{{route("admin.knows.edit",$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger" href="{{route("admin.knows.delete",$item->id)}}"><i class="fa-solid fa-trash"></i></a>
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

