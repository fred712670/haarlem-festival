<?php
require(__DIR__ . "/../controllers/MagicController.php");

Route::add('/magicteylers', function () {
    $controller = new MagicController();
    $lorentzSchedule = $controller->getLorentz();
    require(__DIR__ . "/../views/pages/magic.php");
});
