<?php
/**
 * Admin Routes File
 * 
 * This file defines all administrative routes for the application
 * It handles user management, event management (jazz, dance, yummy), order management,
 * and general CMS functionality. All routes require admin authentication.
 * 
 * Route Pattern: /admin/*
 * Authentication: Admin role required
 */

// Import required controllers
require_once(__DIR__ . "/../controllers/AdminUserController.php");
require_once(__DIR__ . '/../controllers/EventManagementController.php');
require_once(__DIR__ . "/../controllers/JazzManagementController.php");

/**
 * Middleware function to check if user has administrator privileges
 * 
 * This function verifies that the current user is:
 * 1. Logged in (has active session)
 * 2. Has administrator role
 * 
 * If not authorized, redirects to login page or home page with error message
 * 
 * @return void
 */
function requireAdmin() {
    // Check if user is logged in by verifying session user data exists
    if (!isset($_SESSION['user'])) {
        $_SESSION['error_message'] = 'You must be logged in to access this page.';
        header('Location: /login');
        exit();
    }
    
    // Check if user has admin role (case-insensitive comparison)
    if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) != 'admin') {
        $_SESSION['error_message'] = 'You must be an administrator to access this page.';
        header('Location:/');
        exit();
    }
}

/**
 * LOGOUT ROUTE
 * 
 * Handles user logout functionality
 * Destroys all session data and redirects to login page
 */
Route::add('/logout', function() {
    // Clear all session data completely
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    header('Location: /login');
    exit();
}, 'get');

/**
 * USER MANAGEMENT SECTION
 * 
 * All routes related to managing users in the admin panel
 * Includes: CRUD operations for users, password resets
 */

/**
 * User Management Dashboard Route
 * 
 * Displays paginated list of users with filtering and sorting capabilities
 * Supports: role filtering, date range filtering, search by name/email
 */
Route::add('/admin/users', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    // Extract filtering parameters from URL query string
    $filters = [
        'role' => $_GET['role'] ?? '',         // Filter by user role
        'startDate' => $_GET['startDate'] ?? '', // Filter by registration start date
        'endDate' => $_GET['endDate'] ?? ''     // Filter by registration end date
    ];
    
    // Search and sort parameters
    $searchTerm = $_GET['search'] ?? '';        // Text search term
    $sortBy = $_GET['sortBy'] ?? 'FullName';    // Field to sort by
    $sortOrder = $_GET['sortOrder'] ?? 'asc';   // Sort direction
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Current page (min 1)
    
    // Get data for the view with applied filters and pagination
    $viewData = $controller->index($filters, $searchTerm, $sortBy, $sortOrder, $page);
    $viewData['roles'] = $controller->getRoles(); // Add role options for filtering
    
    require_once(__DIR__ . "/../views/pages/admin.php");
}, 'get');

/**
 * Create User Form Route
 * 
 * Displays form for creating a new user
 */
Route::add('/admin/users/create', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    $roles = $controller->getRoles(); // Get available roles for dropdown
    
    require_once(__DIR__ . "/../views/pages/create_user.php");
}, 'get');

/**
 * Create User Process Route
 * 
 * Handles POST request to create a new user
 * Validates data and redirects with success/error message
 */
Route::add('/admin/users/create', function() {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    // Extract form data
    $fullName = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    // Attempt to create user
    $result = $controller->createUser($fullName, $email, $password, $role);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/users');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST; // Preserve form data for repopulation
        header('Location: /admin/users/create');
    }
    exit();
}, 'post');

/**
 * Edit User Form Route
 * 
 * Displays form to edit an existing user
 * Dynamic routing parameter: ([0-9]+) captures user ID
 */
Route::add('/admin/users/edit/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    $user = $controller->getUser($userId);
    
    // Handle case where user doesn't exist
    if (!$user) {
        $_SESSION['error_message'] = 'User not found.';
        header('Location: /admin/users');
        exit();
    }
    
    $roles = $controller->getRoles();
    
    require_once(__DIR__ . "/../views/pages/edit_user.php");
}, 'get');

