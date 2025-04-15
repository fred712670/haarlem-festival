<?php
require_once(__DIR__ . "/../partials/header.php");
?>

<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <?php require_once(__DIR__ . "/../partials/admin_sidebar.php"); ?>

    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1><?= isset($viewData['venue']) ? 'Edit Venue' : 'Create New Venue' ?></h1>
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
                <div class="col-md-6">
                    <a href="/admin/jazz/venues" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Venues
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><?= isset($viewData['venue']) ? 'Edit Venue Details' : 'New Venue Details' ?></h5>
                </div>
                <div class="admin-card-body">
                    <form method="post" action="<?= isset($viewData['venue']) ? '/admin/jazz/venues/edit/' . $viewData['venue']['id'] : '/admin/jazz/venues/create' ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Venue Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['name']) : (isset($viewData['formData']['name']) ? htmlspecialchars($viewData['formData']['name']) : '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['address']) : (isset($viewData['formData']['address']) ? htmlspecialchars($viewData['formData']['address']) : '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity *</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" value="<?= isset($viewData['venue']) ? (int)$viewData['venue']['capacity'] : (isset($viewData['formData']['capacity']) ? (int)$viewData['formData']['capacity'] : '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['description']) : (isset($viewData['formData']['description']) ? htmlspecialchars($viewData['formData']['description']) : '') ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['email']) : (isset($viewData['formData']['email']) ? htmlspecialchars($viewData['formData']['email']) : '') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="officePhone" class="form-label">Office Phone</label>
                            <input type="text" class="form-control" id="officePhone" name="officePhone" value="<?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['office_phone']) : (isset($viewData['formData']['officePhone']) ? htmlspecialchars($viewData['formData']['officePhone']) : '') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="officeHours" class="form-label">Office Hours</label>
                            <input type="text" class="form-control" id="officeHours" name="officeHours" value="<?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['office_hours']) : (isset($viewData['formData']['officeHours']) ? htmlspecialchars($viewData['formData']['officeHours']) : '') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="infoPhone" class="form-label">Info Phone</label>
                            <input type="text" class="form-control" id="infoPhone" name="infoPhone" value="<?= isset($viewData['venue']) ? htmlspecialchars($viewData['venue']['info_phone']) : (isset($viewData['formData']['infoPhone']) ? htmlspecialchars($viewData['formData']['infoPhone']) : '') ?>">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?= isset($viewData['venue']) ? 'Update Venue' : 'Create Venue' ?>
                            </button>
                            
                            <?php if (isset($viewData['venue'])): ?>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteVenueModal">
                                    <i class="fas fa-trash"></i> Delete Venue
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($viewData['venue'])): ?>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteVenueModal" tabindex="-1" aria-labelledby="deleteVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteVenueModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the venue "<?= htmlspecialchars($viewData['venue']['name']) ?>"?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="post" action="/admin/jazz/venues/delete/<?= $viewData['venue']['id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete Venue</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="/assets/js/admin.js"></script>

<?php require_once(__DIR__ . "/../partials/footer.php"); ?>