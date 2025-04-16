<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Management</h1>
        <a href="/admin/users/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New User
        </a>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Filter and Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="/admin/users" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?= htmlspecialchars($viewData['searchTerm']) ?>" 
                           placeholder="Name, email, role...">
                </div>
                
                <div class="col-md-2">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">All Roles</option>
                        <?php foreach ($viewData['roles'] as $role): ?>
 *     <option value="<?= htmlspecialchars($role) ?>" 
 *         <?= ($viewData['filters']['role'] === $role) ? 'selected' : '' ?>>
 *         <?= htmlspecialchars(ucfirst($role)) ?>
 *     </option>
 * <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" 
                           value="<?= htmlspecialchars($viewData['filters']['startDate']) ?>">
                </div>
                
                <div class="col-md-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" 
                           value="<?= htmlspecialchars($viewData['filters']['endDate']) ?>">
                </div>
                
                <div class="col-md-12 d-flex mt-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="/admin/users" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
                
                <!-- Keep sort parameters when filtering -->
                <input type="hidden" name="sortBy" value="<?= htmlspecialchars($viewData['sortBy']) ?>">
                <input type="hidden" name="sortOrder" value="<?= htmlspecialchars($viewData['sortOrder']) ?>">
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($viewData['users'])): ?>
                <div class="alert alert-info">
                    No users found matching your criteria.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <a href="<?= sortUrl('FullName', $viewData) ?>" class="text-decoration-none text-dark">
                                        Name
                                        <?= sortIcon('FullName', $viewData) ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?= sortUrl('Email', $viewData) ?>" class="text-decoration-none text-dark">
                                        Email
                                        <?= sortIcon('Email', $viewData) ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?= sortUrl('Role', $viewData) ?>" class="text-decoration-none text-dark">
                                        Role
                                        <?= sortIcon('Role', $viewData) ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?= sortUrl('RegisteredDate', $viewData) ?>" class="text-decoration-none text-dark">
                                        Registration Date
                                        <?= sortIcon('RegisteredDate', $viewData) ?>
                                    </a>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($viewData['users'] as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['FullName']) ?></td>
                                    <td><?= htmlspecialchars($user['Email']) ?></td>
                                    <td><?= htmlspecialchars(ucfirst($user['Role'])) ?></td>
                                    <td><?= htmlspecialchars($user['RegisteredDate']) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/users/edit/<?= $user['UserId'] ?>" class="btn btn-sm btn-outline-primary" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/users/reset-password/<?= $user['UserId'] ?>" class="btn btn-sm btn-outline-warning" title="Reset Password">
                                                <i class="fas fa-key"></i>
                                            </a>
                                            <a href="/admin/users/delete/<?= $user['UserId'] ?>" class="btn btn-sm btn-outline-danger" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($viewData['totalPages'] > 1): ?>
                    <nav aria-label="User pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($viewData['currentPage'] <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= paginationUrl($viewData, $viewData['currentPage'] - 1) ?>">
                                    Previous
                                </a>
                            </li>
                            
                            <?php for ($i = 1; $i <= $viewData['totalPages']; $i++): ?>
                                <li class="page-item <?= ($viewData['currentPage'] == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= paginationUrl($viewData, $i) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <li class="page-item <?= ($viewData['currentPage'] >= $viewData['totalPages']) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= paginationUrl($viewData, $viewData['currentPage'] + 1) ?>">
                                    Next
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
/**
 * Helper function to generate sorting URL
 */
function sortUrl($field, $viewData) {
    $newOrder = 'asc';
    if ($viewData['sortBy'] === $field && $viewData['sortOrder'] === 'asc') {
        $newOrder = 'desc';
    }
    
    $params = [
        'sortBy' => $field,
        'sortOrder' => $newOrder,
        'search' => $viewData['searchTerm'],
        'role' => $viewData['filters']['role'],
        'startDate' => $viewData['filters']['startDate'],
        'endDate' => $viewData['filters']['endDate'],
        'page' => $viewData['currentPage']
    ];
    
    return '/admin/users?' . http_build_query(array_filter($params));
}

/**
 * Helper function to display sort icon
 */
function sortIcon($field, $viewData) {
    if ($viewData['sortBy'] !== $field) {
        return '<i class="fas fa-sort text-muted"></i>';
    }
    
    return ($viewData['sortOrder'] === 'asc') 
        ? '<i class="fas fa-sort-up"></i>' 
        : '<i class="fas fa-sort-down"></i>';
}

/**
 * Helper function to generate pagination URL
 */
function paginationUrl($viewData, $page) {
    $params = [
        'sortBy' => $viewData['sortBy'],
        'sortOrder' => $viewData['sortOrder'],
        'search' => $viewData['searchTerm'],
        'role' => $viewData['filters']['role'],
        'startDate' => $viewData['filters']['startDate'],
        'endDate' => $viewData['filters']['endDate'],
        'page' => $page
    ];
    
    return '/admin/users?' . http_build_query(array_filter($params));
}
?>