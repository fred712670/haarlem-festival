<link rel="stylesheet" href="/assets/css/admin.css">

<?php 
// Check if these variables are defined, otherwise set defaults
$isEdit = isset($viewData) && isset($viewData['menuItem']);
$pageTitle = $isEdit ? 'Edit Menu Item' : 'Create Menu Item';

// Set form data
$formData = $isEdit ? $viewData['menuItem'] : (isset($_SESSION['form_data']) ? $_SESSION['form_data'] : []);

// Clear form data after use if it exists
if (isset($_SESSION['form_data'])) {
    unset($_SESSION['form_data']);
}
?>

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1><?= $pageTitle ?></h1>
        </div>

        <div class="admin-content">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><?= $pageTitle ?></h5>
                </div>
                <div class="admin-card-body">
                    <form action="<?= $isEdit ? '/admin/yummy/menu-items/edit/' . htmlspecialchars($formData['MenuItemId']) : '/admin/yummy/menu-items/create' ?>" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= isset($formData['Title']) ? htmlspecialchars($formData['Title']) : '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= isset($formData['Description']) ? htmlspecialchars($formData['Description']) : '' ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (€)</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" value="<?= isset($formData['Price']) ? htmlspecialchars($formData['Price']) : '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="menuId" class="form-label">Menu</label>
                            <select class="form-control" id="menuId" name="menuId" required>
                                <option value="">Select Menu</option>
                                <?php if (isset($viewData) && isset($viewData['menus'])): ?>
                                    <?php foreach ($viewData['menus'] as $menu): ?>
                                        <option value="<?= htmlspecialchars($menu['MenuId']) ?>" <?= (isset($formData['MenuId']) && $formData['MenuId'] == $menu['MenuId']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($menu['MenuName']) ?> (<?= htmlspecialchars($menu['RestaurantName']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <a href="/admin/yummy/menu-items" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?> Menu Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>