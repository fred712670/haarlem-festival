<?php
require_once(__DIR__ . "/../models/DanceManagementModel.php");


class DanceManagementController
{
    /**
     * @var DanceManagementModel Instance for database operations
     */
    private $danceModel;

    /**
     * Constructor initializes the controller with DanceManagementModel
     */
    public function __construct()
    {
        $this->danceModel = new DanceManagementModel();
    }

    /**
     * Display the dance management dashboard with overview statistics
     * 
     * @return array Dashboard statistics including:
     *               - artistCount: Total number of dance artists
     *               - eventCount: Total number of dance events
     */
    public function dashboard()
    {
        $artistCount = $this->danceModel->getArtistCount();
        $eventCount = $this->danceModel->getEventCount();
        
        return [
            'artistCount' => $artistCount,
            'eventCount' => $eventCount
        ];
    }

    /**
     * Retrieve all dance artists from the database
     * 
     * @return array Array containing all artists under 'artists' key
     */
    public function listArtists()
    {
        $artists = $this->danceModel->getAllArtists();
        return ['artists' => $artists];
    }

    /**
     * Get detailed information for a specific artist
     * 
     * @param int $artistId Unique identifier of the artist
     * @return array|bool Artist data if found, false otherwise
     */
    public function getArtist($artistId)
    {
        return $this->danceModel->getArtistById($artistId);
    }

    /**
     * Create a new artist profile with image uploads
     * Handles validation, image processing, and database insertion
     * 
     * @param array $data POST data containing artist information:
     *                    - name: Artist name (required)
     *                    - genre: Music genre (required)
     *                    - description: Artist description (optional)
     * @param array $files File upload data containing:
     *                     - profileImage: Main profile image (optional)
     *                     - detailImage: Detail/banner image (optional)
     * @return array Result containing success status and message
     */
    public function createArtist($data, $files)
    {
        // Validate required fields
        if (empty($data['name']) || empty($data['genre'])) {
            return ['success' => false, 'message' => 'Artist name and genre are required.'];
        }

        // Process profile image upload if provided
        $profileImageName = null;
        if (!empty($files['profileImage']['name'])) {
            $profileImageName = $this->processImageUpload($files['profileImage'], 'dance');
            if (!$profileImageName) {
                return ['success' => false, 'message' => 'Failed to upload profile image.'];
            }
        }

        // Process detail image upload if provided
        $detailImageName = null;
        if (!empty($files['detailImage']['name'])) {
            $detailImageName = $this->processImageUpload($files['detailImage'], 'dance');
            if (!$detailImageName) {
                return ['success' => false, 'message' => 'Failed to upload detail image.'];
            }
        }

        // Create artist record in database
        return $this->danceModel->createArtist(
            $data['name'],
            $data['genre'],
            $profileImageName,
            $detailImageName,
            $data['description'] ?? ''
        );
    }

