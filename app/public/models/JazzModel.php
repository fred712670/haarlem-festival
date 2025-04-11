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
                        ja.artistGallery,
                        ja.Description as description,
                        ja.short_description,
                        ja.musical_style,
                        ja.career_highlights,
                        MIN(je.StartDateTime) as performance_time,
                        v.Name as stage
                    FROM JazzArtist ja
                    LEFT JOIN JazzPerformance jp ON ja.ArtistId = jp.ArtistId
                    LEFT JOIN JazzEvent je ON jp.JazzEventId = je.JazzEventId
                    LEFT JOIN Event e ON je.EventId = e.EventId
                    LEFT JOIN Venue v ON je.Location = CAST(v.VenueId AS CHAR)
                    GROUP BY ja.ArtistId
                    ORDER BY ja.Name";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $artists;
        } catch (Exception $e) {
            error_log("Error fetching jazz artists: " . $e->getMessage());
            return [];
        }
    }

    
    /**
     * Get a specific artist by ID
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
                        ja.artistGallery,
                        ja.Description as description,
                        ja.short_description,
                        ja.musical_style,
                        ja.career_highlights,
                        MIN(je.StartDateTime) as performance_time,
                        v.Name as stage,
                        je.Price as price
                    FROM JazzArtist ja
                    LEFT JOIN JazzPerformance jp ON ja.ArtistId = jp.ArtistId
                    LEFT JOIN JazzEvent je ON jp.JazzEventId = je.JazzEventId
                    LEFT JOIN Event e ON je.EventId = e.EventId
                    LEFT JOIN Venue v ON je.Location = CAST(v.VenueId AS CHAR)
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
        // Get artist gallery
        $artist['gallery'] = $this->getArtistGallery($artistId, $artist['image']);
        
        // Get artist tracks
        $artist['tracks'] = $this->getArtistTracks($artistId);
        
        return $artist;
    }

    /**
     * Helper function to generate a preview text from a longer description
     * 
     * @param string $description Full description text
     * @param int $length Maximum length of preview
     * @return string Shortened preview text
     */
    private function generatePreviewText($description, $length = 150)
    {
        if (strlen($description) <= $length) {
            return $description;
        }
        
        $preview = substr($description, 0, $length);
        return rtrim($preview, ".,;:!? \t\n\r\0\x0B") . '...';
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
            error_log("Error fetching schedule: " . $e->getMessage());
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
            $query = "SELECT 
                        e.EventId,
                        DATE(je.StartDateTime) as date,
                        DAYNAME(je.StartDateTime) as day_name,
                        DAY(je.StartDateTime) as day_number,
                        MONTHNAME(je.StartDateTime) as month_name,
                        TIME(je.StartDateTime) as start_time,
                        ADDTIME(TIME(je.StartDateTime), SEC_TO_TIME(je.DurationByMinute * 60)) as end_time,
                        ja.ArtistId as artist_id,
                        ja.Name as artist_name,
                        v.VenueId as venue_id,
                        v.Name as venue_name,
                        v.Location as venue_location,
                        je.Price as price
                    FROM JazzEvent je
                    JOIN Event e ON je.EventId = e.EventId
                    JOIN JazzPerformance jp ON je.JazzEventId = jp.JazzEventId
                    JOIN JazzArtist ja ON jp.ArtistId = ja.ArtistId
                    JOIN Venue v ON je.Location = CAST(v.VenueId AS CHAR)";
            
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
            
            // Add remarks based on the event price
            foreach ($events as &$event) {
                if ((float)$event['price'] === 0.0) {
                    // Free event
                    $event['remarks'] = 'All Jazz events on this day are free.';                   
                } else  {
                    // paid event
                    $event['remarks'] = 'A day pass will cover all the Jazz events on this day.';
                } 
            }
            
            return $events;
        } catch (Exception $e) {
            error_log("Error fetching event data: " . $e->getMessage());
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
            $query = "SELECT * FROM JazzPass";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            // Format the data for the frontend
            $formattedInfo = [];
            
            while ($pass = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ticketInfo = [
                    'id' => $pass['PassId'],
                    'title' => $pass['DisplayName'],
                    'description' => $pass['ShortDescription'],
                    'price' => (float)$pass['BasePrice'],
                    'featured' => (bool)$pass['Featured']
                ];
                
                $formattedInfo[] = $ticketInfo;
            }
            
            return $formattedInfo;
        } catch (Exception $e) {
            error_log("Error retrieving ticket information: " . $e->getMessage());
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
                        v.Description as description,
                        v.Email,
                        v.OfficePhone,
                        v.OfficeHours,
                        v.InfoPhone
                    FROM Venue v
                    WHERE v.VenueId IN (1, 2, 3, 4)
                    ORDER BY v.VenueId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Process venues to create contact structure
            return $this->enrichVenueData($venues);
        } catch (Exception $e) {
            error_log("Error fetching venue details: " . $e->getMessage());
            return [];
        }
    }

    private function enrichVenueData($venues)
    {
        try {
            // Since the contact information is now part of the Venue table,
            // we just need to format it into the 'contact' array structure
            foreach ($venues as &$venue) {
                // Only add contact info if at least email is available
                if (!empty($venue['Email'])) {
                    $venue['contact'] = [
                        'email' => $venue['Email'],
                        'office_phone' => $venue['OfficePhone'],
                        'office_hours' => $venue['OfficeHours'],
                        'info_phone' => $venue['InfoPhone']
                    ];
                    
                    // Remove the original columns to keep the structure clean
                    unset($venue['Email']);
                    unset($venue['OfficePhone']);
                    unset($venue['OfficeHours']);
                    unset($venue['InfoPhone']);
                }
            }
            
            return $venues;
        } catch (Exception $e) {
            error_log("Error enriching venue data: " . $e->getMessage());
            return $venues; // Return original venues if enrichment fails
        }
    }
    
    private function getArtistTracks($artistId)
    {
        try {
            $query = "SELECT 
                t.TrackId as id,
                t.Title as title,
                t.ReleaseYear as release_year,
                t.Description as description,
                t.audio_file as audio_file
            FROM JazzTrack t
            WHERE t.ArtistId = :artistId
            ORDER BY t.ReleaseYear DESC, t.Title";
                
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching artist tracks: " . $e->getMessage());
            return [];
        }
    }
}