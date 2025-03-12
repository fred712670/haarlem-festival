<div class="auth-container">
    <h2>Reset Password</h2>
    <form action="/process-reset-password" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['reset_token'] ?? '') ?>">
        
        <label for="password">New Password</label>
        <input type="password" name="password" placeholder="Enter new password" required>
        
        <button type="submit">Reset Password</button>
    </form>
    
    <div class="auth-links">
        <a href="/login">Back to Login</a>
    </div>
</div>