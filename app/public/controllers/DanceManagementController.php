<?php
require_once(__DIR__ . "/../models/DanceManagementModel.php");

/**
 * Controller for handling dance management operations
 */
class DanceManagementController
{
    private $danceModel;

    public function __construct()
    {
        $this->danceModel = new DanceManagementModel();
    }

    /**
     * Display the dance management dashboard
     */
    public function dashboard()
    {
        $artistCount = $this->danceModel->getArtistCount();
        $eventCount = $this->danceModel->getEventCount();
        $songCount = $this->danceModel->getSongCount();
        
        return [
            'artistCount' => $artistCount,
            'eventCount' => $eventCount,
            'songCount' => $songCount
        ];
    }

    /**
     * Get all dance artists
     */
    public function listArtists()
    {
        $artists = $this->danceModel->getAllArtists();
        return ['artists' => $artists];
    }

    /**
     * Get a specific artist by ID
     */
    public function getArtist($artistId)
    {
        return $this->danceModel->getArtistById($artistId);
    }

    /**
     * Create a new artist
     */
    public function createArtist($data, $files)
    {
        // Validate inputs
        if (empty($data['name']) || empty($data['genre'])) {
            return ['success' => false, 'message' => 'Artist name and genre are required.'];
        }

        // Handle profile image upload
        $profileImageName = null;
        if (!empty($files['profileImage']['name'])) {
            $profileImageName = $this->processImageUpload($files['profileImage'], 'dance');
            if (!$profileImageName) {
                return ['success' => false, 'message' => 'Failed to upload profile image.'];
            }
        }

        // Handle detail image upload
        $detailImageName = null;
        if (!empty($files['detailImage']['name'])) {
            $detailImageName = $this->processImageUpload($files['detailImage'], 'dance');
            if (!$detailImageName) {
                return ['success' => false, 'message' => 'Failed to upload detail image.'];
            }
        }

        // Create artist
        return $this->danceModel->createArtist(
            $data['name'],
            $data['genre'],
            $profileImageName,
            $detailImageName,
            $data['description'] ?? ''
        );
    }

