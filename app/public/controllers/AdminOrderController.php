<?php
require_once(__DIR__ . "/../models/OrderModel.php");

/**
 * AdminOrderController handles all administrative operations related to orders
 * This controller provides functionality for order management in the admin panel
 * including viewing, updating, and exporting order data
 */
class AdminOrderController {
    // Instance of OrderModel for database operations
    private $orderModel;

    /**
     * Constructor to initialize the controller
     * Creates an instance of OrderModel for handling database operations
     */
    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    /**
     * Lists all orders with simple pagination
     * 
     * @param array $filters Optional filters to apply to the order list
     * @param string $searchTerm Search term to filter orders by customer name/email
     * @param string $sortBy Field to sort orders by (default: OrderDate)
     * @param string $sortOrder Sorting direction - 'asc' or 'desc' (default: desc)
     * @param int $page Current page number for pagination (default: 1)
     * @return array Contains orders data, pagination info, and applied filters
     */
    public function index($filters = [], $searchTerm = '', $sortBy = 'OrderDate', $sortOrder = 'desc', $page = 1) {
        // Set number of orders per page
        $perPage = 10;
        
        // Fetch orders from the database (limited to 1000 for performance)
        // NOTE: This method currently doesn't implement proper pagination in the query
        $orders = $this->orderModel->getOrders(1000); // Get a reasonable number of orders
        
        // Get total count of orders for pagination calculation
        $totalOrders = $this->orderModel->getTotalOrdersCount();
        $totalPages = ceil($totalOrders / $perPage);
        
        // Return data structure that maintains backward compatibility with existing views
        return [
            'orders' => $orders,          // Array of order records
            'total' => $totalOrders,      // Total number of orders
            'currentPage' => $page,       // Current page number
            'totalPages' => $totalPages,  // Total number of pages
            'sortBy' => $sortBy,          // Field being sorted by
            'sortOrder' => $sortOrder,    // Sort direction
            'filters' => $filters,        // Applied filters
            'searchTerm' => $searchTerm   // Search term if any
        ];
    }

    /**
     * Get detailed information for a specific order including customer and tickets
     * 
     * @param int $orderId The ID of the order to retrieve
     * @return array|false Returns order details with user and tickets data, or false if not found
     */
    public function getOrder($orderId) {
        // Fetch the order from the database
        $order = $this->orderModel->getOrderById($orderId);
        
        // Return false if order not found
        if (!$order) {
            return false;
        }
        
        // Initialize user variable
        $user = null;
        
        // If order has an associated user, fetch user details
        if ($order['UserId']) {
            // Dynamically require the user model
            require_once(__DIR__ . "/../models/AdminUserModel.php");
            $userModel = new AdminUserModel();
            $user = $userModel->getUserById($order['UserId']);
        }
        
        // Get all tickets associated with this order
        $tickets = $this->orderModel->getTicketsByOrderId($orderId);
        
        // Return combined data structure
        return [
            'order' => $order,      // Order information
            'user' => $user,        // Customer information (null if guest order)
            'tickets' => $tickets   // Array of tickets for this order
        ];
    }

    /**
     * Update the status of an order
     * Validates status before updating to ensure data integrity
     * 
     * @param int $orderId The ID of the order to update
     * @param string $status New status to set (must be one of: pending, paid, completed, cancelled, refunded)
     * @return array Success status with message
     */
    public function updateOrderStatus($orderId, $status) {
        // Define valid status values
        $validStatuses = ['pending', 'paid', 'completed', 'cancelled', 'refunded'];
        
        // Validate the provided status
        if (!in_array($status, $validStatuses)) {
            return ['success' => false, 'message' => 'Invalid status provided.'];
        }
        
        // Update the order status in the database
        return $this->orderModel->updateOrderStatus($orderId, $status);
    }

    /**
     * Export orders to CSV file with direct download
     * Creates a CSV file with order data and forces browser download
     * 
     * @param array $filters Optional filters to apply before export
     * @param string $searchTerm Optional search term to filter orders
     * @return void Outputs CSV file directly to browser and exits
     */
    public function exportOrders($filters = [], $searchTerm = '') {
        // Fetch orders for export (limited to 1000 for performance)
        // NOTE: Currently doesn't apply filters or search term to the query
        $orders = $this->orderModel->getOrders(1000);
        
        // Generate filename with timestamp for uniqueness
        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Set appropriate HTTP headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Open PHP output stream for writing CSV data
        $output = fopen('php://output', 'w');
        
        // Write CSV header row with column names
        fputcsv($output, [
            'Order ID', 
            'Date', 
            'Customer Name',
            'Email',
            'Phone',
            'Status',
            'Total Amount',
            'Tickets'
        ]);
        
        // Add data rows to CSV file
        foreach ($orders as $order) {
            // Write order data to CSV with proper formatting and null handling
            fputcsv($output, [
                $order['OrderId'],
                $order['OrderDate'],
                $order['CustomerName'] ?? '',           // Use empty string if null
                $order['CustomerEmail'] ?? '',          // Use empty string if null
                $order['PhoneNumber'] ?? '',            // Use empty string if null
                $order['Status'] ?? 'pending',          // Default to 'pending' if null
                $order['Amount'] ?? 'N/A',              // Show 'N/A' if amount is null
                $order['TicketCount'] ?? 0              // Default to 0 if count is null
            ]);
        }
        
        // Close the output stream
        fclose($output);
        // Exit script execution after file download is complete
        exit();
    }
}