<?php
require_once(__DIR__ . "/BaseModel.php");

/**
 * Model for handling jazz management database operations
 */
class JazzManagementModel extends BaseModel
{
    /**
     * Get count of artists
     */
    public function getArtistCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM JazzArtist";
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
            $query = "SELECT COUNT(*) as count FROM JazzEvent";
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
     * Get count of venues
     */
    public function getVenueCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM Venue";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting venue count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of passes
     */
    public function getPassCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM JazzPass";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting pass count: " . $e->getMessage());
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
                        ArtistId as id,
                        Name as name,
                        ProfileImageName as image,
                        short_description
                      FROM JazzArtist
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
                        ArtistId as id,
                        Name as name,
                        ProfileImageName as image,
                        artistGallery,
                        Description as description,
                        short_description,
                        musical_style,
                        career_highlights
                      FROM JazzArtist
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
    public function createArtist($name, $profileImage, $shortDescription, $description, $musicalStyle, $careerHighlights, $galleryImages)
    {
        try {
            $query = "INSERT INTO JazzArtist 
                        (Name, ProfileImageName, short_description, Description, musical_style, career_highlights, artistGallery) 
                      VALUES 
                        (:name, :profileImage, :shortDescription, :description, :musicalStyle, :careerHighlights, :galleryImages)";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':profileImage', $profileImage, PDO::PARAM_STR);
            $stmt->bindParam(':shortDescription', $shortDescription, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':musicalStyle', $musicalStyle, PDO::PARAM_STR);
            $stmt->bindParam(':careerHighlights', $careerHighlights, PDO::PARAM_STR);
            $stmt->bindParam(':galleryImages', $galleryImages, PDO::PARAM_STR);
            
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
    public function updateArtist($artistId, $name, $profileImage, $shortDescription, $description, $musicalStyle, $careerHighlights, $galleryImages)
    {
        try {
            $query = "UPDATE JazzArtist 
                      SET Name = :name,
                          ProfileImageName = :profileImage,
                          short_description = :shortDescription,
                          Description = :description,
                          musical_style = :musicalStyle,
                          career_highlights = :careerHighlights,
                          artistGallery = :galleryImages
                      WHERE ArtistId = :artistId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':profileImage', $profileImage, PDO::PARAM_STR);
            $stmt->bindParam(':shortDescription', $shortDescription, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':musicalStyle', $musicalStyle, PDO::PARAM_STR);
            $stmt->bindParam(':careerHighlights', $careerHighlights, PDO::PARAM_STR);
            $stmt->bindParam(':galleryImages', $galleryImages, PDO::PARAM_STR);
            
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
                      FROM JazzPerformance
                      WHERE ArtistId = :artistId";
            
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
            // Also delete any track records for this artist
            $trackQuery = "DELETE FROM JazzTrack WHERE ArtistId = :artistId";
            $trackStmt = self::$pdo->prepare($trackQuery);
            $trackStmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $trackStmt->execute();
            
            // Delete the artist
            $query = "DELETE FROM JazzArtist WHERE ArtistId = :artistId";
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
     * Get all events with venue and artist info
     */
    public function getAllEvents()
    {
        try {
            $query = "SELECT 
                        je.JazzEventId as id,
                        je.EventId as event_id,
                        je.Description as description,
                        je.Location as venue_id,
                        v.Name as venue_name,
                        je.StartDateTime as start_datetime,
                        je.TimeSlot as time_slot,
                        je.DurationByMinute as duration,
                        je.TicketsAvailable as tickets,
                        je.Price as price,
                        GROUP_CONCAT(ja.Name SEPARATOR ', ') as artists
                      FROM JazzEvent je
                      JOIN Venue v ON je.Location = v.VenueId
                      LEFT JOIN JazzPerformance jp ON je.JazzEventId = jp.JazzEventId
                      LEFT JOIN JazzArtist ja ON jp.ArtistId = ja.ArtistId
                      GROUP BY je.JazzEventId
                      ORDER BY je.StartDateTime";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all events: " . $e->getMessage());
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
                        je.JazzEventId as id,
                        je.EventId as event_id,
                        je.Description as description,
                        je.Location as venue_id,
                        v.Name as venue_name,
                        je.StartDateTime as start_datetime,
                        je.TimeSlot as time_slot,
                        je.DurationByMinute as duration,
                        je.TicketsAvailable as tickets,
                        je.Price as price
                      FROM JazzEvent je
                      JOIN Venue v ON je.Location = v.VenueId
                      WHERE je.JazzEventId = :eventId";
            
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
                        ja.ArtistId as id,
                        ja.Name as name
                      FROM JazzPerformance jp
                      JOIN JazzArtist ja ON jp.ArtistId = ja.ArtistId
                      WHERE jp.JazzEventId = :eventId";
            
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
    public function createEvent($description, $venueId, $startDateTime, $timeSlot, $duration, $tickets, $price, $artistIds)
    {
        try {
            self::$pdo->beginTransaction();
            
            // Create Event entry first
            $eventQuery = "INSERT INTO Event (EventType) VALUES ('JazzEvent')";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->execute();
            
            $eventId = self::$pdo->lastInsertId();
            
            // Create JazzEvent entry
            $jazzEventQuery = "INSERT INTO JazzEvent 
                                (EventId, Description, Location, StartDateTime, TimeSlot, DurationByMinute, TicketsAvailable, Price) 
                              VALUES 
                                (:eventId, :description, :location, :startDateTime, :timeSlot, :duration, :tickets, :price)";
            
            $jazzEventStmt = self::$pdo->prepare($jazzEventQuery);
            $jazzEventStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $jazzEventStmt->bindParam(':description', $description, PDO::PARAM_STR);
            $jazzEventStmt->bindParam(':location', $venueId, PDO::PARAM_STR);
            $jazzEventStmt->bindParam(':startDateTime', $startDateTime, PDO::PARAM_STR);
            $jazzEventStmt->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
            $jazzEventStmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $jazzEventStmt->bindParam(':tickets', $tickets, PDO::PARAM_INT);
            $jazzEventStmt->bindParam(':price', $price, PDO::PARAM_INT);
            
            $jazzEventStmt->execute();
            
            $jazzEventId = self::$pdo->lastInsertId();
            
            // Add artist performances
            foreach ($artistIds as $artistId) {
                $performanceQuery = "INSERT INTO JazzPerformance (JazzEventId, ArtistId) VALUES (:jazzEventId, :artistId)";
                $performanceStmt = self::$pdo->prepare($performanceQuery);
                $performanceStmt->bindParam(':jazzEventId', $jazzEventId, PDO::PARAM_INT);
                $performanceStmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
                $performanceStmt->execute();
            }
            
            self::$pdo->commit();
            
            return [
                'success' => true, 
                'message' => 'Event created successfully.',
                'eventId' => $jazzEventId
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
    public function updateEvent($eventId, $description, $venueId, $startDateTime, $timeSlot, $duration, $tickets, $price, $artistIds)
    {
        try {
            self::$pdo->beginTransaction();
            
            // Update JazzEvent entry
            $eventQuery = "UPDATE JazzEvent 
                           SET Description = :description,
                               Location = :location,
                               StartDateTime = :startDateTime,
                               TimeSlot = :timeSlot,
                               DurationByMinute = :duration,
                               TicketsAvailable = :tickets,
                               Price = :price
                           WHERE JazzEventId = :eventId";
            
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $eventStmt->bindParam(':description', $description, PDO::PARAM_STR);
            $eventStmt->bindParam(':location', $venueId, PDO::PARAM_STR);
            $eventStmt->bindParam(':startDateTime', $startDateTime, PDO::PARAM_STR);
            $eventStmt->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
            $eventStmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $eventStmt->bindParam(':tickets', $tickets, PDO::PARAM_INT);
            $eventStmt->bindParam(':price', $price, PDO::PARAM_INT);
            
            $eventStmt->execute();
            
            // Remove all existing artist performances
            $deleteQuery = "DELETE FROM JazzPerformance WHERE JazzEventId = :eventId";
            $deleteStmt = self::$pdo->prepare($deleteQuery);
            $deleteStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $deleteStmt->execute();
            
            // Add new artist performances
            foreach ($artistIds as $artistId) {
                $performanceQuery = "INSERT INTO JazzPerformance (JazzEventId, ArtistId) VALUES (:eventId, :artistId)";
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
            // First, get the EventId from JazzEvent
            $eventQuery = "SELECT EventId FROM JazzEvent WHERE JazzEventId = :jazzEventId";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':jazzEventId', $eventId, PDO::PARAM_INT);
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
            
            // Debug the input
            error_log("Deleting event with ID: " . $eventId);
            
            // First, get the EventId from JazzEvent
            $getQuery = "SELECT EventId FROM JazzEvent WHERE JazzEventId = :jazzEventId";
            $getStmt = self::$pdo->prepare($getQuery);
            $getStmt->bindParam(':jazzEventId', $eventId, PDO::PARAM_INT);
            $getStmt->execute();
            $result = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                error_log("No matching event found in database");
                self::$pdo->rollBack();
                return ['success' => false, 'message' => 'Event not found.'];
            }
            
            $mainEventId = $result['EventId'];
            error_log("Found main EventId: " . $mainEventId);
            
            // Delete performances first (foreign key constraint)
            $performanceQuery = "DELETE FROM JazzPerformance WHERE JazzEventId = :jazzEventId";
            $performanceStmt = self::$pdo->prepare($performanceQuery);
            $performanceStmt->bindParam(':jazzEventId', $eventId, PDO::PARAM_INT);
            $performanceStmt->execute();
            
            // Delete JazzEvent 
            $jazzEventQuery = "DELETE FROM JazzEvent WHERE JazzEventId = :jazzEventId";
            $jazzEventStmt = self::$pdo->prepare($jazzEventQuery);
            $jazzEventStmt->bindParam(':jazzEventId', $eventId, PDO::PARAM_INT);
            $jazzEventStmt->execute();
            
            // Delete from main Event table
            $eventQuery = "DELETE FROM Event WHERE EventId = :eventId";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':eventId', $mainEventId, PDO::PARAM_INT);
            $eventStmt->execute();
            
            self::$pdo->commit();
            error_log("Event deletion successful");
            
            return ['success' => true, 'message' => 'Event deleted successfully.'];
        } catch (Exception $e) {
            self::$pdo->rollBack();
            error_log("Error deleting event: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete event: ' . $e->getMessage()];
        }
    }

    /**
     * Get all venues
     */
    public function getAllVenues()
    {
        try {
            $query = "SELECT 
                        VenueId as id,
                        Name as name,
                        Address as address,
                        Capacity as capacity,
                        Description as description,
                        Email as email,
                        OfficePhone as office_phone,
                        OfficeHours as office_hours,
                        InfoPhone as info_phone
                      FROM Venue
                      ORDER BY Name";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all venues: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get venue by ID
     */
    public function getVenueById($venueId)
    {
        try {
            $query = "SELECT 
                        VenueId as id,
                        Name as name,
                        Address as address,
                        Capacity as capacity,
                        Description as description,
                        Email as email,
                        OfficePhone as office_phone,
                        OfficeHours as office_hours,
                        InfoPhone as info_phone
                      FROM Venue
                      WHERE VenueId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $venueId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching venue by ID {$venueId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update a venue
     */
    public function updateVenue($venueId, $name, $address, $capacity, $description, $email, $officePhone, $officeHours, $infoPhone)
    {
        try {
            $query = "UPDATE Venue 
                      SET Name = :name,
                          Address = :address,
                          Capacity = :capacity,
                          Description = :description,
                          Email = :email,
                          OfficePhone = :officePhone,
                          OfficeHours = :officeHours,
                          InfoPhone = :infoPhone
                      WHERE VenueId = :venueId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':venueId', $venueId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':officePhone', $officePhone, PDO::PARAM_STR);
            $stmt->bindParam(':officeHours', $officeHours, PDO::PARAM_STR);
            $stmt->bindParam(':infoPhone', $infoPhone, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Venue updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating venue: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update venue: ' . $e->getMessage()];
        }
    }

    /**
 * Create a new venue
 */
public function createVenue($name, $address, $capacity, $description = '', $email = '', $officePhone = '', $officeHours = '', $infoPhone = '')
{
    try {
        $query = "INSERT INTO Venue 
                    (Name, Address, Capacity, Description, Email, OfficePhone, OfficeHours, InfoPhone) 
                  VALUES 
                    (:name, :address, :capacity, :description, :email, :officePhone, :officeHours, :infoPhone)";
        
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':officePhone', $officePhone, PDO::PARAM_STR);
        $stmt->bindParam(':officeHours', $officeHours, PDO::PARAM_STR);
        $stmt->bindParam(':infoPhone', $infoPhone, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return [
            'success' => true, 
            'message' => 'Venue created successfully.',
            'venueId' => self::$pdo->lastInsertId()
        ];
    } catch (Exception $e) {
        error_log("Error creating venue: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to create venue: ' . $e->getMessage()];
    }
}

/**
 * Delete a venue
 */
public function deleteVenue($venueId)
{
    try {
        // Check if the venue is used in any events
        $checkQuery = "SELECT COUNT(*) as count FROM JazzEvent WHERE Location = :venueId";
        $checkStmt = self::$pdo->prepare($checkQuery);
        $checkStmt->bindParam(':venueId', $venueId, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return ['success' => false, 'message' => 'Cannot delete venue. It is used in events. Remove the events first.'];
        }
        
        $query = "DELETE FROM Venue WHERE VenueId = :venueId";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':venueId', $venueId, PDO::PARAM_INT);
        $stmt->execute();
        
        return ['success' => true, 'message' => 'Venue deleted successfully.'];
    } catch (Exception $e) {
        error_log("Error deleting venue: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to delete venue: ' . $e->getMessage()];
    }
}

    /**
     * Get all passes
     */
    public function getAllPasses()
    {
        try {
            $query = "SELECT 
                        PassId as id,
                        PassType as pass_type,
                        DisplayName as display_name,
                        ShortDescription as short_description,
                        Description as description,
                        Dates as dates,
                        BasePrice as price,
                        Featured as featured
                      FROM JazzPass
                      ORDER BY PassId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            $passes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Convert price to float and featured to boolean
            foreach ($passes as &$pass) {
                $pass['price'] = (float)$pass['price'];
                $pass['featured'] = (bool)$pass['featured'];
            }
            
            return $passes;
        } catch (Exception $e) {
            error_log("Error fetching all passes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get pass by ID
     */
    public function getPassById($passId)
    {
        try {
            $query = "SELECT 
                        PassId as id,
                        PassType as pass_type,
                        DisplayName as display_name,
                        ShortDescription as short_description,
                        Description as description,
                        Dates as dates,
                        BasePrice as price,
                        Featured as featured
                      FROM JazzPass
                      WHERE PassId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $passId, PDO::PARAM_INT);
            $stmt->execute();
            
            $pass = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($pass) {
                // Convert price to float and featured to boolean
                $pass['price'] = (float)$pass['price'];
                $pass['featured'] = (bool)$pass['featured'];
            }
            
            return $pass;
        } catch (Exception $e) {
            error_log("Error fetching pass by ID {$passId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new pass
     */
    public function createPass($passType, $displayName, $shortDescription, $description, $dates, $basePrice, $featured)
    {
        try {
            $query = "INSERT INTO JazzPass 
                        (PassType, DisplayName, ShortDescription, Description, Dates, BasePrice, Featured) 
                      VALUES 
                        (:passType, :displayName, :shortDescription, :description, :dates, :basePrice, :featured)";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':passType', $passType, PDO::PARAM_STR);
            $stmt->bindParam(':displayName', $displayName, PDO::PARAM_STR);
            $stmt->bindParam(':shortDescription', $shortDescription, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':dates', $dates, PDO::PARAM_STR);
            $stmt->bindParam(':basePrice', $basePrice, PDO::PARAM_STR);
            $stmt->bindParam(':featured', $featured, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return [
                'success' => true, 
                'message' => 'Pass created successfully.',
                'passId' => self::$pdo->lastInsertId()
            ];
        } catch (Exception $e) {
            error_log("Error creating pass: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create pass: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing pass
     */
    public function updatePass($passId, $passType, $displayName, $shortDescription, $description, $dates, $basePrice, $featured)
    {
        try {
            $query = "UPDATE JazzPass 
                      SET PassType = :passType,
                          DisplayName = :displayName,
                          ShortDescription = :shortDescription,
                          Description = :description,
                          Dates = :dates,
                          BasePrice = :basePrice,
                          Featured = :featured
                      WHERE PassId = :passId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':passId', $passId, PDO::PARAM_INT);
            $stmt->bindParam(':passType', $passType, PDO::PARAM_STR);
            $stmt->bindParam(':displayName', $displayName, PDO::PARAM_STR);
            $stmt->bindParam(':shortDescription', $shortDescription, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':dates', $dates, PDO::PARAM_STR);
            $stmt->bindParam(':basePrice', $basePrice, PDO::PARAM_STR);
            $stmt->bindParam(':featured', $featured, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Pass updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating pass: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update pass: ' . $e->getMessage()];
        }
    }

    /**
     * Check if tickets have been sold with a pass type
     */
    public function passHasSoldTickets($passId)
    {
        try {
            // This would require a more complex check with the real tickets system
            // For now, just check if passId = 1 (free) or passId = 4 (featured)
            // as example of a system constraint
            return $passId == 1 || $passId == 4;
        } catch (Exception $e) {
            error_log("Error checking if pass has sold tickets: " . $e->getMessage());
            return true; // Assume has tickets if query fails, to prevent accidental deletion
        }
    }

    /**
     * Delete a pass
     */
    public function deletePass($passId)
    {
        try {
            $query = "DELETE FROM JazzPass WHERE PassId = :passId";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':passId', $passId, PDO::PARAM_INT);
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Pass deleted successfully.'];
        } catch (Exception $e) {
            error_log("Error deleting pass: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete pass: ' . $e->getMessage()];
        }
    }
}