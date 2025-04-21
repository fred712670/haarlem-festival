<?php
require_once(__DIR__ . '/../models/EventManagementModel.php');

class EventManagementController
{
    private $model;

    public function __construct()
    {
        $this->model = new EventManagementModel();
    }
    // Render the homepage management interface
    public function manageHomepage()
    {
        // all slides and other content
        $slides = $this->model->getSlides();
        $contents = $this->model->getContent();
        // Extract specific content sections for convenience
        $welcome = $this->extractSection($contents, 'welcome');
        $about = $this->extractSection($contents, 'about');
    
        $locationOptions = $this->model->getLocationOptions();
        $eventCards = $this->model->getEventCards();
    
        require(__DIR__ . '/../views/pages/homepage_management.php');
    }
     // Helper to find one content entry by its section key
    private function extractSection(array $contents, string $sectionKey): ?array
    {
    foreach ($contents as $content) {
        if ($content['Section'] === $sectionKey) {
            return $content;
        }
    }
    return null;
    }   
    // Handle storage of a new slide (file upload + DB insert)
    public function storeSlide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather form inputs
            $title = $_POST['title'] ?? '';
            $eventType = $_POST['eventType'] ?? '';
            $imageName = null;
            // If a new image file was uploaded, move it to assets
            if (!empty($_FILES['imageFile']['name'])) {
                $imageName = basename($_FILES['imageFile']['name']);
                $uploadDir = __DIR__ . '/../../public/assets/img/home/';
                $targetPath = $uploadDir . $imageName;

                if (!is_dir($uploadDir)) {
                    // create dir if needed
                    mkdir($uploadDir, 0755, true);
                }

                move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetPath);
            }
            // save DB record
            $this->model->storeSlide($title, $eventType, $imageName);
        }

        header('Location: /admin/homepage-management');
    }

    // Update existing slide
    public function updateSlide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather form inputs, including existing image fallback
            $id = $_POST['id'] ?? null;
            $title = $_POST['title'] ?? '';
            $eventType = $_POST['eventType'] ?? '';
            $imageName = $_POST['existingImage'] ?? null;

            // If a new image file was uploaded, replace the old one
            if (!empty($_FILES['imageFile']['name'])) {
                $imageName = basename($_FILES['imageFile']['name']);
                $uploadDir = __DIR__ . '/../../public/assets/img/home/';
                $targetPath = $uploadDir . $imageName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetPath);
            }

            $this->model->updateSlide($id, $title, $eventType, $imageName);
        }

        header('Location: /admin/homepage-management');
    }

    // Handle deletion of a slide (remove file + DB)
    public function deleteSlide()
    {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Step 1: Get the image name before deleting
        $slides = $this->model->getSlides();
        $slide = null;
        foreach ($slides as $s) {
            if ($s['ContentId'] == $id) {
                $slide = $s;
                break;
            }
        }
        // Step 2: Delete image file if it exists
        if ($slide && !empty($slide['ImageName'])) {
            $imagePath = __DIR__ . '/../../public/assets/img/home/' . $slide['ImageName'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        // Step 3: Delete from database
        $this->model->deleteSlide($id);
    }

    header('Location: /admin/homepage-management');
    }

   // Store new content 
public function storeContent()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $section = $_POST['section'] ?? '';
        $eventType = $_POST['eventType'] ?? '';
        $content = $_POST['content'] ?? '';
        $imageName = null;
        // If an image file was uploaded, save it
        if (!empty($_FILES['imageFile']['name'])) {
            $imageName = basename($_FILES['imageFile']['name']);
            $uploadDir = __DIR__ . '/../../public/assets/img/home/';
            $targetPath = $uploadDir . $imageName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetPath);
        }
        // insert DB
        $this->model->storeContent($title, $section, $eventType, $content, $imageName);
    }

    header('Location: /admin/homepage-management');
}

// Update content 
public function updateContent()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $section = $_POST['section'] ?? '';
        $eventType = $_POST['eventType'] ?? '';
        $content = $_POST['content'] ?? '';
        $imageName = $_POST['existingImage'] ?? null;

        // If a new image file was uploaded, replace the old one
        if (!empty($_FILES['imageFile']['name'])) {
            $imageName = basename($_FILES['imageFile']['name']);
            $uploadDir = __DIR__ . '/../../public/assets/img/home/';
            $targetPath = $uploadDir . $imageName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetPath);
        }
        // update DB
        $this->model->updateContent($id, $title, $section, $eventType, $content, $imageName);
    }

    header('Location: /admin/homepage-management');
}

    // Delete a homepage content entry
    public function deleteContent()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->model->deleteContent($id);
        }

        header('Location: /admin/homepage-management');
    }
}
