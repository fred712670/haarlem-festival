<?php
require_once(__DIR__ . "/BaseModel.php");

class OrderModel extends BaseModel {

    public function createOrder($order){
        // Insert the order into the 'orders' table
        $orderQuery = "INSERT INTO `Order` (UserId, OrderDate, PhoneNumber, Address)
                    VALUES (:UserId, :OrderDate, :PhoneNumber, :Address)";

        $currentDateTime = date('Y-m-d H:i:s');
        $null = null;

        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':UserId', $_SESSION['userId']);
        $stmt->bindParam(':OrderDate', $currentDateTime);
        $stmt->bindParam(':PhoneNumber', $null);
        $stmt->bindParam(':Address', $null);
        $stmt->execute();

        // Get the OrderId of the newly inserted order
        $orderId = self::$pdo->lastInsertId();

        // Now loop through each ticket in the order and insert them into the tickets table
        foreach ($order as $ticket) {
            for ($i = 0; $i < $ticket['quantity']; $i++) {
                $ticketQuery = "INSERT INTO Ticket (OrderId, Price, PassType, IsValid, EventId)
                                VALUES (:OrderId, :Price, :PassType, :IsValid, :EventId)";
                $isValid = 1; // Assume tickets are valid when created

                // Prepare the statement for inserting each ticket
                $stmt = self::$pdo->prepare($ticketQuery);
                $stmt->bindParam(':OrderId', $orderId);
                $stmt->bindParam(':Price', $ticket['price']);
                $stmt->bindParam(':PassType', $null);  // Set PassType as null or another default value
                $stmt->bindParam(':IsValid', $isValid);
                $stmt->bindParam(':EventId', $ticket['eventId']);
                $stmt->execute();
            }
        }
    }

    public function getUserOrders($userId){
        $orderQuery = "
        SELECT o.OrderId, o.OrderDate, o.Status, t.TicketId, t.Price, t.PassType, t.IsValid, t.EventId, e.Name AS EventName
        FROM `Order` o
        LEFT JOIN Ticket t ON o.OrderId = t.OrderId
        LEFT JOIN Event e ON t.EventId = e.EventId
        WHERE o.UserId = :userId
        ORDER BY o.OrderDate DESC";  // Order by the latest orders

        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        // Fetch the results
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group tickets by OrderId
        $orders = [];
        foreach ($reservations as $reservation) {
            $orders[$reservation['OrderId']]['orderDetails'] = [
                'OrderId' => $reservation['OrderId'],
                'OrderDate' => $reservation['OrderDate'],
                'Status' => $reservation['Status']
            ];
            $orders[$reservation['OrderId']]['tickets'][] = [
                'TicketId' => $reservation['TicketId'],
                'Price' => $reservation['Price'],
                'PassType' => $reservation['PassType'],
                'IsValid' => $reservation['IsValid'],
                'EventId' => $reservation['EventId'],
                'EventName' => $reservation['EventName']  // Event name from the Event table
            ];
        }

        return $orders;
    }
}