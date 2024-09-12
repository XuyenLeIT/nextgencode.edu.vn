<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        @if (session('message'))
            <div class="alert alert-danger">
                <strong>Danger!</strong>{{session('message')}}
            </div>
        @endif
        <h2>Login Form</h2>
        <form action="{{ route('user.checklogin') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" placeholder="Enter password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
