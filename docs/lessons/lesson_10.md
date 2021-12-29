# Lesson 10: Handle redirects

# What you will learn
 ~ Document what will be learnt ~

# Lesson notes
- [Logging out](lesson_10.md#logging-out)

## Logging out
There is currently no way of logging out of the application.  Create`public/logout.php` and start the session before requiring the `common.php` include.
```php
<?php

session_start();
require_once '../common.php';
```
This file will need to call a function called `logout` which will remove all the session data. 

Create a new test file called `LogoutTest.php` with the following test
```php
<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;


class LogoutTest extends TestCase
{
    public function testLogout(): void
    {
        $_SESSION['user_key'] = 'test';
        logout();
        $this->assertEmpty($_SESSION);
    }
}
```
This tests ensures that after logout is called the `$_SESSION` variable is `empty`.
After running `composer test` you should see a similar error
```bash
There was 1 failure:

1) Test\UserTest::testGetUserKeyWhenNotSet
Failed asserting that 'test' is null.
```
This is failing because the `user_key` of `test` has not been removed as the function `logout` does not exist.

Create the function `logout` in `common.php`

```php
function logout(): void
{
    unset($_SESSION['user_key']);
}
```
This function unsets all the data stored in `$_SESSION` which means the user is no longer logged into the application.

Re-run `composer test` and all tests should pass.


[Go to lesson index](index.md)

[Go back to readme](../../README.md)