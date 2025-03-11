<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="auth-container">
    <h2>Login</h2>
    <form action="/login" method="POST">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Log In</button>
    </form>
    <p class="auth-links">
        Don't have an account?
        <a href="/registration">Sign Up</a>
    </p>
</div>
</body>
</html>