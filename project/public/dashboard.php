<?php
session_start();
require_once '../common.php';

$hasLoggedIn = isLoggedIn();
if (false === $hasLoggedIn) {
    // 3 - If not logged in redirect user to /index.php
    header('Location: /index.php');
    exit;
}
$userName = getUsername();
$orders = getOrders($userName);
$items = $orders['items'] ?? [];
?>

<html lang="en">
    <head>

    </head>
    <body>
        <p>Welcome, <?php echo $userName; ?> <a href="logout.php">logout</a> </p>

        <table>
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Price</th>
                <th>Date ordered</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><img src="<?php echo $item['product_image']; ?>" alt=""/></td>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['product_price']; ?></td>
                        <td><?php echo $item['order_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </body>
</html>