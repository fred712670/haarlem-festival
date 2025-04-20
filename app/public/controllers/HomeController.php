<?php
require_once(__DIR__ . "/../models/HomeModel.php");

class HomeController
{
    private $model;

    public function __construct()
    {
        $this->model = new HomeModel();
    }

    public function loadSections()
    {
        $slides = $this->model->getHeroSlides();
        $welcome = $this->model->getSection('home', 'welcome');
        $about = $this->model->getSection('home', 'about');
        $locations = $this->model->getSection('home', 'locations');
        $locationOptions = $this->model->getLocationOptions();
        $eventCards = $this->model->getEventCards();

        require(__DIR__ . '/../views/pages/index.php');
    }

    public function getLorentz(): array {
        return $this->getLorentz();
    }
}