    /**
     * Update an existing artist profile
     * Handles image updates by removing old images when new ones are uploaded
     * 
     * @param int $artistId ID of the artist to update
     * @param array $data Updated artist information
     * @param array $files Updated image files
     * @return array Result containing success status and message
     */
    public function updateArtist($artistId, $data, $files)
    {
        // Validate required fields
        if (empty($data['name']) || empty($data['genre'])) {
            return ['success' => false, 'message' => 'Artist name and genre are required.'];
        }

        // Retrieve current artist data to handle image updates
        $artist = $this->danceModel->getArtistById($artistId);
        if (!$artist) {
            return ['success' => false, 'message' => 'Artist not found.'];
        }

        // Handle profile image update with cleanup of old image
        $profileImageName = $artist['ProfileImageName']; // Default to existing image
        if (!empty($files['profileImage']['name'])) {
            $newProfileImageName = $this->processImageUpload($files['profileImage'], 'dance');
            if ($newProfileImageName) {
                // Remove old image if it's not the default image
                if ($profileImageName && $profileImageName != 'default-artist.png') {
                    $oldImagePath = __DIR__ . '/../../public/assets/img/dance/' . $profileImageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $profileImageName = $newProfileImageName;
            }
        }

        // Handle detail image update with cleanup of old image
        $detailImageName = $artist['DetailImageName']; // Default to existing image
        if (!empty($files['detailImage']['name'])) {
            $newDetailImageName = $this->processImageUpload($files['detailImage'], 'dance');
            if ($newDetailImageName) {
                // Remove old image if it's not the default image
                if ($detailImageName && $detailImageName != 'default-detail.png') {
                    $oldImagePath = __DIR__ . '/../../public/assets/img/dance/' . $detailImageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $detailImageName = $newDetailImageName;
            }
        }

        // Update artist record in database
        return $this->danceModel->updateArtist(
            $artistId,
            $data['name'],
            $data['genre'],
            $profileImageName,
            $detailImageName,
            $data['description'] ?? ''
        );
    }

    /**
     * Delete an artist from the system
     * Checks for existing events and removes associated images
     * Prevents deletion if artist has associated events
     * 
     * @param int $artistId ID of the artist to delete
     * @return array Result containing success status and message
     */
    public function deleteArtist($artistId)
    {
        // Verify artist exists
        $artist = $this->danceModel->getArtistById($artistId);
        if (!$artist) {
            return ['success' => false, 'message' => 'Artist not found.'];
        }

        // Check for associated events - prevent deletion if exists
        $hasEvents = $this->danceModel->artistHasEvents($artistId);
        if ($hasEvents) {
            return ['success' => false, 'message' => 'Cannot delete artist. The artist has associated events. Remove the events first.'];
        }

        // Delete profile image if not default
        if ($artist['ProfileImageName'] && $artist['ProfileImageName'] != 'default-artist.png') {
            $imagePath = __DIR__ . '/../../public/assets/img/dance/' . $artist['ProfileImageName'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Delete detail image if not default
        if ($artist['DetailImageName'] && $artist['DetailImageName'] != 'default-detail.png') {
            $imagePath = __DIR__ . '/../../public/assets/img/dance/' . $artist['DetailImageName'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete artist record from database
        return $this->danceModel->deleteArtist($artistId);
    }

    /**
     * Retrieve all dance events from the database
     * 
     * @return array Array containing all events under 'events' key
     */
    public function listEvents()
    {
        $events = $this->danceModel->getAllEvents();
        return ['events' => $events];
    }

    /**
     * Get data needed for event creation/editing form
     * Includes lists of available artists and locations
     * 
     * @return array Form data including:
     *               - artists: All available artists
     *               - locations: All available locations
     *               - event: null (for new event form)
     */
    public function getEventFormData()
    {
        $artists = $this->danceModel->getAllArtists();
        $locations = $this->danceModel->getAllLocations();
        
        return [
            'artists' => $artists,
            'locations' => $locations,
            'event' => null
        ];
    }

    /**
     * Get detailed information for a specific event including assigned artists
     * 
     * @param int $eventId Unique identifier of the event
     * @return array Event data including:
     *               - event: Event details
     *               - artists: All available artists
     *               - locations: All available locations
     *               - selectedArtists: Artists assigned to this event
     */
    public function getEvent($eventId)
    {
        $event = $this->danceModel->getEventById($eventId);
        
        $artists = [];
        if ($event) {
            $artists = $this->danceModel->getEventArtists($eventId);
        }
        
        return [
            'event' => $event,
            'artists' => $this->danceModel->getAllArtists(),
            'locations' => $this->danceModel->getAllLocations(),
            'selectedArtists' => $artists
        ];
    }

    /**
     * Create a new dance event with artist assignments
     * Validates input data and processes date/time format
     * 
     * @param array $data Event data including:
     *                    - description: Event description (required)
     *                    - location: Event location ID (required)
     *                    - startDate: Event date (required)
     *                    - startTime: Event start time (required)
     *                    - durationByMinute: Event duration in minutes (required)
     *                    - tickets: Available tickets (required)
     *                    - price: Ticket price (required)
     *                    - artists: Array of artist IDs (required, at least one)
     *                    - timeSlot: Additional time slot description (optional)
     * @return array Result containing success status and message
     */
    public function createEvent($data)
    {
        // Validate all required fields
        if (empty($data['description']) || empty($data['location']) || empty($data['startDate']) || empty($data['startTime']) || 
            empty($data['durationByMinute']) || !isset($data['tickets']) || !isset($data['price'])) {
            return ['success' => false, 'message' => 'All required fields must be filled.'];
        }
    
        // Validate at least one artist is selected
        if (empty($data['artists'])) {
            return ['success' => false, 'message' => 'At least one artist must be selected.'];
        }
    
        // Combine date and time into MySQL datetime format
        $startDateTime = $data['startDate'] . ' ' . $data['startTime'] . ':00';
    
        // Create event in database
        $result = $this->danceModel->createEvent(
            $data['description'],
            $data['location'],
            $startDateTime,
            $data['timeSlot'] ?? '',
            $data['durationByMinute'],
            $data['tickets'],
            $data['price'],
            $data['artists']
        );
    
        return $result;
    }
    
    /**
     * Update an existing dance event
     * Validates input data and updates artist assignments
     * 
     * @param int $eventId ID of the event to update
     * @param array $data Updated event information
     * @return array Result containing success status and message
     */
    public function updateEvent($eventId, $data)
    {
        // Validate all required fields
        if (empty($data['description']) || empty($data['location']) || empty($data['startDate']) || empty($data['startTime']) || 
            empty($data['durationByMinute']) || !isset($data['tickets']) || !isset($data['price'])) {
            return ['success' => false, 'message' => 'All required fields must be filled.'];
        }

        // Validate at least one artist is selected
        if (empty($data['artists'])) {
            return ['success' => false, 'message' => 'At least one artist must be selected.'];
        }

        // Combine date and time into MySQL datetime format
        $startDateTime = $data['startDate'] . ' ' . $data['startTime'] . ':00';

        // Update event in database
        $result = $this->danceModel->updateEvent(
            $eventId,
            $data['description'],
            $data['location'],
            $startDateTime,
            $data['timeSlot'] ?? '',
            $data['durationByMinute'],
            $data['tickets'],
            $data['price'],
            $data['artists']
        );

        return $result;
    }
    
    /**
     * Delete a dance event from the system
     * Prevents deletion if tickets have been sold for the event
     * 
     * @param int $eventId ID of the event to delete
     * @return array Result containing success status and message
     */
    public function deleteEvent($eventId)
    {
        // Verify event exists
        $event = $this->danceModel->getEventById($eventId);
        if (!$event) {
            return ['success' => false, 'message' => 'Event not found.'];
        }

        // Check for sold tickets - prevent deletion if exists
        $hasSoldTickets = $this->danceModel->eventHasSoldTickets($eventId);
        if ($hasSoldTickets) {
            return ['success' => false, 'message' => 'Cannot delete event. There are tickets sold for this event.'];
        }

        // Delete event from database
        return $this->danceModel->deleteEvent($eventId);
    }

    /**
     * Process image upload and return the filename
     * Handles validation, unique filename generation, and file movement
     * 
     * @param array $file File upload array from $_FILES
     * @param string $subdir Subdirectory to save the image in
     * @return string|false Returns filename on success, false on failure
     */
    private function processImageUpload($file, $subdir)
    {
        // Validate upload success
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Validate file type - only allow specific image formats
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Generate unique filename to prevent collisions
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $extension;
        
        // Ensure destination directory exists with proper permissions
        $uploadDir = __DIR__ . '/../../public/assets/img/' . $subdir . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Move uploaded file to destination
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $filename;
        }
        
        return false;
    }
}