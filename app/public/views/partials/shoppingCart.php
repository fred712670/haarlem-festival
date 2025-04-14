<?php
    //print_r($_SESSION['cart']);
    //echo password_hash("fred123", PASSWORD_DEFAULT);
    $totalPrice = 0;
    $isUserLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="/assets/css/cart.css">
</head>
    <div class="container">
        <div class="personal-and-cart">

            <div class="cart-title">
                <br><br>
                <i class="fa fa-shopping-cart"> Shopping Cart</i>
            </div>
            <?php if (!$isUserLoggedIn) {?>
            <div class="form-section">
                <p>Please log in before proceeding with the payment!</p>
            </div>
            <?php }?>
            <div class="cart-section">
                <h2>Cart contents</h2>
                <div class="cart-items-container">
                    <?php
                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){ 
                        foreach ($_SESSION['cart'] as $index => $ticket): ?>
                        <div class="ticket-container">
                            <p class="eventName"><?= htmlspecialchars($ticket['description']) ?></p>
                            <p>Reservation for <?= htmlspecialchars($ticket['dateTime'])?></p>
                            <p>Ticket type: <?= htmlspecialchars($ticket['ticketType']) ?></p>
                            <p>Amount of people:</p>
                            <div class="quantity-controls">
                                <form method="post" action="updateQuantity">
                                    <button type="submit" name="action" value="subtract">-</button>
                                    <input type="number" class="inp-quantity" id="quantity<?= $index ?>" name="quantity" value="<?= htmlspecialchars($ticket['quantity']) ?>" readonly>
                                    <button type="submit" name="action" value="add">+</button>
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                </form>
                            </div>
                            <form method="post" action="deleteItem">
                                <input type="hidden" name="itemIndex" value="<?= $index ?>">
                                <button type="submit" class="delete-item" onclick="return confirm('Are you sure you want to remove this item?');">&#10005;</button>
                            </form>

                            <?php if ($ticket['price'] > 0): ?>
                                <p>€ <span id="ticketPrice<?= $index ?>"><?= htmlspecialchars($ticket['price']) ?></span></p>
                            <?php endif; ?>
                            <input type="hidden" name="index" value="<?= $index ?>">
                        </div>
                        <?php endforeach; ?>
                        </div>
                        <p>Total: € <span id="totalPrice"><?= htmlspecialchars($totalPrice) ?></span></p>
                        <a href="/create/order" class="btn btn-primary btn-pay" name="createOrder" id="createOrderBtn" <?php echo $isUserLoggedIn ? '' : 'disabled'; ?>>
                            Proceed to payment
                        </a>
                        <?php
                        // Calculate total price
                        $totalPrice += $ticket['price'] * $ticket['quantity'];
                        ?>
                    </div>
                    
                    <?php } else { ?>
                            <p>Cart is empty!</p>
                        <?php } ?>
            </div>
        </div>
        

        <!--<div class="order-summary">
            <h2>Order Summary</h2>
            Additional summary details can be added here
        </div>-->

        <!--<div class="button-bar">
            <button class="btn btn-secondary">Back</button>
            <form method="post" action="/completeOrder">
                button class="btn btn-primary" name="completeOrder">Proceed to payment</button>
            </form>
        </div>-->
    </div>
    </div>
    <script src="/assets/js/shoppingCart.js"></script>
</html>