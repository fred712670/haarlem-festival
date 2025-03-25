<?php
// Create this file in your public directory to help debug session issues
session_start();

echo "<h1>Session Debug Information</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Check if the user is logged in
echo "<h2>Login Status</h2>";
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    echo "Logged in as: " . htmlspecialchars($_SESSION['user']) . "<br>";
    echo "Role: " . htmlspecialchars($_SESSION['role']) . "<br>";
    echo "User ID: " . htmlspecialchars($_SESSION['userId'] ?? 'Not set') . "<br>";
    
    // Check admin status
    echo "<h2>Admin Access Check</h2>";
    if ($_SESSION['role'] === 'Administrator') {
        echo "<p style='color: green;'>You have administrator access.</p>";
    } else {
        echo "<p style='color: red;'>You do NOT have administrator access.</p>";
    }
} else {
    echo "<p>Not logged in</p>";
}

// Display database user role for comparison using a proper wrapper class
echo "<h2>Database User Role Check</h2>";
if (isset($_SESSION['userId'])) {
    try {
        // Create a helper class to access the database
        require_once(__DIR__ . "/models/BaseModel.php");
        
        class UserRoleChecker extends BaseModel {
            public function getRoleById($userId) {
                $stmt = self::$pdo->prepare("SELECT Role FROM User WHERE UserId = ?");
                $stmt->execute([$userId]);
                return $stmt->fetchColumn();
            }
        }
        
        $checker = new UserRoleChecker();
        $role = $checker->getRoleById($_SESSION['userId']);
        
        echo "Role in database: " . htmlspecialchars($role ?? 'Not found') . "<br>";
        echo "Case-sensitive comparison with 'Administrator': " . (($role ?? '') === 'Administrator' ? 'Match' : 'No Match') . "<br>";
        echo "Case-insensitive comparison with 'administrator': " . (strtolower($role ?? '') === 'administrator' ? 'Match' : 'No Match');
    } catch (Exception $e) {
        echo "Error checking database role: " . $e->getMessage();
    }
}

// Admin navigation link if you're an admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') {
    echo "<hr>";
    echo "<h2>Admin Navigation</h2>";
    echo "<a href='/admin' style='font-size: 16px; padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Go to Admin Panel</a>";
}
?>