<!-- Festival Event Cards Section -->
<div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Festival Events</h4>
        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addEventCardPopup">+ Add Event</button>
    </div>
    <ul class="list-group">
        <?php foreach ($eventCards as $card): ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold"><?= htmlspecialchars($card['Title']) ?></div>
                <?= html_entity_decode($card['Content']) ?>
                <?php if (!empty($card['ImageName'])): ?>
                    <div class="mt-2">
                        <img src="/assets/img/home/<?= htmlspecialchars($card['ImageName']) ?>" alt="Event Image" width="100" class="rounded">
                    </div>
                <?php endif; ?>
            </div>
            <div class="btn-group">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEventCardPopup<?= $card['ContentId'] ?>">Edit</button>
                <a href="/admin/homepage-management/delete-content?id=<?= $card['ContentId'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this event card?')">Delete</a>
            </div>
        </li>

        <!-- Edit Event Card Popup -->
        <div class="modal fade" id="editEventCardPopup<?= $card['ContentId'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="/admin/homepage-management/update-content" method="POST" enctype="multipart/form-data" class="modal-content">
                    <input type="hidden" name="id" value="<?= $card['ContentId'] ?>">
                    <input type="hidden" name="section" value="event_card">
                    <input type="hidden" name="eventType" value="<?= htmlspecialchars($card['EventType']) ?>">
                    <input type="hidden" name="existingImage" value="<?= htmlspecialchars($card['ImageName']) ?>">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Event Card</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($card['Title']) ?>" required>

                        <label class="form-label mt-3">Content</label>
                        <input id="eventContent<?= $card['ContentId'] ?>" type="hidden" name="content" value="<?= htmlspecialchars($card['Content']) ?>">
                        <trix-editor input="eventContent<?= $card['ContentId'] ?>"></trix-editor>

                        <div class="mt-3">
                            <label class="form-label">Optional Image</label>
                            <input type="file" name="imageFile" class="form-control" accept="image/*">
                            <?php if (!empty($card['ImageName'])): ?>
                                <small class="text-muted">Current: <?= htmlspecialchars($card['ImageName']) ?></small>
                            <?php endif; ?>
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
    </ul>
</div>

<!-- Add Event Card Popup -->
<div class="modal fade" id="addEventCardPopup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/homepage-management/store-content" method="POST" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="section" value="event_card">
            <input type="hidden" name="eventType" value="home">
            <div class="modal-header">
                <h5 class="modal-title">Add Event Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>

                <label class="form-label mt-3">Content</label>
                <input id="newEventCardContent" type="hidden" name="content">
                <trix-editor input="newEventCardContent"></trix-editor>

                <div class="mt-3">
                    <label class="form-label">Optional Image</label>
                    <input type="file" name="imageFile" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Event</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
