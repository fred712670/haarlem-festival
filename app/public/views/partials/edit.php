<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-0 h3">Edit User</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error_message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close error message"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form action="/admin/users/edit/<?= $user['UserId'] ?>" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <input type="text" class="form-control" id="fullName" name="fullName" 
                                   value="<?= htmlspecialchars($user['FullName']) ?>" 
                                   required
                                   maxlength="100"
                                   pattern="^[A-Za-z\s\-'\.]+$"
                                   title="Please enter a valid name (letters, spaces, hyphens, apostrophes, and periods only)">
                            <div class="invalid-feedback">
                                Please provide a valid full name.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($user['Email']) ?>" 
                                   required
                                   maxlength="255"
                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                   title="Please enter a valid email address">
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= htmlspecialchars($role) ?>" 
                                            <?= ($user['Role'] === $role) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a role.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Registration Date</label>
                            <p class="form-control-plaintext">
                                <?= htmlspecialchars($user['RegisteredDate']) ?>
                            </p>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin/users" class="btn btn-secondary me-md-2">
                                <span class="fas fa-arrow-left" aria-hidden="true"></span> Back to Users
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <span class="fas fa-save" aria-hidden="true"></span> Update User
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="/admin/users/reset-password/<?= $user['UserId'] ?>" class="btn btn-warning">
                            <span class="fas fa-key" aria-hidden="true"></span> Reset Password
                        </a>
                        <a href="/admin/users/delete/<?= $user['UserId'] ?>" class="btn btn-danger">
                            <span class="fas fa-trash" aria-hidden="true"></span> Delete User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
