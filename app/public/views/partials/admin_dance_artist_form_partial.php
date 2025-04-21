<link rel="stylesheet" href="/assets/css/admin.css">

<?php 
// Determine if this is an edit or create operation
$isEdit = isset($artist);
$pageTitle = $isEdit ? 'Edit Dance Artist' : 'Create Dance Artist';

// Set form data from artist or form_data
$formData = $isEdit ? $artist : ($_SESSION['form_data'] ?? []);
unset($_SESSION['form_data']); // Clear form data after use
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
                    <form action="<?= $isEdit ? "/admin/dance/artists/edit/{$formData['ArtistId']}" : "/admin/dance/artists/create" ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Artist Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($formData['Name'] ?? '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" class="form-control" id="genre" name="genre" value="<?= htmlspecialchars($formData['Genre'] ?? '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($formData['Description'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profileImage" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="profileImage" name="profileImage">
                                    <?php if ($isEdit && !empty($formData['ProfileImageName'])): ?>
                                        <div class="mt-2">
                                            <img src="/assets/img/dance/<?= htmlspecialchars($formData['ProfileImageName']) ?>" 
                                                alt="Current profile image" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="d-block text-muted">Current profile image. Upload a new one to replace.</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="detailImage" class="form-label">Detail Image</label>
                                    <input type="file" class="form-control" id="detailImage" name="detailImage">
                                    <?php if ($isEdit && !empty($formData['DetailImageName'])): ?>
                                        <div class="mt-2">
                                            <img src="/assets/img/dance/<?= htmlspecialchars($formData['DetailImageName']) ?>" 
                                                alt="Current detail image" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="d-block text-muted">Current detail image. Upload a new one to replace.</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <a href="/admin/dance/artists" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?> Artist</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>