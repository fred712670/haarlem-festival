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
            <h1>Delete Jazz Pass</h1>
        </div>

        <div class="admin-content">
            <div class="row mb-4">
                <div class="col-12">
                    <a href="/admin/jazz/passes" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Passes
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
                    
                    <div class="mb-4">
                        <h4><?= htmlspecialchars($pass['display_name']) ?></h4>
                        <p><strong>Type:</strong> <?= htmlspecialchars($pass['pass_type']) ?></p>
                        <p><strong>Price:</strong> €<?= number_format($pass['price'], 2) ?></p>
                        <p><strong>Dates:</strong> <?= htmlspecialchars($pass['dates'] ?? 'N/A') ?></p>
                        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars(str_replace('||', "\n", $pass['description']))) ?></p>
                    </div>
                    
                    <p>Are you sure you want to delete this pass? This will permanently remove it from the system.</p>
                    <p class="text-danger">You cannot delete a pass if tickets of this type have already been sold.</p>

                    <form method="post" action="/admin/jazz/passes/delete/<?= $pass['id'] ?>" class="mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/jazz/passes" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Delete Pass
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>

<?php require_once(__DIR__ . "/../partials/footer.php"); ?>