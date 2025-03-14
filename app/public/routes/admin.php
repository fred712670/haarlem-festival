<?php
/**
 * Routes for admin user management functionality
 */
require_once(__DIR__ . "/../controllers/AdminUserController.php");
require_once(__DIR__ . "/../views/admin/users/index.php");
require_once(__DIR__ . "/../views/admin/users/index.php");

/**
 * Middleware to check if user is an administrator
 * Redirects to login page if not authenticated or not an admin
 */
function requireAdmin() {
    // TEMPORARY TEST CODE - REMOVE BEFORE PRODUCTION
    if (!isset($_SESSION['userId'])) {
        $_SESSION['userId'] = 1;
        $_SESSION['role'] = 'Administrator';
        $_SESSION['fullName'] = 'Test Admin';
    }
    
    // Comment out the original check
    /*
    if (!isset($_SESSION['userId']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrator') {
        $_SESSION['error_message'] = 'You must be an administrator to access this page.';
        header('Location: /login');
        exit();
    }
    */
}

// Admin Dashboard
Route::add('/admin', function() {
    requireAdmin();
    header('Location: /admin/users');
    exit();
});

// User Management Dashboard
Route::add('/admin/users', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    // Get filters, search, sort parameters from query string
    $filters = [
        'role' => $_GET['role'] ?? '',
        'startDate' => $_GET['startDate'] ?? '',
        'endDate' => $_GET['endDate'] ?? '',
        'status' => $_GET['status'] ?? ''
    ];
    
    $searchTerm = $_GET['search'] ?? '';
    $sortBy = $_GET['sortBy'] ?? 'FullName';
    $sortOrder = $_GET['sortOrder'] ?? 'asc';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    
    // Get data for the view
    $viewData = $controller->index($filters, $searchTerm, $sortBy, $sortOrder, $page);
    $viewData['roles'] = $controller->getRoles();
    
    require_once(__DIR__ . "/../views/admin/users/index.php");
}, 'get');

// Form to create a new user
Route::add('/admin/users/create', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    $roles = $controller->getRoles();
    
    require_once(__DIR__ . "/../views/admin/users/create.php");
}, 'get');

// Process new user creation
Route::add('/admin/users/create', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    $fullName = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    $result = $controller->createUser($fullName, $email, $password, $role);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/users');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/users/create');
    }
    exit();
}, 'post');

// Form to edit a user
Route::add('/admin/users/edit/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    $user = $controller->getUser($userId);
    
    if (!$user) {
        $_SESSION['error_message'] = 'User not found.';
        header('Location: /admin/users');
        exit();
    }
    
    $roles = $controller->getRoles();
    
    require_once(__DIR__ . "/../views/admin/users/edit.php");
}, 'get');

// Process user update
Route::add('/admin/users/edit/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    $fullName = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    
    $result = $controller->updateUser($userId, $fullName, $email, $role);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/users');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/users/edit/{$userId}");
    }
    exit();
}, 'post');

// Reset user password form
Route::add('/admin/users/reset-password/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    $user = $controller->getUser($userId);
    
    if (!$user) {
        $_SESSION['error_message'] = 'User not found.';
        header('Location: /admin/users');
        exit();
    }
    
    require_once(__DIR__ . "/../views/admin/users/reset_password.php");
}, 'get');

// Process password reset
Route::add('/admin/users/reset-password/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = 'Passwords do not match.';
        header("Location: /admin/users/reset-password/{$userId}");
        exit();
    }
    
    $result = $controller->resetPassword($userId, $newPassword);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/users');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/users/reset-password/{$userId}");
    }
    exit();
}, 'post');

// Delete user confirmation
Route::add('/admin/users/delete/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    $user = $controller->getUser($userId);
    
    if (!$user) {
        $_SESSION['error_message'] = 'User not found.';
        header('Location: /admin/users');
        exit();
    }
    
    require_once(__DIR__ . "/../views/admin/users/delete.php");
}, 'get');

// Process user deletion
Route::add('/admin/users/delete/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    $result = $controller->deleteUser($userId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/users');
    exit();
}, 'post');


