<!-- Location Options Section -->
<div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Location Options</h4>
        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addLocationPopup">+ Add Location</button>
    </div>
    <ul class="list-group">
        <?php foreach ($locationOptions as $option): ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold"><?= htmlspecialchars($option['Title']) ?></div>
                <?= nl2br(htmlspecialchars($option['Content'])) ?>
            </div>
            <div class="btn-group">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editLocationPopup<?= $option['ContentId'] ?>">Edit</button>
                <a href="/admin/homepage-management/delete-content?id=<?= $option['ContentId'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this location?')">Delete</a>
            </div>
        </li>

        <!-- Edit Location Popup -->
        <div class="modal fade" id="editLocationPopup<?= $option['ContentId'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="/admin/homepage-management/update-content" method="POST" class="modal-content">
                    <input type="hidden" name="id" value="<?= $option['ContentId'] ?>">
                    <input type="hidden" name="section" value="location_option">
                    <input type="hidden" name="eventType" value="home">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($option['Title']) ?>" required>

                        <label class="form-label mt-3">Address</label>
                        <textarea name="content" class="form-control" rows="2" required><?= htmlspecialchars($option['Content']) ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Add Location Popup -->
<div class="modal fade" id="addLocationPopup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/homepage-management/store-content" method="POST" class="modal-content">
            <input type="hidden" name="section" value="location_option">
            <input type="hidden" name="eventType" value="home">
            <div class="modal-header">
                <h5 class="modal-title">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>

                <label class="form-label mt-3">Address</label>
                <textarea name="content" class="form-control" rows="2" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Location</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