/**
 * Edit User Process Route
 * 
 * Handles POST request to update existing user
 */
Route::add('/admin/users/edit/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    // Extract updated user data
    $fullName = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    
    // Attempt to update user
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

/**
 * Password Reset Form Route
 * 
 * Displays form to reset a user's password
 */
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

/**
 * Password Reset Process Route
 * 
 * Handles POST request to reset user password
 * Includes password confirmation validation
 */
Route::add('/admin/users/reset-password/([0-9]+)', function($userId) {
    requireAdmin();
    
    $controller = new AdminUserController();
    
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    
    // Validate password confirmation
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = 'Passwords do not match.';
        header("Location: /admin/users/reset-password/{$userId}");
        exit();
    }
    
    // Attempt to reset password
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

/**
 * Delete User Confirmation Route
 * 
 * Displays confirmation page before deleting a user
 */
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

/**
 * Delete User Process Route
 * 
 * Handles POST request to delete a user
 */
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

/**
 * JAZZ MANAGEMENT SECTION
 * 
 * All routes for managing jazz events, artists, venues, and passes
 * Includes: CRUD operations for all jazz-related entities
 */

/**
 * Jazz Management Dashboard
 * Displays overview of jazz event management with statistics
 */
Route::add('/admin/jazz', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->dashboard();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz.php");
}, 'get');

/**
 * Jazz Artist Management
 * List all jazz artists with management options
 */
Route::add('/admin/jazz/artists', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listArtists();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_artists.php");
}, 'get');

/**
 * Create Jazz Artist Form
 * Display form for adding new jazz artist
 */
Route::add('/admin/jazz/artists/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_artist_form.php");
}, 'get');

/**
 * Create Jazz Artist Process
 * Handles POST request to create new jazz artist
 * Includes file upload handling for artist images
 */
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

/**
 * Edit Jazz Artist Form
 * Display form for editing existing jazz artist
 */
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

/**
 * Edit Jazz Artist Process
 * Handles POST request to update jazz artist
 * Includes file upload handling for artist images
 */
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

/**
 * Delete Jazz Artist Confirmation
 * Display confirmation page before deleting jazz artist
 */
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

/**
 * Delete Jazz Artist Process
 * Handles POST request to delete jazz artist
 */
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

/**
 * Jazz Events Management
 * List all jazz performances/events with management options
 */
Route::add('/admin/jazz/events', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listEvents();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_events.php");
}, 'get');

/**
 * Create Jazz Event Form
 * Display form for adding new jazz event/performance
 */
Route::add('/admin/jazz/events/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->getEventFormData();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_event_form.php");
}, 'get');

/**
 * Create Jazz Event Process
 * Handles POST request to create new jazz event
 * Includes validation for dates, times, and ticket availability
 */
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

/**
 * Edit Jazz Event Form
 * Display form for editing existing jazz event
 */
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

/**
 * Edit Jazz Event Process
 * Handles POST request to update jazz event
 */
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

/**
 * Delete Jazz Event Confirmation
 * Display confirmation page before deleting jazz event
 */
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

/**
 * Delete Jazz Event Process
 * Handles POST request to delete jazz event
 */
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

/**
 * Jazz Venue Management
 * List all jazz venues with management options
 */
Route::add('/admin/jazz/venues', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listVenues();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_venues.php");
}, 'get');

/**
 * Create/Edit Jazz Venue
 * Combined GET/POST route for creating and updating venues
 * GET: Display form
 * POST: Process form submission
 */
