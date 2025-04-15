<!-- Welcome Section -->
<div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Welcome Section</h4>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editWelcomePopup">Edit</button>
    </div>
    <ul class="list-group mb-4">
        <?php if (isset($welcome)): ?>
        <li class="list-group-item">
            <div class="fw-bold mb-1"><?= htmlspecialchars($welcome['Title']) ?></div>
            <div><?= nl2br(htmlspecialchars($welcome['Content'])) ?></div>
        </li>
        <?php endif; ?>
    </ul>
</div>

<!-- About Section -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">About Section</h4>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAboutPopup">Edit</button>
    </div>
    <ul class="list-group mb-4">
        <?php if (isset($about)): ?>
        <li class="list-group-item">
            <div class="fw-bold mb-1"><?= htmlspecialchars($about['Title']) ?></div>
            <div><?= nl2br(htmlspecialchars($about['Content'])) ?></div>
        </li>
        <?php endif; ?>
    </ul>
</div>

<!-- Edit Welcome Popup -->
<div class="modal fade" id="editWelcomePopup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/homepage-management/update-content" method="POST" class="modal-content">
            <input type="hidden" name="id" value="<?= $welcome['ContentId'] ?>">
            <input type="hidden" name="section" value="welcome">
            <input type="hidden" name="eventType" value="home">
            <div class="modal-header">
                <h5 class="modal-title">Edit Welcome Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($welcome['Title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <input id="welcomeContent" type="hidden" name="content" value="<?= htmlspecialchars($welcome['Content']) ?>">
                    <trix-editor input="welcomeContent"></trix-editor>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit About Popup -->
<div class="modal fade" id="editAboutPopup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/homepage-management/update-content" method="POST" class="modal-content">
            <input type="hidden" name="id" value="<?= $about['ContentId'] ?>">
            <input type="hidden" name="section" value="about">
            <input type="hidden" name="eventType" value="home">
            <div class="modal-header">
                <h5 class="modal-title">Edit About Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($about['Title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <input id="aboutContent" type="hidden" name="content" value="<?= htmlspecialchars($about['Content']) ?>">
                    <trix-editor input="aboutContent"></trix-editor>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
