<?php

use public_site\controller\ErrorController;
use public_site\controller\HomeController;
use public_site\controller\LogInController;
use public_site\controller\UserController;
use public_site\controller\WeatherController;
use api\manager\ServerRequestManager;
use api\manager\SessionManager;

require __DIR__ . "/src/inc/bootstrap.php";

session_start();

$uri = ServerRequestManager::getUriParts();

if ($uri[2] != "ajax") {
    echo "
    <!DOCTYPE html>
    <html lang='fi'>
        <head>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='icon' type='image/x-icon' href='/src/public_site/media/icons/favicon.svg'>
            <link href='/src/public_site/styles/root-variables.css' rel='stylesheet' type='text/css'>
            <link href='/src/public_site/styles/main.css' rel='stylesheet' type='text/css'>
            <link href='/src/public_site/styles/header.css' rel='stylesheet' type='text/css'>
            <link href='/src/public_site/styles/footer.css' rel='stylesheet' type='text/css'>
            <link href='/src/public_site/styles/home-page.css' rel='stylesheet' type='text/css'>
            <link href='/src/public_site/styles/login-page.css' rel='stylesheet' type='text/css'>
            <link href='/src/public_site/styles/media_queries.css' rel='stylesheet' type='text/css'>
            <script src='/src/public_site/js/Dropdown.js' defer></script>
            <script src='/src/public_site/js/ElementDisplay.js' defer></script>
            <link
            rel='stylesheet'
            href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css'
            />
            <meta charset='UTF-8' />
            <meta http-equiv='X-UA-Compatible' content='IE=edge' />
            <title>Weather Oy</title>
    ";
}

switch ($uri[2]) {
    case "":
        showHome();
        break;
    case "kirjaudu":
        showLogIn();
        break;
    case "authenticate-user":
        if (ServerRequestManager::isPost()) {
            authenticateUser();
        }
        break;
    case "log-out":
        logOutUser();
        break;
    case "weather":
        if (SessionManager::issetUserSession()) {
            showWeather();
        } else {
            showError(
                "Kirjaudu sisään",
                "kirjaudu sisään jotta voitte jatkaa",
                "/index.php/kirjaudu"
            );
        }
        break;
    default:
        showError(
            "404 Not Found",
            "Sivua ei löydy.",
            "/index.php"
        );
        exit();
}

if ($uri[2] != "ajax") {
    echo "
            </body>
        </html>
    ";
}

function showHome()
{
    $homeController = new HomeController();
    $homeController->showHomePage();
}

function showLogIn()
{
    $logInController = new LogInController();
    $logInController->showLogInForm();
}

function authenticateUser()
{
    $userController = new UserController();
    $userController->authenticate();
}

function logOutUser()
{
    $userController = new UserController();
    $userController->logOut();
}

function showWeather()
{
    $weatherController = new WeatherController();
    $weatherController->showWeatherPage();
}

function showError($title, $message, $link): void
{
    $errorController = new ErrorController($title, $message, $link);
    $errorController->showErrorPage();
}