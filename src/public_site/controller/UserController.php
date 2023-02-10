<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\manager\RedirectManager;
use api\manager\SessionManager;
use api\model\Database;
use api\model\UserModel;

class UserController
{
    /** @var Database */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function authenticate(): void
    {
        $userModel = new UserModel($this->db);
        $userModel->username = ServerRequestManager::postUsername();
        $user = $userModel->load();

        if ($user !== NULL &&
            password_verify(ServerRequestManager::postPassword(), $user->password)) {
            SessionManager::saveUserToSession($user->session);
            RedirectManager::redirectToWeatherPage();
        } else {
            $errorController = new ErrorController(
                                        "Käyttäjä tai salasana on väärin",
                                        "Käyttäjä tai salasana on väärin",
                                        "/index.php/kirjaudu"
                                    );
            $errorController->showErrorPage();
        }
    }

    public function logOut(): void
    {
        SessionManager::removeUserSession();
        RedirectManager::redirectToHomePage();
    }
}