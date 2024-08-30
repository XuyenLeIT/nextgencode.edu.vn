@extends('layouts.admin')
@section('title', 'Knowledge Page')
@section('content')
    <div class="container">
        @if (!empty($success))
            <div class="alert alert-success">
                <strong>Success!</strong>{{ $success }}
            </div>
        @endif
        <a class="btn btn-primary" href="{{ route('admin.user.create') }}">Create a new User</a>
        <h1>Student List</h1>
        <div class="col-md-4">
            <form method="GET" action="{{ route('admin.user.index') }}">
                <select class="form-select" name="search">
                    @foreach ($courses as $item)
                        <option value="{{ $item->class }}" {{request('search')== $item->class ?'selected':''}}>{{ $item->class }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary mt-2" type="submit">Search</button>
            </form>
        </div>
        <table class="table usertable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    @if ($item->role != 'admin')
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>

                            <td>
                                @if (!$item->courses_name)
                                    <button class="btn btn-warning" disabled><i class="fa-solid fa-ban"></i></button>
                                @endif
                            </td>
                            <td>
                                @if ($item->status)
                                    <a class="btn btn-success" href="{{ route('admin.user.active', $item->id) }}"><i
                                            class="fa-solid fa-thumbs-up"></i></a>
                                @else
                                    <a class="btn btn-danger" href="{{ route('admin.user.active', $item->id) }}"><i
                                            class="fa-solid fa-thumbs-down"></i></a>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('admin.user.edit', $item->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn btn-danger" href="{{ route('admin.user.delete', $item->id) }}"><i
                                        class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endif
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
