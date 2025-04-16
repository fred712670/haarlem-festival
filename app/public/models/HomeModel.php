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
/**
 * Get a track by ID
 * 
 * @param int $trackId Track ID
 * @return array|null Track data
 */
public function getTrackById($trackId) {
    try {
        $query = "SELECT 
                TrackId as id,
                Title as title,
                Description as description,
                audio_file
            FROM JazzTrack
            WHERE TrackId = :trackId";
            
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':trackId', $trackId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error fetching track: " . $e->getMessage());
        return null;
    }
}
}

