<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="auth-container">
    <h2>Forgot Password</h2>
    <form method="POST" action="/send-password-reset">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Link</button>
    </form>
    <div class="auth-links">
        <a href="/login">Back to Login</a>
    </div>
</div>
</body>