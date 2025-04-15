<?php
require_once(__DIR__ . "/../models/JazzManagementModel.php");

/**
 * Controller for handling jazz management operations
 */
class JazzManagementController
{
    private $jazzModel;

    public function __construct()
    {
        $this->jazzModel = new JazzManagementModel();
    }

    /**
     * Display the jazz management dashboard
     */
    public function dashboard()
    {
        $artistCount = $this->jazzModel->getArtistCount();
        $eventCount = $this->jazzModel->getEventCount();
        $venueCount = $this->jazzModel->getVenueCount();
        $passCount = $this->jazzModel->getPassCount();
        
        return [
            'artistCount' => $artistCount,
            'eventCount' => $eventCount,
            'venueCount' => $venueCount,
            'passCount' => $passCount
        ];
    }

    /**
     * Get all jazz artists
     */
    public function listArtists()
    {
        $artists = $this->jazzModel->getAllArtists();
        return ['artists' => $artists];
    }

    /**
     * Get a specific artist by ID
     */
    public function getArtist($artistId)
    {
        return $this->jazzModel->getArtistById($artistId);
    }

    /**
     * Create a new artist
     */
    public function createArtist($data, $files)
    {
        // Validate inputs
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Artist name is required.'];
        }

        // Handle image upload
        $imageName = null;
        if (!empty($files['profileImage']['name'])) {
            $imageName = $this->processImageUpload($files['profileImage'], 'jazz');
            if (!$imageName) {
                return ['success' => false, 'message' => 'Failed to upload profile image.'];
            }
        }

        // Handle gallery images if present
        $galleryImages = [];
        if (!empty($files['galleryImages']['name'][0])) {
            foreach ($files['galleryImages']['name'] as $index => $filename) {
                if (empty($filename)) continue;

                $galleryFile = [
                    'name' => $files['galleryImages']['name'][$index],
                    'type' => $files['galleryImages']['type'][$index],
                    'tmp_name' => $files['galleryImages']['tmp_name'][$index],
                    'error' => $files['galleryImages']['error'][$index],
                    'size' => $files['galleryImages']['size'][$index]
                ];

                $galleryImageName = $this->processImageUpload($galleryFile, 'jazz');
                if ($galleryImageName) {
                    $galleryImages[] = $galleryImageName;
                }
            }
        }

