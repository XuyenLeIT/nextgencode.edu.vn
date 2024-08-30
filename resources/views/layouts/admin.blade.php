<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Course management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Including jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- include summernote editor css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    {{-- font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/root.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="header">
                <div class="logo-container">
                    <div class="logo">
                        <span class="highlight">N</span>ext<span class="highlight">G</span>en<span
                            class="highlight">C</span>ode
                    </div>
                </div>
                <div class="authen-profile">
                    <div class="dropdown">
                        <img class="dropdown-toggle avatar-admin" data-bs-toggle="dropdown"
                            src="https://img.a.transfermarkt.technology/portrait/big/8198-1694609670.jpg?lm=1"
                            class="avatar" alt="avatar" />
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('user.viewchangepass')}}">Change password</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-info btn-sm" href="{{ route('user.logout') }}">Logout</a>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-2 sidebar">
                <p class="sidebar__title text-center">Admin Management</p>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.course.index') }}">Course Manager</a>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.knows.index') }}">Know Manager</a>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.carausel.index') }}">Carausel Manager</a>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.user.index') }}">User Manager</a>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.feedback.index') }}">Feed Manager</a>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.banner.index') }}">Banner Manager</a>
                <a class="btn btn-info mt-2 mt-2 w-100" href="{{ route('admin.timeline.index') }}">Timeline Manager</a>

            </div>
            <main class="col-md-10 main-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
