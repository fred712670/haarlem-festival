<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h1 class="mb-0 h3">Confirm Delete User</h1>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <span class="fas fa-exclamation-triangle" aria-hidden="true"></span> Warning: This action cannot be undone.
                    </div>
                    
                    <p class="lead">Are you sure you want to delete the following user?</p>
                    
                    <dl>
                        <dt class="form-label fw-bold">Name:</dt>
                        <dd><?= htmlspecialchars($user['FullName']) ?></dd>
                        
                        <dt class="form-label fw-bold">Email:</dt>
                        <dd><?= htmlspecialchars($user['Email']) ?></dd>
                        
                        <dt class="form-label fw-bold">Role:</dt>
                        <dd><?= htmlspecialchars($user['Role']) ?></dd>
                        
                        <dt class="form-label fw-bold">Registration Date:</dt>
                        <dd><?= htmlspecialchars($user['RegisteredDate']) ?></dd>
                    </dl>
                    
                    <form action="/admin/users/delete/<?= $user['UserId'] ?>" method="post">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin/users" class="btn btn-secondary me-md-2">
                                <span class="fas fa-times" aria-hidden="true"></span> Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <span class="fas fa-trash" aria-hidden="true"></span> Delete User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>