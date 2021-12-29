# Lesson 9: Handle sessions

# What you will learn
- Starting PHP sessions
- Storing data from PHP sessions
- Retrieving data from PHP sessions

# Lesson notes
- [Starting a session](lesson_9.md#starting-a-session)
- [Securing the dashboard](lesson_9.md#securing-the-dashboard)
- [Logging into the application](lesson_9.md#logging-into-the-application)
- [Displaying the users order items](lesson_9.md#displaying-the-users-order-items)

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
Alter the body of the if condition in `login.php` and set the sessions `user_key` to null if `$hasSubmitted` is `true`.
Then alter the body of the inner if condition and set the sessions `user_key` to the value of `$userKey` if it's not `null`.

```php
if ($hasSubmitted) {
    $_SESSION['user_key'] = null;
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userKey = getUser($username, $password);

    if ($userKey !== null) {
        // Start the session
        $_SESSION['user_key'] = $userKey;
        // redirect to dashboard
    } else {
        $error = 'Invalid login, please try again';
    }
}
```
This sets the session `user_key` if the user has logged in correctly.

Access the login page and enter the username and password of a known user and then go to the secure dashboard page.  

You should now be able to access the users orders.

## Displaying the users order items

Now a user can log into the application it is time to show the correct order items for a given user in the secure dashboard.
A function called `getUserKey` is needed to return the `user_key` which is stored in the session. Create a failing test in `UserTest.php` called `testGetUserKeyWhenNotSet`.
This test will check that `null` is returned when the `getUserKey` function is called without a valid login.

```php
public function testGetUserKeyWhenNotSet(): void
{
    $this->assertNull(getUserKey());
}
```

After running `make test` you should get a similar error message.

```bash
There was 1 error:

1) Test\UserTest::testGetUserKeyWhenNotSet
Error: Call to undefined function Test\getUserKey()
```

To fix the test create the function `getUserKey` in `common.php` which will return the stored `user_key` or `null` if it doesn't exist. 
```php
function getUserKey(): ?string
{
    return $_SESSION['user_key'] ?? null;
}
```

The tests should now pass.

To make sure the correct `user_key` is being returned create a new test in `UserTest.php` called `testGetUserKeyWhenSet`
This test will set a `user_key` to the session before calling `getUserKey` and checks that it is returned.
```php
public function testGetUserKeyWhenSet(): void
{
    $key = 'test_key';
    $_SESSION['user_key'] = $key;
    $this->assertSame($key, getUserKey());
}
```

All the tests should pass after running `make test`.

Now the correct `user_key` is being returned a users order can now be displayed.

A users order is found by passing a username to the `getOrders` function call in `dashboard.php`. At the moment the username has been hardcoded to `howtocodewell1`. 
Create the failing test called `testGetUserNameWhenNotSet` in `UserTest.php` that attempts to get a username.
```php
public function testGetUserNameWhenNotSet(): void
{
    $this->assertEmpty(getUsername());
}
```
Run `make test` and you should get a similar error

```bash
There was 1 error:

1) Test\UserTest::testGetUserNameWhenNotSet
Error: Call to undefined function Test\getUsername()
```

To fix the test create the function `getUsername` in `common.php`
```php
function getUsername(): string
{
    $userKey = getUserKey();
    return (USER_CONFIG[$userKey]['username']) ?? '';
}
```
This function will get the `$userKey` which could either be a `string` or  `null`. From this `$userKey` the username is returned based on what is stored in the `USER_CONFIG` array.
If the username cannot be found then `null` will be returned.

All the tests should now pass after running `make test`.

Let's also make sure that a valid username is returned when a `user_key` is set in the session.  Create the following test in `UserTest.php`

```php
public function testGetUsernameWhenSet(): void
{
    $userKey = 'user_1';
    $username = 'howtocodewell1';
    $_SESSION['user_key'] = $userKey;
    $this->assertSame($username, getUsername());
}
```

All the tests should pass after running `make test`.

Now the correct username can be returned from a logged in user it is time to update `dashboard.php` to get the correct user order.
Alter `dashboard.php` and change the hardcoded username to the `getUsername` function call.

```php
<?php
session_start();
require_once '../common.php';

$hasLoggedIn = isLoggedIn();
if (false === $hasLoggedIn) {
    echo 'User has not logged in!'
    exit;
}
$userName = getUsername();
$orders = getOrders($userName);
$items = $orders['items'] ?? [];
?>
```

After logging into the application and going to `dashboard.php` in the browser, you should now see the correct order and in the dashboard.
[Go to lesson index](index.md)

[Go back to readme](../../README.md)