# Lesson 6: Handle user login

# What you will learn
 - Creating associative arrays
 - Accessing POSTed form values
 - Configuring PHPUnit
 - TDD (Test Driven Development)

# Lesson notes
- [Create user config](lesson_6.md#create-user-config)
- [Add user array data](lesson_6.md#add-user-array-data)
- [Include user config](lesson_6.md#include-user-config)
- [Get a user](lesson_6.md#get-a-user)
- [Submit the login form](lesson_6.md#get-a-user)
- [Display error](lesson_6.md#get-a-user)

## Create user config
Create the file `userConfig.php` in the `config` folder
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
│   userConfig.php
└───public/
|   └───assets/
│       main.css
│   login.php
│   dashboard.php
└───reports/
└───tests/
└───vendor/
```
[^ Back to top](lesson_6.md#what-you-will-learn)

## Add user array data
In `userConfig.php` add the following:
```php
<?php

return [
    'user_1' => [
        'username' => 'howtocodewell1',
        'password' => 'testHTCW'
    ],
    'user_2' => [
        'username' => 'howtocodewell2',
        'password' => 'testHTCW'
    ]
];

```

This is a nested associative array where the first element index is the user reference. For example the first user is referenced by the index `user_1` and the second user is referenced by the index `user_2`
The user has two elements. The `username` and `password`. These will be used to identify the user during login.

## Include user config
In `common.php` add the following:
```php
$userConfig = include_once 'config/userConfig.php';
```
This will include the `userConfig.php` file and assigns the array to the variable `$userConfig`

Define the named constant `USER_CONFIG`  in `common.php`
```php
define('USER_CONFIG', $userConfig);
```

[^ Back to top](lesson_6.md#what-you-will-learn)

## Get a user
We need to create a function that will return the user reference of a given username and password.
Create a `tests/UserTest.php`
```
project/
│   .gitignore
└───.phpunit.cache/
│   coding_standard.xml
│   common.php
│   composer.json
│   composer.lock
│   phpstan.neon
│   phpunit.xml
└───config/
│   userConfig.php
└───public/
|   └───assets/
│             main.css
│       login.php
│       dashboard.php
└───reports/
└───tests/
│        UserTest.php
└───vendor/
```
In the test file add the following class
```php
<?php

declare(strict_types=1);
namespace Test;

use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{


}
```
The function that fetches the user by the username and password will be called `getUser()`.  Create a failing test that checks `null` is returned when blank credentials are passed.

```php
public function testGetUserWithEmptyCredentials(): void
{
    $this->assertNull(getUser('', ''));
}
```
Run the tests `composer tests`

You will get an error similar to this
```bash
1) Test\UserTest::testGetUserWithEmptyCredentials
Error: Call to undefined function Test\getUser()
```

This error is happening for two reasons
1. The `getUser` function doesn't exist
2. The test file cannot access `common.php`

Add the `getUser` function to `common.php`
```php
function getUser(string $username, string $password): ?string
{
    return null;
}
```
This function takes two string parameters.  The first parameter is the `$username` and the second is the `$password`.
The function will return the user reference from the `$userConfig`.  If a user hasn't been found  then `null` will be returned.
Currently, this function only returns `null` which is acceptable for our failing test.

Run the tests again `composer tests`
This will still throw an error because the second issue hasn't been resolved.

To fix this error, create the file `tests/bootstrap.php` and add the following
```php
<?php
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../common.php';
```
This bootstrap file will require the autoloader from vendor and our `common.php` file.

To include this boostrap file in our tests open `phpunit.xml` and change `bootstrap="vendor/autoload.php"` to `bootstrap="tests/bootstrap.php"` and re-run `composer tests`. 

The test should now pass.

Add another test to `UserTest.php` that checks for a correct username and password.

```php
public function testGetUserWithCorrectCredentials(): void
{
    $this->assertSame('user_1', getUser('howtocodewell1', 'testHTCW'));
}
```
Here we are looking for the return of the user reference that corresponds to the user that has the username of `howtocodewell1` and password `testHTCW`. 
In this example the function `getUser()` should return the user reference `user_1`.

When re-running `composer tests` you should get the following error:
```bash
There was 1 failure:

1) Test\UserTest::testGetUserWithCorrectCredentials
Failed asserting that null is identical to 'user_1'.
```

To make the test pass the body of `getUser` function needs to be adjusted to find the correct user.
Change the `getUser` function to look like this:
```php
function getUser(string $username, string $password): ?string
{
    foreach (USER_CONFIG as $userKey => $userData) {
        if ($userData['username'] === $username && $userData['password'] === $password) {
            return $userKey;
        }
    }
    return null;
}
```
Here we are looping over the constant `USER_CONFIG` that we defined earlier and pulling out the `$userData`. The `$userKey` variable holds the user reference of each user.
Once the login is submitted we need check the supplied `$username` against the `$userData['username']` and the supplied `$password` against `$userData['password']`. If both match then we can return the `$userKey`. 

After changing `common.php` re-run `composer tests`.  All tests should now pass.

So far we have tested getting a user with correct details and empty details. Let's also test incorrect details.

Create the following test in `UserTest.php` 

```php
public function testGetUserWithIncorrectCredentials(): void
{
    $this->assertNull(getUser('howtocodewell1', 'not-valid'));
}
```
This test replicates submitting the wrong credentials on the login form. This should be covered by the first test that we created earlier but it is always a good idea to capture different edge cases.
Re-run `composer tests`. All tests should still pass.


[^ Back to top](lesson_6.md#what-you-will-learn)

## Submit the form
Now all the tests are passing we can call `getUser` when the login form has been submitted.
Open `login.php` and update the PHP code to look like this:
```php
<?php
require_once '../common.php';

$submitted = $_POST['submit'] ?? '';
$hasSubmitted = ($submitted === 'Login');

if ($hasSubmitted) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userKey = getUser($username, $password);

    if ($userKey !== null) {
        // 1) Start the session
        // 2) redirect to dashboard
    } else {
        // 1) Display error
    }
}

?>
```
Here we are calling `getUser` when the form has been submitted (when `$hasSubmitted === true`). The supplied `$username` and `$password` is passed to `getUser` and `$userKey` is returned if found.  If the user is not found then `NULL` is returned.
We can check if the `$userKey` is not `null`, set the session and redirect the user to the secured area.  If `$userKey` is `null` then we can display an error on the page.


[^ Back to top](lesson_6.md#what-you-will-learn)

## Display error when incorrect details are submitted
Alter `login.php` with the following:
```php
<?php
require_once '../common.php';

$submitted = $_POST['submit'] ?? '';
$hasSubmitted = ($submitted === 'Login');
$error = null;

if ($hasSubmitted) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userKey = getUser($username, $password);

    if ($userKey !== null) {
        // 1) Start the session
        // 2) redirect to dashboard
    } else {
        $error = 'Invalid login, please try again';
    }
}

?>
```
Here we are setting an error message to the `$error` variable if `$userKey` is `null`.
We can display the error message on the page like so:
```html
<main>
    <form id="loginForm" method="post" action="login.php">
        <?php if (!empty($error)) : ?>
            <div class="alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="form-content">
```

Update the `main.css` add the following `alert-error` class.
```css
.alert-error {
    background-color: darkred;
    color: #FFF;
    text-align: center;
    padding: 5px;
}
```
Re-run `composer tests` to make sure everything is OK and then run the webserver. 
Try logging in with correct and incorrect details.

[^ Back to top](lesson_6.md#what-you-will-learn)

[<<< Go back to readme](../../README.md) | [<< Go to lesson index](index.md) | [< Go to previous lesson](lesson_5.md) | [Go to next lesson >](lesson_7.md)