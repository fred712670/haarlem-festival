<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Order Details</h1>
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Order #<?= htmlspecialchars($orderData['order']['OrderId']) ?></h2>
                    <p class="text-muted">
                        <?= htmlspecialchars(date('F j, Y H:i', strtotime($orderData['order']['OrderDate']))) ?>
                    </p>
                </div>
                <a href="/admin/orders" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>

            <div class="row mb-4">
                <!-- Order Summary Card -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Order ID:</th>
                                    <td><?= htmlspecialchars($orderData['order']['OrderId']) ?></td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td><?= htmlspecialchars(date('F j, Y H:i', strtotime($orderData['order']['OrderDate']))) ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <?php
                                        $statusClass = 'secondary';
                                        if ($orderData['order']['Status'] === 'paid') $statusClass = 'success';
                                        elseif ($orderData['order']['Status'] === 'pending') $statusClass = 'warning';
                                        elseif ($orderData['order']['Status'] === 'cancelled') $statusClass = 'danger';
                                        elseif ($orderData['order']['Status'] === 'completed') $statusClass = 'primary';
                                        elseif ($orderData['order']['Status'] === 'refunded') $statusClass = 'info';
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>">
                                            <?= htmlspecialchars(ucfirst($orderData['order']['Status'] ?? 'Pending')) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td>
                                        <?php if (isset($orderData['order']['Amount']) && $orderData['order']['Amount'] !== null): ?>
                                            €<?= htmlspecialchars(number_format($orderData['order']['Amount'], 2)) ?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stripe Session:</th>
                                    <td>
                                        <?php if (!empty($orderData['order']['StripeSessionId'])): ?>
                                            <span class="text-monospace"><?= htmlspecialchars($orderData['order']['StripeSessionId']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Update Status Form -->
                            <form method="post" action="/admin/orders/update-status/<?= $orderData['order']['OrderId'] ?>" class="mt-3">
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <select name="status" class="form-select">
                                            <?php foreach ($statusOptions as $status): ?>
                                                <option value="<?= htmlspecialchars($status) ?>" <?= ($orderData['order']['Status'] === $status) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Information Card -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($orderData['user']): ?>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Customer:</th>
                                        <td><?= htmlspecialchars($orderData['user']['FullName']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?= htmlspecialchars($orderData['user']['Email']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>
                                            <?php if (!empty($orderData['order']['PhoneNumber'])): ?>
                                                <?= htmlspecialchars($orderData['order']['PhoneNumber']) ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>
                                            <?php if (!empty($orderData['order']['Address'])): ?>
                                                <?= nl2br(htmlspecialchars($orderData['order']['Address'])) ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Registered:</th>
                                        <td>
                                            <?php if (!empty($orderData['user']['RegisteredDate'])): ?>
                                                <?= htmlspecialchars(date('F j, Y', strtotime($orderData['user']['RegisteredDate']))) ?>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                <div class="mt-2">
                                    <a href="/admin/users/edit/<?= $orderData['user']['UserId'] ?>" class="btn btn-outline-primary">
                                        View User
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center p-3">
                                    <p class="mb-2"><i class="fas fa-user fa-2x text-muted"></i></p>
                                    <p>User information not available or guest order.</p>
                                    
                                    <?php if (!empty($orderData['order']['PhoneNumber']) || !empty($orderData['order']['Address'])): ?>
                                        <div class="mt-3">
                                            <?php if (!empty($orderData['order']['PhoneNumber'])): ?>
                                                <p><strong>Phone:</strong> <?= htmlspecialchars($orderData['order']['PhoneNumber']) ?></p>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($orderData['order']['Address'])): ?>
                                                <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($orderData['order']['Address'])) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Tickets</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($orderData['tickets'])): ?>
                        <div class="alert alert-info">No tickets found for this order.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Event Type</th>
                                        <th>Event Date</th>
                                        <th>Pass Type</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderData['tickets'] as $ticket): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($ticket['TicketId']) ?></td>
                                            <td><?= htmlspecialchars($ticket['EventName'] ?? 'Unknown') ?></td>
                                            <td>
                                                <?php if (!empty($ticket['EventDetails']['DateTime'])): ?>
                                                    <?= htmlspecialchars(date('Y-m-d H:i', strtotime($ticket['EventDetails']['DateTime']))) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($ticket['PassType']) ?></td>
                                            <td>€<?= htmlspecialchars(number_format($ticket['Price'], 2)) ?></td>
                                            <td>
                                                <?php if ($ticket['IsValid']): ?>
                                                    <span class="badge bg-success">Valid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Used/Invalid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($orderData['order']['Status'] === 'paid' || $orderData['order']['Status'] === 'completed'): ?>
                                                    <a href="/download/ticket?order_id=<?= $orderData['order']['OrderId'] ?>&event_id=<?= $ticket['EventId'] ?>" 
                                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="fas fa-ticket-alt"></i> View Ticket
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                                        <i class="fas fa-ticket-alt"></i> Ticket Unavailable
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($orderData['order']['Status'] === 'paid' || $orderData['order']['Status'] === 'completed'): ?>
                            <div class="mt-3">
                                <a href="/download/invoice?order_id=<?= $orderData['order']['OrderId'] ?>" class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-file-invoice"></i> View Invoice
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>