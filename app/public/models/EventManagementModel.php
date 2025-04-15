<?php
require_once(__DIR__ . '/../models/BaseModel.php');

class EventManagementModel extends BaseModel
{
    public function getSlides() {
        $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'hero_slide' ORDER BY ContentId ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function storeSlide($title, $eventType, $imageName) {
        $stmt = self::$pdo->prepare("INSERT INTO Content (Title, EventType, Section, ImageName) VALUES (?, ?, 'hero_slide', ?)");
        return $stmt->execute([$title, $eventType, $imageName]);
    }
    
    public function updateSlide($id, $title, $eventType, $imageName) {
        $stmt = self::$pdo->prepare("UPDATE Content SET Title = ?, EventType = ?, ImageName = ? WHERE ContentId = ? AND Section = 'hero_slide'");
        return $stmt->execute([$title, $eventType, $imageName, $id]);
    }
    
    public function deleteSlide($id) {
        $stmt = self::$pdo->prepare("DELETE FROM Content WHERE ContentId = ? AND Section = 'hero_slide'");
        return $stmt->execute([$id]);
    }
    
    public function getContent() {
        $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section != 'hero_slide' ORDER BY ContentId DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function updateContent($id, $title, $section, $eventType, $content, $imageName = null)
    {
        $stmt = self::$pdo->prepare("UPDATE Content SET Title = ?, Section = ?, EventType = ?, Content = ?, ImageName = ? WHERE ContentId = ?");
        return $stmt->execute([$title, $section, $eventType, $content, $imageName, $id]);
    }

    public function storeContent($title, $section, $eventType, $content, $imageName = null)
    {
        $stmt = self::$pdo->prepare("INSERT INTO Content (Title, Section, EventType, Content, ImageName) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $section, $eventType, $content, $imageName]);
    }
    
    public function deleteContent($id) {
        $stmt = self::$pdo->prepare("DELETE FROM Content WHERE ContentId = ?");
        return $stmt->execute([$id]);
    }
    public function getLocationOptions()
    {
    $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'location_option' ORDER BY ContentId ASC");
    $stmt->execute();
    return $stmt->fetchAll();
    }

    public function getEventCards()
    {
    $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'event_card' ORDER BY ContentId ASC");
    $stmt->execute();
    return $stmt->fetchAll();
    }
}
