<?php
require_once(__DIR__ . '/../models/BaseModel.php');

class EventManagementModel extends BaseModel
{
    // Fetch all hero slides, ordered by ID
    public function getSlides() {
        $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'hero_slide' ORDER BY ContentId ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // Insert a new hero slide entry
    public function storeSlide($title, $eventType, $imageName) {
        $stmt = self::$pdo->prepare("INSERT INTO Content (Title, EventType, Section, ImageName) VALUES (?, ?, 'hero_slide', ?)");
        return $stmt->execute([$title, $eventType, $imageName]);
    }
    // Update an existing hero slide by ID
    public function updateSlide($id, $title, $eventType, $imageName) {
        $stmt = self::$pdo->prepare("UPDATE Content SET Title = ?, EventType = ?, ImageName = ? WHERE ContentId = ? AND Section = 'hero_slide'");
        return $stmt->execute([$title, $eventType, $imageName, $id]);
    }
    // Delete a hero slide by ID
    public function deleteSlide($id) {
        $stmt = self::$pdo->prepare("DELETE FROM Content WHERE ContentId = ? AND Section = 'hero_slide'");
        return $stmt->execute([$id]);
    }
    // Fetch all non-slide content entries
    public function getContent() {
        $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section != 'hero_slide' ORDER BY ContentId DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // Update a content entry, optionally changing its image
    public function updateContent($id, $title, $section, $eventType, $content, $imageName = null)
    {
        $stmt = self::$pdo->prepare("UPDATE Content SET Title = ?, Section = ?, EventType = ?, Content = ?, ImageName = ? WHERE ContentId = ?");
        return $stmt->execute([$title, $section, $eventType, $content, $imageName, $id]);
    }
    // Insert a new content entry with optional image
    public function storeContent($title, $section, $eventType, $content, $imageName = null)
    {
        $stmt = self::$pdo->prepare("INSERT INTO Content (Title, Section, EventType, Content, ImageName) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $section, $eventType, $content, $imageName]);
    }
    // Delete a content entry by ID
    public function deleteContent($id) {
        $stmt = self::$pdo->prepare("DELETE FROM Content WHERE ContentId = ?");
        return $stmt->execute([$id]);
    }
    // Fetch all location option entries
    public function getLocationOptions()
    {
    $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'location_option' ORDER BY ContentId ASC");
    $stmt->execute();
    return $stmt->fetchAll();
    }
    // Fetch all event card entries
    public function getEventCards()
    {
    $stmt = self::$pdo->prepare("SELECT * FROM Content WHERE Section = 'event_card' ORDER BY ContentId ASC");
    $stmt->execute();
    return $stmt->fetchAll();
    }
}
