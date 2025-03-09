<?php
require_once __DIR__ . "/../../controllers/UserController.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    echo UserController::sendResetLink($email); // ✅ Call controller, output success/error
} else {
    die("❌ Invalid request method.");
}
?>
