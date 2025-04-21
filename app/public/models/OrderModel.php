<?php
require_once(__DIR__ . "/BaseModel.php");

class OrderModel extends BaseModel {

    /**
     * Inserts an order with its tickets and returns the order details along with each inserted ticket.
     *
     * Expected $order (the cart) is an array of ticket data arrays with keys:
     * - quantity
     * - price
     * - ticketType
     * - eventId
     * - eventName (optional, if available)
     *
     * @param array $order
     * @param int   $userId
     * @param string|null $phone
     * @param string|null $address
     * @return array  ['order' => orderDetails, 'tickets' => [ticketData, ...]]
     */
    public function createOrder($order, $userId, $phone = null, $address = null) {
    // Calculate the total amount for all tickets
    $amount = 0;
    foreach ($order as $ticket) {
        $amount += $ticket['price'] * $ticket['quantity'];
    }

    // Insert the order into the 'Order' table, including Amount
    $orderQuery = "INSERT INTO `Order` (UserId, OrderDate, PhoneNumber, Address, Amount)
                   VALUES (:UserId, :OrderDate, :PhoneNumber, :Address, :Amount)";
                   
    $currentDateTime = date('Y-m-d H:i:s');
    $stmt = self::$pdo->prepare($orderQuery);
    $stmt->bindParam(':UserId', $userId);
    $stmt->bindParam(':OrderDate', $currentDateTime);
    $stmt->bindParam(':PhoneNumber', $phone);
    $stmt->bindParam(':Address', $address);
    $stmt->bindParam(':Amount', $amount);
    $stmt->execute();

    // Get the generated OrderId.
    $orderId = self::$pdo->lastInsertId();

    // Retrieve the customer's name (not critical but kept for completeness)
    $userQuery = "SELECT FullName FROM User WHERE UserId = :userId LIMIT 1";
    $stmtUser = self::$pdo->prepare($userQuery);
    $stmtUser->bindParam(':userId', $userId);
    $stmtUser->execute();
    $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
    $customerName = $userData ? $userData['FullName'] : 'Unknown';

    // Insert tickets for each item in cart
    foreach ($order as $ticket) {
        for ($i = 0; $i < $ticket['quantity']; $i++) {
            $ticketQuery = "INSERT INTO Ticket (OrderId, Price, PassType, IsValid, EventId)
                            VALUES (:OrderId, :Price, :PassType, :IsValid, :EventId)";
            $isValid = 1;
            $stmtTicket = self::$pdo->prepare($ticketQuery);
            $stmtTicket->bindParam(':OrderId', $orderId);
            $stmtTicket->bindParam(':Price', $ticket['price']);
            $stmtTicket->bindParam(':PassType', $ticket['ticketType']);
            $stmtTicket->bindParam(':IsValid', $isValid);
            $stmtTicket->bindParam(':EventId', $ticket['eventId']);
            $stmtTicket->execute();
        }
    }
return [
    'order' => [
        'OrderId'       => $orderId,
        'UserId'        => $userId,
        'OrderDate'     => $currentDateTime,
        'PhoneNumber'   => $phone,
        'Address'       => $address,
        'Amount'        => $amount,
        'CustomerName'  => $customerName  // ✅ This is what the OrderController needs
    ],
    'tickets' => $this->getTicketsByOrderId($orderId)
];

}

/**
 * Retrieves detailed information for an event based on its EventId.
 * It first fetches the base event row from the Event table and then
 * performs an additional lookup based on EventType to fetch event-specific details.
 * Only the Location and DateTime are fetched and standardized.
 *
 * @param int $eventId
 * @return array|null  Standardized event info including Name, Location, and DateTime.
 */
public function getEventDetails($eventId) {
    // Fetch the base event details.
    $eventQuery = "SELECT * FROM Event WHERE EventId = :eventId LIMIT 1";
    $stmtEvent = self::$pdo->prepare($eventQuery);
    $stmtEvent->bindParam(':eventId', $eventId);
    $stmtEvent->execute();
    $event = $stmtEvent->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        return null;
    }
    
    // Depending on EventType, fetch event–specific details and alias location and datetime.
    switch ($event['EventType']) {
        case 'JazzEvent':
            $specificQuery = "SELECT StartDateTime AS DateTime, Location FROM JazzEvent WHERE EventId = :eventId LIMIT 1";
            break;
        case 'DanceEvent':
            $specificQuery = "SELECT StartDateTime AS DateTime, Location FROM DanceEvent WHERE EventId = :eventId LIMIT 1";
            break;
        case 'HistoryTourSchedule':
            $specificQuery = "SELECT TourDate AS DateTime FROM HistoryTourSchedule WHERE EventId = :eventId LIMIT 1";
            break;
        case 'Restaurant':
            $specificQuery = "SELECT FirstStart AS DateTime, Name FROM Restaurant WHERE EventId = :eventId LIMIT 1";
            break;
        default:
            $specificQuery = "";
            break;
    }
    
    $standardDetails = ['Name' => $event['EventType']]; // Default event name
    
    if ($specificQuery != "") {
        try {
            $stmtSpecific = self::$pdo->prepare($specificQuery);
            $stmtSpecific->bindParam(':eventId', $eventId);
            $stmtSpecific->execute();
            $specificDetails = $stmtSpecific->fetch(PDO::FETCH_ASSOC);
            if ($specificDetails) {
                $standardDetails = array_merge($standardDetails, $specificDetails);
            }
        } catch (PDOException $e) {
            // Log the error but continue with what we have
            error_log("Error fetching event details: " . $e->getMessage());
        }
    }
    
