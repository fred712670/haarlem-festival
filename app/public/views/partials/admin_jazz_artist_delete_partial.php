<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Delete Jazz Artist</h1>
        </div>

        <div class="admin-content">
            <div class="row mb-4">
                <div class="col-12">
                    <a href="/admin/jazz/artists" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Artists
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header bg-danger text-white">
                    <h5 class="admin-card-title">Confirm Deletion</h5>
                </div>
                <div class="admin-card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Warning: This action cannot be undone!
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <?php if (!empty($artist['image'])): ?>
                            <img src="/assets/img/jazz/<?= htmlspecialchars($artist['image']) ?>" 
                                 alt="<?= htmlspecialchars($artist['name']) ?>"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; margin-right: 20px;">
                        <?php else: ?>
                            <div style="width: 100px; height: 100px; background-color: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                                <i class="fas fa-user fa-3x text-secondary"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <h3><?= htmlspecialchars($artist['name']) ?></h3>
                            <p class="mb-0">
                                <?= !empty($artist['short_description']) ? htmlspecialchars($artist['short_description']) : 'No description' ?>
                            </p>
                        </div>
                    </div>
                    
                    <p>Are you sure you want to delete this artist? This will permanently delete:</p>
                    <ul>
                        <li>The artist's profile information</li>
                        <li>Associated images and gallery</li>
                        <li>Any tracks associated with this artist</li>
                    </ul>
                    <p>You cannot delete an artist who has scheduled performances. You must delete or reassign those performances first.</p>

                    <form method="post" action="/admin/jazz/artists/delete/<?= $artist['id'] ?>" class="mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/jazz/artists" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Delete Artist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
