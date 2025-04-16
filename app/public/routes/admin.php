<?php
/**
 * Routes for admin user management functionality
 */
require_once(__DIR__ . "/../controllers/AdminUserController.php");
require_once(__DIR__ . '/../controllers/EventManagementController.php');
require_once(__DIR__ . "/../controllers/JazzManagementController.php");

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
Route::add('/admin/homepage-management', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->manageHomepage();
});

Route::add('/admin/homepage-management/store-slide', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->storeSlide();
}, 'post');

Route::add('/admin/homepage-management/update-slide', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->updateSlide();
}, 'post');

Route::add('/admin/homepage-management/delete-slide', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->deleteSlide();
});

Route::add('/admin/homepage-management/update-content', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->updateContent();
}, 'post');

Route::add('/admin/homepage-management/store-content', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->storeContent();
}, 'post');

Route::add('/admin/homepage-management/delete-content', function () {
    requireAdmin();
    $controller = new EventManagementController();
    $controller->deleteContent();
});
// Jazz Management Dashboard
Route::add('/admin/jazz', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->dashboard();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz.php");
}, 'get');

// Artist Management
Route::add('/admin/jazz/artists', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listArtists();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_artists.php");
}, 'get');

Route::add('/admin/jazz/artists/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_artist_form.php");
}, 'get');

Route::add('/admin/jazz/artists/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->createArtist($_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/jazz/artists');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/jazz/artists/create');
    }
    exit();
}, 'post');

Route::add('/admin/jazz/artists/edit/([0-9]+)', function($artistId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $artist = $controller->getArtist($artistId);
    
    if (!$artist) {
        $_SESSION['error_message'] = 'Artist not found.';
        header('Location: /admin/jazz/artists');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_artist_form.php");
}, 'get');

Route::add('/admin/jazz/artists/edit/([0-9]+)', function($artistId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->updateArtist($artistId, $_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/jazz/artists');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/jazz/artists/edit/{$artistId}");
    }
    exit();
}, 'post');

Route::add('/admin/jazz/artists/delete/([0-9]+)', function($artistId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $artist = $controller->getArtist($artistId);
    
    if (!$artist) {
        $_SESSION['error_message'] = 'Artist not found.';
        header('Location: /admin/jazz/artists');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_artist_delete.php");
}, 'get');

Route::add('/admin/jazz/artists/delete/([0-9]+)', function($artistId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->deleteArtist($artistId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/jazz/artists');
    exit();
}, 'post');

// Event/Performance Management
Route::add('/admin/jazz/events', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listEvents();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_events.php");
}, 'get');

Route::add('/admin/jazz/events/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->getEventFormData();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_event_form.php");
}, 'get');

Route::add('/admin/jazz/events/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->createEvent($_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/jazz/events');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/jazz/events/create');
    }
    exit();
}, 'post');

Route::add('/admin/jazz/events/edit/([0-9]+)', function($eventId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->getEvent($eventId);
    
    if (!$viewData['event']) {
        $_SESSION['error_message'] = 'Event not found.';
        header('Location: /admin/jazz/events');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_event_form.php");
}, 'get');

Route::add('/admin/jazz/events/edit/([0-9]+)', function($eventId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->updateEvent($eventId, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/jazz/events');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/jazz/events/edit/{$eventId}");
    }
    exit();
}, 'post');

Route::add('/admin/jazz/events/delete/([0-9]+)', function($eventId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->getEvent($eventId);
    
    if (!$viewData['event']) {
        $_SESSION['error_message'] = 'Event not found.';
        header('Location: /admin/jazz/events');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_event_delete.php");
}, 'get');

Route::add('/admin/jazz/events/delete/([0-9]+)', function($eventId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->deleteEvent($eventId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/jazz/events');
    exit();
}, 'post');

// Venue Management
Route::add('/admin/jazz/venues', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listVenues();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_venues.php");
}, 'get');

Route::add('/admin/jazz/venues/create', function() {
    // Use the existing requireAdmin function
    requireAdmin();
    
    $controller = new JazzManagementController();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $controller->createVenue($_POST);
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            header('Location: /admin/jazz/venues');
            exit();
        } else {
            $_SESSION['error_message'] = $result['message'];
            $viewData = $controller->getVenueFormData();
            $viewData['formData'] = $_POST;
            require __DIR__ . '/../views/pages/admin_jazz_venue_form.php';
            exit();
        }
    }
    
    $viewData = $controller->getVenueFormData();
    require __DIR__ . '/../views/pages/admin_jazz_venue_form.php';
}, ['get', 'post']);

Route::add('/admin/jazz/venues/edit/([0-9]+)', function($venueId) {
    // Use the existing requireAdmin function
    requireAdmin();
    
    $controller = new JazzManagementController();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $controller->updateVenue($venueId, $_POST);
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            header('Location: /admin/jazz/venues');
            exit();
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
    }
    
    $viewData = ['venue' => $controller->getVenue($venueId)];
    require __DIR__ . '/../views/pages/admin_jazz_venue_form.php';
}, ['get', 'post']);

