<?php
require_once __DIR__ . '/../models/DanceModel.php';

class DanceController {
    private $danceModel;

    public function __construct() {
        $this->danceModel = new DanceModel();
    }

    // Retrieve all artists.
    public function getArtists() {
        return $this->danceModel->getAllArtists();
    }

    // Retrieve a single artist by ID.
    public function getArtistById($id) {
        return $this->danceModel->getArtist($id);
    }

    // Retrieve content for a particular event and section.
    public function getContent($event, $section) {
        return $this->danceModel->getContentByEventAndSection($event, $section);
    }

    // Retrieve all dance events.
    public function getDanceEvents() {
        return $this->danceModel->getDanceEvents();
    }

    // Retrieve songs by a specific artist.
    public function getSongsByArtistId($id) {
        return $this->danceModel->getArtistSongs($id);
    }

    // Retrieve performances for an artist.
    public function getArtistPerformances($id) {
        return $this->danceModel->getArtistPerformances($id);
    }
    
    /**
     * Group dance events by day.
     * Returns an associative array with keys 'friday', 'saturday', and 'sunday'.
     */
    public function groupDanceEventsByDay($danceEvents) {
        $friday = [];
        $saturday = [];
        $sunday = [];
        foreach ($danceEvents as $event) {
            // Ensure that StartDateTime is defined and valid.
            $date = date('Y-m-d', strtotime($event['StartDateTime']));
            if ($date === '2025-07-25') {
                $friday[] = $event;
            } elseif ($date === '2025-07-26') {
                $saturday[] = $event;
            } elseif ($date === '2025-07-27') {
                $sunday[] = $event;
            }
        }
        return [
            'friday'   => $friday,
            'saturday' => $saturday,
            'sunday'   => $sunday,
        ];
    }
    
    /**
     * Wraps paragraphs in a given text.
     * Splits the text into lines and wraps non-empty lines in <p> tags.
     */
    public function wrapParagraphs($text) {
        if (!is_string($text)) return '';
        $lines = preg_split('/\r\n|\r|\n/', trim($text));
        $paragraphs = array_filter($lines, function ($line) {
            return trim($line) !== '';
        });
        return implode("\n", array_map(function ($line) {
            return "<p>" . htmlspecialchars($line) . "</p>";
        }, $paragraphs));
    }
}
