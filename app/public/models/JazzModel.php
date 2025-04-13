<?php
require_once __DIR__ . '/BaseModel.php';

class JazzModel extends BaseModel
{
    /**
     * Get all jazz artists 
     * 
     * @return array All jazz artists
     */
    public function getAllArtists()
    {
        try {
        
            $query = "SELECT 
                        ja.ArtistId as id,
                        ja.Name as name,
                        ja.ProfileImageName as image,
                        ja.short_description
                    FROM JazzArtist ja
                    ORDER BY ja.Name";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching jazz artists: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get a specific artist by ID with all details needed for the artist page
     * 
     * @param int $id Artist ID
     * @return array|null Artist data or null if not found
     */
    public function getArtistById($id)
    {
        try {
            // Query only the fields needed for the artist detail page
            $query = "SELECT 
                        ja.ArtistId as id,
                        ja.Name as name,
                        ja.ProfileImageName as image,
                        ja.artistGallery,
                        ja.Description as description,
                        ja.short_description,
                        ja.musical_style,
                        ja.career_highlights
                    FROM JazzArtist ja
                    WHERE ja.ArtistId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $artist = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$artist) {
                return null;
            }
            
            // Process gallery images - simple approach based on database structure AI MADE
            if (!empty($artist['artistGallery'])) {
                // If it's just a single image in the database
                if (strpos($artist['artistGallery'], '[') === false && strpos($artist['artistGallery'], ',') === false) {
                    $artist['gallery'] = [$artist['image'], $artist['artistGallery']];
                } else {
                    // Try to parse as JSON
                    $galleryImages = json_decode($artist['artistGallery'], true);
                    
                    // If not JSON, treat as comma-separated
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $galleryImages = explode(',', $artist['artistGallery']);
                    }
                    
                    // Ensure profile image is included
                    array_unshift($galleryImages, $artist['image']);
                    $artist['gallery'] = $galleryImages;
                }
            } else {
                // Just use the profile image if no gallery
                $artist['gallery'] = [$artist['image']];
            }
            
            // Get tracks in a separate query
            $artist['tracks'] = $this->getArtistTracks($id);
            
            return $artist;
        } catch (Exception $e) {
            error_log("Error fetching artist by ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get artist tracks
     * 
     * @param int $artistId The artist ID
     * @return array Track list
     */
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

    /**
     * Get schedule data organized by days
     * 
     * @param int|null $artistId Optional artist ID to filter schedule
     * @return array Schedule data organized by days
     */
    public function getSchedule($artistId = null)
    {
        try {
            
            $query = "SELECT 
                        DATE(je.StartDateTime) as date,
                        DAYNAME(je.StartDateTime) as day_name,
                        DAY(je.StartDateTime) as day_number,
                        MONTHNAME(je.StartDateTime) as month_name,
                        TIME(je.StartDateTime) as start_time,
                        ADDTIME(TIME(je.StartDateTime), SEC_TO_TIME(je.DurationByMinute * 60)) as end_time,
                        ja.ArtistId as artist_id,
                        ja.Name as artist_name,
                        v.Name as venue_name,
                        je.Price as price,
                        CASE 
                            WHEN je.Price = 0 THEN 'All Jazz events on this day are free.'
                            ELSE 'A day pass will cover all the Jazz events on this day.'
                        END as remarks
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
            
            if (empty($events)) {
                return [];
            }
            
            // Organize events by day
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
        } catch (Exception $e) {
            error_log("Error fetching schedule: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get ticket information for the festival directly from JazzPass table
     * 
     * @return array Ticket types and pricing
     */
   public function getTicketInfo()
   {
       try {
           $query = "SELECT 
                       PassId as id,
                       PassType as type,
                       DisplayName as title,
                       Description as description,
                       Dates as dates,
                       BasePrice as price,
                       Featured as featured
                     FROM JazzPass
                     ORDER BY PassId ASC";
                     
           $stmt = self::$pdo->prepare($query);
           $stmt->execute();
           
           $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
           // Convert numeric strings to proper types
           foreach ($tickets as &$ticket) {
               $ticket['price'] = (float)$ticket['price'];
               $ticket['featured'] = (bool)$ticket['featured'];
           }
           
           return $tickets;
       } catch (Exception $e) {
           error_log("Error retrieving ticket information: " . $e->getMessage());
           return [];
       }
   }

    /**
     * Get venue information with only fields needed for the venue view
     * 
     * @return array Venue details
     */
    public function getVenueDetails()
    {
        try {
            $query = "SELECT 
                        VenueId as id,
                        Name as name,
                        Address as address,
                        Capacity as capacity,
                        Description as description,
                        Email as contact_email,
                        OfficePhone as contact_office_phone,
                        OfficeHours as contact_office_hours,
                        InfoPhone as contact_info_phone
                    FROM Venue
                    ORDER BY VenueId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching venue details: " . $e->getMessage());
            return [];
        }
    }
}