<?php
require_once(__DIR__ . "/BaseModel.php");

class HomeModel extends BaseModel
{
    public function getHeroSlides()
    {
        $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'hero_slide' ORDER BY EventType ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSection($eventType, $section)
    {
        $stmt = self::$pdo->prepare("SELECT Title, Content FROM Content WHERE EventType = ? AND Section = ? LIMIT 1");
        $stmt->execute([$eventType, $section]);
        return $stmt->fetch();
    }
    
    public function getLocationOptions()
    {
    $stmt = self::$pdo->prepare("SELECT Title, Content FROM Content WHERE Section = 'location_option'");
    $stmt->execute();
    return $stmt->fetchAll();
    }

    public function getEventCards()
    {
    $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'event_card' ORDER BY EventType ASC");
    $stmt->execute();
    return $stmt->fetchAll();
    }

    public function getLorentz(): array {
        $sql = "SELECT LorentzId, Description, StartDate, StartDateTime, EndDateTime
                FROM Lorentz
                ORDER BY LorentzId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
