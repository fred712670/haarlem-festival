<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-0 h3">Create New User</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error_message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close error message"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form action="/admin/users/create" method="post" class="needs-validation" novalidate>
                        <!-- Form data from previous submission -->
                        <?php $formData = $_SESSION['form_data'] ?? []; ?>
                        <?php unset($_SESSION['form_data']); ?>
                        
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <input type="text" class="form-control" id="fullName" name="fullName" 
                                   value="<?= htmlspecialchars($formData['fullName'] ?? '') ?>" 
                                   required>
                            <div class="invalid-feedback">
                                Please provide a full name.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($formData['email'] ?? '') ?>" 
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" 
                                       required minlength="8" aria-describedby="passwordHelpText">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Show password">
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
                            <label for="confirmPassword" class="form-label">Confirm Password <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <input type="password" class="form-control" id="confirmPassword" 
                                   required minlength="8" aria-describedby="confirmPasswordHelpText">
                            <div class="visually-hidden" id="confirmPasswordHelpText">
                                Please confirm your password.
                            </div>
                            <div class="invalid-feedback">
                                Passwords do not match.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="required" aria-hidden="true">*</span><span class="visually-hidden">required</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" selected disabled>Select a role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= htmlspecialchars($role) ?>" 
                                            <?= (isset($formData['role']) && $formData['role'] === $role) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a role.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin/users" class="btn btn-secondary me-md-2">
                                <span class="fas fa-times" aria-hidden="true"></span> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <span class="fas fa-save" aria-hidden="true"></span> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
