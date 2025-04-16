<?php
require_once __DIR__ . '/BaseModel.php';

class DanceModel extends BaseModel
{
    public function getAllArtists()
    {
        try {
            $query = "SELECT ArtistId, Name, Genre, ProfileImageName FROM DanceArtist";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 🛠️ Debugging Output - Log fetched data
            error_log("Fetched artists: " . print_r($artists, true));
            return $artists ?: [];
        } catch (Exception $e) {
            error_log("Error fetching artists: " . $e->getMessage());
            return [];
        }
    }

    public function getArtist($id)
    {   
        try {
            $query = "SELECT * FROM DanceArtist WHERE ArtistId = :id";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $artist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$artist) {
            return null;
        }

        return $artist;

        } catch (Exception $e) {
            error_log("Error fetching artist details: " . $e->getMessage());
            return null;
        }
    }

    public function getContentByEventAndSection($event, $section)
    {
        try {
            $query = "SELECT Content FROM Content WHERE EventType = :event AND Section = :section LIMIT 1";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':event', $event);
            $stmt->bindParam(':section', $section);
            $stmt->execute();
            return $stmt->fetchColumn(); // returns string
        } catch (Exception $e) {
            error_log("Error fetching content: " . $e->getMessage());
            return '';
        }
    }

    public function getDanceEvents()
    {
        try {
            $query = "SELECT * FROM DanceEvent ORDER BY StartDateTime ASC";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Fetched dance events: " . print_r($events, true));
            return $events ?: [];
    } catch (Exception $e) {
        error_log("Error fetching dance events: " . $e->getMessage());
        return [];
    }
}

    public function getArtistSongs($artistId)
{
    try {
        $query = "SELECT SongId, Title, ReleaseYear, Credits, Description, SongFileName, ImageName
          FROM DanceSong
          WHERE ArtistId = :artistId";


        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $stmt->execute();
        $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Fetched songs for artist ID $artistId: " . print_r($songs, true));
        return $songs ?: [];
    } catch (Exception $e) {
        error_log("Error fetching songs for artist $artistId: " . $e->getMessage());
        return [];
    }
}

public function getArtistPerformances($artistId)
{
    try {
        $query = "SELECT de.DanceEventId, de.Description, de.Location, de.StartDateTime,
                         de.TimeSlot, de.DurationByMinute, de.TicketsAvailable, de.Price
                  FROM DancePerformance dp
                  INNER JOIN DanceEvent de ON dp.DanceEventId = de.DanceEventId
                  WHERE dp.DanceArtistId = :artistId
                  ORDER BY de.StartDateTime ASC";

        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $stmt->execute();
        $performances = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Fetched performances for artist ID $artistId: " . print_r($performances, true));
        return $performances ?: [];
    } catch (Exception $e) {
        error_log("Error fetching performances for artist $artistId: " . $e->getMessage());
        return [];
    }
}

}
