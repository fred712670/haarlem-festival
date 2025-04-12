<?php
require_once 'models/OrderModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class OrderController {
    public function createOrder() {
        if (empty($_SESSION['cart']) || empty($_SESSION['userId'])) {
            die("❌ Order or User not available.");
        }

        $orderModel = new OrderModel();
        $cart = $_SESSION['cart'];
        $userId = $_SESSION['userId'];

        // Get phone/address from POST data.
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;

        // Insert the order and tickets; receive a structured result.
        try {
            $orderResult = $orderModel->createOrder($cart, $userId, $phone, $address);
        } catch (Exception $e) {
            die("Error processing order: " . $e->getMessage());
        }

        $orderId = $orderResult['order']['OrderId'];

        // Generate one PDF per event using the returned ticket data.
        $this->generateTicketPdfs($orderResult);

        // Clear the shopping cart.
        unset($_SESSION['cart']);

        // Redirect to the thank-you page.
        //header("Location: /thank-you?orderId=$orderId");
        //exit;
    }

/**
 * Generates one PDF per event from the inserted order's tickets.
 *
 * Each PDF displays a single ticket per page with left-aligned content.
 * The design includes event name, customer name, event date & time,
 * location, ticket type, ticket id, and the QR code.
 *
 * @param array $orderResult Data from createOrder() including 'order' and 'tickets'.
 */
private function generateTicketPdfs($orderResult) {
    // Instantiate OrderModel to fetch event details.
    $orderModel = new OrderModel();

    // Group tickets by EventId.
    $ticketsByEvent = [];
    foreach ($orderResult['tickets'] as $ticket) {
        $eventId = $ticket['EventId'];
        if (!isset($ticketsByEvent[$eventId])) {
            $ticketsByEvent[$eventId] = [
                'tickets' => []
            ];
        }
        $ticketsByEvent[$eventId]['tickets'][] = $ticket;
    }

    $generatedPdfs = [];
    // Define the PDF output directory.
    $pdfDirectory = __DIR__ . "/../assets/orders/tickets/";
    if (!is_dir($pdfDirectory)) {
        mkdir($pdfDirectory, 0777, true);
    }

    // Loop over each event group.
    foreach ($ticketsByEvent as $eventId => $groupData) {
        // Fetch standardized event details (Name, DateTime, Location).
        $eventDetails = $orderModel->getEventDetails($eventId);

        // Build HTML; each ticket will be on its own page.
        $html = '<html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
                    .ticket-page {
                        display: flex;
                        flex-direction: row;
                        align-items: flex-start;
                        padding: 40px;
                        box-sizing: border-box;
                        width: 100%;
                        page-break-after: always;
                    }
                    .ticket-info {
                        flex: 1;
                        text-align: left;
                    }
                    .ticket-info h1 {
                        font-size: 28px;
                        margin: 0 0 10px 0;
                    }
                    .ticket-info p {
                        font-size: 16px;
                        margin: 6px 0;
                    }
                    .qr-code {
                        width: 200px;
                        height: 200px;
                        /* Ensure the image stays within the div */
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .qr-code img {
                        width: 200px;
                        height: 200px;
                    }
                </style>
            </head>
            <body>';
            
        // For each ticket in this event, create a page.
        foreach ($groupData['tickets'] as $ticket) {
            $ticketId = htmlspecialchars($ticket['TicketId']);
            $passType = htmlspecialchars($ticket['PassType']);
            $customerName = htmlspecialchars($orderResult['order']['CustomerName']);
            $eventName = isset($eventDetails['Name']) ? htmlspecialchars($eventDetails['Name']) : 'Event';
        
            // --- Secure QR Code Generation ---
            $secret = $_ENV["QR_SECRETKEY"];
            if (!$secret) {
                throw new Exception("Secret key not defined. Please set the QR_SECRET_KEY environment variable.");
            }
            $signature = hash_hmac('sha256', $ticketId, $secret);
            $rawData = $ticketId . '|' . $signature;
            $qrContent = base64_encode($rawData);
            // --- End Secure QR Code Generation ---
        
            // Generate the QR code (using SVG backend).
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $svgQrCode = $writer->writeString($qrContent);
            $svgDataURI = 'data:image/svg+xml;base64,' . base64_encode($svgQrCode);
        
            $writer = new Writer($renderer);
            $svgQrCode = $writer->writeString($qrContent);
            $svgDataURI = 'data:image/svg+xml;base64,' . base64_encode($svgQrCode);

            $html .= '<div class="qr-code">';
            $html .= '<img src="' . $svgDataURI . '" alt="QR Code" />';
            $html .= '</div>';
            $html .= '<div class="ticket-page">';
            // Left column with text data.
            $html .= '<div class="ticket-info">';
            $html .= '<h1>' . $eventName . '</h1>';
            $html .= '<p>Customer: ' . $customerName . '</p>';
            if (!empty($eventDetails['DateTime'])) {
                $html .= '<p>Event Date & Time: ' . htmlspecialchars($eventDetails['DateTime']) . '</p>';
            }
            if (!empty($eventDetails['Location'])) {
                $html .= '<p>Location: ' . htmlspecialchars($eventDetails['Location']) . '</p>';
            }
            $html .= '<p>Ticket Type: ' . $passType . '</p>';
            $html .= '<p>Ticket ID: ' . $ticketId . '</p>';
            $html .= '</div>';
            // Right column with QR code.
            $html .= '</div>'; // end .ticket-page
        }

        $html .= '</body></html>';

        // Generate PDF with Dompdf.
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Save PDF file.
        $pdfPath = $pdfDirectory . "order-{$orderResult['order']['OrderId']}_event-{$eventId}.pdf";
        $pdfOutput = $dompdf->output();
        if (file_put_contents($pdfPath, $pdfOutput) === false) {
            echo "Failed to write PDF file to: $pdfPath";
        } else {
            $generatedPdfs[] = $pdfPath;
        }
    }
    

    // (Optional) Output generated PDF paths.
    foreach ($generatedPdfs as $pdf) {
        echo "PDF generated: " . htmlspecialchars($pdf) . "<br>";
    }
}
}