        // Create artist
        return $this->jazzModel->createArtist(
            $data['name'],
            $imageName,
            $data['short_description'] ?? '',
            $data['description'] ?? '',
            $data['musical_style'] ?? '',
            $data['career_highlights'] ?? '',
            !empty($galleryImages) ? implode(',', $galleryImages) : null
        );
    }

    /**
     * Update an existing artist
     */
    public function updateArtist($artistId, $data, $files)
    {
        // Validate inputs
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Artist name is required.'];
        }

        // Get current artist data
        $artist = $this->jazzModel->getArtistById($artistId);
        if (!$artist) {
            return ['success' => false, 'message' => 'Artist not found.'];
        }

        // Handle image upload
        $imageName = $artist['image']; // Default to existing image
        if (!empty($files['profileImage']['name'])) {
            $newImageName = $this->processImageUpload($files['profileImage'], 'jazz');
            if ($newImageName) {
                // Remove old image if successful and not the default
                if ($imageName && $imageName != 'default-artist.jpg') {
                    $oldImagePath = __DIR__ . '/../../public/assets/img/jazz/' . $imageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $imageName = $newImageName;
            }
        }

        // Handle gallery images if present
        $galleryImages = [];
        if (!empty($artist['artistGallery'])) {
            // Parse existing gallery images
            $galleryImages = explode(',', $artist['artistGallery']);
        }
        
        // Add new gallery images
        if (!empty($files['galleryImages']['name'][0])) {
            foreach ($files['galleryImages']['name'] as $index => $filename) {
                if (empty($filename)) continue;

                $galleryFile = [
                    'name' => $files['galleryImages']['name'][$index],
                    'type' => $files['galleryImages']['type'][$index],
                    'tmp_name' => $files['galleryImages']['tmp_name'][$index],
                    'error' => $files['galleryImages']['error'][$index],
                    'size' => $files['galleryImages']['size'][$index]
                ];

                $galleryImageName = $this->processImageUpload($galleryFile, 'jazz');
                if ($galleryImageName) {
                    $galleryImages[] = $galleryImageName;
                }
            }
        }

        // Handle removed gallery images
        if (!empty($data['removed_gallery_images'])) {
            $removedImages = explode(',', $data['removed_gallery_images']);
            foreach ($removedImages as $removedImage) {
                $key = array_search($removedImage, $galleryImages);
                if ($key !== false) {
                    unset($galleryImages[$key]);
                    
                    // Delete the file
                    $imagePath = __DIR__ . '/../../public/assets/img/jazz/' . $removedImage;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
        }

        // Update artist
        return $this->jazzModel->updateArtist(
            $artistId,
            $data['name'],
            $imageName,
            $data['short_description'] ?? '',
            $data['description'] ?? '',
            $data['musical_style'] ?? '',
            $data['career_highlights'] ?? '',
            !empty($galleryImages) ? implode(',', array_values($galleryImages)) : null
        );
    }

    /**
     * Delete an artist
     */
    public function deleteArtist($artistId)
    {
        // Check if artist exists
        $artist = $this->jazzModel->getArtistById($artistId);
        if (!$artist) {
            return ['success' => false, 'message' => 'Artist not found.'];
        }

        // Check if artist has any events
        $hasEvents = $this->jazzModel->artistHasEvents($artistId);
        if ($hasEvents) {
            return ['success' => false, 'message' => 'Cannot delete artist. The artist has associated events. Remove the events first.'];
        }

        // Delete artist image if exists
        if ($artist['image'] && $artist['image'] != 'default-artist.jpg') {
            $imagePath = __DIR__ . '/../../public/assets/img/jazz/' . $artist['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete gallery images if exist
        if (!empty($artist['artistGallery'])) {
            $galleryImages = explode(',', $artist['artistGallery']);
            foreach ($galleryImages as $image) {
                $imagePath = __DIR__ . '/../../public/assets/img/jazz/' . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Delete artist
        return $this->jazzModel->deleteArtist($artistId);
    }

    /**
     * List all jazz events
     */
    public function listEvents()
    {
        $events = $this->jazzModel->getAllEvents();
        return ['events' => $events];
    }

    /**
     * Get data needed for event form
     */
    public function getEventFormData()
    {
        $artists = $this->jazzModel->getAllArtists();
        $venues = $this->jazzModel->getAllVenues();
        
        return [
            'artists' => $artists,
            'venues' => $venues,
            'event' => null
        ];
    }

    /**
     * Get a specific event by ID
     */
    public function getEvent($eventId)
    {
        error_log("Loading event with ID: " . $eventId);
        $event = $this->jazzModel->getEventById($eventId);
        error_log("Event found: " . ($event ? 'Yes' : 'No'));
        
        $artists = [];
        if ($event) {
            $artists = $this->jazzModel->getEventArtists($eventId);
        }
        
        return [
            'event' => $event,
            'artists' => $this->jazzModel->getAllArtists(),
            'venues' => $this->jazzModel->getAllVenues(),
            'selectedArtists' => $artists
        ];
    }

    /**
     * Create a new event
     */
    public function createEvent($data)
    {
        // Validate inputs
        if (empty($data['description']) || empty($data['venue']) || empty($data['startDate']) || empty($data['startTime']) || 
            empty($data['durationByMinute']) || !isset($data['tickets']) || !isset($data['price'])) {
            return ['success' => false, 'message' => 'All required fields must be filled.'];
        }
    
        if (empty($data['artists'])) {
            return ['success' => false, 'message' => 'At least one artist must be selected.'];
        }
    
        // Combine date and time into datetime format
        $startDateTime = $data['startDate'] . ' ' . $data['startTime'] . ':00';
    
        // Create event
        $result = $this->jazzModel->createEvent(
            $data['description'],
            $data['venue'],
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
     * Update an existing event
     */
    public function updateEvent($eventId, $data)
{
    // Validate inputs
    if (empty($data['description']) || empty($data['venue']) || empty($data['startDate']) || empty($data['startTime']) || 
        empty($data['durationByMinute']) || !isset($data['tickets']) || !isset($data['price'])) {
        return ['success' => false, 'message' => 'All required fields must be filled.'];
    }

    if (empty($data['artists'])) {
        return ['success' => false, 'message' => 'At least one artist must be selected.'];
    }

    // Combine date and time into datetime format
    $startDateTime = $data['startDate'] . ' ' . $data['startTime'] . ':00';

    // Update event
    $result = $this->jazzModel->updateEvent(
        $eventId,
        $data['description'],
        $data['venue'],
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
     * Delete an event
     */
    public function deleteEvent($eventId)
    {
        // Check if event exists
        $event = $this->jazzModel->getEventById($eventId);
        if (!$event) {
            return ['success' => false, 'message' => 'Event not found.'];
        }

        // Check if there are tickets sold for this event
        $hasSoldTickets = $this->jazzModel->eventHasSoldTickets($eventId);
        if ($hasSoldTickets) {
            return ['success' => false, 'message' => 'Cannot delete event. There are tickets sold for this event.'];
        }

        // Delete event
        return $this->jazzModel->deleteEvent($eventId);
    }

    /**
     * List all venues
     */
    public function listVenues()
    {
        $venues = $this->jazzModel->getAllVenues();
        return ['venues' => $venues];
    }

    /**
     * Get a specific venue by ID
     */
    public function getVenue($venueId)
    {
        return $this->jazzModel->getVenueById($venueId);
    }

    /**
     * Update a venue
     */
    public function updateVenue($venueId, $data)
    {
        // Validate inputs
        if (empty($data['name']) || empty($data['address']) || !isset($data['capacity'])) {
            return ['success' => false, 'message' => 'Name, address and capacity are required.'];
        }

        // Update venue
        return $this->jazzModel->updateVenue(
            $venueId,
            $data['name'],
            $data['address'],
            $data['capacity'],
            $data['description'] ?? '',
            $data['email'] ?? '',
            $data['officePhone'] ?? '',
            $data['officeHours'] ?? '',
            $data['infoPhone'] ?? ''
        );
    }

    /**
     * List all passes
     */
    public function listPasses()
    {
        $passes = $this->jazzModel->getAllPasses();
        return ['passes' => $passes];
    }

    /**
     * Get a specific pass by ID
     */
    public function getPass($passId)
    {
        return $this->jazzModel->getPassById($passId);
    }

    /**
     * Create a new pass
     */
    public function createPass($data)
    {
        // Validate inputs
        if (empty($data['passType']) || empty($data['displayName']) || empty($data['description']) || !isset($data['basePrice'])) {
            return ['success' => false, 'message' => 'Pass type, name, description and price are required.'];
        }

        // Create pass
        return $this->jazzModel->createPass(
            $data['passType'],
            $data['displayName'],
            $data['shortDescription'] ?? '',
            $data['description'],
            $data['dates'] ?? null,
            $data['basePrice'],
            isset($data['featured']) ? 1 : 0
        );
    }

    /**
     * Update an existing pass
     */
    public function updatePass($passId, $data)
    {
        // Validate inputs
        if (empty($data['passType']) || empty($data['displayName']) || empty($data['description']) || !isset($data['basePrice'])) {
            return ['success' => false, 'message' => 'Pass type, name, description and price are required.'];
        }

        // Update pass
        return $this->jazzModel->updatePass(
            $passId,
            $data['passType'],
            $data['displayName'],
            $data['shortDescription'] ?? '',
            $data['description'],
            $data['dates'] ?? null,
            $data['basePrice'],
            isset($data['featured']) ? 1 : 0
        );
    }

    /**
     * Delete a pass
     */
    public function deletePass($passId)
    {
        // Check if pass exists
        $pass = $this->jazzModel->getPassById($passId);
        if (!$pass) {
            return ['success' => false, 'message' => 'Pass not found.'];
        }

        // Check if there are tickets sold with this pass
        $hasSoldTickets = $this->jazzModel->passHasSoldTickets($passId);
        if ($hasSoldTickets) {
            return ['success' => false, 'message' => 'Cannot delete pass. There are tickets sold with this pass type.'];
        }

        // Delete pass
        return $this->jazzModel->deletePass($passId);
    }

    /**
     * Process image upload and return the filename
     */
    private function processImageUpload($file, $subdir)
    {
        // Check if file upload is valid
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $extension;
        
        // Make sure the destination directory exists
        $uploadDir = __DIR__ . '/../../public/assets/img/' . $subdir . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $filename;
        }
        
        return false;
    }
}