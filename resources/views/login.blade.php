<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cafe</title>
</head>
<body>
    
    <h2>Login Cafe</h2>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="{{ route('proses.login') }}" method="POST">

        @csrf

        <label>Username</label>
        <br>
        <input type="username" name="username" required>

        <br><br>

        <label>Password</label>
        <br>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">LOGIN</button>

    </form>
</body>
</html>