<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Dance Events Management</h1>
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

            <div class="admin-card mb-4">
                <div class="admin-card-header d-flex justify-content-between align-items-center">
                    <h5 class="admin-card-title">Events</h5>
                    <a href="/admin/dance/events/create" class="btn btn-primary">Add New Event</a>
                </div>
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Artists</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($viewData['events'])): ?>
                                    <?php foreach ($viewData['events'] as $event): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($event['DanceEventId']) ?></td>
                                            <td><?= htmlspecialchars($event['Description']) ?></td>
                                            <td><?= htmlspecialchars($event['Location']) ?></td>
                                            <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($event['StartDateTime']))) ?></td>
                                            <td><?= htmlspecialchars($event['artists']) ?></td>
                                            <td>€<?= htmlspecialchars($event['Price']) ?></td>
                                            <td>
                                                <a href="/admin/dance/events/edit/<?= htmlspecialchars($event['DanceEventId']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="/admin/dance/events/delete/<?= htmlspecialchars($event['DanceEventId']) ?>" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No events found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>