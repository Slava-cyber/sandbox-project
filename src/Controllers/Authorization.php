<?php

namespace App\Controllers;

use App\Models\Users\User as User;

class Authorization
{
    public static function signIn(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, time() + 36000, '/', '', false, true);
    }

    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int)$userId);

        if ($user == null) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }
        return $user;
    }
}
