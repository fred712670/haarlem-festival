<?php
$isEdit = isset($artist) && !empty($artist);
$pageTitle = $isEdit ? "Edit Jazz Artist" : "Add New Jazz Artist";

// For repopulating form on validation error
$formData = $_SESSION['form_data'] ?? ($isEdit ? $artist : []);
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
                    <a href="/admin/jazz/artists" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Artists
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><?= $pageTitle ?></h5>
                </div>
                <div class="admin-card-body">
                    <form method="post" enctype="multipart/form-data" action="<?= $isEdit ? "/admin/jazz/artists/edit/{$artist['id']}" : "/admin/jazz/artists/create" ?>">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="name" class="admin-form-label">Artist Name <span class="text-danger">*</span></label>
                                    <input type="text" class="admin-form-control" id="name" name="name" 
                                           value="<?= htmlspecialchars($formData['name'] ?? '') ?>" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="short_description" class="admin-form-label">Short Description <span class="text-danger">*</span></label>
                                    <textarea class="admin-form-control" id="short_description" name="short_description" 
                                              rows="3" required><?= htmlspecialchars($formData['short_description'] ?? '') ?></textarea>
                                    <small class="form-text text-muted">Brief description (100-150 characters) used in artist cards</small>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="profileImage" class="admin-form-label">Profile Image</label>
                                    <input type="file" class="admin-form-control" id="profileImage" name="profileImage" accept="image/*">
                                    <?php if ($isEdit && !empty($artist['image'])): ?>
                                        <div class="mt-2">
                                            <img src="/assets/img/jazz/<?= htmlspecialchars($artist['image']) ?>" 
                                                 alt="Current profile image" style="max-width: 100px; max-height: 100px;">
                                            <small class="d-block">Current image: <?= htmlspecialchars($artist['image']) ?></small>
                                        </div>
                                    <?php endif; ?>
                                    <small class="form-text text-muted">Recommended size: 400x400 pixels</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="galleryImages" class="admin-form-label">Gallery Images</label>
                                    <input type="file" class="admin-form-control" id="galleryImages" name="galleryImages[]" 
                                           accept="image/*" multiple>
                                    <small class="form-text text-muted">You can select multiple images</small>
                                </div>
                                
                                <?php if ($isEdit && !empty($artist['artistGallery'])): ?>
                                    <div class="admin-form-group">
                                        <label class="admin-form-label">Current Gallery Images</label>
                                        <div class="row">
                                            <?php 
                                            $galleryImages = explode(',', $artist['artistGallery']);
                                            foreach ($galleryImages as $img): 
                                            ?>
                                                <div class="col-4 col-sm-3 mb-3 gallery-image-item" data-image="<?= htmlspecialchars($img) ?>">
                                                    <div class="position-relative">
                                                        <img src="/assets/img/jazz/<?= htmlspecialchars($img) ?>" 
                                                             alt="Gallery image" class="img-thumbnail" style="height: 100px; object-fit: cover;">
                                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-gallery-image"
                                                                style="margin: 2px;" title="Remove image">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <input type="hidden" name="removed_gallery_images" id="removed_gallery_images" value="">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="admin-form-group">
                                    <label for="description" class="admin-form-label">Full Description</label>
                                    <textarea class="admin-form-control" id="description" name="description" 
                                              rows="6"><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
                                    <small class="form-text text-muted">Detailed artist description for their profile page</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="musical_style" class="admin-form-label">Musical Style</label>
                                    <textarea class="admin-form-control" id="musical_style" name="musical_style" 
                                              rows="4"><?= htmlspecialchars($formData['musical_style'] ?? '') ?></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="career_highlights" class="admin-form-label">Career Highlights</label>
                                    <textarea class="admin-form-control" id="career_highlights" name="career_highlights" 
                                              rows="4"><?= htmlspecialchars($formData['career_highlights'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end mt-4">
                            <a href="/admin/jazz/artists" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $isEdit ? 'Update Artist' : 'Create Artist' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