    /**
     * Update an existing artist
     */
    public function updateArtist($artistId, $data, $files)
    {
        // Validate inputs
        if (empty($data['name']) || empty($data['genre'])) {
            return ['success' => false, 'message' => 'Artist name and genre are required.'];
        }

        // Get current artist data
        $artist = $this->danceModel->getArtistById($artistId);
        if (!$artist) {
            return ['success' => false, 'message' => 'Artist not found.'];
        }

        // Handle profile image upload
        $profileImageName = $artist['ProfileImageName']; // Default to existing image
        if (!empty($files['profileImage']['name'])) {
            $newProfileImageName = $this->processImageUpload($files['profileImage'], 'dance');
            if ($newProfileImageName) {
                // Remove old image if successful and not the default
                if ($profileImageName && $profileImageName != 'default-artist.png') {
                    $oldImagePath = __DIR__ . '/../../public/assets/img/dance/' . $profileImageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $profileImageName = $newProfileImageName;
            }
        }

        // Handle detail image upload
        $detailImageName = $artist['DetailImageName']; // Default to existing image
        if (!empty($files['detailImage']['name'])) {
            $newDetailImageName = $this->processImageUpload($files['detailImage'], 'dance');
            if ($newDetailImageName) {
                // Remove old image if successful and not the default
                if ($detailImageName && $detailImageName != 'default-detail.png') {
                    $oldImagePath = __DIR__ . '/../../public/assets/img/dance/' . $detailImageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $detailImageName = $newDetailImageName;
            }
        }

        // Update artist
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
     * Delete an artist
     */
    public function deleteArtist($artistId)
    {
        // Check if artist exists
        $artist = $this->danceModel->getArtistById($artistId);
        if (!$artist) {
            return ['success' => false, 'message' => 'Artist not found.'];
        }

        // Check if artist has any events
        $hasEvents = $this->danceModel->artistHasEvents($artistId);
        if ($hasEvents) {
            return ['success' => false, 'message' => 'Cannot delete artist. The artist has associated events. Remove the events first.'];
        }

        // Delete artist images if exist
        if ($artist['ProfileImageName'] && $artist['ProfileImageName'] != 'default-artist.png') {
            $imagePath = __DIR__ . '/../../public/assets/img/dance/' . $artist['ProfileImageName'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        if ($artist['DetailImageName'] && $artist['DetailImageName'] != 'default-detail.png') {
            $imagePath = __DIR__ . '/../../public/assets/img/dance/' . $artist['DetailImageName'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete artist
        return $this->danceModel->deleteArtist($artistId);
    }

    /**
     * List all dance events
     */
    public function listEvents()
    {
        $events = $this->danceModel->getAllEvents();
        return ['events' => $events];
    }

    /**
     * Get data needed for event form
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
     * Get a specific event by ID
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
     * Create a new event
     */
    public function createEvent($data)
    {
        // Validate inputs
        if (empty($data['description']) || empty($data['location']) || empty($data['startDate']) || empty($data['startTime']) || 
            empty($data['durationByMinute']) || !isset($data['tickets']) || !isset($data['price'])) {
            return ['success' => false, 'message' => 'All required fields must be filled.'];
        }
    
        if (empty($data['artists'])) {
            return ['success' => false, 'message' => 'At least one artist must be selected.'];
        }
    
        // Combine date and time into datetime format
        $startDateTime = $data['startDate'] . ' ' . $data['startTime'] . ':00';
    
        // Create event
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
     * Update an existing event
     */
    public function updateEvent($eventId, $data)
    {
        // Validate inputs
        if (empty($data['description']) || empty($data['location']) || empty($data['startDate']) || empty($data['startTime']) || 
            empty($data['durationByMinute']) || !isset($data['tickets']) || !isset($data['price'])) {
            return ['success' => false, 'message' => 'All required fields must be filled.'];
        }

        if (empty($data['artists'])) {
            return ['success' => false, 'message' => 'At least one artist must be selected.'];
        }

        // Combine date and time into datetime format
        $startDateTime = $data['startDate'] . ' ' . $data['startTime'] . ':00';

        // Update event
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
     * Delete an event
     */
    public function deleteEvent($eventId)
    {
        // Check if event exists
        $event = $this->danceModel->getEventById($eventId);
        if (!$event) {
            return ['success' => false, 'message' => 'Event not found.'];
        }

        // Check if there are tickets sold for this event
        $hasSoldTickets = $this->danceModel->eventHasSoldTickets($eventId);
        if ($hasSoldTickets) {
            return ['success' => false, 'message' => 'Cannot delete event. There are tickets sold for this event.'];
        }

        // Delete event
        return $this->danceModel->deleteEvent($eventId);
    }

    /**
     * List all songs
     */
    public function listSongs()
    {
        $songs = $this->danceModel->getAllSongs();
        return ['songs' => $songs];
    }

    /**
     * Get a specific song by ID
     */
    public function getSong($songId)
    {
        return [
            'song' => $this->danceModel->getSongById($songId),
            'artists' => $this->danceModel->getAllArtists()
        ];
    }

    /**
     * Create a new song
     */
    public function createSong($data, $files)
    {
        // Validate inputs
        if (empty($data['title']) || empty($data['artistId'])) {
            return ['success' => false, 'message' => 'Song title and artist are required.'];
        }

        // Handle song file upload
        $songFileName = null;
        if (!empty($files['songFile']['name'])) {
            $songFileName = $this->processAudioUpload($files['songFile'], 'dance');
            if (!$songFileName) {
                return ['success' => false, 'message' => 'Failed to upload song file.'];
            }
        }

        // Handle song image upload
        $imageName = null;
        if (!empty($files['songImage']['name'])) {
            $imageName = $this->processImageUpload($files['songImage'], 'dance');
            if (!$imageName) {
                return ['success' => false, 'message' => 'Failed to upload song image.'];
            }
        }

        // Create song
        return $this->danceModel->createSong(
            $data['artistId'],
            $data['title'],
            $data['releaseYear'] ?? null,
            $data['credits'] ?? null,
            $data['description'] ?? null,
            $songFileName,
            $imageName
        );
    }

    /**
     * Update an existing song
     */
    public function updateSong($songId, $data, $files)
    {
        // Validate inputs
        if (empty($data['title']) || empty($data['artistId'])) {
            return ['success' => false, 'message' => 'Song title and artist are required.'];
        }

        // Get current song data
        $song = $this->danceModel->getSongById($songId);
        if (!$song) {
            return ['success' => false, 'message' => 'Song not found.'];
        }

        // Handle song file upload
        $songFileName = $song['SongFileName']; // Default to existing file
        if (!empty($files['songFile']['name'])) {
            $newSongFileName = $this->processAudioUpload($files['songFile'], 'dance');
            if ($newSongFileName) {
                // Remove old file if successful
                if ($songFileName) {
                    $oldFilePath = __DIR__ . '/../../public/assets/audio/' . $songFileName;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $songFileName = $newSongFileName;
            }
        }

        // Handle song image upload
        $imageName = $song['ImageName']; // Default to existing image
        if (!empty($files['songImage']['name'])) {
            $newImageName = $this->processImageUpload($files['songImage'], 'dance');
            if ($newImageName) {
                // Remove old image if successful
                if ($imageName) {
                    $oldImagePath = __DIR__ . '/../../public/assets/img/dance/' . $imageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $imageName = $newImageName;
            }
        }

        // Update song
        return $this->danceModel->updateSong(
            $songId,
            $data['artistId'],
            $data['title'],
            $data['releaseYear'] ?? null,
            $data['credits'] ?? null,
            $data['description'] ?? null,
            $songFileName,
            $imageName
        );
    }

    /**
     * Delete a song
     */
    public function deleteSong($songId)
    {
        // Check if song exists
        $song = $this->danceModel->getSongById($songId);
        if (!$song) {
            return ['success' => false, 'message' => 'Song not found.'];
        }

        // Delete song file if exists
        if ($song['SongFileName']) {
            $filePath = __DIR__ . '/../../public/assets/audio/' . $song['SongFileName'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete song image if exists
        if ($song['ImageName']) {
            $imagePath = __DIR__ . '/../../public/assets/img/dance/' . $song['ImageName'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete song
        return $this->danceModel->deleteSong($songId);
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

    /**
     * Process audio upload and return the filename
     */
    private function processAudioUpload($file, $subdir = '')
    {
        // Check if file upload is valid
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Validate file type
        $allowedTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('audio_') . '.' . $extension;
        
        // Make sure the destination directory exists
        $uploadDir = __DIR__ . '/../../public/assets/audio/';
        if (!empty($subdir)) {
            $uploadDir .= $subdir . '/';
        }
        
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