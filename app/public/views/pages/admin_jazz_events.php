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
            <h1>Jazz Events Management</h1>
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
                    <a href="/admin/jazz/events/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Event
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Jazz Events</h5>
                </div>
                <div class="admin-card-body">
                    <?php if (empty($viewData['events'])): ?>
                        <div class="alert alert-info">
                            No events found. Click the "Add New Event" button to create one.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Description</th>
                                        <th>Venue</th>
                                        <th>Artists</th>
                                        <th>Tickets</th>
                                        <th>Price</th>
                                        <th style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewData['events'] as $event): ?>
                                        <tr>
                                            <td>
                                                <?= date('Y-m-d', strtotime($event['start_datetime'])) ?><br>
                                                <small><?= date('H:i', strtotime($event['start_datetime'])) ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($event['description']) ?></td>
                                            <td><?= htmlspecialchars($event['venue_name']) ?></td>
                                            <td><?= htmlspecialchars($event['artists']) ?></td>
                                            <td>
                                                <?= intval($event['tickets']) ?> available
                                                <div class="progress mt-1" style="height: 5px;">
                                                    <?php 
                                                    $capacity = 500; // Default value
                                                    $percentage = min(100, ($event['tickets'] / $capacity) * 100);
                                                    $colorClass = $percentage < 20 ? 'bg-danger' : ($percentage < 50 ? 'bg-warning' : 'bg-success');
                                                    ?>
                                                    <div class="progress-bar <?= $colorClass ?>" role="progressbar" style="width: <?= $percentage ?>%" 
                                                        aria-valuenow="<?= $event['tickets'] ?>" aria-valuemin="0" aria-valuemax="<?= $capacity ?>"></div>
                                                </div>
                                            </td>
                                            <td>€<?= number_format($event['price'], 2) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/admin/jazz/events/edit/<?= $event['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Event">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/admin/jazz/events/delete/<?= $event['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete Event">
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

<script src="/assets/js/admin.js"></script>

<?php require_once(__DIR__ . "/../partials/footer.php"); ?>