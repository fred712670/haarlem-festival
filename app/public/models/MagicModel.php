<?php
require_once(__DIR__ . "/BaseModel.php");

class MagicModel extends BaseModel {

    public function getLorentz(): array {
        $sql = "SELECT LorentzId, Description, StartDate, StartDateTime, EndDateTime
                FROM Lorentz
                ORDER BY LorentzId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}