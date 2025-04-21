<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Delete Dance Artist</h1>
        </div>

        <div class="admin-content">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Confirm Deletion</h5>
                </div>
                <div class="admin-card-body">
                    <div class="alert alert-danger">
                        <p>Are you sure you want to delete the artist <strong><?= htmlspecialchars($artist['Name']) ?></strong>?</p>
                        <p>This action cannot be undone. All associated songs will be deleted as well.</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <?php if (!empty($artist['ProfileImageName'])): ?>
                                <img src="/assets/img/dance/<?= htmlspecialchars($artist['ProfileImageName']) ?>" 
                                     alt="<?= htmlspecialchars($artist['Name']) ?>" 
                                     class="img-thumbnail" style="max-height: 200px;">
                            <?php else: ?>
                                <p>No profile image available</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <h4><?= htmlspecialchars($artist['Name']) ?></h4>
                            <p><strong>Genre:</strong> <?= htmlspecialchars($artist['Genre']) ?></p>
                            <?php if (!empty($artist['Description'])): ?>
                                <p><strong>Description:</strong> <?= htmlspecialchars($artist['Description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <form action="/admin/dance/artists/delete/<?= htmlspecialchars($artist['ArtistId']) ?>" method="post">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/dance/artists" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Artist</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>