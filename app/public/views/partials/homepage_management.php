<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
    <link rel="stylesheet" href="/assets/css/event_management.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Homepage Slides</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSlidePopup">+ Add Slide</button>
    </div>

    <ul class="list-group">
        <?php foreach ($slides as $slide): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <?php if (!empty($slide['ImageName'])): ?>
                    <img src="/assets/img/home/<?= htmlspecialchars($slide['ImageName']) ?>" alt="Slide" width="80" class="rounded">
                <?php else: ?>
                    <span class="text-muted">No image</span>
                <?php endif; ?>
                <div>
                    <div><?= html_entity_decode($slide['Title']) ?></div>
                    <small class="text-muted"><?= htmlspecialchars($slide['EventType']) ?></small>
                </div>
            </div>
            <div class="btn-group">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSlidePopup<?= $slide['ContentId'] ?>">Edit</button>
                <a href="/admin/homepage-management/delete-slide?id=<?= urlencode($slide['ContentId']) ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure you want to delete this slide?');">Delete</a>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>

    <!-- Edit popup -->
    <?php foreach ($slides as $slide): ?>
    <div class="modal fade" id="editSlidePopup<?= $slide['ContentId'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/admin/homepage-management/update-slide" method="POST" enctype="multipart/form-data" class="modal-content">
                <input type="hidden" name="id" value="<?= $slide['ContentId'] ?>">
                <input type="hidden" name="existingImage" value="<?= htmlspecialchars($slide['ImageName']) ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Title</label>
                    <input id="title<?= $slide['ContentId'] ?>" type="hidden" name="title" value="<?= html_entity_decode($slide['Title']) ?>">
                    <trix-editor input="title<?= $slide['ContentId'] ?>"></trix-editor>

                <div class="mt-3">
                    <label class="form-label">Event Type</label>
                    <select name="eventType" class="form-select" required>
                        <option value="home" <?= $slide['EventType'] === 'home' ? 'selected' : '' ?>>Home</option>
                        <option value="dance" <?= $slide['EventType'] === 'dance' ? 'selected' : '' ?>>Dance</option>
                        <option value="history" <?= $slide['EventType'] === 'history' ? 'selected' : '' ?>>History</option>
                        <option value="yummy" <?= $slide['EventType'] === 'yummy' ? 'selected' : '' ?>>Yummy</option>
                        <option value="magic" <?= $slide['EventType'] === 'magic' ? 'selected' : '' ?>>Magic</option>
                        <option value="jazz" <?= $slide['EventType'] === 'jazz' ? 'selected' : '' ?>>Jazz</option>
                    </select>
                </div>

                    <div class="mt-3">
                        <label class="form-label">Image Upload</label>
                        <input type="file" name="imageFile" class="form-control" accept="image/*">
                        <small class="text-muted">Leave blank to keep the current image.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add popup -->
    <div class="modal fade" id="addSlidePopup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/admin/homepage-management/store-slide" method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Title</label>
                    <input id="newTitle" type="hidden" name="title">
                    <trix-editor input="newTitle"></trix-editor>

                <div class="mt-3">
                    <label class="form-label">Event Type</label>
                    <select name="eventType" class="form-select" required>
                        <option value="" disabled selected>Select event type</option>
                        <option value="home">Home</option>
                        <option value="dance">Dance</option>
                        <option value="history">History</option>
                        <option value="yummy">Yummy</option>
                        <option value="magic">Magic</option>
                        <option value="jazz">Jazz</option>
                    </select>
                </div>

                    <div class="mt-3">
                        <label class="form-label">Image Upload</label>
                        <input type="file" name="imageFile" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Slide</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section Partials -->
    <?php require(__DIR__ . '/../partials/homepage_content_management.php'); ?>
    <?php require(__DIR__ . '/../partials/homepage_location.php'); ?>
    <?php require(__DIR__ . '/../partials/homepage_event_card.php'); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
