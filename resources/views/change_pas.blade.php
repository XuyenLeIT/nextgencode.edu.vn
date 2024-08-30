<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        @if (session('message'))
            <div class="alert alert-info">
                <strong>Danger!</strong>{{ session('message') }}
            </div>
        @endif
        <h2>Change password Form</h2>
        <form action="{{ route('user.changepass') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label for="email">Email:</label>
                <input type="text" class="form-control" value="{{ old('email') }}" placeholder="Enter email"
                    name="email">
                @error('email')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pwd">Current Password:</label>
                <input type="password" class="form-control" placeholder="Enter password" name="password">
                @error('password')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pwd">New Password:</label>
                <input type="password" class="form-control" placeholder="Enter password" name="newpassword">
                @error('newpassword')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pwd">Confirm Password:</label>
                <input type="password" class="form-control" placeholder="Enter confirm password"
                    name="newpassword_confirmation">
                @error('password_confirmation')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
