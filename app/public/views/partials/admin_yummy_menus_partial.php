<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Menus Management</h1>
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
                    <h5 class="admin-card-title">Menus</h5>
                    <a href="/admin/yummy/menus/create" class="btn btn-primary">Add New Menu</a>
                </div>
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Menu Name</th>
                                    <th>Restaurant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($viewData['menus'])): ?>
                                    <?php foreach ($viewData['menus'] as $menu): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($menu['MenuId']) ?></td>
                                            <td><?= htmlspecialchars($menu['MenuName']) ?></td>
                                            <td><?= htmlspecialchars($menu['RestaurantName']) ?></td>
                                            <td>
                                                <a href="/admin/yummy/menus/edit/<?= htmlspecialchars($menu['MenuId']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="/admin/yummy/menus/delete/<?= htmlspecialchars($menu['MenuId']) ?>" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No menus found.</td>
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
