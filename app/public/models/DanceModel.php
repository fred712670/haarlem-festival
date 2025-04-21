<?php
require_once __DIR__ . '/BaseModel.php';

class DanceModel extends BaseModel
{
    // Fetch all dance artists with select public fields
    public function getAllArtists()
    {
        try {
            $query = "SELECT ArtistId, Name, Genre, ProfileImageName FROM DanceArtist";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();

            $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $artists ?: [];
        } catch (Exception $e) {
            error_log("Error fetching artists: " . $e->getMessage());
            return [];
        }
    }

    // Fetch full details for a single artist by ID
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

    // Retrieve custom content based on event and section (e.g. About, Shows, Passes)
    public function getContentByEventAndSection($event, $section)
    {
        try {
            $query = "SELECT Content FROM Content WHERE EventType = :event AND Section = :section LIMIT 1";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':event', $event);
            $stmt->bindParam(':section', $section);
            $stmt->execute();

            // Return content text as a string
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error fetching content: " . $e->getMessage());
            return '';
        }
    }

    // Fetch all scheduled dance events ordered chronologically
    public function getDanceEvents()
    {
        try {
            $query = "SELECT * FROM DanceEvent ORDER BY StartDateTime ASC";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();

            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $events ?: [];
        } catch (Exception $e) {
            error_log("Error fetching dance events: " . $e->getMessage());
            return [];
        }
    }

    // Fetch all songs tied to a specific dance artist
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

            return $songs ?: [];
        } catch (Exception $e) {
            error_log("Error fetching songs for artist $artistId: " . $e->getMessage());
            return [];
        }
    }

    // Fetch all performances for a specific artist by joining with DanceEvent
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

            return $performances ?: [];
        } catch (Exception $e) {
            error_log("Error fetching performances for artist $artistId: " . $e->getMessage());
            return [];
        }
    }
}
