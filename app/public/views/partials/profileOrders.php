<div class="container">
    <h1 class="mb-4" id="h1-MyOrders">My Orders</h1>
    <div class="order-section">
    <?php if (!empty($orders)): ?>
        <!-- Loop through each order -->
        <?php foreach ($orders as $order): ?>
            <?php 
                // Group tickets by EventId and then by PassType (or Ticket Type).
                $events = [];
                foreach ($order['tickets'] as $ticket) {
                    $eventId = $ticket['EventId'];
                    $passType = $ticket['PassType'];
                    
                    // Initialize an event grouping if not set.
                    if (!isset($events[$eventId])) {
                        $events[$eventId] = [];
                    }
                    // Group by pass type; if not set, initialize it.
                    if (!isset($events[$eventId][$passType])) {
                        $events[$eventId][$passType] = [
                            'count'    => 0,
                            'price'    => $ticket['Price'],  // Assuming price is the same within this group.
                            'passType' => $passType
                        ];
                    }
                    $events[$eventId][$passType]['count']++;
                }
            ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Order #<?= $order['orderDetails']['OrderId'] ?>
                                (<?= $order['orderDetails']['Status'] ?>)</h5>
                                <small><strong>Order Placed:</strong> <?= (new DateTime($order['orderDetails']['OrderDate']))->format('D. jS M y') ?></small>
                        </div>
                        <a class="btn btn-success btn-sm ms-2" href="/download/invoice?order_id=<?= $order['orderDetails']['OrderId'] ?>" target="_blank">
                            Download Invoice
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($events as $eventId => $groups): ?>
                        <div class="mb-3">
                            <h6>Event #<?= $eventId ?></h6>
                            <?php foreach ($groups as $group): ?>
                                <div class="justify-content-between align-items-center py-2 border-bottom">
                                    <strong><?= $group['count'] ?>x <?= $group['passType'] ?></strong>
                                    <span class="ms-2">- Price: €<?= $group['price'] ?></span>
                                    <a class="btn btn-primary btn-sm ms-2 btnDownload" 
                                        href="/download/ticket?order_id=<?= $order['orderDetails']['OrderId'] ?>&event_id=<?= $eventId ?>" 
                                        target="_blank">
                                            Download Ticket(s)
                                    </a>
                                <div>
                                        <!-- You could add more controls per ticket group here if needed -->
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>You currently don't have any reservations.</p>
        </div>
    <?php endif; ?>
</div>