Route::add('/admin/jazz/venues/create', function() {
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

/**
 * Edit Jazz Venue
 * Combined GET/POST route for editing venues
 */
Route::add('/admin/jazz/venues/edit/([0-9]+)', function($venueId) {
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

/**
 * Delete Jazz Venue
 * POST only route for deleting venues
 */
Route::add('/admin/jazz/venues/delete/([0-9]+)', function($venueId) {
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

/**
 * Jazz Pass Management
 * List all jazz passes (day/weekend) with management options
 */
Route::add('/admin/jazz/passes', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    $viewData = $controller->listPasses();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_passes.php");
}, 'get');

/**
 * Create Jazz Pass Form
 * Display form for creating new jazz pass
 */
Route::add('/admin/jazz/passes/create', function() {
    requireAdmin();
    
    $controller = new JazzManagementController();
    
    require_once(__DIR__ . "/../views/pages/admin_jazz_pass_form.php");
}, 'get');

/**
 * Create Jazz Pass Process
 * Handles POST request to create new jazz pass
 */
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

/**
 * Edit Jazz Pass Form
 * Display form for editing existing jazz pass
 */
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

/**
 * Edit Jazz Pass Process
 * Handles POST request to update jazz pass
 */
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

/**
 * Delete Jazz Pass Confirmation
 * Display confirmation page before deleting jazz pass
 */
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

/**
 * Delete Jazz Pass Process
 * Handles POST request to delete jazz pass
 */
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

/**
 * ORDER MANAGEMENT SECTION
 * 
 * Routes for viewing and managing orders, including exports
 */

/**
 * Order Management Dashboard
 * Displays paginated list of orders with filtering and sorting options
 */
Route::add('/admin/orders', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/AdminOrderController.php");
    $controller = new AdminOrderController();
    
    // Extract filtering parameters from URL query string
    $filters = [
        'status' => $_GET['status'] ?? '',          // Filter by order status
        'startDate' => $_GET['startDate'] ?? '',    // Filter by order start date
        'endDate' => $_GET['endDate'] ?? '',        // Filter by order end date
        'minAmount' => $_GET['minAmount'] ?? '',    // Filter by minimum amount
        'maxAmount' => $_GET['maxAmount'] ?? ''     // Filter by maximum amount
    ];
    
    // Search and sort parameters
    $searchTerm = $_GET['search'] ?? '';          // Text search term
    $sortBy = $_GET['sortBy'] ?? 'OrderDate';     // Field to sort by
    $sortOrder = $_GET['sortOrder'] ?? 'desc';    // Sort direction
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Current page
    
    // Get data for the view
    $viewData = $controller->index($filters, $searchTerm, $sortBy, $sortOrder, $page);
    
    // Add status options for the filter dropdown
    $viewData['statusOptions'] = ['pending', 'paid', 'completed', 'cancelled', 'refunded'];
    
    require_once(__DIR__ . "/../views/pages/admin_orders.php");
}, 'get');

/**
 * View Order Details
 * Display detailed information for a specific order
 * Includes customer information and tickets
 */
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

/**
 * Update Order Status
 * Handles POST request to update order status
 */
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

/**
 * Export Orders to CSV
 * Generates CSV file with filtered order data
 * Directly outputs file for download
 */
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
    
    // This will directly output the CSV to the browser
    $controller->exportOrders($filters, $searchTerm);
    
    // No need for redirects since exportOrders handles the download
    // and exits execution
}, 'get');

/**
 * DANCE MANAGEMENT SECTION
 * 
 * All routes for managing dance events and artists
 * Similar structure to jazz management
 */

/**
 * Dance Management Dashboard
 * Displays overview of dance event management with statistics
 */
Route::add('/admin/dance', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $viewData = $controller->dashboard();
    
    require_once(__DIR__ . "/../views/pages/admin_dance.php");
}, 'get');

/**
 * Dance Artist Management
 * List all dance artists with management options
 */
Route::add('/admin/dance/artists', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $viewData = $controller->listArtists();
    
    require_once(__DIR__ . "/../views/pages/admin_dance_artists.php");
}, 'get');

