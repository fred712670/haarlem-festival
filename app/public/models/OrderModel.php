<?php
require_once(__DIR__ . "/BaseModel.php");

class OrderModel extends BaseModel {

    public function createOrder($order){
        // Insert the order into the 'orders' table
        $orderQuery = "INSERT INTO `Order` (UserId, Amount, Status, OrderDate, PhoneNumber, Address) 
                       VALUES (:UserId, :Amount, :Status, :OrderDate, :PhoneNumber, :Address)";

        $currentDateTime = date('Y-m-d H:i:s');
        $null = null;

        $stmt = self::$pdo->prepare($orderQuery);
        $stmt->bindParam(':UserId', $_SESSION['userId']);
        $stmt->bindParam(':Amount', $order['Amount']);
        $stmt->bindParam(':Status', $order['Status']);
        $stmt->bindParam(':OrderDate', $currentDateTime);
        $stmt->bindParam(':PhoneNumber', $null);
        $stmt->bindParam(':Address', $null);
        $stmt->execute();
        
        // Get the OrderId of the newly inserted order
        $orderId = self::$pdo->lastInsertId();

        // Insert each ticket into the 'tickets' table
        foreach ($order as $ticket) {
            $ticketQuery = "INSERT INTO Ticket (OrderId, Price, PassType, IsValid, EventId)
                            VALUES (:OrderId, :Price, :PassType, :IsValid, :EventId)";

            $isValid = 1;                

            $stmt = self::$pdo->prepare($ticketQuery);
            $stmt->bindParam(':OrderId', $orderId);
            $stmt->bindParam(':Price', $ticket['Price']);
            $stmt->bindParam(':PassType', $$null);
            $stmt->bindParam(':IsValid', $isValid);
            $stmt->bindParam(':EventId', $ticket['EventId']);
            $stmt->execute();
        }

        return $orderId;

    }

}