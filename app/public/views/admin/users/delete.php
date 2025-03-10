<?php require_once(__DIR__ . "/../../partials/admin_header.php"); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">Confirm Delete User</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Warning: This action cannot be undone.
                    </div>
                    
                    <p class="lead">Are you sure you want to delete the following user?</p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p><?= htmlspecialchars($user['FullName']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p><?= htmlspecialchars($user['Email']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role:</label>
                        <p><?= htmlspecialchars($user['Role']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Registration Date:</label>
                        <p><?= htmlspecialchars($user['RegisteredDate']) ?></p>
                    </div>
                    
                    <form action="/admin/users/delete/<?= $user['UserId'] ?>" method="post">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin/users" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../../partials/admin_footer.php"); ?>