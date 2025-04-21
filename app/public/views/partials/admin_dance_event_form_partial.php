<link rel="stylesheet" href="/assets/css/admin.css">

<?php 
// Determine if this is an edit or create operation
$isEdit = isset($viewData['event']);
$pageTitle = $isEdit ? 'Edit Dance Event' : 'Create Dance Event';

// Set form data from event or form_data
$formData = $isEdit ? $viewData['event'] : ($_SESSION['form_data'] ?? []);
unset($_SESSION['form_data']); // Clear form data after use

// Format date and time for form inputs if editing
$startDate = '';
$startTime = '';
if ($isEdit && !empty($formData['StartDateTime'])) {
    $dateTime = new DateTime($formData['StartDateTime']);
    $startDate = $dateTime->format('Y-m-d');
    $startTime = $dateTime->format('H:i');
}

// Get selected artists for edit mode
$selectedArtistIds = [];
if ($isEdit && !empty($viewData['selectedArtists'])) {
    foreach ($viewData['selectedArtists'] as $artist) {
        $selectedArtistIds[] = $artist['ArtistId'];
    }
}
?>

<div class="admin-container">
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

            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><?= $pageTitle ?></h5>
                </div>
                <div class="admin-card-body">
                    <form action="<?= $isEdit ? "/admin/dance/events/edit/{$formData['DanceEventId']}" : "/admin/dance/events/create" ?>" method="post">
                        <div class="mb-3">
                            <label for="description" class="form-label">Event Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($formData['Description'] ?? '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-select" id="location" name="location" required>
                                <option value="">Select location</option>
                                <?php foreach ($viewData['locations'] as $location): ?>
                                    <option value="<?= htmlspecialchars($location) ?>" <?= (isset($formData['Location']) && $formData['Location'] == $location) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($location) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" value="<?= htmlspecialchars($startDate) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startTime" class="form-label">Time</label>
                                    <input type="time" class="form-control" id="startTime" name="startTime" value="<?= htmlspecialchars($startTime) ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="timeSlot" class="form-label">Time Slot Display (e.g., "20:00 - 22:00")</label>
                            <input type="text" class="form-control" id="timeSlot" name="timeSlot" value="<?= htmlspecialchars($formData['TimeSlot'] ?? '') ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="durationByMinute" class="form-label">Duration (minutes)</label>
                                    <input type="number" class="form-control" id="durationByMinute" name="durationByMinute" value="<?= htmlspecialchars($formData['DurationByMinute'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tickets" class="form-label">Tickets Available</label>
                                    <input type="number" class="form-control" id="tickets" name="tickets" value="<?= htmlspecialchars($formData['TicketsAvailable'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price (€)</label>
                                    <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($formData['Price'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Artists</label>
                            <div class="row">
                                <?php foreach ($viewData['artists'] as $artist): ?>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="artists[]" value="<?= htmlspecialchars($artist['ArtistId']) ?>" id="artist<?= htmlspecialchars($artist['ArtistId']) ?>"
                                                <?= in_array($artist['ArtistId'], $selectedArtistIds ?? []) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="artist<?= htmlspecialchars($artist['ArtistId']) ?>">
                                                <?= htmlspecialchars($artist['Name']) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <a href="/admin/dance/events" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?> Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>