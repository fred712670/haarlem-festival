<?php
require_once __DIR__ . '/BaseModel.php';


class DanceModel extends BaseModel
{
    public function getAllArtists()
    {
        try {
            $query = "SELECT ArtistId, Name, Genre, Description FROM Artist";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 🛠️ Debugging Output - Log fetched data
            error_log("Fetched artists: " . print_r($artists, true));
            return $artists ?: [];
        } catch (Exception $e) {
            error_log("Error fetching restaurants: " . $e->getMessage());
            return [];
        }
    }
}
?>
