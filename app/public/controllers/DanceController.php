<?php
require_once __DIR__ . '/../models/DanceModel.php';

class DanceController {
    private $danceModel;

    public function __construct() {
        $this->danceModel = new DanceModel();
    }

    // Retrieve all dance artists from the database
    public function getArtists() {
        return $this->danceModel->getAllArtists();
    }

    // Retrieve a single artist by ID
    public function getArtistById($id) {
        return $this->danceModel->getArtist($id);
    }

    // Retrieve section content for a specific event (e.g., About, Shows, Passes)
    public function getContent($event, $section) {
        return $this->danceModel->getContentByEventAndSection($event, $section);
    }

    // Retrieve all scheduled dance events
    public function getDanceEvents() {
        return $this->danceModel->getDanceEvents();
    }

    // Retrieve all songs associated with a specific artist
    public function getSongsByArtistId($id) {
        return $this->danceModel->getArtistSongs($id);
    }

    // Retrieve all dance performances linked to a given artist
    public function getArtistPerformances($id) {
        return $this->danceModel->getArtistPerformances($id);
    }

    
    // Group dance events by weekday name ('friday', 'saturday', 'sunday').
    // Dynamically derives the day from each event's StartDateTime
    public function groupDanceEventsByDay($danceEvents) {
        // Predefine the structure with only the relevant days
        $grouped = [
            'friday'   => [],
            'saturday' => [],
            'sunday'   => [],
        ];

        foreach ($danceEvents as $event) {
            // Parse the StartDateTime into a lowercase weekday string (e.g., 'friday')
            $dayName = strtolower(date('l', strtotime($event['StartDateTime'])));

            // Only group events that fall on the expected festival days
            if (isset($grouped[$dayName])) {
                $grouped[$dayName][] = $event;
            }
        }

        return $grouped;
    }

    // Format raw text into HTML paragraph tags.
    // Splits by newlines and wraps each non-empty line in <p> tags,
    public function wrapParagraphs($text) {
        if (!is_string($text)) return '';

        // Split text by line breaks into an array
        $lines = preg_split('/\r\n|\r|\n/', trim($text));

        // Filter out empty lines
        $paragraphs = array_filter($lines, function ($line) {
            return trim($line) !== '';
        });

        // Wrap each line in <p> tags and return the combined string
        return implode("\n", array_map(function ($line) {
            return "<p>" . htmlspecialchars($line) . "</p>";
        }, $paragraphs));
    }
}
