<div class="auth-container">
    <h2>Login</h2>

    <!-- Login form submits via POST to the same /login route -->
    <form action="/login" method="POST">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>

        <!-- Display login error if authentication fails -->
        <?php if (isset($error)) { ?>
            <p style="color: red; text-align: center;">
                <?php echo $error; ?>
            </p>
        <?php } ?>

        <button type="submit">Log In</button>
    </form>

    <!-- Links to reset password and register -->
    <p class="auth-links">
        <a href="/forgot-password">Forgot Password?</a><br>
        <a href="/registration">Don't have an account? Register</a>
    </p>
</div>
