<?php
require_once(__DIR__ . "/BaseModel.php");

class OrderModel extends BaseModel {

    public function createOrder($order, $phone = null, $address = null) {
        $currentDateTime = date('Y-m-d H:i:s');
        $null = null;

        $orderQuery = "INSERT INTO `Order` (UserId, OrderDate, PhoneNumber, Address)
                       VALUES (:UserId, :OrderDate, :PhoneNumber, :Address)";

        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':UserId', $_SESSION['userId']);
        $stmt->bindParam(':OrderDate', $currentDateTime);
        $stmt->bindParam(':PhoneNumber', $phone);
        $stmt->bindParam(':Address', $address);
        $stmt->execute();

        $orderId = self::$pdo->lastInsertId();

        foreach ($order as $ticket) {
            for ($i = 0; $i < $ticket['quantity']; $i++) {
                $ticketQuery = "INSERT INTO Ticket (OrderId, Price, PassType, IsValid, EventId)
                                VALUES (:OrderId, :Price, :PassType, :IsValid, :EventId)";
                $isValid = 1;

                $stmt = self::$pdo->prepare($ticketQuery);
                $stmt->bindParam(':OrderId', $orderId);
                $stmt->bindParam(':Price', $ticket['price']);
                $stmt->bindParam(':PassType', $null);
                $stmt->bindParam(':IsValid', $isValid);
                $stmt->bindParam(':EventId', $ticket['eventId']);
                $stmt->execute();
            }
        }

        return $orderId;
    }

    public function getUserOrders($userId) {
        $orderQuery = "
        SELECT o.OrderId, o.OrderDate, o.Status, t.TicketId, t.Price, t.PassType, t.IsValid, t.EventId, e.Name AS EventName
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
                'EventName' => $reservation['EventName']
            ];
        }

        return $orders;
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
            SELECT t.TicketId, t.Price, t.PassType, t.IsValid, t.EventId, e.Name AS EventName
            FROM Ticket t
            JOIN Event e ON t.EventId = e.EventId
            WHERE t.OrderId = :orderId";
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
}
