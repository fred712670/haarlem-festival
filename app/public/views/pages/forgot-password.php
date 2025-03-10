<?php
require_once __DIR__ . '/../partials/header.php';
?>

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

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
