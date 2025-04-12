<?php
require_once __DIR__ . '/BaseModel.php';

class JazzModel extends BaseModel
{
    /**
     * Get all jazz artists with their details
     * 
     * @return array All jazz artists
     */
    public function getAllArtists()
    {
        try {
            $query = "SELECT 
                        ja.ArtistId as id,
                        ja.Name as name,
                        ja.Hashtag as hashtag,
                        ja.ProfileImageName as image,
                        ja.artistGallery, /* Updated column name */
                        ja.Description as description,
                        ja.short_description, /* Added this field */
                        ja.musical_style,
                        ja.career_highlights,
                        MIN(je.StartDateTime) as performance_time,
                        v.Name as stage
                    FROM JazzArtist ja
                    LEFT JOIN JazzPerformance jp ON ja.ArtistId = jp.ArtistId
                    LEFT JOIN JazzEvent je ON jp.JazzEventId = je.EventId
                    LEFT JOIN Event e ON je.EventId = e.EventId
                    LEFT JOIN Venue v ON e.Location = CAST(v.VenueId AS CHAR)
                    GROUP BY ja.ArtistId
                    ORDER BY ja.Name";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
           
            
            return $artists;
        } catch (Exception $e) {
            // Replace logError with direct error logging or silent error handling
            error_log("Error fetching jazz artists: " . $e->getMessage());
            return [];
        }
    }

    
    /**
     * Get a specific artist by ID 
     * break it up, and make the name  spesifci 
     * 
     * @param int $id Artist ID
     * @return array|null Artist data or null if not found
     */
    public function getArtistById($id)
    {
        try {
            $query = "SELECT 
                        ja.ArtistId as id,
                        ja.Name as name,
                        ja.Hashtag as hashtag,
                        ja.ProfileImageName as image,
                        ja.artistGallery, /* Updated column name */
                        ja.Description as description,
                        ja.short_description, /* Added this field */
                        ja.musical_style,
                        ja.career_highlights,
                        MIN(je.StartDateTime) as performance_time,
                        v.Name as stage,
                        e.Price as price
                    FROM JazzArtist ja
                    LEFT JOIN JazzPerformance jp ON ja.ArtistId = jp.ArtistId
                    LEFT JOIN JazzEvent je ON jp.JazzEventId = je.EventId
                    LEFT JOIN Event e ON je.EventId = e.EventId
                    LEFT JOIN Venue v ON e.Location = CAST(v.VenueId AS CHAR)
                    WHERE ja.ArtistId = :id
                    GROUP BY ja.ArtistId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $artist = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$artist) {
                return null;
            }
            
            // Generate short description if not available
            if (empty($artist['short_description'])) {
                $artist['short_description'] = $this->generatePreviewText($artist['description']);
            }
            
            // Enrich the artist data with related information
            $artist = $this->enrichArtistData($artist, $id);
            
            return $artist;
        } catch (Exception $e) {
            error_log("Error fetching artist by ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Enrich artist data with related information like tracks and gallery
     * 
     * @param array $artist Base artist data
     * @param int $artistId Artist ID
     * @return array Enhanced artist data
     */
    private function enrichArtistData($artist, $artistId)
    {
        // Get tracks for this artist if available
        $artist['tracks'] = $this->getArtistTracks($artistId);
        
        
        $artist['gallery'] = $this->getArtistGallery($artistId, $artist['image']);
        
        return $artist;
    }

    /**
     * Get tracks for a specific artist
     * 
     * @param int $artistId Artist ID
     * @return array Tracks for the artist
     */
    private function getArtistTracks($artistId)
    {
        try {
            $query = "SELECT 
                        TrackId as id,
                        Title as title,
                        Credits as credits,
                        Description as description,
                        ReleaseYear as release_year
                    FROM JazzTrack
                    WHERE ArtistId = :artistId
                    ORDER BY ReleaseYear DESC";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->logError("Error fetching artist tracks", $e);
            return [];
        }
    }

    private function getArtistGallery($artistId, $defaultImage)
    {
        try {
            $query = "SELECT artistGallery FROM JazzArtist WHERE ArtistId = :artistId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result && !empty($result['artistGallery'])) {
                // If stored as JSON
                $galleryImages = json_decode($result['artistGallery'], true);
                
                // If decode failed, it might be comma-separated
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $galleryImages = explode(',', $result['artistGallery']);
                }
                
                // Make sure we have an array
                if (!is_array($galleryImages)) {
                    $galleryImages = [$result['artistGallery']];
                }
                
                // Add the default image if it's not already included
                if (!in_array($defaultImage, $galleryImages)) {
                    array_unshift($galleryImages, $defaultImage);
                }
                
                return $galleryImages;
            }
            
            // Return just the default image if no gallery was found
            return [$defaultImage];
        } catch (Exception $e) {
            error_log("Error fetching artist gallery: " . $e->getMessage());
            return [$defaultImage];
        }
    }

