<?php
require_once(__DIR__ . "/BaseModel.php");

class OrderModel extends BaseModel {


    public function createOrder($order){
        // Insert the order into the 'orders' table
        $orderQuery = "INSERT INTO orders (UserId, Amount, Status, OrderDate, PhoneNumber, Address) 
                       VALUES (:UserId, :Amount, :Status, :OrderDate, :PhoneNumber, :Address)";
        
        $stmt = $this->db->prepare($orderQuery);
        $stmt->bindParam(':UserId', $order['UserId']);
        $stmt->bindParam(':Amount', $order['Amount']);
        $stmt->bindParam(':Status', $order['Status']);
        $stmt->bindParam(':OrderDate', $order['OrderDate']);
        $stmt->bindParam(':PhoneNumber', $order['PhoneNumber']);
        $stmt->bindParam(':Address', $order['Address']);
        $stmt->execute();
        
        // Get the OrderId of the newly inserted order
        $orderId = $this->db->lastInsertId();

        // Insert each ticket into the 'tickets' table
        foreach ($postData['tickets'] as $ticket) {
            $ticketQuery = "INSERT INTO tickets (OrderId, Price, PassType, IsValid, EventId)
                            VALUES (:OrderId, :Price, :PassType, :IsValid, :EventId)";

            $stmt = $this->db->prepare($ticketQuery);
            $stmt->bindParam(':OrderId', $orderId);
            $stmt->bindParam(':Price', $ticket['Price']);
            $stmt->bindParam(':PassType', $ticket['PassType']);
            $stmt->bindParam(':IsValid', $ticket['IsValid']);
            $stmt->bindParam(':EventId', $ticket['EventId']);
            $stmt->execute();
        }

        return $orderId; // Return the OrderId for further processing if needed

    }

}