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

<script src="/assets/js/admin.js"></script>

<?php require_once(__DIR__ . "/../partials/footer.php"); ?>