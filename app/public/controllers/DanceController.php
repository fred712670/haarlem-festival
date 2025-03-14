<?php
require_once __DIR__ . '/../models/DanceModel.php';

class DanceController
{
    public function getArtists()
    {
        $artistModel = new DanceModel();
        $artists = $artistModel->getAllArtists();

        return $artists;
    }
}
?>