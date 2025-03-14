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

            <?php if (!isset($_SESSION['user'])) {?>
            <div class="form-section">
                <p>Please log in before proceeding with the payment!</p>
            </div>
            <?php }?>
            <div class="cart-section">
                <h2>Cart contents</h2>
                    <?php
                    if(isset($_SESSION['cart'])){ 
                        foreach ($_SESSION['cart'] as $index => $ticket): ?>
                        <div class="ticket-container">
                            <p class="eventName"><?= htmlspecialchars($ticket['description']) ?></p>
                            <p><?= htmlspecialchars($ticket['location']) ?></p>
                            <p><?= htmlspecialchars($ticket['dateTime']) ?></p>
                            
                            <div class="quantity-controls">
                                <form method="post" action="updateQuantity">
                                    <button type="submit" name="action" value="subtract">-</button>
                                    <input type="number" id="quantity<?= $index ?>" name="quantity" value="<?= htmlspecialchars($ticket['quantity']) ?>" readonly>
                                    <button type="submit" name="action" value="add">+</button>
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                </form>
                            </div>
                            <form method="post" action="deleteItem">
                                <input type="hidden" name="itemIndex" value="<?= $index ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">X</button>
                            </form>

                            <p>€ <span id="ticketPrice<?= $index ?>"><?= htmlspecialchars($ticket['price']) ?></span></p>
                            <input type="hidden" name="index" value="<?= $index ?>">
                        </div>
                        <?php endforeach; } else { ?>
                            <p>Cart is empty!</p>
                        <?php } ?>
                        <p>Total: € <span id="totalPrice"><?= htmlspecialchars($totalPrice) ?></span></p>
                        <button class="btn btn-primary" name="completeOrder">Proceed to payment</button>
                        <?php
                        // Calculate total price
                        $totalPrice += $ticket['price'] * $ticket['quantity'];
                        ?>
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