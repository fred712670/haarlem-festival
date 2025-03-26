<?php
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<link rel="stylesheet" href="/assets/css/payment.css">

<div class="payment-container">
    <h2>Confirm & Pay</h2>

    <?php if (!empty($cart)): ?>
        <div class="payment-summary">
            <h3>Order Summary</h3>
            <ul>
                <?php foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <li>
                        <strong><?= htmlspecialchars($item['description']) ?></strong><br>
                        <?= htmlspecialchars($item['location']) ?> | <?= htmlspecialchars($item['dateTime']) ?><br>
                        Quantity: <?= $item['quantity'] ?> x €<?= $item['price'] ?> = €<?= number_format($subtotal, 2) ?>
                    </li>
                    <hr>
                <?php endforeach; ?>
                <li><strong>Total: €<?= number_format($total, 2) ?></strong></li>
            </ul>
        </div>

        <form class="payment-form" method="POST" action="/process-payment" onsubmit="return validatePaymentForm()">
        <input type="text" name="phone" required>
        <input type="text" name="address" required>
        <label for="card-name">Cardholder Name</label>
            <input type="text" name="card_name" id="card-name" required>

            <label for="card-number">Card Number</label>
            <input type="text" name="card_number" id="card-number" required maxlength="19">

            <div class="card-details">
                <div>
                    <label for="expiry">Expiry</label>
                    <input type="text" name="expiry" id="expiry" placeholder="MM/YY" required>
                </div>
                <div>
                    <label for="cvv">CVV</label>
                    <input type="text" name="cvv" id="cvv" maxlength="4" required>
                </div>
            </div>

            <div class="payment-buttons">
                <a href="/cart" class="btn-grey">← Back to Cart</a>
                <button class="btn-yellow" type="submit">Pay €<?= number_format($total, 2) ?> →</button>
            </div>
        </form>

    <?php else: ?>
        <p>Your cart is empty. <a href="/cart">Go back</a></p>
    <?php endif; ?>
</div>

<script src="/assets/js/payment.js"></script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
