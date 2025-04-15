<?php require_once(__DIR__ . "/../partials/admin_sidebar.php"); ?>

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Order Management</h1>
        </div>

        <div class="admin-content">
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Orders</h2>
                <a href="<?= exportUrl($viewData) ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>
            </div>

            <!-- Filter and Search Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="get" action="/admin/orders" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="<?= htmlspecialchars($viewData['searchTerm']) ?>" 
                                   placeholder="Order ID, customer, email...">
                        </div>
                        
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Statuses</option>
                                <?php foreach ($viewData['statusOptions'] as $status): ?>
                                    <option value="<?= htmlspecialchars($status) ?>" 
                                        <?= ($viewData['filters']['status'] === $status) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars(ucfirst($status)) ?>
                                    </option>
                                <?php endforeach; ?>
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
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="minAmount" class="form-label">Min Amount</label>
                                    <input type="number" class="form-control" id="minAmount" name="minAmount" 
                                           value="<?= htmlspecialchars($viewData['filters']['minAmount']) ?>" 
                                           placeholder="Min €">
                                </div>
                                <div class="col-md-6">
                                    <label for="maxAmount" class="form-label">Max Amount</label>
                                    <input type="number" class="form-control" id="maxAmount" name="maxAmount" 
                                           value="<?= htmlspecialchars($viewData['filters']['maxAmount']) ?>" 
                                           placeholder="Max €">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="/admin/orders" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </div>
                        
                        <!-- Keep sort parameters when filtering -->
                        <input type="hidden" name="sortBy" value="<?= htmlspecialchars($viewData['sortBy']) ?>">
                        <input type="hidden" name="sortOrder" value="<?= htmlspecialchars($viewData['sortOrder']) ?>">
                    </form>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="card">
                <div class="card-body">
                    <?php if (empty($viewData['orders'])): ?>
                        <div class="alert alert-info">
                            No orders found matching your criteria.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="<?= sortUrl('OrderId', $viewData) ?>" class="text-decoration-none text-dark">
                                                Order #
                                                <?= sortIcon('OrderId', $viewData) ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="<?= sortUrl('OrderDate', $viewData) ?>" class="text-decoration-none text-dark">
                                                Date
                                                <?= sortIcon('OrderDate', $viewData) ?>
                                            </a>
                                        </th>
                                        <th>Customer</th>
                                        <th>
                                            <a href="<?= sortUrl('Status', $viewData) ?>" class="text-decoration-none text-dark">
                                                Status
                                                <?= sortIcon('Status', $viewData) ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="<?= sortUrl('Amount', $viewData) ?>" class="text-decoration-none text-dark">
                                                Amount
                                                <?= sortIcon('Amount', $viewData) ?>
                                            </a>
                                        </th>
                                        <th>Tickets</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewData['orders'] as $order): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($order['OrderId']) ?></td>
                                            <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($order['OrderDate']))) ?></td>
                                            <td>
                                                <?php if (!empty($order['CustomerName'])): ?>
                                                    <?= htmlspecialchars($order['CustomerName']) ?><br>
                                                    <small class="text-muted"><?= htmlspecialchars($order['CustomerEmail']) ?></small>
                                                <?php elseif (!empty($order['UserId'])): ?>
                                                    <span class="text-muted">User ID: <?= htmlspecialchars($order['UserId']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">Guest Order</span>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($order['PhoneNumber'])): ?>
                                                    <br><small class="text-muted"><?= htmlspecialchars($order['PhoneNumber']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'secondary';
                                                if ($order['Status'] === 'paid') $statusClass = 'success';
                                                elseif ($order['Status'] === 'pending') $statusClass = 'warning';
                                                elseif ($order['Status'] === 'cancelled') $statusClass = 'danger';
                                                elseif ($order['Status'] === 'completed') $statusClass = 'primary';
                                                elseif ($order['Status'] === 'refunded') $statusClass = 'info';
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>">
                                                    <?= htmlspecialchars(ucfirst($order['Status'] ?? 'Pending')) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (isset($order['Amount']) && $order['Amount'] !== null): ?>
                                                    €<?= htmlspecialchars(number_format($order['Amount'], 2)) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($order['TicketCount'] ?? 0) ?>
                                            </td>
                                            <td>
                                                <a href="/admin/orders/view/<?= $order['OrderId'] ?>" class="btn btn-sm btn-primary" title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($viewData['totalPages'] > 1): ?>
                            <nav aria-label="Order pagination">
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
        'status' => $viewData['filters']['status'],
        'startDate' => $viewData['filters']['startDate'],
        'endDate' => $viewData['filters']['endDate'],
        'minAmount' => $viewData['filters']['minAmount'],
        'maxAmount' => $viewData['filters']['maxAmount'],
        'page' => $viewData['currentPage']
    ];
    
    return '/admin/orders?' . http_build_query(array_filter($params));
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
        'status' => $viewData['filters']['status'],
        'startDate' => $viewData['filters']['startDate'],
        'endDate' => $viewData['filters']['endDate'],
        'minAmount' => $viewData['filters']['minAmount'],
        'maxAmount' => $viewData['filters']['maxAmount'],
        'page' => $page
    ];
    
    return '/admin/orders?' . http_build_query(array_filter($params));
}

/**
 * Helper function to generate export URL
 */
function exportUrl($viewData) {
    $params = [
        'status' => $viewData['filters']['status'],
        'startDate' => $viewData['filters']['startDate'],
        'endDate' => $viewData['filters']['endDate'],
        'minAmount' => $viewData['filters']['minAmount'],
        'maxAmount' => $viewData['filters']['maxAmount'],
        'search' => $viewData['searchTerm']
    ];
    
    return '/admin/orders/export?' . http_build_query(array_filter($params));
}
?>