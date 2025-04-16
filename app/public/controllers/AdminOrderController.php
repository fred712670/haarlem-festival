<?php
require_once(__DIR__ . "/../models/OrderModel.php");

class AdminOrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    // Lists all orders with filtering and pagination
    public function index($filters = [], $searchTerm = '', $sortBy = 'OrderDate', $sortOrder = 'desc', $page = 1) {
        $perPage = 10;
        
        // Get orders with filtering, searching, sorting
        $result = $this->orderModel->getOrders($filters, $searchTerm, $sortBy, $sortOrder, $page, $perPage);
        
        // Get total count for pagination
        $totalOrders = $this->orderModel->getTotalOrdersCount($filters, $searchTerm);
        $totalPages = ceil($totalOrders / $perPage);
        
        return [
            'orders' => $result,
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
        
        // Prepare detailed ticket info with event details
        $ticketsWithDetails = [];
        foreach ($tickets as $ticket) {
            $eventDetails = $this->orderModel->getEventDetails($ticket['EventId']);
            $ticketsWithDetails[] = array_merge($ticket, [
                'EventDetails' => $eventDetails
            ]);
        }
        
        return [
            'order' => $order,
            'user' => $user,
            'tickets' => $ticketsWithDetails
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

    // Export orders to CSV file
    public function exportOrders($filters = [], $searchTerm = '') {
        // Get all orders without pagination
        $orders = $this->orderModel->getOrders($filters, $searchTerm, 'OrderDate', 'desc', 1, 1000000);
        
        // Prepare filename and path
        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = __DIR__ . '/../../public/assets/exports/';
        $fullPath = $filePath . $filename;
        
        // Ensure the exports directory exists
        if (!is_dir($filePath)) {
            mkdir($filePath, 0755, true);
        }
        
        // Open file for writing
        $fp = fopen($fullPath, 'w');
        
        // Add CSV header
        fputcsv($fp, [
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
            // Get user info for this order
            $userInfo = '';
            $userEmail = '';
            
            if ($order['UserId']) {
                require_once(__DIR__ . "/../models/AdminUserModel.php");
                $userModel = new AdminUserModel();
                $user = $userModel->getUserById($order['UserId']);
                
                if ($user) {
                    $userInfo = $user['FullName'];
                    $userEmail = $user['Email'];
                }
            }
            
            // Get count of tickets for this order
            $tickets = $this->orderModel->getTicketsByOrderId($order['OrderId']);
            $ticketCount = count($tickets);
            
            // Write order data to CSV
            fputcsv($fp, [
                $order['OrderId'],
                $order['OrderDate'],
                $userInfo,
                $userEmail,
                $order['PhoneNumber'] ?? '',
                $order['Status'] ?? 'pending',
                $order['Amount'] ?? 'N/A',
                $ticketCount
            ]);
        }
        
        // Close the file
        fclose($fp);
        
        return [
            'success' => true,
            'filename' => $filename,
            'filepath' => $fullPath
        ];
    }
}