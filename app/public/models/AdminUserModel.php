<?php
require_once(__DIR__ . "/BaseModel.php");

/**
 * Model for handling admin user management database operations
 */
class AdminUserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get users with optional filtering, searching, sorting, and pagination
     * 
     * @param array $filters Associative array of filters to apply
     * @param string $searchTerm Term to search for in user data
     * @param string $sortBy Field to sort by
     * @param string $sortOrder Sort order (asc or desc)
     * @param int $page Current page number
     * @param int $perPage Records per page
     * @return array Users matching the criteria
     */
    public function getUsers($filters = [], $searchTerm = '', $sortBy = 'FullName', $sortOrder = 'asc', $page = 1, $perPage = 10)
    {
        // Validate and sanitize inputs
        $validSortFields = ['FullName', 'Email', 'Role', 'RegisteredDate'];
        if (!in_array($sortBy, $validSortFields)) {
            $sortBy = 'FullName';
        }
        
        $sortOrder = strtolower($sortOrder) === 'desc' ? 'DESC' : 'ASC';
        
        // Calculate offset for pagination
        $offset = ($page - 1) * $perPage;
        
        // Build the base query
        $sql = "SELECT UserId, FullName, Email, Role, 
                IFNULL(DATE_FORMAT(RegisteredDate, '%Y-%m-%d'), 'N/A') as RegisteredDate,
                Status 
                FROM User WHERE 1=1";
        $params = [];
        
        // Add search condition if search term provided
        if (!empty($searchTerm)) {
            $sql .= " AND (FullName LIKE ? OR Email LIKE ? OR Role LIKE ?)";
            $searchPattern = "%$searchTerm%";
            $params[] = $searchPattern;
            $params[] = $searchPattern;
            $params[] = $searchPattern;
        }
        
        // Add filters
        if (!empty($filters)) {
            // Filter by role
            if (!empty($filters['role'])) {
                $sql .= " AND Role = ?";
                $params[] = $filters['role'];
            }
            
            // Filter by date range
            if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
                $sql .= " AND RegisteredDate BETWEEN ? AND ?";
                $params[] = $filters['startDate'];
                $params[] = $filters['endDate'];
            }
            
            // Filter by status
            if (isset($filters['status']) && $filters['status'] !== '') {
                $sql .= " AND Status = ?";
                $params[] = $filters['status'];
            }
        }
        
        // Add sorting
        $sql .= " ORDER BY $sortBy $sortOrder";
        
        // Add pagination using limit clause
        $sql .= " LIMIT ?, ?";
        
        // Prepare statement
        $stmt = self::$pdo->prepare($sql);
        
        // Bind parameters with the correct types
        $paramIndex = 1;
        foreach ($params as $param) {
            $stmt->bindValue($paramIndex++, $param, PDO::PARAM_STR);
        }
        
        // Bind the pagination parameters as integers
        $stmt->bindValue($paramIndex++, $offset, PDO::PARAM_INT);
        $stmt->bindValue($paramIndex++, $perPage, PDO::PARAM_INT);
        
        // Execute and return results
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get total count of users matching filters and search term
     * 
     * @param array $filters Associative array of filters to apply
     * @param string $searchTerm Term to search for in user data
     * @return int Total count of matching users
     */
    public function getTotalUsersCount($filters = [], $searchTerm = '')
    {
        // Build the base query
        $sql = "SELECT COUNT(*) as total FROM User WHERE 1=1";
        $params = [];
        
        // Add search condition if search term provided
        if (!empty($searchTerm)) {
            $sql .= " AND (FullName LIKE ? OR Email LIKE ? OR Role LIKE ?)";
            $searchPattern = "%$searchTerm%";
            $params[] = $searchPattern;
            $params[] = $searchPattern;
            $params[] = $searchPattern;
        }
        
        // Add filters
        if (!empty($filters)) {
            // Filter by role
            if (!empty($filters['role'])) {
                $sql .= " AND Role = ?";
                $params[] = $filters['role'];
            }
            
            // Filter by date range
            if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
                $sql .= " AND RegisteredDate BETWEEN ? AND ?";
                $params[] = $filters['startDate'];
                $params[] = $filters['endDate'];
            }
            
            // Filter by status
            if (isset($filters['status']) && $filters['status'] !== '') {
                $sql .= " AND Status = ?";
                $params[] = $filters['status'];
            }
        }
        
        // Execute query
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }
    
    /**
     * Get a user by ID
     * 
     * @param int $userId User ID to retrieve
     * @return array|bool User data or false if not found
     */
    public function getUserById($userId)
    {
        $sql = "SELECT UserId, FullName, Email, Role, 
                IFNULL(DATE_FORMAT(RegisteredDate, '%Y-%m-%d'), 'N/A') as RegisteredDate,
                Status 
                FROM User WHERE UserId = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$userId]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new user
     * 
     * @param string $fullName Full name of the user
     * @param string $email Email address of the user
     * @param string $password Password for the user
     * @param string $role Role of the user
     * @return array Result of the operation
     */
    public function createUser($fullName, $email, $password, $role)
    {
        // Check if email already exists
        $checkSql = "SELECT COUNT(*) as count FROM User WHERE Email = ?";
        $checkStmt = self::$pdo->prepare($checkSql);
        $checkStmt->execute([$email]);
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return ['success' => false, 'message' => 'Email already exists.'];
        }
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert new user
        $sql = "INSERT INTO User (FullName, Email, Password, Role, RegisteredDate, Status) 
                VALUES (?, ?, ?, ?, NOW(), 'Active')";
        $stmt = self::$pdo->prepare($sql);
        
        try {
            $stmt->execute([$fullName, $email, $hashedPassword, $role]);
            return [
                'success' => true, 
                'message' => 'User created successfully.', 
                'userId' => self::$pdo->lastInsertId()
            ];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Failed to create user: ' . $e->getMessage()];
        }
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
        // Check if email already exists for another user
        $checkSql = "SELECT COUNT(*) as count FROM User WHERE Email = ? AND UserId != ?";
        $checkStmt = self::$pdo->prepare($checkSql);
        $checkStmt->execute([$email, $userId]);
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return ['success' => false, 'message' => 'Email already exists for another user.'];
        }
        
        // Update user
        $sql = "UPDATE User SET FullName = ?, Email = ?, Role = ?, Status = ? WHERE UserId = ?";
        $stmt = self::$pdo->prepare($sql);
        
        try {
            $stmt->execute([$fullName, $email, $role, $status, $userId]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'User updated successfully.'];
            } else {
                return ['success' => false, 'message' => 'No changes made or user not found.'];
            }
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Failed to update user: ' . $e->getMessage()];
        }
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
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        
        // Update password
        $sql = "UPDATE User SET Password = ? WHERE UserId = ?";
        $stmt = self::$pdo->prepare($sql);
        
        try {
            $stmt->execute([$hashedPassword, $userId]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Password reset successfully.'];
            } else {
                return ['success' => false, 'message' => 'User not found.'];
            }
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Failed to reset password: ' . $e->getMessage()];
        }
    }
    
    /**
     * Delete a user
     * 
     * @param int $userId ID of the user to delete
     * @return array Result of the operation
     */
    public function deleteUser($userId)
    {
        $sql = "DELETE FROM User WHERE UserId = ?";
        $stmt = self::$pdo->prepare($sql);
        
        try {
            $stmt->execute([$userId]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'User deleted successfully.'];
            } else {
                return ['success' => false, 'message' => 'User not found.'];
            }
        } catch (\PDOException $e) {
            // If deletion fails due to foreign key constraint
            if ($e->getCode() == '23000') {
                // Instead of deleting, update status to Inactive
                $updateSql = "UPDATE User SET Status = 'Inactive' WHERE UserId = ?";
                $updateStmt = self::$pdo->prepare($updateSql);
                $updateStmt->execute([$userId]);
                
                if ($updateStmt->rowCount() > 0) {
                    return ['success' => true, 'message' => 'User deactivated instead of deleted due to existing relationships.'];
                }
            }
            return ['success' => false, 'message' => 'Failed to delete user: ' . $e->getMessage()];
        }
    }
}