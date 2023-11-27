<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="{{ route('auth.google') }}" method="get">
        <button type="submit">Login with Google</button>
    </form>
</body>
</html>
