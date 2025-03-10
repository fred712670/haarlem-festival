<?php
// Function to add a dummy ticket to the session cart

    $dummyTicket = array(
        'eventId' => 1,
        'eventName' => 'Stroll To History Event',
        'dateTime' => '13:00, Saturday, 26 July 2025',
        'price' => 60.00,
        'quantity' => 1
    );

    $_SESSION['cart'] = array();

    // Add the dummy ticket to the cart
    $_SESSION['cart'][] = $dummyTicket;



?>
<body>
    <div class="container">
        <h1>Shopping Cart</h1>

        <!-- Button to add a ticket to the cart 
        <form method="post">
            <button type="submit" name="addToCart">Add Dummy Ticket to Cart</button>
        </form>-->
        
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

        <div class="form-section">
            <h2>Cart contents</h2>
            <?php
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    echo "<ul>";
                    foreach ($_SESSION['cart'] as $item) {
                        echo "<li>" . htmlspecialchars($item['eventName']) . " - " .
                            htmlspecialchars($item['dateTime']) . " - " .
                            "€" . htmlspecialchars(number_format($item['price'], 2)) . " - " .
                            "Qty: " . htmlspecialchars($item['quantity']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
        </div>

        <div class="button-bar">
            <button class="btn btn-secondary">Back</button>
            <button class="btn btn-primary">Proceed to payment</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>