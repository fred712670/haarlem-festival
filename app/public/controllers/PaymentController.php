<?php
/**
 * PaymentController.php
 *
 * Handles the Stripe checkout flow:
 *   - Creating (or reusing) a Stripe checkout session from the current cart,
 *   - Handling the success, cancel, and expired redirects,
 *   - Marking orders as paid in the database.
 *
 * Assumes:
 *   - User session data is stored in $_SESSION['user'] and $_SESSION['userId']
 *   - Cart data is in $_SESSION['cart']
 *   - OrderModel exists in ../models/OrderModel.php and has the required methods.
 */
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../controllers/OrderController.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController {
    
    private $orderModel;
    private $orderController;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->orderController = new OrderController();
    }
    
    /**
     * Create a Stripe checkout session from the current cart.
     * If an existing Stripe session exists for the order, reuse it.
     */
    public function createCheckoutSession() {
        // Check for authenticated user and non-empty cart.
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            http_response_code(403);
            exit("User not authenticated.");
        }
        
        $cart = $_SESSION['cart'] ?? null;
        if (!$cart || empty($cart)) {
            http_response_code(400);
            exit("Your cart is empty.");
        }
        
        // Create a new order from the current cart.
$orderResult = $this->orderModel->createOrder(
    $cart,
    $_SESSION['userId'],
    $user['phoneNumber'] ?? null,
    $user['address'] ?? null
);

$orderId = $orderResult['order']['OrderId'];

        // Retrieve the order so we can check its data.
        $order = $this->orderModel->getOrderById($orderId);
        if (!$order || $order['UserId'] != $_SESSION['userId'] || $order['Status'] !== 'pending') {
            http_response_code(403);
            exit("Unauthorized or invalid order.");
        }
        
        // Check if the order is expired (older than 24 hours).
        if (strtotime($order['OrderDate']) < strtotime('-24 hours')) {
            $this->orderModel->expireOrder($orderId);
            header("Location: /payment/expired?order_id=$orderId");
            exit;
        }
        
        // If the order already has a Stripe session ID, reuse it.
        if (!empty($order['StripeSessionId'])) {
            Stripe::setApiKey($_ENV["STRIPE_SECRET_KEY"]);
            $existingSession = Session::retrieve($order['StripeSessionId']);
            header("Location: " . $existingSession->url);
            exit;
        }
        
        // Get the ticket details associated with this order.
        $tickets = $this->orderModel->getTicketsByOrderId($orderId);
        if (empty($tickets)) {
            http_response_code(400);
            exit("No tickets found for this order.");
        }
        
        // Set the API key for Stripe.
        Stripe::setApiKey($_ENV["STRIPE_SECRET_KEY"]);
        
        // Build the line items array from each ticket.
        $lineItems = array_map(function ($ticket) {
            // You may want to change the mapping if you need to convert event type to a different display name.
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $ticket['PassType'] . ' - ' . $ticket['EventName']
                    ],
                    'unit_amount' => intval($ticket['Price'] * 100),
                ],
                'quantity' => 1,
            ];
        }, $tickets);
        
        // Create a new Stripe Checkout session.
        $session = Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => "http://localhost/payment/success?session_id={CHECKOUT_SESSION_ID}",
    'cancel_url'  => "http://localhost/payment/cancel?order_id=$orderId",
    'metadata'    => [
        'order_id' => $orderId
    ],
    'phone_number_collection' => [
        'enabled' => true
    ],
    'billing_address_collection' => 'required'
]);

        
        // Store the new Stripe session ID with the order.
        $this->orderModel->setStripeSessionId($orderId, $session->id);
        
        // Redirect the user to the Stripe Checkout session.
        header("Location: " . $session->url);
        exit;
    }
    
    /**
     * Handles the Stripe success redirect.
     * Verifies payment is completed, marks order as paid, and clears the cart.
     */
    public function showSuccessPage() {
        $view = 'payment_success';
        $status = 'error';
        $message = 'Unknown error occurred.';
        $sessionId = $_GET['session_id'] ?? null;
        
        if (!$sessionId) {
            $message = 'Missing session ID.';
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }
        
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        
        try {
            $session = Session::retrieve($sessionId);
        } catch (Exception $e) {
            $message = 'Error retrieving session: ' . $e->getMessage();
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }
        
        if ($session->payment_status !== 'paid') {
            $message = 'Payment not completed. Status: ' . $session->payment_status;
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }
        
        $orderId = $this->orderModel->getOrderIdBySessionId($sessionId);
        if (!$orderId) {
            $message = 'No matching order found.';
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }
        
        $order = $this->orderModel->getOrderById($orderId);
if ($order['Status'] !== 'paid') {
    $this->orderModel->markOrderAsPaid($orderId);
    
    // Expand Stripe session to access customer details
    $session = \Stripe\Checkout\Session::retrieve($sessionId, ['expand' => ['customer_details']]);
    $phone = $session->customer_details->phone ?? null;
    $addressObj = $session->customer_details->address ?? null;

    // Format the address into a single string
    $address = $addressObj
        ? "{$addressObj->line1}, {$addressObj->postal_code}, {$addressObj->city}, {$addressObj->country}"
        : null;

    // Store into database
    $this->orderModel->grabContactDetails($orderId, $phone, $address);
}


        $this->orderController->generateOrderDocuments($orderId);

        $status = 'success';
        $message = 'Thank you! Your order has been confirmed, and your tickets have been added to your personal program.';
        
        // Clear the cart after successful payment.
        unset($_SESSION['cart']);
        
        require __DIR__ . '/../views/pages/payment.php';
    }
    
    /**
     * Handles the Stripe cancel redirect.
     */
    public function showCancelPage() {
        $view = 'payment_cancel';
        $orderId = $_GET['order_id'] ?? null;
        
        $status = 'error';
        $message = 'Your payment was cancelled.';
        
        if ($orderId && is_numeric($orderId)) {
            $order = $this->orderModel->getOrderById($orderId);
            if ($order && $order['Status'] === 'pending') {
                $message = 'You cancelled your payment. Your reservation is still being held for a limited time.';
                $status = 'notice';
            }
        }
        
        require __DIR__ . '/../views/pages/payment.php';
    }
    
    /**
     * Handles the expired order redirect.
     */
    public function showExpiredPage() {
        $view = 'payment_expired';
        $status = 'error';
        $message = 'Your order has expired because it was not paid in time.';
        
        require __DIR__ . '/../views/pages/payment.php';
    }
}
