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
     * Each PDF shows the event's name, order details, and a QR code per ticket (with TicketId embedded).
     *
     * @param array $orderResult  Data from createOrder() including 'order' and 'tickets'.
     */
    private function generateTicketPdfs($orderResult) {
        // Group tickets by EventId.
        $ticketsByEvent = [];
        foreach ($orderResult['tickets'] as $ticket) {
            $eventId = $ticket['EventId'];
            if (!isset($ticketsByEvent[$eventId])) {
                $ticketsByEvent[$eventId] = [
                    'event_name' => $ticket['EventName'],
                    'tickets' => []
                ];
            }
            $ticketsByEvent[$eventId]['tickets'][] = $ticket;
        }

        $generatedPdfs = [];
        // Define the PDF directory.
        $pdfDirectory = __DIR__ . "/../assets/orders/tickets/";

        // Generate a PDF for each event group.
        foreach ($ticketsByEvent as $eventId => $eventData) {
            // Build the HTML to be rendered into PDF.
            $html  = "<h1>" . htmlspecialchars($eventData['event_name']) . " Ticket(s)</h1>";
            $html .= "<p>Order ID: " . htmlspecialchars($orderResult['order']['OrderId']) . "</p>";
            $html .= "<ul>";

            // Create a QR code for each ticket.
            foreach ($eventData['tickets'] as $ticket) {
                $ticketId = htmlspecialchars($ticket['TicketId']);
                $qrContent = "ticket:" . $ticketId;

                // Generate an SVG QR code using BaconQrCode.
                $renderer = new ImageRenderer(
                    new RendererStyle(200), // 200x200 px size.
                    new SvgImageBackEnd()
                );
                $writer = new Writer($renderer);
                $svgQrCode = $writer->writeString($qrContent);
                $svgDataURI = 'data:image/svg+xml;base64,' . base64_encode($svgQrCode);

                $html .= "<li>";
                $html .= "Ticket ID: $ticketId<br>";
                $html .= "<img src=\"$svgDataURI\" width=\"200\" height=\"200\" /><br>";
                $html .= "</li>";
            }
            $html .= "</ul>";

            // Generate the PDF using Dompdf.
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Define the full PDF path.
            $pdfPath = $pdfDirectory . "order-{$orderResult['order']['OrderId']}_event-{$eventId}.pdf";
            $pdfOutput = $dompdf->output();
            if (file_put_contents($pdfPath, $pdfOutput) === false) {
                echo "Failed to write PDF file to: $pdfPath";
            } else {
                $generatedPdfs[] = $pdfPath;
            }
        }

        foreach ($generatedPdfs as $pdf) {
            echo "PDF generated: " . htmlspecialchars($pdf) . "<br>";
        }
    }


    public function getUserOrders() {
        $userId = $_SESSION['userId'];
        $orderModel = new OrderModel();
        return $orderModel->getUserOrders($userId);
    }
}
