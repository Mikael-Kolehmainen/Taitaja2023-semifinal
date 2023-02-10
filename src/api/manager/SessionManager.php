<?php

namespace api\manager;

class SessionManager
{
    private const USER_SESSION = "user_session";

    public static function issetUserSession(): bool
    {
        return isset($_SESSION[self::USER_SESSION]);
    }

    public static function saveUserToSession($session): void
    {
        $_SESSION[self::USER_SESSION] = $session;
    }

    public static function getUserSession(): string
    {
        return $_SESSION[self::USER_SESSION];
    }

    public static function removeUserSession(): void
    {
        unset($_SESSION[self::USER_SESSION]);
    }
}