    return $standardDetails;
}
    public function getOrderById($orderId) {
    $query = "SELECT o.*, u.FullName AS CustomerName
              FROM `Order` o
              JOIN User u ON o.UserId = u.UserId
              WHERE o.OrderId = :orderId LIMIT 1";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function getUserOrders($userId) {
        $orderQuery = "
        SELECT o.OrderId, o.OrderDate, o.Status, t.TicketId, t.Price, t.PassType, t.IsValid, t.EventId, e.EventType
        FROM `Order` o
        LEFT JOIN Ticket t ON o.OrderId = t.OrderId
        LEFT JOIN Event e ON t.EventId = e.EventId
        WHERE o.UserId = :userId
        ORDER BY o.OrderDate DESC";

        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($reservations as $reservation) {
            $orders[$reservation['OrderId']]['orderDetails'] = [
                'OrderId'   => $reservation['OrderId'],
                'OrderDate' => $reservation['OrderDate'],
                'Status'    => $reservation['Status']
            ];
            $orders[$reservation['OrderId']]['tickets'][] = [
                'TicketId'  => $reservation['TicketId'],
                'Price'     => $reservation['Price'],
                'PassType'  => $reservation['PassType'],
                'IsValid'   => $reservation['IsValid'],
                'EventId'   => $reservation['EventId'],
            ];
        }
        return $orders;
    }

    public function validateTicket($ticketId) {
        // Update the ticket to mark it as used (set IsValid = 0)
        $query = "UPDATE Ticket SET IsValid = 0 WHERE TicketId = :ticketId AND IsValid = 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        // Return true if a ticket row was updated.
        return $stmt->rowCount() > 0;
    }

    public function setStripeSessionId($orderId, $sessionId) {
        $query = "UPDATE `Order` SET StripeSessionId = :sessionId WHERE OrderId = :orderId";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':sessionId', $sessionId);
        $stmt->execute();
    }

    public function getOrderIdBySessionId($sessionId) {
        $query = "SELECT OrderId FROM `Order` WHERE StripeSessionId = :sessionId LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':sessionId', $sessionId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTicketsByOrderId($orderId) {
    $query = "
        SELECT t.TicketId, t.Price, t.PassType, t.IsValid, t.EventId, e.EventType AS EventName
        FROM Ticket t
        JOIN Event e ON t.EventId = e.EventId
        WHERE t.OrderId = :orderId
    ";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':orderId', $orderId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function markOrderAsPaid($orderId) {
        $query = "UPDATE `Order` SET Status = 'paid' WHERE OrderId = :orderId";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
    }

    public function expireStaleOrders() {
        $query = "SELECT OrderId FROM `Order` WHERE Status = 'pending' AND OrderDate < NOW() - INTERVAL 24 HOUR";
        $stmt = self::$pdo->query($query);
        $expiredOrders = $stmt->fetchAll(PDO::FETCH_COLUMN);
        foreach ($expiredOrders as $orderId) {
            $this->expireOrder($orderId);
        }
    }

    public function expireOrder($orderId) {
        $updateOrder = "UPDATE `Order` SET Status = 'expired' WHERE OrderId = :orderId";
        $stmt = self::$pdo->prepare($updateOrder);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();

        $updateTickets = "UPDATE Ticket SET IsValid = 0 WHERE OrderId = :orderId";
        $stmt = self::$pdo->prepare($updateTickets);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
    }

    public function getLatestPendingOrderWithSession($userId) {
    $query = "SELECT * FROM `Order` 
              WHERE UserId = :userId AND Status = 'pending' AND StripeSessionId IS NOT NULL 
              ORDER BY OrderDate DESC LIMIT 1";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function grabContactDetails($orderId, $phone, $address) {
    $query = "UPDATE `Order` 
              SET PhoneNumber = :phone, Address = :address 
              WHERE OrderId = :orderId";

    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':orderId', $orderId);
    return $stmt->execute();
}

/**
 * get the list of orders
 * 
 * @return array List of orders
 */
public function getOrders($limit = 100) {
    $query = "SELECT o.*, u.FullName AS CustomerName, u.Email AS CustomerEmail,
              (SELECT COUNT(*) FROM Ticket WHERE OrderId = o.OrderId) AS TicketCount
              FROM `Order` o
              LEFT JOIN User u ON o.UserId = u.UserId
              ORDER BY o.OrderDate DESC
              LIMIT :limit";
    
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get total count of orders
 * 
 * @return int Total number of orders
 */
public function getTotalOrdersCount() {
    $query = "SELECT COUNT(*) FROM `Order`";
    $stmt = self::$pdo->query($query);
    return $stmt->fetchColumn();
}

/**
 * Update an order's status
 *
 * @param int $orderId Order ID
 * @param string $status New status
 * @return array Result of the operation
 */
public function updateOrderStatus($orderId, $status) {
    $query = "UPDATE `Order` SET Status = :status WHERE OrderId = :orderId";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':orderId', $orderId);
    
    try {
        $stmt->execute();
        return [
            'success' => true,
            'message' => 'Order status updated successfully.'
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to update order status: ' . $e->getMessage()
        ];
    }
}
}
