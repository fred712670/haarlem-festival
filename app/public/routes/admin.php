<?php
/**
 * Routes for admin user management functionality
 */
require_once(__DIR__ . "/../controllers/AdminUserController.php");
require_once(__DIR__ . '/../controllers/EventManagementController.php');

/**
 * Middleware to check if user is an administrator
 */
function requireAdmin() {
    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
        $_SESSION['error_message'] = 'You must be logged in to access this page.';
        header('Location: /login');
        exit();
    }
    
    // Check if the role exists and equals Administrator (case-insensitive)
    if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) != 'admin') {
        $_SESSION['error_message'] = 'You must be an administrator to access this page.';
        header('Location:/');
        exit();
    }
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
        'endDate' => $_GET['endDate'] ?? ''
    ];
    
    $searchTerm = $_GET['search'] ?? '';
    $sortBy = $_GET['sortBy'] ?? 'FullName';
    $sortOrder = $_GET['sortOrder'] ?? 'asc';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    
    // Get data for the view
    $viewData = $controller->index($filters, $searchTerm, $sortBy, $sortOrder, $page);
    $viewData['roles'] = $controller->getRoles();
    
    require_once(__DIR__ . "/../views/pages/admin.php");
}, 'get');

// Form to create a new user
Route::add('/admin/users/create', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    $roles = $controller->getRoles();
    
    require_once(__DIR__ . "/../views/pages/create_user.php");
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
    
    require_once(__DIR__ . "/../views/pages/edit_user.php");
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
    
    require_once(__DIR__ . "/../views/pages/reset_password.php");
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
    
    require_once(__DIR__ . "/../views/pages/delete_user.php");
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

// Homepage management
// Load homepage content management view
Route::add('/admin/homepage-management', function () {
    // Ensure only admin can access
    requireAdmin(); 
    try {
        $controller = new EventManagementController();
        // Load the main page
        $controller->manageHomepage(); 
    } catch (Throwable $e) {
        error_log("Homepage management error: " . $e->getMessage());
    }
});

// Store new homepage slide 
Route::add('/admin/homepage-management/store-slide', function () {
    requireAdmin();
    try {
        $controller = new EventManagementController();
        // Insert new slide into DB
        $controller->storeSlide(); 
    } catch (Throwable $e) {
        error_log("Store slide error: " . $e->getMessage());
    }
}, 'post');

// Update existing homepage slide 
Route::add('/admin/homepage-management/update-slide', function () {
    requireAdmin();
    try {
        $controller = new EventManagementController();
        // Update slide data
        $controller->updateSlide(); 
    } catch (Throwable $e) {
        error_log("Update slide error: " . $e->getMessage());
    }
}, 'post');

// Delete a homepage slide
Route::add('/admin/homepage-management/delete-slide', function () {
    requireAdmin();
    try {
        $controller = new EventManagementController();
        // Delete slide from DB + file
        $controller->deleteSlide(); 
    } catch (Throwable $e) {
        error_log("Delete slide error: " . $e->getMessage());
    }
});

// Update general homepage content
Route::add('/admin/homepage-management/update-content', function () {
    requireAdmin();
    try {
        $controller = new EventManagementController();
        // Update content row
        $controller->updateContent(); 
    } catch (Throwable $e) {
        error_log("Update content error: " . $e->getMessage());
    }
}, 'post');

// Store new content (location/event card) (POST)
Route::add('/admin/homepage-management/store-content', function () {
    requireAdmin();
    try {
        $controller = new EventManagementController();
        // Insert new row into Content table
        $controller->storeContent(); 
    } catch (Throwable $e) {
        error_log("Store content error: " . $e->getMessage());
    }
}, 'post');

// Delete a content row (location/event card)
Route::add('/admin/homepage-management/delete-content', function () {
    requireAdmin();
    try {
        $controller = new EventManagementController();
        // Remove content from DB
        $controller->deleteContent(); 
    } catch (Throwable $e) {
        error_log("Delete content error: " . $e->getMessage());
    }
});