/**
 * Create Dance Artist Form
 * Display form for adding new dance artist
 */
Route::add('/admin/dance/artists/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    
    require_once(__DIR__ . "/../views/pages/admin_dance_artist_form.php");
}, 'get');

/**
 * Create Dance Artist Process
 * Handles POST request to create new dance artist
 * Includes file upload handling for artist images
 */
Route::add('/admin/dance/artists/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $result = $controller->createArtist($_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/dance/artists');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/dance/artists/create');
    }
    exit();
}, 'post');

/**
 * Edit Dance Artist Form
 * Display form for editing existing dance artist
 */
Route::add('/admin/dance/artists/edit/([0-9]+)', function($artistId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $artist = $controller->getArtist($artistId);
    
    if (!$artist) {
        $_SESSION['error_message'] = 'Artist not found.';
        header('Location: /admin/dance/artists');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_dance_artist_form.php");
}, 'get');

/**
 * Edit Dance Artist Process
 * Handles POST request to update dance artist
 * Includes file upload handling for artist images
 */
Route::add('/admin/dance/artists/edit/([0-9]+)', function($artistId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $result = $controller->updateArtist($artistId, $_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/dance/artists');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/dance/artists/edit/{$artistId}");
    }
    exit();
}, 'post');

/**
 * Delete Dance Artist Confirmation
 * Display confirmation page before deleting dance artist
 */
Route::add('/admin/dance/artists/delete/([0-9]+)', function($artistId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $artist = $controller->getArtist($artistId);
    
    if (!$artist) {
        $_SESSION['error_message'] = 'Artist not found.';
        header('Location: /admin/dance/artists');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_dance_artist_delete.php");
}, 'get');

/**
 * Delete Dance Artist Process
 * Handles POST request to delete dance artist
 */
Route::add('/admin/dance/artists/delete/([0-9]+)', function($artistId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $result = $controller->deleteArtist($artistId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/dance/artists');
    exit();
}, 'post');

/**
 * Dance Events Management
 * List all dance events with management options
 */
Route::add('/admin/dance/events', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $viewData = $controller->listEvents();
    
    require_once(__DIR__ . "/../views/pages/admin_dance_events.php");
}, 'get');

/**
 * Create Dance Event Form
 * Display form for adding new dance event
 */
Route::add('/admin/dance/events/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $viewData = $controller->getEventFormData();
    
    require_once(__DIR__ . "/../views/pages/admin_dance_event_form.php");
}, 'get');

/**
 * Create Dance Event Process
 * Handles POST request to create new dance event
 */
Route::add('/admin/dance/events/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $result = $controller->createEvent($_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/dance/events');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/dance/events/create');
    }
    exit();
}, 'post');

/**
 * Edit Dance Event Form
 * Display form for editing existing dance event
 */
Route::add('/admin/dance/events/edit/([0-9]+)', function($eventId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $viewData = $controller->getEvent($eventId);
    
    if (!$viewData['event']) {
        $_SESSION['error_message'] = 'Event not found.';
        header('Location: /admin/dance/events');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_dance_event_form.php");
}, 'get');

/**
 * Edit Dance Event Process
 * Handles POST request to update dance event
 */
Route::add('/admin/dance/events/edit/([0-9]+)', function($eventId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $result = $controller->updateEvent($eventId, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/dance/events');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/dance/events/edit/{$eventId}");
    }
    exit();
}, 'post');

/**
 * Delete Dance Event Confirmation
 * Display confirmation page before deleting dance event
 */
Route::add('/admin/dance/events/delete/([0-9]+)', function($eventId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $viewData = $controller->getEvent($eventId);
    
    if (!$viewData['event']) {
        $_SESSION['error_message'] = 'Event not found.';
        header('Location: /admin/dance/events');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_dance_event_delete.php");
}, 'get');

/**
 * Delete Dance Event Process
 * Handles POST request to delete dance event
 */
Route::add('/admin/dance/events/delete/([0-9]+)', function($eventId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/DanceManagementController.php");
    $controller = new DanceManagementController();
    $result = $controller->deleteEvent($eventId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/dance/events');
    exit();
}, 'post');

/**
 * YUMMY MANAGEMENT SECTION
 * 
 * All routes for managing restaurants, menus, and menu items
 * Manages the food/dining aspect of the festival
 */

/**
 * Yummy Management Dashboard
 * Displays overview of restaurant management with statistics
 */
Route::add('/admin/yummy', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->dashboard();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy.php");
}, 'get');

/**
 * Restaurant Management
 * List all restaurants with management options
 */
Route::add('/admin/yummy/restaurants', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->listRestaurants();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_restaurants.php");
}, 'get');

/**
 * Create Restaurant Form
 * Display form for adding new restaurant
 */
Route::add('/admin/yummy/restaurants/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_restaurant_form.php");
}, 'get');

