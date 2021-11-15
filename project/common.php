<?php
$userConfig = include_once 'config/userConfig.php';
$orderConfig = require_once 'config/orderConfig.php';

define('USER_CONFIG', $userConfig);
define('ORDER_CONFIG', $orderConfig);


function getUser(string $username, string $password): ?string
{
    foreach (USER_CONFIG as $userKey => $userData) {
        if ($userData['username'] === $username && $userData['password'] === $password) {
            return $userKey;
        }
    }
    return null;
}

function getOrders(string $userName): ?array
{
    foreach (ORDER_CONFIG as $order) {
        if ($order['user'] === $userName) {
            return $order;
        }
    }

    return null;
}

function isLoggedIn(): bool
{
    $userKey = $_SESSION['user_key'] ?? null;
    return ($userKey !== null);
}

function getUserKey(): ?string
{
    return $_SESSION['user_key'] ?? null;
}

function getUsername(): string
{
    $userKey = getUserKey();
    return (USER_CONFIG[$userKey]['username']) ?? '';

}

function logout()
{
    unset($_SESSION['user_key']);
}