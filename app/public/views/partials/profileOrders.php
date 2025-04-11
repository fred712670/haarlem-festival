<?php
require __DIR__ . '../../../vendor/autoload.php';

use Dompdf\Dompdf;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

// === Generate QR Code ===
try {
    $renderer = new ImageRenderer(
        new RendererStyle(200),
        new ImagickImageBackEnd()
    );
    $writer = new Writer($renderer);
    $qrCode = $writer->writeString('Hello from baconQrCode!');
    file_put_contents('qrcode-test.png', $qrCode);
    echo "✅ QR Code generated: qrcode-test.png<br>";
} catch (Exception $e) {
    echo "❌ QR Code error: " . $e->getMessage() . "<br>";
}

// === Generate PDF ===
try {
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>Hello from dompdf</h1><p>PDF test successful!</p>');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    file_put_contents('pdf-test.pdf', $dompdf->output());
    echo "✅ PDF generated: pdf-test.pdf<br>";
} catch (Exception $e) {
    echo "❌ PDF generation error: " . $e->getMessage() . "<br>";
}
?>
<div class="container">
    <h1 class="mb-4" id="h1-MyOrders">My Orders</h1>
    <?php if (!empty($orders)): ?>
    <!-- Loop through each order -->
    <?php foreach ($orders as $order): ?>
        <div class="card mb-3">
        <div class="card-header">
            <h5>Order #<?= $order['orderDetails']['OrderId'] ?> (<?= $order['orderDetails']['Status'] ?>)</h5>
            <p><strong>Order Date:</strong> <?= $order['orderDetails']['OrderDate'] ?></p>
        </div>
        <div class="card-body">
            <!-- Loop through each ticket in the order -->
            <?php foreach ($order['tickets'] as $ticket): ?>
            <div class="ticket-info mb-3">
                <h6>Ticket ID: <?= $ticket['TicketId'] ?></h6>
                <p><strong>Price:</strong> €<?= $ticket['Price'] ?> <br><strong>Pass Type:</strong> <?= $ticket['PassType'] ?? 'N/A' ?></p>
                <p><strong>Event Name:</strong> <?= $ticket['EventName'] ?> <br><strong>Status:</strong> <?= $ticket['IsValid'] == 1 ? 'Valid' : 'Invalid' ?></p>
                <hr>
            </div>
            <?php endforeach; ?>
        </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <div class="form-section">
            <p>You currently don't have any reservations</p>
        </div>
    <?php endif;?>
</div>