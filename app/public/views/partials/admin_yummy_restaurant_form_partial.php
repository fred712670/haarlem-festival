<link rel="stylesheet" href="/assets/css/admin.css">

<?php 
// Determine if this is an edit or create operation
$isEdit = isset($restaurant);
$pageTitle = $isEdit ? 'Edit Restaurant' : 'Create Restaurant';

// Set form data from restaurant or form_data
$formData = $isEdit ? $restaurant : ($_SESSION['form_data'] ?? []);
unset($_SESSION['form_data']); // Clear form data after use

// Prepare gallery images for display
$galleryImages = [];
if ($isEdit && !empty($formData['ImageGallery'])) {
    $galleryImages = explode(',', $formData['ImageGallery']);
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
                    <form action="<?= $isEdit ? "/admin/yummy/restaurants/edit/{$formData['RestaurantId']}" : "/admin/yummy/restaurants/create" ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Restaurant Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($formData['Name'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="cuisineType" class="form-label">Cuisine Type</label>
                                    <input type="text" class="form-control" id="cuisineType" name="cuisineType" value="<?= htmlspecialchars($formData['CuisineType'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($formData['Address'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($formData['Description'] ?? '') ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="about" class="form-label">About</label>
                                    <textarea class="form-control" id="about" name="about" rows="5"><?= htmlspecialchars($formData['About'] ?? '') ?></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="workingHours" class="form-label">Working Hours</label>
                                    <textarea class="form-control" id="workingHours" name="workingHours" rows="3"><?= htmlspecialchars($formData['WorkingHours'] ?? '') ?></textarea>
                                    <small class="text-muted">Use line breaks for different days.</small>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sessionsAvailable" class="form-label">Sessions Available</label>
                                            <input type="number" class="form-control" id="sessionsAvailable" name="sessionsAvailable" min="1" max="10" value="<?= htmlspecialchars($formData['SessionsAvailable'] ?? '3') ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration (hours)</label>
                                            <input type="number" class="form-control" id="duration" name="duration" min="1" max="5" value="<?= htmlspecialchars($formData['Duration'] ?? '2') ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstStart" class="form-label">First Start Time</label>
                                            <input type="time" class="form-control" id="firstStart" name="firstStart" value="<?= htmlspecialchars(substr($formData['FirstStart'] ?? '18:00:00', 11, 5)) ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Rating (1-5)</label>
                                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="<?= htmlspecialchars($formData['Rating'] ?? '4') ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="seats" class="form-label">Seats</label>
                                            <input type="number" class="form-control" id="seats" name="seats" min="1" max="200" value="<?= htmlspecialchars($formData['Seats'] ?? '40') ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="reducedPrice" class="form-label">Reduced Price</label>
                                            <input type="number" class="form-control" id="reducedPrice" name="reducedPrice" min="0" max="100" value="<?= htmlspecialchars($formData['ReducedPrice'] ?? '20') ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="2"><?= htmlspecialchars($formData['Comment'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mainImage" class="form-label">Main Image</label>
                                    <input type="file" class="form-control" id="mainImage" name="mainImage">
                                    <?php if ($isEdit && !empty($formData['Image_url'])): ?>
                                        <div class="mt-2">
                                            <img src="/assets/img/yummy/<?= htmlspecialchars($formData['Image_url']) ?>" 
                                                alt="Current main image" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="d-block text-muted">Current main image. Upload a new one to replace.</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="galleryImages" class="form-label">Gallery Images (Multiple allowed)</label>
                                    <input type="file" class="form-control" id="galleryImages" name="galleryImages[]" multiple>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($galleryImages)): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Gallery Images</label>
                                <div class="row">
                                    <?php foreach ($galleryImages as $image): ?>
                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <img src="/assets/img/yummy/<?= htmlspecialchars($image) ?>" 
                                                    alt="Gallery image" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="removed_gallery_images[]" 
                                                            value="<?= htmlspecialchars($image) ?>" id="remove_<?= htmlspecialchars($image) ?>">
                                                        <label class="form-check-label" for="remove_<?= htmlspecialchars($image) ?>">
                                                            Remove
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <a href="/admin/yummy/restaurants" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?> Restaurant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>