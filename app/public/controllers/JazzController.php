<?php
require_once __DIR__ . '/../models/JazzModel.php';

class JazzController {
    private $jazzModel;
    
    public function __construct() {
        $this->jazzModel = new JazzModel();
    }
    
    /**
 * Index page for Jazz Festival
 * 
 * @return array Data for the jazz main page
 */
public function index() {
    // Get all required data for the main page
    $artists = $this->jazzModel->getAllArtists();
    $schedule = $this->jazzModel->getSchedule();
    $ticketInfo = $this->jazzModel->getTicketInfo();
    $venues = $this->jazzModel->getVenueDetails();
    
    // Get content from database instead of hardcoding
    $content = $this->jazzModel->getJazzContent();
    
    // Return data needed for the view
    return [
        'artists' => $artists,
        'schedule' => $schedule,
        'ticketInfo' => $ticketInfo,
        'venues' => $venues,
        'content' => $content
    ];
}
    /**
     * Show details for a specific artist
     * 
     * @param int $id Artist ID
     * @return array|null Artist data or null if not found
     */
    public function showArtist($id) {
        // Get the artist's details
        $artist = $this->jazzModel->getArtistById($id);
        
        if (!$artist) {
            return null;
        }
        
        // Format and enhance artist data
        $artist = $this->formatArtistData($artist);
        
        return $artist;
    }
    
    /**
     * Format and enhance artist data for display
     * 
     * @param array $artist Raw artist data
     * @return array Formatted artist data
     */
    private function formatArtistData($artist) {
        // Format performance time if available
        if (!empty($artist['performance_time'])) {
            $artist['formatted_date'] = date('l, F j', strtotime($artist['performance_time']));
            $artist['formatted_time'] = date('g:i A', strtotime($artist['performance_time']));
        }
        
        // Ensure all required sections exist with default values if missing
        $artist = $this->ensureRequiredSections($artist);
        
        return $artist;
    }
    
    /**
     * Ensure all required sections exist in artist data
     * 
     * @param array $artist Artist data
     * @return array Complete artist data
     */
    private function ensureRequiredSections($artist) {
        $requiredSections = ['description', 'musical_style', 'career_highlights'];
        
        foreach ($requiredSections as $section) {
            if (empty($artist[$section])) {
                // If any required section is missing, provide a default
                $artist[$section] = $this->getDefaultSectionContent($section, $artist['name']);
            }
        }
        
        // Make sure we have at least one gallery image
        if (empty($artist['gallery']) || !is_array($artist['gallery']) || count($artist['gallery']) === 0) {
            $artist['gallery'] = [$artist['image']];
        }
        
        return $artist;
    }
    
    /**
     * Get default content for missing artist sections
     * 
     * @param string $section Section name
     * @param string $artistName Artist name
     * @return string Default content
     */
    
    /**
     * Get venue details
     * 
     * @return array Venue data
     */
    public function getVenues() {
        return $this->jazzModel->getVenueDetails();
    }
    
    /**
     * Get schedule data
     * 
     * @param int|null $artistId Optional artist ID to filter schedule
     * @return array Schedule data
     */
    public function getSchedule($artistId = null) {
        $scheduleData = $this->jazzModel->getSchedule($artistId);
        
        // If requesting a specific artist's schedule but no data found
        if ($artistId !== null && empty($scheduleData)) {
            // Return an empty structure with days but no events
            return $this->createEmptySchedule();
        }
        
        return $scheduleData;
    }
    
    /**
     * Create an empty schedule structure with festival days
     * 
     * @return array Empty schedule structure
     */
    private function createEmptySchedule() {
        // we still need to add a table to database for the days of festival and the events
        $festivalDates = [
            ['date' => '2025-07-24', 'day_name' => 'Thursday', 'day_number' => '24', 'month_name' => 'July'],
            ['date' => '2025-07-25', 'day_name' => 'Friday', 'day_number' => '25', 'month_name' => 'July'],
            ['date' => '2025-07-26', 'day_name' => 'Saturday', 'day_number' => '26', 'month_name' => 'July'],
            ['date' => '2025-07-27', 'day_name' => 'Sunday', 'day_number' => '27', 'month_name' => 'July']
        ];
        
        $emptySchedule = [];
        foreach ($festivalDates as $day) {
            $dateKey = $day['date'];
            $emptySchedule[$dateKey] = [
                'date' => $day['date'],
                'day_name' => $day['day_name'],
                'day_number' => $day['day_number'],
                'month_name' => $day['month_name'],
                'events' => []
            ];
        }
        
        return $emptySchedule;
    }
    
    /**
     * Get featured artists for the homepage
     * 
     * @param int $limit Number of artists to retrieve
     * @return array Featured artists data
     */
    public function getFeaturedArtists($limit = 4) {
        $allArtists = $this->jazzModel->getAllArtists();
        
        // Sort by performance time to get upcoming performances
        usort($allArtists, function($a, $b) {
            if (empty($a['performance_time']) && empty($b['performance_time'])) return 0;
            if (empty($a['performance_time'])) return 1;
            if (empty($b['performance_time'])) return -1;
            return strtotime($a['performance_time']) - strtotime($b['performance_time']);
        });
        
        // Return the first $limit artists
        return array_slice($allArtists, 0, $limit);
    }

/**
 * Get content for Jazz Festival
 * 
 * @param string|null $section Specific section to retrieve (optional)
 * @return array|string Content data or string for specific section
 */
public function getJazzContent($section = null)
{
    try {
        $query = "SELECT 
                    ContentId as id,
                    Section as section,
                    Content as content
                FROM Content
                WHERE EventType = 'jazz'";
        
        // If a specific section is requested, add WHERE clause
        if ($section !== null) {
            $query .= " AND Section = :section";
        }
        
        $stmt = self::$pdo->prepare($query);
        
        // Bind the section parameter if needed
        if ($section !== null) {
            $stmt->bindParam(':section', $section, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        // If a specific section was requested, return just the content
        if ($section !== null) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['content'] : '';
        }
        
        // Otherwise return all content items indexed by section
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contentBySection = [];
        
        foreach ($results as $row) {
            $contentBySection[$row['section']] = $row['content'];
        }
        
        return $contentBySection;
    } catch (Exception $e) {
        error_log("Error fetching jazz content: " . $e->getMessage());
        return $section !== null ? '' : [];
    }
}


/**
 * Get ticket information for the festival
 * 
 * @return array Ticket types and pricing
 */
public function getTicketInfo() {
    return $this->jazzModel->getTicketInfo();
}
/**
 * Get track details for audio player
 * 
 * @param int $trackId Track ID
 * @return array Track details including audio file path
 */
public function getTrackDetails($trackId) {
    return $this->jazzModel->getTrackById($trackId);
}
}

