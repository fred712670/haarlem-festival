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
            <h1>Jazz Artists Management</h1>
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
                <div class="col-md-6 text-md-end">
                    <a href="/admin/jazz/artists/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Artist
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Jazz Artists</h5>
                </div>
                <div class="admin-card-body">
                    <?php if (empty($viewData['artists'])): ?>
                        <div class="alert alert-info">
                            No artists found. Click the "Add New Artist" button to create one.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewData['artists'] as $artist): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($artist['image'])): ?>
                                                    <img src="/assets/img/jazz/<?= htmlspecialchars($artist['image']) ?>" 
                                                         alt="<?= htmlspecialchars($artist['name']) ?>"
                                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                                <?php else: ?>
                                                    <div style="width: 60px; height: 60px; background-color: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user text-secondary"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($artist['name']) ?></td>
                                            <td>
                                                <?php if (!empty($artist['short_description'])): ?>
                                                    <?= mb_substr(htmlspecialchars($artist['short_description']), 0, 100) . (mb_strlen($artist['short_description']) > 100 ? '...' : '') ?>
                                                <?php else: ?>
                                                    <em class="text-muted">No description</em>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/admin/jazz/artists/edit/<?= $artist['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Artist">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/admin/jazz/artists/delete/<?= $artist['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete Artist">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="/jazz/artist/<?= $artist['id'] ?>" target="_blank" class="btn btn-sm btn-outline-info" title="View Artist Page">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
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