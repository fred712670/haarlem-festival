<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <form action="/login" method="POST">
        <p><label>Username: <input type="text" name="username" required></label></p>
        <p><label>Password: <input type="password" name="password" required></label></p>
        <p><button type="submit">Log In</button></p>
    </form>
</body>
</html>