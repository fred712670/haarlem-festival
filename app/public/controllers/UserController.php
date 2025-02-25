<?php

require_once(__DIR__ . "/../models/UserModel.php");

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getAll()
    {
        return $this->userModel->getAll();
    }

    public function get($id)
    {
        return $this->userModel->get($id);
    }

    public function updateName($username, $newFullName) {
        return $this->userModel->updateName($username, $newFullName);
    }

    public function changePassword($username, $currentPswd, $newPswd, $repeatNewPsw ) {
        return $this->userModel->updatePassword($username, $currentPswd, $newPswd, $repeatNewPsw);
    }
}
