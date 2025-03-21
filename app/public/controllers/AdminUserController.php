<?php
require_once(__DIR__ . "/../models/AdminUserModel.php");

/**
 * Controller for handling admin user management operations
 */
class AdminUserController
{
    private $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
    }

    /**
     * Display the user management dashboard with optional filtering, searching, and sorting
     * 
     * @param array $filters Associative array of filters to apply
     * @param string $searchTerm Term to search for in user data
     * @param string $sortBy Field to sort by
     * @param string $sortOrder Sort order (asc or desc)
     * @param int $page Current page number for pagination
     * @return array Results including users and metadata
     */
    public function index($filters = [], $searchTerm = '', $sortBy = 'FullName', $sortOrder = 'asc', $page = 1)
    {
        // Set default records per page
        $perPage = 10;
        
        // Get users with filtering, searching, and sorting
        $result = $this->adminUserModel->getUsers($filters, $searchTerm, $sortBy, $sortOrder, $page, $perPage);
        
        // Get total count for pagination
        $totalUsers = $this->adminUserModel->getTotalUsersCount($filters, $searchTerm);
        $totalPages = ceil($totalUsers / $perPage);
        
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
     * Get a specific user by ID
     * 
     * @param int $userId User ID to retrieve
     * @return array|bool User data or false if not found
     */
    public function getUser($userId)
    {
        return $this->adminUserModel->getUserById($userId);
    }

    /**
     * Create a new user
     * 
     * @param string $fullName Full name of the user
     * @param string $email Email address of the user
     * @param string $password Password for the user
     * @param string $role Role of the user (Customer, Employee, Administrator)
     * @return array Result of the operation
     */
    public function createUser($fullName, $email, $password, $role)
    {
        // Validate inputs
        if (empty($fullName) || empty($email) || empty($password) || empty($role)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }

        $validRoles = ['Customer', 'Employee', 'Administrator'];
        if (!in_array($role, $validRoles)) {
            return ['success' => false, 'message' => 'Invalid role.'];
        }

        // Create user
        return $this->adminUserModel->createUser($fullName, $email, $password, $role);
    }

    /**
     * Update an existing user
     * 
     * @param int $userId ID of the user to update
     * @param string $fullName Updated full name
     * @param string $email Updated email address
     * @param string $role Updated role
     * @param string $status Updated status
     * @return array Result of the operation
     */
    public function updateUser($userId, $fullName, $email, $role, $status = 'Active')
    {
        // Validate inputs
        if (empty($userId) || empty($fullName) || empty($email) || empty($role)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        $validRoles = ['Customer', 'Employee', 'Administrator'];
        if (!in_array($role, $validRoles)) {
            return ['success' => false, 'message' => 'Invalid role.'];
        }

        $validStatuses = ['Active', 'Inactive'];
        if (!in_array($status, $validStatuses)) {
            return ['success' => false, 'message' => 'Invalid status.'];
        }

        // Update user
        return $this->adminUserModel->updateUser($userId, $fullName, $email, $role, $status);
    }

    /**
     * Reset a user's password
     * 
     * @param int $userId ID of the user
     * @param string $newPassword New password to set
     * @return array Result of the operation
     */
    public function resetPassword($userId, $newPassword)
    {
        // Validate inputs
        if (empty($userId) || empty($newPassword)) {
            return ['success' => false, 'message' => 'User ID and new password are required.'];
        }

        if (strlen($newPassword) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }

        // Reset password
        return $this->adminUserModel->resetPassword($userId, $newPassword);
    }

    /**
     * Delete a user
     * 
     * @param int $userId ID of the user to delete
     * @return array Result of the operation
     */
    public function deleteUser($userId)
    {
        // Validate input
        if (empty($userId)) {
            return ['success' => false, 'message' => 'User ID is required.'];
        }

        // Prevent deleting the current admin user
        if (isset($_SESSION['userId']) && $_SESSION['userId'] == $userId) {
            return ['success' => false, 'message' => 'You cannot delete your own account.'];
        }

        // Delete user
        return $this->adminUserModel->deleteUser($userId);
    }

    /**
     * Get available roles for dropdown
     * 
     * @return array List of available roles
     */
    public function getRoles()
    {
        return ['Customer', 'Employee', 'Administrator'];
    }

    /**
     * Get available statuses for dropdown
     * 
     * @return array List of available statuses
     */
    public function getStatuses()
    {
        return ['Active', 'Inactive'];
    }
}