/**
 * Create Restaurant Process
 * Handles POST request to create new restaurant
 * Includes file upload handling for restaurant images
 */
Route::add('/admin/yummy/restaurants/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->createRestaurant($_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/yummy/restaurants');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/yummy/restaurants/create');
    }
    exit();
}, 'post');

/**
 * Edit Restaurant Form
 * Display form for editing existing restaurant
 */
Route::add('/admin/yummy/restaurants/edit/([0-9]+)', function($restaurantId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $restaurant = $controller->getRestaurant($restaurantId);
    
    if (!$restaurant) {
        $_SESSION['error_message'] = 'Restaurant not found.';
        header('Location: /admin/yummy/restaurants');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_restaurant_form.php");
}, 'get');

/**
 * Edit Restaurant Process
 * Handles POST request to update restaurant
 * Includes file upload handling for restaurant images
 */
Route::add('/admin/yummy/restaurants/edit/([0-9]+)', function($restaurantId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->updateRestaurant($restaurantId, $_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/yummy/restaurants');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/yummy/restaurants/edit/{$restaurantId}");
    }
    exit();
}, 'post');

/**
 * Delete Restaurant Confirmation
 * Display confirmation page before deleting restaurant
 */
Route::add('/admin/yummy/restaurants/delete/([0-9]+)', function($restaurantId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $restaurant = $controller->getRestaurant($restaurantId);
    
    if (!$restaurant) {
        $_SESSION['error_message'] = 'Restaurant not found.';
        header('Location: /admin/yummy/restaurants');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_restaurant_delete.php");
}, 'get');

/**
 * Delete Restaurant Process
 * Handles POST request to delete restaurant
 */
Route::add('/admin/yummy/restaurants/delete/([0-9]+)', function($restaurantId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->deleteRestaurant($restaurantId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/yummy/restaurants');
    exit();
}, 'post');

/**
 * Menu Management
 * List all menus with management options
 */
Route::add('/admin/yummy/menus', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->listMenus();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menus.php");
}, 'get');

/**
 * Create Menu Form
 * Display form for adding new menu
 */
Route::add('/admin/yummy/menus/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->getMenuFormData();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_form.php");
}, 'get');

/**
 * Create Menu Process
 * Handles POST request to create new menu
 */
Route::add('/admin/yummy/menus/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->createMenu($_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/yummy/menus');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/yummy/menus/create');
    }
    exit();
}, 'post');

/**
 * Edit Menu Form
 * Display form for editing existing menu
 */
