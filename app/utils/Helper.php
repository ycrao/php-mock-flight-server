<?php

namespace app\utils;

class Helper
{
    public static function hideEmail(string $email): string
    {
        list($username, $domain) = explode('@', $email);
        $len = strlen($username);

        if ($len > 2) {
            $maskedUsername = substr($username, 0, 1) . str_repeat('*', $len - 2) . substr($username, -1);
        } elseif ($len === 2) {
            $maskedUsername = substr($username, 0, 1) . '*';
        } else {
            $maskedUsername = '*';
        }

        return $maskedUsername . '@' . $domain;
    }

    public static function oneOf(array $values): string
    {
        return $values[array_rand($values)];
    }

    public static function isUuid(string $uuid): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuid) === 1;
    }
}