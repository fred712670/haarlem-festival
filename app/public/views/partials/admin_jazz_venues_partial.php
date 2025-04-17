<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Jazz Venues Management</h1>
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

            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="/admin/jazz" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <a href="/admin/jazz/venues/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Venue
                    </a>
                </div>
            </div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Jazz Venues</h5>
                </div>
                <div class="admin-card-body">
                    <?php if (empty($viewData['venues'])): ?>
                        <div class="alert alert-info">
                            No venues found.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Capacity</th>
                                        <th>Contact Info</th>
                                        <th style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewData['venues'] as $venue): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($venue['name']) ?></td>
                                            <td><?= htmlspecialchars($venue['address']) ?></td>
                                            <td><?= intval($venue['capacity']) ?> people</td>
                                            <td>
                                                <?php if (!empty($venue['email'])): ?>
                                                    <div><i class="fas fa-envelope fa-fw text-muted"></i> <?= htmlspecialchars($venue['email']) ?></div>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($venue['office_phone'])): ?>
                                                    <div><i class="fas fa-phone fa-fw text-muted"></i> <?= htmlspecialchars($venue['office_phone']) ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="/admin/jazz/venues/edit/<?= $venue['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Venue">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteVenueModal<?= $venue['id'] ?>" title="Delete Venue">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
<?php foreach ($viewData['venues'] as $venue): ?>
<div class="modal fade" id="deleteVenueModal<?= $venue['id'] ?>" tabindex="-1" aria-labelledby="deleteVenueModalLabel<?= $venue['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteVenueModalLabel<?= $venue['id'] ?>">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the venue "<?= htmlspecialchars($venue['name']) ?>"?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="post" action="/admin/jazz/venues/delete/<?= $venue['id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete Venue</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
