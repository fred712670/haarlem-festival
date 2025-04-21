<?php
require_once(__DIR__ . "/../models/AdminUserModel.php");

/**
 * AdminUserController handles all administrative user management operations
 * This controller provides CRUD operations for user management, including
 * listing users with filtering/searching/sorting, creating new users,
 * updating user information, resetting passwords, and user deletion.
 */
class AdminUserController
{
    /**
     * @var AdminUserModel Instance of AdminUserModel for database operations
     */
    private $adminUserModel;

    /**
     * Constructor initializes the controller with AdminUserModel
     * Creates an instance of AdminUserModel for performing user-related database operations
     */
    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
    }

    /**
     * Display the user management dashboard with optional filtering, searching, and sorting
     * Implements pagination and supports dynamic filtering and sorting of user data
     * 
     * @param array $filters Associative array of filters to apply (e.g., ['role' => 'admin'])
     * @param string $searchTerm Term to search for in user data (searches name, email etc.)
     * @param string $sortBy Field to sort by (default: FullName)
     * @param string $sortOrder Sort order: 'asc' or 'desc' (default: asc)
     * @param int $page Current page number for pagination (default: 1)
     * @return array Results containing:
     *               - users: Array of user records
     *               - total: Total number of users matching criteria
     *               - currentPage: Current page number
     *               - totalPages: Total pages available
     *               - sortBy: Field being sorted by
     *               - sortOrder: Current sort order
     *               - filters: Applied filters
     *               - searchTerm: Applied search term
     */
    public function index($filters = [], $searchTerm = '', $sortBy = 'FullName', $sortOrder = 'asc', $page = 1)
    {
        // Set default records per page for pagination
        $perPage = 10;
        
        // Retrieve users from model with applied filters, search, and sorting
        $result = $this->adminUserModel->getUsers($filters, $searchTerm, $sortBy, $sortOrder, $page, $perPage);
        
        // Get total count for pagination calculations
        $totalUsers = $this->adminUserModel->getTotalUsersCount($filters, $searchTerm);
        $totalPages = ceil($totalUsers / $perPage);
        
        // Return structured array with all necessary data for the view
        return [
            'users' => $result,
            'total' => $totalUsers,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'filters' => $filters,
            'searchTerm' => $searchTerm
        ];
    }

    /**
     * Get a specific user by their ID
     * Retrieves complete user information for editing or viewing
     * 
     * @param int $userId Unique identifier of the user to retrieve
     * @return array|bool User data array if found, false if user doesn't exist
     */
    public function getUser($userId)
    {
        return $this->adminUserModel->getUserById($userId);
    }

    /**
     * Create a new user with the provided details
     * Validates all input data before creating the user
     * Password is hashed securely before storage
     * 
     * @param string $fullName Full name of the user (required)
     * @param string $email Email address of the user (required, must be valid format)
     * @param string $password Password for the user (required, min 8 characters)
     * @param string $role Role of the user (required, must be: 'customer', 'employee', or 'admin')
     * @return array Result array containing:
     *               - success: Boolean indicating operation success
     *               - message: Status message or error description
     */
    public function createUser($fullName, $email, $password, $role)
    {
        // Validate all required fields are provided
        if (empty($fullName) || empty($email) || empty($password) || empty($role)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        // Validate email format using PHP filter
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        // Enforce minimum password length for security
        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }

        // Validate role against allowed values
        $validRoles = ['customer', 'employee', 'admin'];
        if (!in_array(strtolower($role), $validRoles)) {
            return ['success' => false, 'message' => 'Invalid role.'];
        }

        // Create user in database via model
        return $this->adminUserModel->createUser($fullName, $email, $password, strtolower($role));
    }

    /**
     * Update an existing user's information
     * Note: This method doesn't update passwords (separate method exists for that)
     * 
     * @param int $userId ID of the user to update (required)
     * @param string $fullName Updated full name (required)
     * @param string $email Updated email address (required, must be valid format)
     * @param string $role Updated role (required, must be valid role)
     * @return array Result array containing:
     *               - success: Boolean indicating operation success
     *               - message: Status message or error description
     */
    public function updateUser($userId, $fullName, $email, $role)
    {
        // Validate all required fields are provided
        if (empty($userId) || empty($fullName) || empty($email) || empty($role)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        // Validate role against allowed values
        $validRoles = ['customer', 'employee', 'admin'];
        if (!in_array(strtolower($role), $validRoles)) {
            return ['success' => false, 'message' => 'Invalid role.'];
        }

        // Update user in database via model
        return $this->adminUserModel->updateUser($userId, $fullName, $email, strtolower($role));
    }

    /**
     * Reset a user's password
     * Securely hashes the new password before updating
     * 
     * @param int $userId ID of the user whose password to reset
     * @param string $newPassword New password to set (min 8 characters)
     * @return array Result array containing:
     *               - success: Boolean indicating operation success
     *               - message: Status message or error description
     */
    public function resetPassword($userId, $newPassword)
    {
        // Validate required inputs
        if (empty($userId) || empty($newPassword)) {
            return ['success' => false, 'message' => 'User ID and new password are required.'];
        }

        // Enforce minimum password length
        if (strlen($newPassword) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }

        // Reset password via model (model should handle hashing)
        return $this->adminUserModel->resetPassword($userId, $newPassword);
    }

    /**
     * Delete a user from the system
     * Includes protection against self-deletion for security
     * 
     * @param int $userId ID of the user to delete
     * @return array Result array containing:
     *               - success: Boolean indicating operation success
     *               - message: Status message or error description
     */
    public function deleteUser($userId)
    {
        // Validate user ID is provided
        if (empty($userId)) {
            return ['success' => false, 'message' => 'User ID is required.'];
        }

        // Prevent admin from deleting their own account (security measure)
        if (isset($_SESSION['userId']) && $_SESSION['userId'] == $userId) {
            return ['success' => false, 'message' => 'You cannot delete your own account.'];
        }

        // Delete user via model
        return $this->adminUserModel->deleteUser($userId);
    }

    /**
     * Get available roles for dropdown menus in the UI
     * Returns array of role options matching database schema
     * 
     * @return array List of available roles ('customer', 'employee', 'admin')
     */
    public function getRoles()
    {
        // Return array of valid roles that match database schema
        return ['customer', 'employee', 'admin'];
    }
}