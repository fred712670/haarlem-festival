<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Menu Items Management</h1>
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

            <div class="admin-card mb-4">
                <div class="admin-card-header d-flex justify-content-between align-items-center">
                    <h5 class="admin-card-title">Menu Items</h5>
                    <a href="/admin/yummy/menu-items/create" class="btn btn-primary">Add New Menu Item</a>
                </div>
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Menu</th>
                                    <th>Restaurant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($viewData['menuItems'])): ?>
                                    <?php foreach ($viewData['menuItems'] as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['MenuItemId']) ?></td>
                                            <td><?= htmlspecialchars($item['Title']) ?></td>
                                            <td><?= htmlspecialchars(substr($item['Description'], 0, 50)) . (strlen($item['Description']) > 50 ? '...' : '') ?></td>
                                            <td>€<?= number_format($item['Price'], 2) ?></td>
                                            <td><?= htmlspecialchars($item['MenuName']) ?></td>
                                            <td><?= htmlspecialchars($item['RestaurantName']) ?></td>
                                            <td>
                                                <a href="/admin/yummy/menu-items/edit/<?= htmlspecialchars($item['MenuItemId']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="/admin/yummy/menu-items/delete/<?= htmlspecialchars($item['MenuItemId']) ?>" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No menu items found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>