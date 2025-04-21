<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Delete Dance Event</h1>
        </div>

        <div class="admin-content">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Confirm Deletion</h5>
                </div>
                <div class="admin-card-body">
                    <div class="alert alert-danger">
                        <p>Are you sure you want to delete the event <strong><?= htmlspecialchars($viewData['event']['Description'] ?? '') ?></strong>?</p>
                        <p>This action cannot be undone.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4><?= htmlspecialchars($viewData['event']['Description'] ?? '') ?></h4>
                        <p><strong>Location:</strong> <?= htmlspecialchars($viewData['event']['Location'] ?? '') ?></p>
                        <p><strong>Date/Time:</strong> <?= htmlspecialchars(date('Y-m-d H:i', strtotime($viewData['event']['StartDateTime'] ?? ''))) ?></p>
                        <p><strong>Price:</strong> €<?= htmlspecialchars($viewData['event']['Price'] ?? '') ?></p>
                        <p><strong>Tickets Available:</strong> <?= htmlspecialchars($viewData['event']['TicketsAvailable'] ?? '') ?></p>
                    </div>
                    
                    <form action="/admin/dance/events/delete/<?= htmlspecialchars($viewData['event']['DanceEventId'] ?? '') ?>" method="post">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/dance/events" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>