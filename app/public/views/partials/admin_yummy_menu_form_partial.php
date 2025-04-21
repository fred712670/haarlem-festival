<link rel="stylesheet" href="/assets/css/admin.css">

<?php 
// Check if these variables are defined, otherwise set defaults
$isEdit = isset($viewData) && isset($viewData['menu']);
$pageTitle = $isEdit ? 'Edit Menu' : 'Create Menu';

// Set form data
$formData = $isEdit ? $viewData['menu'] : (isset($_SESSION['form_data']) ? $_SESSION['form_data'] : []);

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
                    <form action="<?= $isEdit ? '/admin/yummy/menus/edit/' . htmlspecialchars($formData['MenuId']) : '/admin/yummy/menus/create' ?>" method="post">
                        <div class="mb-3">
                            <label for="menuName" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="menuName" name="menuName" value="<?= isset($formData['MenuName']) ? htmlspecialchars($formData['MenuName']) : '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="restaurantId" class="form-label">Restaurant</label>
                            <select class="form-control" id="restaurantId" name="restaurantId" required>
                                <option value="">Select Restaurant</option>
                                <?php if (isset($viewData) && isset($viewData['restaurants'])): ?>
                                    <?php foreach ($viewData['restaurants'] as $restaurant): ?>
                                        <option value="<?= htmlspecialchars($restaurant['RestaurantId']) ?>" <?= (isset($formData['RestaurantId']) && $formData['RestaurantId'] == $restaurant['RestaurantId']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($restaurant['Name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <a href="/admin/yummy/menus" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?> Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>