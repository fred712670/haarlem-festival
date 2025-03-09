<?php 
require_once __DIR__ . "/../../controllers/UserController.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"] ?? null;
    $newPassword = $_POST["password"] ?? null;

    if (!$token || !$newPassword) die("❌ Invalid request.");
    
    echo UserController::processResetPassword($token, $newPassword);
} else {
    die("❌ Invalid request method.");
}
?>
