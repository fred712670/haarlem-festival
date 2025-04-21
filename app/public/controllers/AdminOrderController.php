<?php
require_once(__DIR__ . "/../models/OrderModel.php");

class AdminOrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    // Lists all orders with simple pagination
    public function index($filters = [], $searchTerm = '', $sortBy = 'OrderDate', $sortOrder = 'desc', $page = 1) {
        $perPage = 10;
        
        // Get orders with simple pagination
        $orders = $this->orderModel->getOrders(1000); // Get a reasonable number of orders
        
        // Get total count for pagination
        $totalOrders = $this->orderModel->getTotalOrdersCount();
        $totalPages = ceil($totalOrders / $perPage);
        
        // Return the same structure as before to maintain compatibility
        return [
            'orders' => $orders,
            'total' => $totalOrders,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'filters' => $filters,
            'searchTerm' => $searchTerm
        ];
    }

    // Get a specific order by ID with all related tickets
    public function getOrder($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order) {
            return false;
        }
        
        // Get customer info
        $user = null;
        if ($order['UserId']) {
            require_once(__DIR__ . "/../models/AdminUserModel.php");
            $userModel = new AdminUserModel();
            $user = $userModel->getUserById($order['UserId']);
        }
        
        // Get tickets for this order
        $tickets = $this->orderModel->getTicketsByOrderId($orderId);
        
        return [
            'order' => $order,
            'user' => $user,
            'tickets' => $tickets
        ];
    }

    // Update an order's status
    public function updateOrderStatus($orderId, $status) {
        $validStatuses = ['pending', 'paid', 'completed', 'cancelled', 'refunded'];
        
        if (!in_array($status, $validStatuses)) {
            return ['success' => false, 'message' => 'Invalid status provided.'];
        }
        
        return $this->orderModel->updateOrderStatus($orderId, $status);
    }

    // Export orders to CSV file with direct download
    public function exportOrders($filters = [], $searchTerm = '') {
        // Get orders
        $orders = $this->orderModel->getOrders(1000);
        
        // Set up filename
        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // Add CSV header
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
        
        // Add data rows
        foreach ($orders as $order) {
            // Write order data to CSV
            fputcsv($output, [
                $order['OrderId'],
                $order['OrderDate'],
                $order['CustomerName'] ?? '',
                $order['CustomerEmail'] ?? '',
                $order['PhoneNumber'] ?? '',
                $order['Status'] ?? 'pending',
                $order['Amount'] ?? 'N/A',
                $order['TicketCount'] ?? 0
            ]);
        }
        
        // Close the file and end execution
        fclose($output);
        exit();
    }
}