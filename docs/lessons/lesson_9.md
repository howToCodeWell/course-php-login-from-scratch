# Lesson 9: Handle sessions

# What you will learn
 ~ Document what will be learnt ~

# Lesson notes
- [Starting a session](lesson_9.md#starting-a-session)
- [Securing the dashboard](lesson_9.md#securing-the-dashboard)
- [Logging into the application](lesson_9.md#logging-into-the-application)

## Starting a session
Sessions are started when `session_start()` is called. This tends to be the first function call made by an application as sessions as usually started at the beginning of a request.
In `login.php` add `session_start()` before the `common.php` include.
```php
<?php
session_start();
require_once '../common.php';
```

Values can now be stored against the session and retrieved on other pages.  We can use this to log a user into the application.

The session must also be started on the `dashboard.php`. This allows session data to be shared across the login and dashboard pages.
Add the following in `dashboard.php`

```php
<?php
session_start();
require_once '../common.php';
```

## Securing the dashboard
During login, data will be stored in the session. This data will tell the application if the user has logged in or not and has been granted access to the dashboard.
A function is need to check if the user has logged in.  This will return a boolean.

Create a new test file `tests/LoginTest.php`. Add the following failing tests
```php
<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;


class LoginTest extends TestCase
{
    public function testIsNotLoggedInByDefault(): void
    {
        $this->assertFalse(isLoggedIn());
    }
}

```
This will call a function called `isLoggedIn` and check that it return `false` by default.  

Run `make test`. The tests should fail with a similar error message

```php
There was 1 error:

1) Test\LoginTest::testIsNotLoggedInByDefault
Error: Call to undefined function Test\isLoggedIn()
```

To fix this error, create the function `isLoggdIn` in  `common.php`
```php
function isLoggedIn(): bool
{
    return false
}
```
Run `make test` again and all the tests should pass.
At the moment this function is just returning false. It needs to check if the user has been logged in and return true if the user has logged in. 

When the user logs into the application their user reference will be stored in the session. We can check for the existence of this session variable.
Stored session data is contained in an array that can be accessed via the `$_SESSION` variable.  This is a special inbuilt PHP variable.

Update the `isLoggedIn` function like so

```php
function isLoggedIn(): bool
{
    $userKey = $_SESSION['user_key'] ?? null;
    return ($userKey !== null);
}
```
The variable `$userKey` will be assigned the value stored in `$_SESSION['user_key']` or `null` if nothing is found.
`$userKey` is then checked for `null`. If it is not `null` then `true` is returned.  This means there is a session with a stored `user_key`. If no user reference is stored then `$userKey` will be `null` and in this case `false` will be returned.

Run `make test` again and all the tests should continue to pass.

At this point `isLoggedIn` will always return false. The next test will be to check that when a valid session is found `isLoggedIn` will return `true`.

Create the following failing test in `LoginTest.php`
```php
public function testIsLoggedIn(): void
{
    $this->assertTrue(isLoggedIn());
}
```
Run `make tests` and you should see a similar error
```bash
There was 1 failure:

1) Test\LoginTest::testIsLoggedIn
Failed asserting that false is true.
```

The test is failing because `isLoggedIn()` is always returning false.
To mock a session add the following lines to `testIsLoggedIn`
1. Before the call to `isLoggedIn()` add the line to set the session `user_key` value. `$_SESSION['user_key'] = 'foobar';`
2. After the call to `isLoggedIn()` unset the session value. ` unset($_SESSION['user_key']);`

`testIsLoggedIn` should now look like this
```php
public function testIsLoggedIn(): void
{
    $_SESSION['user_key'] = 'foobar';
    $this->assertTrue(isLoggedIn());

    unset($_SESSION['user_key']);
}
```

Run `make test` again and all tests should pass.

To check if the user has logged into the application `isLoggedIn()` can now be called from the `dashboard.php`
```php
<?php
session_start();
require_once '../common.php';

$hasLoggedIn = isLoggedIn();
if (false === $hasLoggedIn) {
    echo 'User has not logged in!'
    exit;
}
```

Run the webserver and access [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php). 

The following message should now be shown instead of the table of orders.
```bash
User has not logged in!
```
## Logging into the application

[Go to lesson index](index.md)

[Go back to readme](../../README.md)