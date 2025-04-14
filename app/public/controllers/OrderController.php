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
    
        // Fetch event details (event name, date, and time) from the session cart before clearing it.
        $eventDetails = [];
        foreach ($cart as $ticket) {
            // Only grab unique event details for this order
            $eventId = $ticket['eventId'];
            if (!isset($eventDetails[$eventId])) {
                $eventDetails[$eventId] = [
                    'name' => $ticket['description'],
                    'dateTime' => $ticket['dateTime'], // Assuming your ticket data includes eventDate
                ];
            }
        }
    
        // Pass event details to PDF generation
        $this->generateTicketPdfs($orderResult, $eventDetails);
    
        // Clear the shopping cart.
        //unset($_SESSION['cart']);
    
        // Redirect to the thank-you page.
        //header("Location: /thank-you?orderId=$orderId");
        //exit;
    }
    

    public function getUserOrders($userId){
        $orderModel = new OrderModel();
        return $orderModel->getUserOrders($userId);
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
private function generateTicketPdfs($orderResult, $eventDetails) {
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
        // Get event details for this specific event.
        $eventDetail = isset($eventDetails[$eventId]) ? $eventDetails[$eventId] : null;
        if (!$eventDetail) {
            continue; // If event details are missing, skip this event.
        }

        $eventName = $eventDetail['name'];
        $eventDateTime = $eventDetail['dateTime'];

        // Build HTML for the PDF; each ticket will be on its own page.
        $html = '<html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
                    p { font-size: 16px; margin: 6px 0; padding-right: 20px;}
                    p.small{font-size: 14px}
                    hr {
                        border: 0;
                        border-top: 1px solid #000;
                        margin: 30px 0 25px 0;
                        width: 87%;
                    }
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
                        padding-left: 20px; /* Adjust this to align text to the right */
                    }
                    .ticket-info h1 {
                        font-size: 28px;
                        margin: 0 0 10px 0;
                    }
                    .ticket-info p {
                        font-size: 16px;
                        margin: 6px 0;
                    }
                    .bold-left {
                        font-weight: bold;
                    }
                    .qr-code {
                        width: 200px;
                        height: 200px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .qr-code img {
                        width: 200px;
                        height: 200px;
                    }
                    /* Logo positioning */
                    .logo {
                        position: absolute;
                        top: 80px;
                        right: 40px;
                        width: 240px;
                        height: auto;
                    }
                </style>
            </head>
            <body>';

        // Add logo to the top-right corner
        $logoPath = __DIR__ . '/../assets/img/home/logo-extended.png';  // Adjust the path to your logo
        $logoData = file_get_contents($logoPath);
        $logoDataURI = 'data:image/png;base64,' . base64_encode($logoData);
        

        // For each ticket in this event, create a page.
        foreach ($groupData['tickets'] as $ticket) {
            $ticketId = htmlspecialchars($ticket['TicketId']);
            $passType = htmlspecialchars($ticket['PassType']);
            $customerName = htmlspecialchars($orderResult['order']['CustomerName']);
        
            // --- Secure QR Code Generation ---
            $secret = $_ENV["QR_SECRETKEY"]; // Retrieve the secret key
            if (!$secret) {
                throw new Exception("Secret key not defined. Please set the QRSECRET_KEY environment variable.");
            }
            $signature = hash_hmac('sha256', $ticketId, $secret);
            $rawData = $ticketId . '|' . $signature;
            $qrContent = base64_encode($rawData); // This is the content to encode in the QR

            // Generate the QR code (using SVG backend).
            $renderer = new ImageRenderer(
                new RendererStyle(200), // QR code size.
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $svgQrCode = $writer->writeString($qrContent);
            $svgDataURI = 'data:image/svg+xml;base64,' . base64_encode($svgQrCode);

            $html .= '<div class="ticket-page">';
            $html .= '<img src="' . $logoDataURI . '" class="logo" />';
            $html .= '<div class="qr-code">';
            $html .= '<img src="' . $svgDataURI . '" alt="QR Code" />';
            $html .= '</div>';
            // Left column with text data.
            $html .= '<div class="ticket-info">';
            $html .= '<p><span class="bold-left">Event:</span> ' . $eventName . '</p>';
            $html .= '<p><span class="bold-left">Customer:</span> ' . $customerName . '</p>';

            if (!empty($eventDateTime)) {
                $html .= '<p><span class="bold-left">Valid on:</span> ' . htmlspecialchars($eventDateTime) . '</p>';
            }
            $html .= '<p><span class="bold-left">Ticket Type:</span> ' . $passType . '</p>';
            $html .= '<p><span class="bold-left">Ticket Number:</span> ' . $ticketId . '</p>';
            $html .= '<hr>';
            $html .= '<p class="small">Welcome to The Haarlem Festival, the best events in the Netherlands!<p/>';
            $html .= '<p class="small">This is your ticket. Your ticket will be checked electronically at the entrance.<br>You can print the ticket or show it on your smartphone.<br><p/>';
            $html .= '<p class="small">In 2025 The Haarlem Festival will be open from July 24th to July 27th<p/>';
            $html .= '<p class="small">If you have a "Weekend Pass" ticket, your ticket is valid for all the mentioned<br>days for the purchased event.<p/>';
            $html .= '<p class="small">All other tickets are only valid on the mentioned date and/or timeslot.<p/><br>';
            $html .= '<p class="small">We wish you an amusing day at The Haarlem Festival!<p/>';
            $html .= '</div>';
            $html .= '</div>'; // end .ticket-page
        }

        $html .= '</body></html>';

        // Generate the PDF with Dompdf.
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

    // Optionally, output the generated PDF paths.
    foreach ($generatedPdfs as $pdf) {
        echo "PDF generated: " . htmlspecialchars($pdf) . "<br>";
    }
}



// In OrderController.php

public function validateTicket($qrContent) {
    // Decode the QR content (expected to be a base64-encoded string)
    $decoded = base64_decode($qrContent);
    $parts = explode("|", $decoded);
    if (count($parts) !== 2) {
        throw new Exception("Invalid QR code format.");
    }
    $ticketId = $parts[0];
    $providedSignature = $parts[1];

    // Retrieve the secret key
    $secret = $_ENV["QR_SECRETKEY"];
    if (!$secret) {
        throw new Exception("Secret key not defined. Please set the QRSECRET_KEY environment variable.");
    }
    // Recompute the HMAC signature.
    $expectedSignature = hash_hmac('sha256', $ticketId, $secret);
    if (!hash_equals($expectedSignature, $providedSignature)) {
        return ['success' => false, 'message' => 'Signature does not match.'];
    }

    // Call the model to update the ticket's validity.
    $orderModel = new OrderModel();
    $updated = $orderModel->validateTicket($ticketId);
    if ($updated) {
        return ['success' => true, 'message' => 'Ticket validated successfully.'];
    }
    return ['success' => false, 'message' => 'Ticket validation failed or ticket already used.'];
}


public function downloadTicket() {
    
    $userId = $_SESSION['userId'];

    // Get order_id and event_id from the URL parameters
    $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : null;
    $eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : null;

    // Validate the input parameters
    if (!$orderId || !$eventId) {
        die("Invalid request.");
    }

    // Fetch the order and check if the user has access to this order and ticket
    $orderModel = new OrderModel();
    $order = $orderModel->getOrderById($orderId);

    // Check if the order exists and belongs to the logged-in user
    if (!$order || $order['UserId'] != $userId) {
        die("Unauthorized access to this order.");
    }

    // Construct the file path for the PDF
    $pdfFilePath = __DIR__ . "/../assets/orders/tickets/order-{$orderId}_event-{$eventId}.pdf";

    // Check if the PDF file exists
    if (!file_exists($pdfFilePath)) {
        die("The requested ticket file does not exist.");
    }

    // Serve the file for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
    header('Content-Length: ' . filesize($pdfFilePath));
    readfile($pdfFilePath);
    exit;
}

}