    /**
     * Get schedule data organized by days
     * 
     * @param int|null $artistId Optional artist ID to filter schedule
     * @return array Schedule data organized by days
     */
    public function getSchedule($artistId = null)
    {
        try {
            $events = $this->fetchEventData($artistId);
            
            if (empty($events)) {
                return [];
            }
            
            // Always organize by days, even for a single artist
            return $this->organizeEventsByDay($events);
        } catch (Exception $e) {
            $this->logError("Error fetching schedule", $e);
            return [];
        }
    }

    /**
     * Get pass information from the database
     * 
     * @return array Pass information indexed by PassType
     */
    private function getPassInformation()
    {
        try {
            $query = "SELECT * FROM JazzPass";  // Changed from Pass to JazzPass
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            $passes = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $passes[$row['PassType']] = $row;
            }
            
            return $passes;
        } catch (Exception $e) {
            error_log("Error fetching pass information: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch raw event data from database
     * 
     * @param int|null $artistId Optional artist ID to filter events
     * @return array Raw event data
     */
    private function fetchEventData($artistId = null)
    {
        try {
            // Get pass information from the database
            $passes = $this->getPassInformation();
            
            $query = "SELECT 
                        e.EventId,
                        DATE(je.StartDateTime) as date,
                        DAYNAME(je.StartDateTime) as day_name,
                        DAY(je.StartDateTime) as day_number,
                        MONTHNAME(je.StartDateTime) as month_name,
                        TIME(je.StartTime) as start_time,
                        TIME(je.EndTime) as end_time,
                        ja.ArtistId as artist_id,
                        ja.Name as artist_name,
                        v.VenueId as venue_id,
                        v.Name as venue_name,
                        v.Location as venue_location,
                        e.Price as price
                    FROM JazzEvent je
                    JOIN Event e ON je.EventId = e.EventId
                    JOIN JazzPerformance jp ON je.EventId = jp.JazzEventId
                    JOIN JazzArtist ja ON jp.ArtistId = ja.ArtistId
                    JOIN Venue v ON e.Location = CAST(v.VenueId AS CHAR)";
            
            // If an artist ID is provided, filter the results
            if ($artistId !== null) {
                $query .= " WHERE ja.ArtistId = :artistId";
            }
            
            $query .= " ORDER BY je.StartDateTime, v.Name";
            
            $stmt = self::$pdo->prepare($query);
            
            // Bind the artist ID parameter if needed
            if ($artistId !== null) {
                $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add the appropriate remarks based on the event price and pass info
            foreach ($events as &$event) {
                if ((float)$event['price'] === 0.0 && isset($passes['Free'])) {
                    // Free event
                    $event['remarks'] = $passes['Free']['Description'];
                    $event['pass_type'] = 'Free';
                } else {
                    // Paid event - show information about day and weekend passes
                    $dayPassInfo = isset($passes['DayPass']) ? $passes['DayPass']['Description'] : '';
                    $weekendPassInfo = isset($passes['WeekendPass']) ? $passes['WeekendPass']['Description'] : '';
                    $event['remarks'] = "$dayPassInfo, $weekendPassInfo";
                    
                    // Set the pass type based on price
                    if ((float)$event['price'] <= 15.0) {
                        $event['pass_type'] = 'SingleUse';
                    } else {
                        $event['pass_type'] = 'DayPass'; // Default to DayPass for higher priced events
                    }
                }
            }
            
            return $events;
        } catch (Exception $e) {
            $this->logError("Error fetching event data", $e);
            return [];
        }
    }

    /**
     * Organize events by day
     * 
     * @param array $events Raw event data
     * @return array Events organized by day
     */
    private function organizeEventsByDay($events)
    {
        $scheduleByDay = [];
        
        foreach ($events as $event) {
            $dateKey = date('Y-m-d', strtotime($event['date']));
            
            if (!isset($scheduleByDay[$dateKey])) {
                $scheduleByDay[$dateKey] = [
                    'date' => $event['date'],
                    'day_name' => $event['day_name'],
                    'day_number' => $event['day_number'],
                    'month_name' => $event['month_name'],
                    'events' => []
                ];
            }
            
            $scheduleByDay[$dateKey]['events'][] = $event;
        }
        
        return $scheduleByDay;
    }

    /**
     * Get ticket information for the festival
     * 
     * @return array Ticket types and pricing
     */
    
     public function getTicketInfo()
    {
        try {
            // Get the pass information from the database
            $passes = $this->getPassInformation();
            
            // Format the data for the frontend
            $formattedInfo = [];
            $id = 1;
            
            // Convert the database pass types to the frontend display structure
            foreach ($passes as $passType => $pass) {
                $ticketInfo = [
                    'id' => $id++,
                    'title' => $pass['DisplayName'],
                    'description' => $pass['ShortDescription'],
                    'price' => (float)$pass['BasePrice'],
                    'featured' => (bool)$pass['Featured']
                ];
                
                
                
                $formattedInfo[] = $ticketInfo;
            }
            
            
            return $formattedInfo;
        } catch (Exception $e) {
            $this->logError("Error retrieving ticket information", $e);
            return [];
        }
    }

    /**
     * Get venue information with detailed contact information
     * 
     * @return array Venue details
     */
    public function getVenueDetails()
    {
        try {
            $query = "SELECT 
                        v.VenueId as id,
                        v.Name as name,
                        v.Location as location,
                        v.Address as address,
                        v.Capacity as capacity,
                        v.Description as description
                    FROM Venue v
                    WHERE v.VenueId IN (1, 2, 3, 4)
                    ORDER BY v.VenueId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Fetch venue contact information from database
            return $this->enrichVenueData($venues);
        } catch (Exception $e) {
            $this->logError("Error fetching venue details", $e);
            return [];
        }
    }

    /**
     * Enrich venue data with additional information from the database
     * 
     * @param array $venues Base venue data
     * @return array Enhanced venue data
     */
    private function enrichVenueData($venues)
    {
        try {
            // will be added to database and fetched from there once we merge the data base 
            foreach ($venues as &$venue) {
                if (strpos($venue['location'], 'Patronaat') !== false) {
                    $venue['contact'] = [
                        'email' => 'info@patronaat.nl',
                        'office_phone' => '023 - 517 58 50',
                        'office_hours' => '10:00 - 17:00',
                        'info_phone' => '023 - 517 58 58',
                        'info_description' => 'cash desk/information number'
                    ];
                }
            }
            
            return $venues;
        } catch (Exception $e) {
            $this->logError("Error enriching venue data", $e);
            return $venues; // Return original venues if enrichment fails
        }
    }

    /**
     * Log error messages
     * 
     * @param string $message Error message
     * @param Exception $exception Exception object
     */
    private function logError($message, Exception $exception)
    {
        error_log("{$message}: " . $exception->getMessage());
    }
}