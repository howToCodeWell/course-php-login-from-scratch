<?php


// Get the user data
$userConfig = include 'config/userConfig.php';
// 1 - Check if user has already logged in
// 2 - If logged in display the dashboard

// User is logged in
$orderConfig = require_once 'config/orderConfig.php';

$hasLoggedIn = isLoggedIn();
if (false === $hasLoggedIn) {
    // 3 - If not logged in redirect user to /index.php
    header('Location: /index.php');
    exit;
}
$userName = getUsername();
$order = getOrder($orderConfig, $userName);

function isLoggedIn(): bool
{
    return false;
}

function getUsername(): string
{
    return 'howtocodewell1';
}


function getOrder(array $config, string $userName): ?array
{
    foreach ($config as $order) {
        if ($order['user'] === $userName) {
            return $order;
        }
    }

    return null;
}

function displayDashboard(string $userName, array $order): string
{
    $HTML = "<p>Welcome, " . $userName . "</p>";
    $HTML .= "<table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Date ordered</th>
                    </tr>
                </thead>
                <tbody>";
    foreach ($order['items'] as $item) {
        /* @var DateTime $orderDate */
        $orderDate = $item['order_date'];
        $HTML .= "<tr>
                        <td><img src='" . $item['product_image'] . "' /></td>
                        <td>" . $item['product_name'] . "</td>
                        <td>" . $item['product_price'] . "</td>
                        <td>" . $orderDate->format('d/m/Y h:m:i') . "</td>
                    </tr>";
    }

    $HTML .= "</tbody></table>";

    return $HTML;
}

echo displayDashboard($userName, $order);
