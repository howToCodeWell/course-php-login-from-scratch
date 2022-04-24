# Lesson 7: Create PHP order config

# What you will learn
- Array shapes
- PHP Data types
- Fixing PHPStan errors

# Lesson notes
- [Create order config](lesson_7.md#create-order-config)
- [Add order array data](lesson_7.md#add-order-array-data)
- [Include order config](lesson_7.md#include-order-config)
- [Get orders for a given user](lesson_7.md#get-orders-for-a-given-user)

## Create order config
Create the file `orderConfig.php` in the `config` folder
```
my_project/
│   .gitignore
└───.phpunit.cache/
│   coding_standard.xml
│   common.php
│   composer.json
│   composer.lock
│   phpstan.neon
│   phpunit.xml
└───config/
│       userConfig.php
│       orderConfig.php
└───public/
|   └───assets/
│       main.css
│   login.php
│   dashboard.php
└───reports/
└───tests/
└───vendor/
```

[^ Back to top](lesson_7.md#what-you-will-learn)

## Add order array data
In `orderConfig.php` add the following:
```php
<?php

return [
    [
        'user' => 'howtocodewell1',
        'items' => [
            [
                'product_name' => 'Keyboard',
                'product_price' => 89.99,
                'order_date' => '01-02-2021',
            ],
            [
                'product_name' => 'Mouse',
                'product_price' => 99.99,
                'order_date' => '01-03-2021',
            ],
            [
                'product_name' => 'Monitor',
                'product_price' => 1500.99,
                'order_date' => '01-04-2021',
            ],
            [
                'product_name' => 'Mixing deck',
                'product_price' => 1500.99,
                'order_date' => '01-04-2021',
            ],
        ]
    ],
    [
        'user' => 'howtocodewell2',
        'items' => [
            [
                'product_name' => 'Watch',
                'product_price' => 350,
                'order_date' => '01-02-2021',
            ],
        ]
    ],
];


```
This is a nested associative array or arrays. Each sub array has a `user` element that corresponds to a `username`.
There is also an `items` array which holds the order items for that user.

## Include order config
In `common.php` add the following:
```php
$orderConfig = include_once 'config/orderConfig.php';
```
This will include the `orderConfig.php` file and assigns the array to the variable `$orderConfig`

Define the named constant `ORDER_CONFIG`  in `common.php`
```php
define('ORDER_CONFIG', $orderConfig);
```

[^ Back to top](lesson_7.md#what-you-will-learn)

## Get orders for a given user
We need to create a function that will return the orders for a given user.
Create the test file `tests/OrdersTest.php`
```
my_project/
│   .gitignore
└───.phpunit.cache/
│   coding_standard.xml
│   common.php
│   composer.json
│   composer.lock
│   phpstan.neon
│   phpunit.xml
└───config/
│       userConfig.php
│       orderConfig.php
└───public/
|   └───assets/
│             main.css
│       login.php
│       dashboard.php
└───reports/
└───tests/
│        UserTest.php
│        OrdersTest.php
└───vendor/
```
In the test file add the following class
```php
<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{

}
```
The function that we will create will be called `getOrders()`. This will return the orders of a given username.  

Create a failing test that checks that `null` is returned when an incorrect username is supplied.
In `OrdersTest.php` add the following test

```php
public function testGetOrdersWithEmptyUsername(): void
{
    $this->assertNull(getOrders(''));
}
```
After running `composer test` you should see the following error
```php
There was 1 error:

1) Test\OrdersTest::testGetOrdersWithEmptyUsername
Error: Call to undefined function Test\getOrders()

```
This is because the getOrders function hasn't been created yet.

In `common.php` create the following `getOrders` function
```php
function getOrders(string $userName): ?array
{
    return null;
}
```
Run `composer test` again the and the tests should pass.

Now we need to return the correct order for a given username.

Create the following failing test in `OrdersTest.php` that should return an array of order items for the user with the username of `howtocodewell2`.

```php
public function testGetOrdersWithCorrectUsername(): void
{
    $this->assertIsArray(getOrders('howtocodewell2'));
}
```
Run `composer test` and notice a similar failure message:
```php
There was 1 failure:

1) Test\OrdersTest::testGetOrdersWithCorrectUsername
Failed asserting that null is of type "array".

```
To fix the test we must update the body of `getOrders()` to find the correct order of the given username.

Update the `getOrders` function in `common.php`
```php
function getOrders(string $userName): ?array
{
    foreach (ORDER_CONFIG as $order) {
        if ($order['user'] === $userName) {
            return $order;
        }
    }
    return null;
}
```
This loops over the `ORDER_CONFIG` array and looks for the `user` element that matches the supplied `$username` variable. If a match is found then the `$order` is returned. If no matches are found then `null` is returned.

Re run `composer test` and notice the following error with PHPStan.  
```bash
./vendor/bin/phpstan
Note: Using configuration file /code/howtocodewell/courses/course-php-login/project/phpstan.neon.
 12/12 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ------ ------------------------------------------------------------------------------------------ 
  Line   common.php                                                                                
 ------ ------------------------------------------------------------------------------------------ 
  21     Function getOrders() return type has no value type specified in iterable type array.      
         💡 See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type  
 ------ ------------------------------------------------------------------------------------------ 

                                                                                                                        
 [ERROR] Found 1 error                                                                                                  
```
This error happens because we are trying to access array elements without defining the shape of the returned array.
To fix this error add the following PHP docblock to the `getOrders` function in `common.php`

```php
/**
 * @param string $userName
 * @return null|array{
 *      user: string,
 *      items: array{
 *          array{
 *              'product_name': string,
 *              'product_price':int,
 *              'order_date': string
 *          }
 *      }
 * }
 *
 */
```
The return part of the docblock defines the shape of the array with the nested array keys and the data types.
Re-run `composer test`. All test should pass.

[^ Back to top](lesson_7.md#what-you-will-learn)

[<<< Go back to readme](../../README.md) | [<< Go to lesson index](index.md) | [< Go to previous lesson](lesson_6.md) | [Go to next lesson >](lesson_8.md)