Route::add('/admin/yummy/menus/edit/([0-9]+)', function($menuId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->getMenu($menuId);
    
    if (!$viewData['menu']) {
        $_SESSION['error_message'] = 'Menu not found.';
        header('Location: /admin/yummy/menus');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_form.php");
}, 'get');

/**
 * Edit Menu Process
 * Handles POST request to update menu
 */
Route::add('/admin/yummy/menus/edit/([0-9]+)', function($menuId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->updateMenu($menuId, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/yummy/menus');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/yummy/menus/edit/{$menuId}");
    }
    exit();
}, 'post');

/**
 * Delete Menu Confirmation
 * Display confirmation page before deleting menu
 */
Route::add('/admin/yummy/menus/delete/([0-9]+)', function($menuId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $menu = $controller->getMenu($menuId);
    
    if (!$menu['menu']) {
        $_SESSION['error_message'] = 'Menu not found.';
        header('Location: /admin/yummy/menus');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_delete.php");
}, 'get');

/**
 * Delete Menu Process
 * Handles POST request to delete menu
 */
Route::add('/admin/yummy/menus/delete/([0-9]+)', function($menuId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->deleteMenu($menuId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/yummy/menus');
    exit();
}, 'post');

/**
 * Menu Item Management
 * List all menu items with management options
 */
Route::add('/admin/yummy/menu-items', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->listMenuItems();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_items.php");
}, 'get');

/**
 * Create Menu Item Form
 * Display form for adding new menu item
 */
Route::add('/admin/yummy/menu-items/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->getMenuItemFormData();
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_item_form.php");
}, 'get');

/**
 * Create Menu Item Process
 * Handles POST request to create new menu item
 */
Route::add('/admin/yummy/menu-items/create', function() {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->createMenuItem($_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/yummy/menu-items');
    } else {
        $_SESSION['error_message'] = $result['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: /admin/yummy/menu-items/create');
    }
    exit();
}, 'post');

/**
 * Edit Menu Item Form
 * Display form for editing existing menu item
 */
Route::add('/admin/yummy/menu-items/edit/([0-9]+)', function($menuItemId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $viewData = $controller->getMenuItem($menuItemId);
    
    if (!$viewData['menuItem']) {
        $_SESSION['error_message'] = 'Menu item not found.';
        header('Location: /admin/yummy/menu-items');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_item_form.php");
}, 'get');

/**
 * Edit Menu Item Process
 * Handles POST request to update menu item
 */
Route::add('/admin/yummy/menu-items/edit/([0-9]+)', function($menuItemId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->updateMenuItem($menuItemId, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /admin/yummy/menu-items');
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: /admin/yummy/menu-items/edit/{$menuItemId}");
    }
    exit();
}, 'post');

/**
 * Delete Menu Item Confirmation
 * Display confirmation page before deleting menu item
 */
Route::add('/admin/yummy/menu-items/delete/([0-9]+)', function($menuItemId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $menuItem = $controller->getMenuItem($menuItemId);
    
    if (!$menuItem['menuItem']) {
        $_SESSION['error_message'] = 'Menu item not found.';
        header('Location: /admin/yummy/menu-items');
        exit();
    }
    
    require_once(__DIR__ . "/../views/pages/admin_yummy_menu_item_delete.php");
}, 'get');

/**
 * Delete Menu Item Process
 * Handles POST request to delete menu item
 */
Route::add('/admin/yummy/menu-items/delete/([0-9]+)', function($menuItemId) {
    requireAdmin();
    
    require_once(__DIR__ . "/../controllers/YummyManagementController.php");
    $controller = new YummyManagementController();
    $result = $controller->deleteMenuItem($menuItemId);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    header('Location: /admin/yummy/menu-items');
    exit();
}, 'post');

/**
 * ADMIN DASHBOARD ROUTES
 * 
 * General admin navigation routes
 */

/**
 * Admin Base Route
 * Redirects to the main dashboard
 */
Route::add('/admin', function() {
    requireAdmin();
    header('Location: /admin/dashboard');
    exit();
});

/**
 * Admin Dashboard Main Page
 * Displays the main admin dashboard with overview of all sections
 */
Route::add('/admin/dashboard', function() {
    requireAdmin();
    require_once(__DIR__ . "/../views/pages/admin_dashboard.php");
}, 'get');

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