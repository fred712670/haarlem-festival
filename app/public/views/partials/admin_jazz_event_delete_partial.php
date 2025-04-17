<div class="admin-container">
    <div class="admin-main" style="margin-left: 0; width: 100%;">
        <div class="admin-header">
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
                        <h4><?= htmlspecialchars($viewData['event']['description'] ?? '') ?></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Date:</strong> <?= !empty($viewData['event']['start_datetime']) ? date('Y-m-d', strtotime($viewData['event']['start_datetime'])) : 'N/A' ?></p>
                                <p><strong>Time:</strong> <?= !empty($viewData['event']['start_datetime']) ? date('H:i', strtotime($viewData['event']['start_datetime'])) : 'N/A' ?></p>
                                <p><strong>Venue:</strong> <?= htmlspecialchars($viewData['event']['venue_name'] ?? '') ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Duration:</strong> <?= htmlspecialchars($viewData['event']['duration'] ?? '') ?> minutes</p>
                                <p><strong>Tickets Available:</strong> <?= intval($viewData['event']['tickets'] ?? 0) ?></p>
                                <p><strong>Price:</strong> €<?= htmlspecialchars($viewData['event']['price'] ?? '') ?></p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <p><strong>Artists:</strong></p>
                            <ul>
                                <?php if (isset($viewData['selectedArtists']) && is_array($viewData['selectedArtists'])): ?>
                                    <?php foreach ($viewData['selectedArtists'] as $artist): ?>
                                        <li><?= htmlspecialchars($artist['name'] ?? '') ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>No artists assigned</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <p>Are you sure you want to delete this event? This will permanently remove:</p>
                    <ul>
                        <li>The event information</li>
                        <li>Artist performance assignments</li>
                    </ul>
                    <p class="text-danger">You cannot delete an event if tickets have already been sold for it.</p>

                    <form method="post" action="/admin/jazz/events/delete/<?= $viewData['event']['id'] ?? 0 ?>" class="mt-4">
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

