<?php
require_once __DIR__ . '/../models/DanceModel.php';

class DanceController
{
    public function getArtists()
    {
        $artistModel = new DanceModel();
        return $artistModel->getAllArtists();
    }

    public function getArtistById($id)
    {
        $artistModel = new DanceModel();
        return $artistModel->getArtist($id);
    }

  public function getContent($event, $section)
    {
        $model = new DanceModel();
        return $model->getContentByEventAndSection($event, $section);
    }

    public function getDanceEvents()
    {
        $danceModel = new DanceModel();
        return $danceModel->getDanceEvents();
    }

    public function getSongsByArtistId($id)
    {
        $songModel = new DanceModel();
        return $songModel->getArtistSongs($id);
    }

    public function getArtistPerformances($id)
    {
        $performanceModel = new DanceModel();
        return $performanceModel->getArtistPerformances($id);
    }
}
?>
