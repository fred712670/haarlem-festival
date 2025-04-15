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
        // Insert the order into the 'Order' table.
        $orderQuery = "INSERT INTO `Order` (UserId, OrderDate, PhoneNumber, Address)
                    VALUES (:UserId, :OrderDate, :PhoneNumber, :Address)";
                    
        $currentDateTime = date('Y-m-d H:i:s');
        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':UserId', $userId);
        $stmt->bindParam(':OrderDate', $currentDateTime);
        $stmt->bindParam(':PhoneNumber', $phone);
        $stmt->bindParam(':Address', $address);
        $stmt->execute();

        // Get the generated OrderId.
        $orderId = self::$pdo->lastInsertId();

        // Build an array of order details.
        $orderDetails = [
            'OrderId'    => $orderId,
            'UserId'     => $userId,
            'OrderDate'  => $currentDateTime,
            'PhoneNumber'=> $phone,
            'Address'    => $address
        ];

        // Retrieve the customer's name from the User table.
        // Adjust table/column names if necessary.
        $userQuery = "SELECT FullName FROM User WHERE UserId = :userId LIMIT 1";
        $stmtUser = self::$pdo->prepare($userQuery);
        $stmtUser->bindParam(':userId', $userId);
        $stmtUser->execute();
        $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
        $orderDetails['CustomerName'] = $userData ? $userData['FullName'] : 'Unknown';

        $insertedTickets = [];
        // Loop through each ticket in the cart.
        $orderId = self::$pdo->lastInsertId();

        foreach ($order as $ticket) {
            // For each quantity, insert a separate ticket.
            for ($i = 0; $i < $ticket['quantity']; $i++) {
                $ticketQuery = "INSERT INTO Ticket (OrderId, Price, PassType, IsValid, EventId)
                                VALUES (:OrderId, :Price, :PassType, :IsValid, :EventId)";
                $isValid = 1; // Tickets are valid on creation.
                $stmtTicket = self::$pdo->prepare($ticketQuery);
                $stmtTicket->bindParam(':OrderId', $orderId);
                $stmtTicket->bindParam(':Price', $ticket['price']);
                $stmtTicket->bindParam(':PassType', $ticket['ticketType']);
                $stmtTicket->bindParam(':IsValid', $isValid);
                $stmtTicket->bindParam(':EventId', $ticket['eventId']);
                $stmtTicket->execute();
                $ticketId = self::$pdo->lastInsertId();

                // Save all the relevant ticket information.
                $insertedTickets[] = [
                    'TicketId'  => $ticketId,
                    'Price'     => $ticket['price'],
                    'PassType'  => $ticket['ticketType'],
                    'IsValid'   => $isValid,
                    'EventId'   => $ticket['eventId'],
                    'EventName' => isset($ticket['eventName']) ? $ticket['eventName'] : ''
                ];
            }
        }
        // Return both the order details and the inserted tickets.
        return [
            'order'   => $orderDetails,
            'tickets' => $insertedTickets
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
            $specificQuery = "SELECT DateTime AS DateTime FROM JazzEvent WHERE EventId = :eventId LIMIT 1";
            break;
        case 'DanceEvent':
            $specificQuery = "SELECT StartDateTime AS DateTime FROM DanceEvent WHERE EventId = :eventId LIMIT 1";
            break;
        case 'HistoryTourSchedule':
            $specificQuery = "SELECT TourDate AS DateTime FROM HistoryTourSchedule WHERE EventId = :eventId LIMIT 1";
            break;
        case 'Restaurant':
            $specificQuery = "SELECT FirstStart AS DateTime FROM Restaurant WHERE EventId = :eventId LIMIT 1";
            break;
        default:
            $specificQuery = "";
            break;
    }
    
    $standardDetails = [];
    if ($specificQuery != "") {
        $stmtSpecific = self::$pdo->prepare($specificQuery);
        $stmtSpecific->bindParam(':eventId', $eventId);
        $stmtSpecific->execute();
        $specificDetails = $stmtSpecific->fetch(PDO::FETCH_ASSOC);
        if ($specificDetails) {
            $standardDetails = $specificDetails;
        }
    }
    // Merge a standardized event name.
    // Here we assume the Event table has a 'Name' column.
    $standardDetails['Name'] = $event['EventType'];
    
    return $standardDetails;
}
public function getOrderById($orderId) {
    $query = "SELECT * FROM `Order` WHERE OrderId = :orderId LIMIT 1";
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
    
    public function getOrderById($orderId) {
        $query = "SELECT * FROM `Order` WHERE OrderId = :orderId LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

}
