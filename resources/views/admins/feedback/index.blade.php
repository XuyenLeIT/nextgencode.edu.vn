@extends('layouts.admin')
@section('title', 'Knowledge Page')
@section('content')
    <div class="container">
        @if (!empty($success))
        <div class="alert alert-success">
            <strong>Success!</strong>{{ $success }}
        </div>
        @endif
        <a class="btn btn-primary" href="{{ route('admin.feedback.create') }}">Create a new Feedback</a>
        <h4>Feedback List</h4>
        <table class="table knowtable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbacks as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            @if ($item->avatar)
                                <img src="{{ asset($item->avatar) }}" alt="{{ $item->id }}" width="100">
                            @endif
                        </td>
                        <td>
                            {{$item->content}}
                        </td>                       
                        <td>
                            {{ $item->status }}
                        </td>
                        <td>
                        <a class="btn btn-warning" href="{{route("admin.feedback.edit",$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger" href="{{route("admin.feedback.delete",$item->id)}}"><i class="fa-solid fa-trash"></i></a>
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

