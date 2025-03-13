<?php
    //print_r($_SESSION['cart']);
    $totalPrice = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="/assets/css/cart.css">
</head>
    <div class="container">
        <div class="personal-and-cart">
            <!--<div class="form-section">
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
            </div>-->

            <div class="cart-section">
                <h2>Cart contents</h2>

                <form method="post" action="completeOrder">
                    <?php foreach ($_SESSION['cart'] as $index => $ticket): ?>
                        <div class="ticket-container">
                            <p class="eventName"><?= htmlspecialchars($ticket['description']) ?></p>
                            <p><?= htmlspecialchars($ticket['location']) ?></p>
                            <p><?= htmlspecialchars($ticket['dateTime']) ?></p>
                            
                            <div class="quantity-controls">
                                <button type="button" onclick="subtractQuantity(<?= $index ?>)">-</button>
                                <input type="number" id="quantity<?= $index ?>" name="quantity[<?= $index ?>]" value="<?= htmlspecialchars($ticket['quantity']) ?>" readonly>
                                <button type="button" onclick="addQuantity(<?= $index ?>)">+</button>
                            </div>

                            <p>€ <span id="ticketPrice<?= $index ?>"><?= htmlspecialchars($ticket['price']) ?></span></p>
                            <input type="hidden" name="index" value="<?= $index ?>">
                        </div>
                        
                        <?php
                        // Calculate total price
                        $totalPrice += $ticket['price'] * $ticket['quantity'];
                        ?>
                        <?php endforeach; ?>

                        <p>Total: € <span id="totalPrice"><?= htmlspecialchars($totalPrice) ?></span></p>
                        <button class="btn btn-primary" name="completeOrder">Proceed to payment</button>
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
    <script src="/assets/js/shoppingCart.js"></script>
</html>