<?php
session_start();
require_once '../common.php';

$hasLoggedIn = isLoggedIn();
if (false === $hasLoggedIn) {
    header('Location: /index.php');
    exit;
}
$userName = getUsername();
$orders = getOrders($userName);
$items = $orders['items'] ?? [];
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>

        <header>
            <p>Welcome, <?php echo $userName; ?> <a class="btn" href="logout.php">logout</a></p>
        </header>
        <main>
        <table >
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Date ordered</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $counter = 0;
            foreach ($items as $item) :
                $counter++;
                $rowClassSuffix = ($counter % 2 === 0)  ? 'even' : 'odd';
                ?>

                <tr class="<?php echo 'row-'.$rowClassSuffix; ?>">
                    <td><?php echo $item['product_name']; ?></td>
                    <td><?php echo $item['product_price']; ?></td>
                    <td><?php echo $item['order_date']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>