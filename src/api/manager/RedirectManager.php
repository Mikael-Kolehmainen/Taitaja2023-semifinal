<?php

namespace api\manager;

class RedirectManager
{
    public static function redirectToLogIn(): void
    {
        echo "<script>
            window.location.href = '/index.php/kirjaudu';
        </script>";
    }

    public static function redirectToWeatherPage(): void
    {
        echo "<script>
            window.location.href = '/index.php/weather';
        </script>";
    }

    public static function redirectToHomePage(): void
    {
        echo "<script>
            window.location.href = '/index.php';
        </script>";
    }
}