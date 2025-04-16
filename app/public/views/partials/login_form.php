<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
<div class="auth-container">
    <h2>Login</h2>
    <form action="/login" method="POST">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>
    
        <?php if(isset($error)){ ?>
            <p style ="color: red;, text-align: center;"><?php echo $error; ?></p>
        <?php } ?>

        <button type="submit">Log In</button>
    </form>
    <p class="auth-links">
        <a href="/forgot-password">Forgot Password?</a><br>
        <a href="/registration">Don't have an account? Register</a>
    </p>
</div>
</body>
</html>