<?php
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . "/../../models/UserModel.php";

$userModel = new UserModel();
$token = $_GET["token"] ?? null;

if (!$token) {
    die("❌ No token provided in the URL.");
}

$token_hash = hash("sha256", $token);
$user = $userModel->getUserByResetToken($token_hash);

if (!$user) {
    die("❌ Token not found or expired.");
}

?>

<div class="auth-container">
    <h2>Reset Password</h2>
    <form action="/process-reset-password" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        
        <label for="password">New Password</label>
        <input type="password" name="password" placeholder="Enter new password" required>
        
        <button type="submit">Reset Password</button>
    </form>
    
    <div class="auth-links">
        <a href="/login">Back to Login</a>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
