<?php
require_once(__DIR__ . "/../partials/header.php");

$isEdit = isset($viewData['event']) && !empty($viewData['event']);
$pageTitle = $isEdit ? "Edit Jazz Event" : "Add New Jazz Event";

// For repopulating form on validation error
$formData = $_SESSION['form_data'] ?? ($isEdit ? $viewData['event'] : []);
unset($_SESSION['form_data']);

// Get selected artists IDs for edit form
$selectedArtistIds = [];
if ($isEdit && isset($viewData['selectedArtists'])) {
    foreach ($viewData['selectedArtists'] as $artist) {
        $selectedArtistIds[] = $artist['id'];
    }
}
?>

<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <?php require_once(__DIR__ . "/../partials/admin_sidebar.php"); ?>

    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1><?= $pageTitle ?></h1>
        </div>

        <div class="admin-content">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-12">
                    <a href="/admin/jazz/events" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Events
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><?= $pageTitle ?></h5>
                </div>
                <div class="admin-card-body">
                    <form method="post" action="<?= $isEdit ? "/admin/jazz/events/edit/{$viewData['event']['id']}" : "/admin/jazz/events/create" ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="description" class="admin-form-label">Event Description <span class="text-danger">*</span></label>
                                    <input type="text" class="admin-form-control" id="description" name="description" 
                                           value="<?= htmlspecialchars($formData['description'] ?? '') ?>" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="venue" class="admin-form-label">Venue <span class="text-danger">*</span></label>
                                    <select class="admin-form-control" id="venue" name="venue" required>
                                        <option value="">-- Select Venue --</option>
                                        <?php foreach ($viewData['venues'] as $venue): ?>
                                            <option value="<?= $venue['id'] ?>" 
                                                    <?= (isset($formData['venue_id']) && $formData['venue_id'] == $venue['id']) || 
                                                        (isset($formData['venue_id']) && $formData['venue_id'] == $venue['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($venue['name']) ?> (Capacity: <?= $venue['capacity'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="startDateTime" class="admin-form-label">Start Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="admin-form-control" id="startDateTime" name="startDateTime" 
                                           value="<?= htmlspecialchars($formData['start_datetime'] ?? '') ?>" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="timeSlot" class="admin-form-label">Time Slot (Display Format)</label>
                                    <input type="text" class="admin-form-control" id="timeSlot" name="timeSlot" 
                                           value="<?= htmlspecialchars($formData['time_slot'] ?? '') ?>" 
                                           placeholder="e.g., 20:00 - 22:00">
                                    <small class="form-text text-muted">Format to display on schedule (if different from actual time)</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label for="durationByMinute" class="admin-form-label">Duration (minutes) <span class="text-danger">*</span></label>
                                    <input type="number" class="admin-form-control" id="durationByMinute" name="durationByMinute" 
                                           value="<?= htmlspecialchars($formData['duration'] ?? '60') ?>" min="15" max="240" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="tickets" class="admin-form-label">Tickets Available <span class="text-danger">*</span></label>
                                    <input type="number" class="admin-form-control" id="tickets" name="tickets" 
                                           value="<?= htmlspecialchars($formData['tickets'] ?? '100') ?>" min="1" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="price" class="admin-form-label">Price (€) <span class="text-danger">*</span></label>
                                    <input type="number" class="admin-form-control" id="price" name="price" 
                                           value="<?= htmlspecialchars($formData['price'] ?? '0') ?>" min="0" step="0.01" required>
                                    <small class="form-text text-muted">Set to 0 for free events</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="admin-form-group mt-4">
                            <label class="admin-form-label">Artists <span class="text-danger">*</span></label>
                            <div class="row">
                                <?php foreach ($viewData['artists'] as $artist): ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="artists[]" 
                                                   value="<?= $artist['id'] ?>" id="artist-<?= $artist['id'] ?>"
                                                   <?= in_array($artist['id'], $selectedArtistIds) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="artist-<?= $artist['id'] ?>">
                                                <?= htmlspecialchars($artist['name']) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="form-text text-muted">Select at least one artist for this event</small>
                        </div>
                        
                        <div class="text-end mt-4">
                            <a href="/admin/jazz/events" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $isEdit ? 'Update Event' : 'Create Event' ?>
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