Route::add('/admin/jazz/venues/delete/([0-9]+)', function($venueId) {
    // Use the existing requireAdmin function
    requireAdmin();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new JazzManagementController();
        $result = $controller->deleteVenue($venueId);
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
        
        header('Location: /admin/jazz/venues');
        exit();
    }
    
    // If not POST, redirect back to venues page
    header('Location: /admin/jazz/venues');
    exit();
}, ['post']);

// Pass Management
Route::add('/admin/jazz/passes', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listPasses();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_passes.php");
}, 'get');

Route::add('/admin/jazz/passes/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_pass_form.php");
}, 'get');

Route::add('/admin/jazz/passes/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->createPass($_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/jazz/passes');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/jazz/passes/create');
    }
    exit();
}, 'post');

Route::add('/admin/jazz/passes/edit/([0-9]+)', function($passId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $pass = $controller->getPass($passId);
    
    if (!$pass) {
        $_SESSION['error_message'] = 'Pass not found.';
        header('Location: /admin/jazz/passes');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_pass_form.php");
}, 'get');

Route::add('/admin/jazz/passes/edit/([0-9]+)', function($passId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->updatePass($passId, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/jazz/passes');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/jazz/passes/edit/{$passId}");
    }
    exit();
}, 'post');

Route::add('/admin/jazz/passes/delete/([0-9]+)', function($passId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $pass = $controller->getPass($passId);
    
    if (!$pass) {
        $_SESSION['error_message'] = 'Pass not found.';
        header('Location: /admin/jazz/passes');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_pass_delete.php");
}, 'get');

Route::add('/admin/jazz/passes/delete/([0-9]+)', function($passId) {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $result = $controller->deletePass($passId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/jazz/passes');
    exit();
}, 'post');

// Order Management Dashboard
Route::add('/admin/orders', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/AdminOrderController.php");
    $controller = new AdminOrderController();
    
    // Get filters, search, sort parameters from query string
    $filters = [
        'status' => $_GET['status'] ?? '',
        'startDate' => $_GET['startDate'] ?? '',
        'endDate' => $_GET['endDate'] ?? '',
        'minAmount' => $_GET['minAmount'] ?? '',
        'maxAmount' => $_GET['maxAmount'] ?? ''
    ];
    
    $searchTerm = $_GET['search'] ?? '';
    $sortBy = $_GET['sortBy'] ?? 'OrderDate';
    $sortOrder = $_GET['sortOrder'] ?? 'desc';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    
    // Get data for the view
    $viewData = $controller->index($filters, $searchTerm, $sortBy, $sortOrder, $page);
    
    // Add status options for the filter dropdown
    $viewData['statusOptions'] = ['pending', 'paid', 'completed', 'cancelled', 'refunded'];
    
    require_once(__DIR__ . "/../views/pages/admin_orders.php");
}, 'get');

// View Order Details
Route::add('/admin/orders/view/([0-9]+)', function($orderId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/AdminOrderController.php");
    $controller = new AdminOrderController();
    
    $orderData = $controller->getOrder($orderId);
    
    if (!$orderData) {
        $_SESSION['error_message'] = 'Order not found.';
        header('Location: /admin/orders');
        exit();
    }
    
    // Add status options for the status update form
    $statusOptions = ['pending', 'paid', 'completed', 'cancelled', 'refunded'];
    
    require_once(__DIR__ . "/../views/pages/admin_order_details.php");
}, 'get');

// Update Order Status
Route::add('/admin/orders/update-status/([0-9]+)', function($orderId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/AdminOrderController.php");
    $controller = new AdminOrderController();
    
    $status = $_POST['status'] ?? '';
    
    $result = $controller->updateOrderStatus($orderId, $status);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header("Location: /admin/orders/view/{$orderId}");
    exit();
}, 'post');

// Export Orders to Excel
Route::add('/admin/orders/export', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/AdminOrderController.php");
    $controller = new AdminOrderController();
    
    // Get filters from query string
    $filters = [
        'status' => $_GET['status'] ?? '',
        'startDate' => $_GET['startDate'] ?? '',
        'endDate' => $_GET['endDate'] ?? '',
        'minAmount' => $_GET['minAmount'] ?? '',
        'maxAmount' => $_GET['maxAmount'] ?? ''
    ];
    
    $searchTerm = $_GET['search'] ?? '';
    
    $result = $controller->exportOrders($filters, $searchTerm);
    
    if ($result['success']) {
        // Send the file to the browser for download
        $filename = basename($result['filepath']);
        $fileUrl = '/assets/exports/' . $filename;
        
        $_SESSION['success_message'] = 'Orders exported successfully.';
        
        // Redirect to the file for download
        header("Location: {$fileUrl}");
        exit();
    } else {
        $_SESSION['error_message'] = 'Failed to export orders.';
        header('Location: /admin/orders');
        exit();
    }
}, 'get');