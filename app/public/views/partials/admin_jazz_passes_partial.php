<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Jazz Passes Management</h1>
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
                    <a href="/admin/jazz/passes/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Pass
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Jazz Passes</h5>
                </div>
                <div class="admin-card-body">
                    <?php if (empty($viewData['passes'])): ?>
                        <div class="alert alert-info">
                            No passes found. Click the "Add New Pass" button to create one.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Dates</th>
                                        <th>Price</th>
                                        <th>Featured</th>
                                        <th style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewData['passes'] as $pass): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($pass['pass_type']) ?></td>
                                            <td><?= htmlspecialchars($pass['display_name']) ?></td>
                                            <td>
                                                <?php if (!empty($pass['short_description'])): ?>
                                                    <?= htmlspecialchars($pass['short_description']) ?>
                                                <?php else: ?>
                                                    <?= mb_substr(htmlspecialchars($pass['description']), 0, 50) . '...' ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($pass['dates'] ?? 'N/A') ?></td>
                                            <td>€<?= number_format($pass['price'], 2) ?></td>
                                            <td>
                                                <span class="badge <?= $pass['featured'] ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= $pass['featured'] ? 'Yes' : 'No' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/admin/jazz/passes/edit/<?= $pass['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Pass">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/admin/jazz/passes/delete/<?= $pass['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete Pass">
                                                        <i class="fas fa-trash"></i>
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
