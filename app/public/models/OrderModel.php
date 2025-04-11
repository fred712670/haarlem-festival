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

        $insertedTickets = [];
        // Loop through each ticket in the cart.
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

    public function getUserOrders($userId) {
        $orderQuery = "
        SELECT o.OrderId, o.OrderDate, o.Status, t.TicketId, t.Price, t.PassType, t.IsValid, t.EventId, e.EventType
        FROM `Order` o
        LEFT JOIN Ticket t ON o.OrderId = t.OrderId
        LEFT JOIN Event e ON t.EventId = e.EventId
        WHERE o.UserId = :userId
        ORDER BY o.OrderDate DESC";  // Latest orders first.

        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group tickets by OrderId.
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
                'EventName' => $reservation['Name']  // Event name from the Event table.
            ];
        }

        return $orders;
    }
}
