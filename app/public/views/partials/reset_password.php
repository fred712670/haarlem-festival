<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h1 class="mb-0 h3">Reset User Password</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error_message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close alert message"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <div class="alert alert-info" role="status">
                        <span class="fas fa-info-circle" aria-hidden="true"></span> You are resetting the password for user:
                        <strong><?= htmlspecialchars($user['FullName']) ?></strong> (<?= htmlspecialchars($user['Email']) ?>)
                    </div>
                    
                    <form action="/admin/users/reset-password/<?= $user['UserId'] ?>" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="newPassword" name="newPassword" 
                                       required minlength="8" aria-describedby="passwordHelpText">
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword" aria-label="Show password">
                                    <span class="fas fa-eye" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="form-text" id="passwordHelpText">
                                Password must be at least 8 characters long.
                            </div>
                            <div class="invalid-feedback">
                                Please provide a password (minimum 8 characters).
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                                       required minlength="8" aria-describedby="confirmPasswordHelpText">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" aria-label="Show confirmation password">
                                    <span class="fas fa-eye" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="visually-hidden" id="confirmPasswordHelpText">
                                Please confirm your password.
                            </div>
                            <div class="invalid-feedback">
                                Passwords do not match.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin/users" class="btn btn-secondary me-md-2">
                                <span class="fas fa-arrow-left" aria-hidden="true"></span> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <span class="fas fa-key" aria-hidden="true"></span> Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/jazz.js"></script>