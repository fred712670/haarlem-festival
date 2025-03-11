<?php
// Function to add a dummy ticket to the session cart

    $dummyTicket = array(
        'eventId' => 1,
        'eventName' => 'Stroll To History Event',
        'dateTime' => '13:00, Saturday, 26 July 2025',
        'price' => 60.00,
        'quantity' => 2
    );

    $_SESSION['cart'] = array();

    // Add the dummy ticket to the cart
    $_SESSION['cart'][] = $dummyTicket;

    print_r($_SESSION['cart']);
?>
<body>
    <div class="container">
        <div class="personal-and-cart">
            <div class="form-section">
                <h2>Personal Details</h2>
                <form>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name*</label>
                        <input type="text" class="form-control" id="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name*</label>
                        <input type="text" class="form-control" id="lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phoneNumber">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                </form>
            </div>

            <div class="cart-section">
                <h2>Cart contents</h2>

                <?php foreach ($_SESSION['cart'] as $index => $ticket): ?>
                <div class="ticket-container">
                    <form method="post" action="/completeOrder">
                        <p class="eventName"><?= htmlspecialchars($ticket['eventName'])?>
                            <div class="quantity-controls">
                                <button type="button" onclick="subtractQuantity()">-</button>
                                <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($ticket['quantity']) ?>" readonly>
                                <button type="button" onclick="addQuantity()">+</button>
                            </div>
                        </p>
                        <p>€ <span id="ticketPrice"><?= htmlspecialchars($ticket['price']) ?></span></p>
                        <input type="hidden" name="index" value="<?= $index ?>">

                    </div>
                    <p>Total: € <span name="totalPrice" id="totalPrice"><?= htmlspecialchars($ticket['price'] * $ticket['quantity'] )?></span></p>
                    <button class="btn btn-primary" name="completeOrder">Proceed to payment</button>
                    <?php endforeach; ?>
                </form>
        </div>

        <!--<div class="order-summary">
            <h2>Order Summary</h2>
            Additional summary details can be added here
        </div>-->

        <div class="button-bar">
            <button class="btn btn-secondary">Back</button>
            <form method="post" action="/completeOrder">
                <!--<button class="btn btn-primary" name="completeOrder">Proceed to payment</button>-->
            </form>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>