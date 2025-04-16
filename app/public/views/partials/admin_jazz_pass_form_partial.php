<?php

$isEdit = isset($pass) && !empty($pass);
$pageTitle = $isEdit ? "Edit Jazz Pass" : "Add New Jazz Pass";

// For repopulating form on validation error
$formData = $_SESSION['form_data'] ?? ($isEdit ? $pass : []);
unset($_SESSION['form_data']);
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

            <div class="row mb-4">
                <div class="col-12">
                    <a href="/admin/jazz/passes" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Passes
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><?= $pageTitle ?></h5>
                </div>
                <div class="admin-card-body">
                    <form method="post" action="<?= $isEdit ? "/admin/jazz/passes/edit/{$pass['id']}" : "/admin/jazz/passes/create" ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="passType" class="admin-form-label">Pass Type <span class="text-danger">*</span></label>
                                    <select class="admin-form-control" id="passType" name="passType" required>
                                        <option value="">-- Select Pass Type --</option>
                                        <option value="Free" <?= (isset($formData['pass_type']) && $formData['pass_type'] == 'Free') ? 'selected' : '' ?>>Free</option>
                                        <option value="SingleUse" <?= (isset($formData['pass_type']) && $formData['pass_type'] == 'SingleUse') ? 'selected' : '' ?>>Single Use</option>
                                        <option value="DayPass" <?= (isset($formData['pass_type']) && $formData['pass_type'] == 'DayPass') ? 'selected' : '' ?>>Day Pass</option>
                                        <option value="WeekendPass" <?= (isset($formData['pass_type']) && $formData['pass_type'] == 'WeekendPass') ? 'selected' : '' ?>>Weekend Pass</option>
                                    </select>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="displayName" class="admin-form-label">Display Name <span class="text-danger">*</span></label>
                                    <input type="text" class="admin-form-control" id="displayName" name="displayName" 
                                           value="<?= htmlspecialchars($formData['display_name'] ?? '') ?>" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="shortDescription" class="admin-form-label">Short Description</label>
                                    <input type="text" class="admin-form-control" id="shortDescription" name="shortDescription" 
                                           value="<?= htmlspecialchars($formData['short_description'] ?? '') ?>">
                                    <small class="form-text text-muted">Brief description for ticket lists</small>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="dates" class="admin-form-label">Valid Dates</label>
                                    <input type="text" class="admin-form-control" id="dates" name="dates" 
                                           value="<?= htmlspecialchars($formData['dates'] ?? '') ?>" 
                                           placeholder="e.g., 2025-07-24,2025-07-25,2025-07-26">
                                    <small class="form-text text-muted">Comma-separated dates in YYYY-MM-DD format</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="description" class="admin-form-label">Full Description <span class="text-danger">*</span></label>
                                    <textarea class="admin-form-control" id="description" name="description" 
                                              rows="5" required><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
                                    <small class="form-text text-muted">Use "||" to create line breaks in the display</small>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="basePrice" class="admin-form-label">Price (€) <span class="text-danger">*</span></label>
                                    <input type="number" class="admin-form-control" id="basePrice" name="basePrice" 
                                           value="<?= htmlspecialchars($formData['price'] ?? '0.00') ?>" min="0" step="0.01" required>
                                    <small class="form-text text-muted">Set to 0 for free passes</small>
                                </div>
                                
                                <div class="admin-form-group">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                               <?= (isset($formData['featured']) && $formData['featured']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="featured">
                                            Feature this pass (highlight as recommended)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end mt-4">
                            <a href="/admin/jazz/passes" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $isEdit ? 'Update Pass' : 'Create Pass' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
