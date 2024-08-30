@extends('layouts.admin')
@section('title', 'Carausel Page')
@section('content')
    <div class="container">
        @if (!empty($success))
        <div class="alert alert-success">
            <strong>Success!</strong>{{ $success }}
        </div>
        @endif
        <a class="btn btn-primary" href="{{ route('admin.carausel.create') }}">Create a new Carausel</a>
        <h1>Carausel List</h1>
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
                @foreach ($carausels as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" width="100">
                            @endif
                        </td>
                        <td><span class="des-know">{{ $item->description }}</span></td>
                       
                        <td>
                            {{ $item->status }}
                        </td>
                        <td>
                        <a class="btn btn-warning" href="{{route("admin.carausel.edit",$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger" href="{{route("admin.carausel.delete",$item->id)}}"><i class="fa-solid fa-trash"></i></a>
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

