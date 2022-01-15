# Lesson 8: Populate secure area with user data

# What you will learn
- Nullish coalescing operator
- Concatenation of strings
- Ternary statements
- The Modulus operator

# Lesson notes
- [Get a users order](lesson_8.md#get-a-users-order)
- [Display the username](lesson_8#display-the-username)
- [Display the order items](lesson_8.md#display-the-order-items)
- [Alternate the order item table row colours](lesson_8.md#alternate-the-order-item-table-row-colours)

## Get a users order
To get a users order the `getOrders` function needs to be called with a username.
In this lesson we will hard code the username. In a future lessons this username will be dynamically set to the username of the logged in user.

To do this, add the following to the `dashboard.php`
```php
$userName = 'howtocodewell1';
$orders = getOrders($userName);
```

Each order will have a set of items.  These order items are held in the `items` element of the `order` array. 
To get the order items add the following to `dashboard.php`
```php
$items = $orders['items'];
```

## Display the username

To display the username replace the hardcoded username in `dashboard.php` with the value of `$username` like so

```html
<header>
    <p>Welcome, <?php echo $userName; ?></p>
</header>
```

[^ Back to top](lesson_8.md#what-you-will-learn)

## Display the order items
Replace the hardcoded order items in the `dashboard.php` table with those from `$items`.
Each item will need its own row in the table. Create a `foreach` loop in the `<tbody>` that prints out three table cells that hold the items name, price and date ordered.

```html
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Date ordered</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) : ?>
        <tr>
            <td><?php echo $item['product_name']; ?></td>
            <td><?php echo $item['product_price']; ?></td>
            <td><?php echo $item['order_date']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
```
Run `composer test` and you should get the following error:

```bash
./vendor/bin/phpstan
Note: Using configuration file /code/howtocodewell/courses/course-php-login/project/phpstan.neon.
 12/12 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ------ ------------------------------------------------------------------------------------------------------------------------------- 
  Line   public/dashboard.php                                                                                                           
 ------ ------------------------------------------------------------------------------------------------------------------------------- 
  12     Offset 'items' does not exist on array{user: string, items: array{array{product_name: string, product_price: int, order_date:  
         string}}}|null.                                                                                                                
 ------ ------------------------------------------------------------------------------------------------------------------------------- 

                                                                                                                        
 [ERROR] Found 1 error                                                                                                  
```

This error is due to the missing offest `items` in the variable `$items`. We know that this is an array however it technically could be `null` as the user may not exist or the user may not have any orders.
To fix this we need to set a default value for `$items` which will default to an empty array.
Adjust the `$items` variable assignment to use the nullish coalescing operator `??` to set a blank array if the value is `null`.
```php
$items = $orders['items'] ?? [];
```
After this adjustment re-run `composer test`. All tests should now pass.

[^ Back to top](lesson_8.md#what-you-will-learn)

## Alternate the order item table row colours
Create two CSS classes in `public/assets/main.css` that will handle the alternating row colours.
``` css
.row-even td {
    background-color: ghostwhite;
}

.row-odd td {
    background-color: blanchedalmond;
}
```

Adjust the `foreach` loop in `dashboard.php` to increment a counter.
Create a variable called `$counter` above the `foreach` loop and set its initial value to `0`.
Within the `foreach` loop increment the value of `$counter` for every iteration.
```php
<?php
    $counter = 0;
    foreach ($items as $item) :
        $counter++;
        ?>
        <tr>
            <td><?php echo $item['product_name']; ?></td>
            <td><?php echo $item['product_price']; ?></td>
            <td><?php echo $item['order_date']; ?></td>
        </tr>
    <?php endforeach; ?>
```
Create a variable called `rowClassSuffix` which will either be assigned the value of `even` or `odd`. This will be set to `even` when the `$counter` is divisible by two. If `$counter` cannot be divided by two then the value of `$rowClassSuffix` will be `odd`.
Use the modulus `%` operator in the if statement. This check is performed like so
```php
if($counter % 2 === 0) {
    $rowClassSuffix = 'even';
} else {
   $rowClassSuffix = 'odd';
}
```
To simplify this we can use a ternary statement like so:
```php
$rowClassSuffix = ($counter % 2 === 0)  ? 'even' : 'odd';
```
The `$rowClassSuffix` will be concocted with the string `row-` to create a CSS class name which wil be assigned to the table row.
Print the dynamic class name to the table row like so.
```php
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
```
Your dashboard.php should now look like this:

```php

<?php
$userName = 'howtocodewell1';
$orders = getOrders($userName);
$items = $orders['items'] ?? [];
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>

        <header>
            <p>Welcome, <?php echo $userName; ?></p>
        </header>
        <main>
        <table>
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
```
[^ Back to top](lesson_8.md#what-you-will-learn)

[Go to lesson index](index.md)

[Go back to readme](../../README.md)