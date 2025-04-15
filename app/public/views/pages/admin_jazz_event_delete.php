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
            <h1>Delete Jazz Event</h1>
        </div>

        <div class="admin-content">
            <div class="row mb-4">
                <div class="col-12">
                    <a href="/admin/jazz/events" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Events
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
                        <h4><?= htmlspecialchars($viewData['event']['description']) ?></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Date:</strong> <?= date('Y-m-d', strtotime($viewData['event']['start_datetime'])) ?></p>
                                <p><strong>Time:</strong> <?= date('H:i', strtotime($viewData['event']['start_datetime'])) ?></p>
                                <p><strong>Venue:</strong> <?= htmlspecialchars($viewData['event']['venue_name']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Duration:</strong> <?= htmlspecialchars($viewData['event']['duration']) ?> minutes</p>
                                <p><strong>Tickets Available:</strong> <?= intval($viewData['event']['tickets']) ?></p>
                                <p><strong>Price:</strong> €<?= htmlspecialchars($viewData['event']['price']) ?></p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <p><strong>Artists:</strong></p>
                            <ul>
                                <?php foreach ($viewData['selectedArtists'] as $artist): ?>
                                    <li><?= htmlspecialchars($artist['name']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <p>Are you sure you want to delete this event? This will permanently remove:</p>
                    <ul>
                        <li>The event information</li>
                        <li>Artist performance assignments</li>
                    </ul>
                    <p class="text-danger">You cannot delete an event if tickets have already been sold for it.</p>

                    <form method="post" action="/admin/jazz/events/delete/<?= $viewData['event']['id'] ?>" class="mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/jazz/events" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Delete Event
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