<?php
require_once(__DIR__ . "/BaseModel.php");

/**
 * Model for handling dance management database operations
 */
class DanceManagementModel extends BaseModel
{
    /**
     * Get count of artists
     */
    public function getArtistCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM DanceArtist";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting artist count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of events
     */
    public function getEventCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM DanceEvent";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting event count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of songs
     */
    public function getSongCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM DanceSong";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting song count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all artists
     */
    public function getAllArtists()
    {
        try {
            $query = "SELECT 
                        ArtistId, 
                        Name, 
                        Genre, 
                        ProfileImageName, 
                        DetailImageName
                      FROM DanceArtist
                      ORDER BY Name";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all artists: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get an artist by ID
     */
    public function getArtistById($artistId)
    {
        try {
            $query = "SELECT 
                        ArtistId, 
                        Name, 
                        Genre, 
                        ProfileImageName, 
                        DetailImageName, 
                        Description
                      FROM DanceArtist
                      WHERE ArtistId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching artist by ID {$artistId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new artist
     */
    public function createArtist($name, $genre, $profileImageName, $detailImageName, $description)
    {
        try {
            $query = "INSERT INTO DanceArtist 
                        (Name, Genre, ProfileImageName, DetailImageName, Description) 
                      VALUES 
                        (:name, :genre, :profileImageName, :detailImageName, :description)";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->bindParam(':profileImageName', $profileImageName, PDO::PARAM_STR);
            $stmt->bindParam(':detailImageName', $detailImageName, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return [
                'success' => true, 
                'message' => 'Artist created successfully.',
                'artistId' => self::$pdo->lastInsertId()
            ];
        } catch (Exception $e) {
            error_log("Error creating artist: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create artist: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing artist
     */
    public function updateArtist($artistId, $name, $genre, $profileImageName, $detailImageName, $description)
    {
        try {
            $query = "UPDATE DanceArtist 
                      SET Name = :name,
                          Genre = :genre,
                          ProfileImageName = :profileImageName,
                          DetailImageName = :detailImageName,
                          Description = :description
                      WHERE ArtistId = :artistId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->bindParam(':profileImageName', $profileImageName, PDO::PARAM_STR);
            $stmt->bindParam(':detailImageName', $detailImageName, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Artist updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating artist: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update artist: ' . $e->getMessage()];
        }
    }

    /**
     * Check if artist has associated events
     */
    public function artistHasEvents($artistId)
    {
        try {
            $query = "SELECT COUNT(*) as count 
                      FROM DancePerformance
                      WHERE DanceArtistId = :artistId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error checking if artist has events: " . $e->getMessage());
            return true; // Assume has events if query fails, to prevent accidental deletion
        }
    }

    /**
     * Delete an artist
     */
    public function deleteArtist($artistId)
    {
        try {
            // Also delete any song records for this artist
            $songQuery = "DELETE FROM DanceSong WHERE ArtistId = :artistId";
            $songStmt = self::$pdo->prepare($songQuery);
            $songStmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $songStmt->execute();
            
            // Delete the artist
            $query = "DELETE FROM DanceArtist WHERE ArtistId = :artistId";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Artist deleted successfully.'];
        } catch (Exception $e) {
            error_log("Error deleting artist: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete artist: ' . $e->getMessage()];
        }
    }

    /**
     * Get all events with location and artist info
     */
    public function getAllEvents()
    {
        try {
            $query = "SELECT 
                        de.DanceEventId, 
                        de.EventId, 
                        de.Description, 
                        de.Location, 
                        de.StartDateTime, 
                        de.TimeSlot, 
                        de.DurationByMinute, 
                        de.TicketsAvailable, 
                        de.Price,
                        GROUP_CONCAT(da.Name SEPARATOR ', ') as artists
                      FROM DanceEvent de
                      LEFT JOIN DancePerformance dp ON de.DanceEventId = dp.DanceEventId
                      LEFT JOIN DanceArtist da ON dp.DanceArtistId = da.ArtistId
                      GROUP BY de.DanceEventId
                      ORDER BY de.StartDateTime";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all events: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all locations for dance events
     */
    public function getAllLocations()
    {
        try {
            // Get unique locations from existing events
            $query = "SELECT DISTINCT Location FROM DanceEvent ORDER BY Location";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            error_log("Error fetching all locations: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get event by ID
     */
    public function getEventById($eventId)
    {
        try {
            $query = "SELECT 
                        DanceEventId, 
                        EventId, 
                        Description, 
                        Location, 
                        StartDateTime, 
                        TimeSlot, 
                        DurationByMinute, 
                        TicketsAvailable, 
                        Price
                      FROM DanceEvent
                      WHERE DanceEventId = :eventId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching event by ID {$eventId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get artists for an event
     */
    public function getEventArtists($eventId)
    {
        try {
            $query = "SELECT 
                        da.ArtistId,
                        da.Name
                      FROM DancePerformance dp
                      JOIN DanceArtist da ON dp.DanceArtistId = da.ArtistId
                      WHERE dp.DanceEventId = :eventId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching event artists: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create a new event
     */
    public function createEvent($description, $location, $startDateTime, $timeSlot, $duration, $tickets, $price, $artistIds)
    {
        try {
            self::$pdo->beginTransaction();
            
            // Create Event entry first
            $eventQuery = "INSERT INTO Event (EventType) VALUES ('DanceEvent')";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->execute();
            
            $eventId = self::$pdo->lastInsertId();
            
            // Create DanceEvent entry
            $danceEventQuery = "INSERT INTO DanceEvent 
                                (EventId, Description, Location, StartDateTime, TimeSlot, DurationByMinute, TicketsAvailable, Price) 
                              VALUES 
                                (:eventId, :description, :location, :startDateTime, :timeSlot, :duration, :tickets, :price)";
            
            $danceEventStmt = self::$pdo->prepare($danceEventQuery);
            $danceEventStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $danceEventStmt->bindParam(':description', $description, PDO::PARAM_STR);
            $danceEventStmt->bindParam(':location', $location, PDO::PARAM_STR);
            $danceEventStmt->bindParam(':startDateTime', $startDateTime, PDO::PARAM_STR);
            $danceEventStmt->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
            $danceEventStmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $danceEventStmt->bindParam(':tickets', $tickets, PDO::PARAM_INT);
            $danceEventStmt->bindParam(':price', $price, PDO::PARAM_INT);
            
            $danceEventStmt->execute();
            
            $danceEventId = self::$pdo->lastInsertId();
            
            // Add artist performances
            foreach ($artistIds as $artistId) {
                $performanceQuery = "INSERT INTO DancePerformance (DanceEventId, DanceArtistId) VALUES (:danceEventId, :artistId)";
                $performanceStmt = self::$pdo->prepare($performanceQuery);
                $performanceStmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
                $performanceStmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
                $performanceStmt->execute();
            }
            
            self::$pdo->commit();
            
            return [
                'success' => true, 
                'message' => 'Event created successfully.',
                'eventId' => $danceEventId
            ];
        } catch (Exception $e) {
            self::$pdo->rollBack();
            error_log("Error creating event: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create event: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing event
     */
    public function updateEvent($eventId, $description, $location, $startDateTime, $timeSlot, $duration, $tickets, $price, $artistIds)
    {
        try {
            self::$pdo->beginTransaction();
            
            // Update DanceEvent entry
            $eventQuery = "UPDATE DanceEvent 
                           SET Description = :description,
                               Location = :location,
                               StartDateTime = :startDateTime,
                               TimeSlot = :timeSlot,
                               DurationByMinute = :duration,
                               TicketsAvailable = :tickets,
                               Price = :price
                           WHERE DanceEventId = :eventId";
            
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $eventStmt->bindParam(':description', $description, PDO::PARAM_STR);
            $eventStmt->bindParam(':location', $location, PDO::PARAM_STR);
            $eventStmt->bindParam(':startDateTime', $startDateTime, PDO::PARAM_STR);
            $eventStmt->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
            $eventStmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $eventStmt->bindParam(':tickets', $tickets, PDO::PARAM_INT);
            $eventStmt->bindParam(':price', $price, PDO::PARAM_INT);
            
            $eventStmt->execute();
            
            // Remove all existing artist performances
            $deleteQuery = "DELETE FROM DancePerformance WHERE DanceEventId = :eventId";
            $deleteStmt = self::$pdo->prepare($deleteQuery);
            $deleteStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $deleteStmt->execute();
            
            // Add new artist performances
            foreach ($artistIds as $artistId) {
                $performanceQuery = "INSERT INTO DancePerformance (DanceEventId, DanceArtistId) VALUES (:eventId, :artistId)";
                $performanceStmt = self::$pdo->prepare($performanceQuery);
                $performanceStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
                $performanceStmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
                $performanceStmt->execute();
            }
            
            self::$pdo->commit();
            
            return ['success' => true, 'message' => 'Event updated successfully.'];
        } catch (Exception $e) {
            self::$pdo->rollBack();
            error_log("Error updating event: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update event: ' . $e->getMessage()];
        }
    }

    /**
     * Check if tickets have been sold for an event
     */
    public function eventHasSoldTickets($eventId)
    {
        try {
            // First, get the EventId from DanceEvent
            $eventQuery = "SELECT EventId FROM DanceEvent WHERE DanceEventId = :danceEventId";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':danceEventId', $eventId, PDO::PARAM_INT);
            $eventStmt->execute();
            $eventResult = $eventStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$eventResult) {
                return false;
            }
            
            $mainEventId = $eventResult['EventId'];
            
            // Now check if any tickets are sold for this event
            $ticketQuery = "SELECT COUNT(*) as count FROM Ticket WHERE EventId = :eventId";
            $ticketStmt = self::$pdo->prepare($ticketQuery);
            $ticketStmt->bindParam(':eventId', $mainEventId, PDO::PARAM_INT);
            $ticketStmt->execute();
            
            $result = $ticketStmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error checking if event has sold tickets: " . $e->getMessage());
            return true; // Assume has tickets if query fails, to prevent accidental deletion
        }
    }

    /**
     * Delete an event
     */
    public function deleteEvent($eventId)
    {
        try {
            self::$pdo->beginTransaction();
            
            // First, get the EventId from DanceEvent
            $getQuery = "SELECT EventId FROM DanceEvent WHERE DanceEventId = :danceEventId";
            $getStmt = self::$pdo->prepare($getQuery);
            $getStmt->bindParam(':danceEventId', $eventId, PDO::PARAM_INT);
            $getStmt->execute();
            $result = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                self::$pdo->rollBack();
                return ['success' => false, 'message' => 'Event not found.'];
            }
            
            $mainEventId = $result['EventId'];
            
            // Delete performances first (foreign key constraint)
            $performanceQuery = "DELETE FROM DancePerformance WHERE DanceEventId = :danceEventId";
            $performanceStmt = self::$pdo->prepare($performanceQuery);
            $performanceStmt->bindParam(':danceEventId', $eventId, PDO::PARAM_INT);
            $performanceStmt->execute();
            
            // Delete DanceEvent 
            $danceEventQuery = "DELETE FROM DanceEvent WHERE DanceEventId = :danceEventId";
            $danceEventStmt = self::$pdo->prepare($danceEventQuery);
            $danceEventStmt->bindParam(':danceEventId', $eventId, PDO::PARAM_INT);
            $danceEventStmt->execute();
            
            // Delete from main Event table
            $eventQuery = "DELETE FROM Event WHERE EventId = :eventId";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':eventId', $mainEventId, PDO::PARAM_INT);
            $eventStmt->execute();
            
            self::$pdo->commit();
            
            return ['success' => true, 'message' => 'Event deleted successfully.'];
        } catch (Exception $e) {
            self::$pdo->rollBack();
            error_log("Error deleting event: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete event: ' . $e->getMessage()];
        }
    }

    /**
     * Get all songs with artist info
     */
    public function getAllSongs()
    {
        try {
            $query = "SELECT 
                        ds.SongId, 
                        ds.Title, 
                        ds.ReleaseYear, 
                        ds.Credits, 
                        ds.Description, 
                        ds.SongFileName, 
                        ds.ImageName,
                        da.Name as ArtistName
                      FROM DanceSong ds
                      JOIN DanceArtist da ON ds.ArtistId = da.ArtistId
                      ORDER BY da.Name, ds.Title";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all songs: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get song by ID
     */
    public function getSongById($songId)
    {
        try {
            $query = "SELECT 
                        SongId, 
                        ArtistId, 
                        Title, 
                        ReleaseYear, 
                        Credits, 
                        Description, 
                        SongFileName, 
                        ImageName
                      FROM DanceSong
                      WHERE SongId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $songId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching song by ID {$songId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new song
     */
    public function createSong($artistId, $title, $releaseYear, $credits, $description, $songFileName, $imageName)
    {
        try {
            $query = "INSERT INTO DanceSong 
                        (ArtistId, Title, ReleaseYear, Credits, Description, SongFileName, ImageName) 
                      VALUES 
                        (:artistId, :title, :releaseYear, :credits, :description, :songFileName, :imageName)";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':releaseYear', $releaseYear, PDO::PARAM_INT);
            $stmt->bindParam(':credits', $credits, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':songFileName', $songFileName, PDO::PARAM_STR);
            $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return [
                'success' => true, 
                'message' => 'Song created successfully.',
                'songId' => self::$pdo->lastInsertId()
            ];
        } catch (Exception $e) {
            error_log("Error creating song: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create song: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing song
     */
    public function updateSong($songId, $artistId, $title, $releaseYear, $credits, $description, $songFileName, $imageName)
    {
        try {
            $query = "UPDATE DanceSong 
                      SET ArtistId = :artistId,
                          Title = :title,
                          ReleaseYear = :releaseYear,
                          Credits = :credits,
                          Description = :description,
                          SongFileName = :songFileName,
                          ImageName = :imageName
                      WHERE SongId = :songId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':songId', $songId, PDO::PARAM_INT);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':releaseYear', $releaseYear, PDO::PARAM_INT);
            $stmt->bindParam(':credits', $credits, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':songFileName', $songFileName, PDO::PARAM_STR);
            $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Song updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating song: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update song: ' . $e->getMessage()];
        }
    }

    /**
     * Delete a song
     */
    public function deleteSong($songId)
    {
        try {
            $query = "DELETE FROM DanceSong WHERE SongId = :songId";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':songId', $songId, PDO::PARAM_INT);
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Song deleted successfully.'];
        } catch (Exception $e) {
            error_log("Error deleting song: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete song: ' . $e->getMessage()];
        }
    }
}