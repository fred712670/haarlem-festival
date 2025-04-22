<?php
require_once __DIR__ . '/../models/MagicModel.php';

class MagicController {

    public function getLorentz(): array {

        $magicModel = new MagicModel();
        return $magicModel->getLorentz();
    }

}