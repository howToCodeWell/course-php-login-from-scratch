# Lesson 6: Create PHP user config

# What you will learn
 ~ Document what will be learnt ~

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
project/
│   .gitignore
│   coding_standard.xml
│   common.php
│   composer.phar
│   composer.json
│   composer.lock
│   Makefile
│   phpstan.neon
│   phpunit.xml
│
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

This is a nested associative array where the first index (_user_id_,_user_2_) is the user key.
The user key has two elements. The _username_ and the _password_ will be used to login.

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
We need to create a function that will return the _user_key_ of a given username and password.
Create a `tests/UserTest.php`
```
project/
│   .gitignore
│   coding_standard.xml
│   common.php
│   composer.phar
│   composer.json
│   composer.lock
│   Makefile
│   phpstan.neon
│   phpunit.xml
│
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
The method that we will create will be called `getUser()`.  Create a failing test first that checks that  null is returned when blank credentials are passed.

```php
public function testGetUserWithEmptyCredentials(): void
{
    $this->assertNull(getUser('', ''));
}
```

Run the tests `make tests`

You will get an error similar to this
```bash
1) Test\UserTest::testGetUserWithEmptyCredentials
Error: Call to undefined function Test\getUser()
```

This error is happening for two reasons
1. The `getUser` method doesn't exist
2. The test file cannot access `common.php`

Add the following to `common.php`
```php
function getUser(string $username, string $password): ?string
{
    return null;
}
```
This method takes two strings.  A `$username` and a `$password` it will be user to identify a user from their login credentials.  It will return the _user_key_ from the `$userConfig`.  If a user hasn't been found  then `null` will be returned.
Currently, this method is only returns `null` which is what is acceptable for our failing test.

Run the tests `make tests`
This will still throw an error because the second issue hasn't been resolved.

Create the file `tests/bootstrap.php` and add the following
```php
<?php
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../common.php';
```
This bootstrap file will require the vendors autoloader and our `common.php` 

To include this boostrap file in our tests open `phpunit.xml` and change `bootstrap="vendor/autoload.php"` to `bootstrap="tests/bootstrap.php"` and re-run `make tests`. 

The test should now pass.

Add another test to `UserTest.php` that checks for a correct username and password

```php
public function testGetUserWithCorrectCredentials(): void
{
    $this->assertSame('user_1', getUser('howtocodewell1', 'testHTCW'));
}
```
Here we are looking for the return of the user key that corresponds to the user with the username of `howtocodewell1` and password `testHTCW`. 
In this example the function `getUser()` should return the user key `user_1`.

When re-running `make tests` you should get the following error:
```bash
There was 1 failure:

1) Test\UserTest::testGetUserWithCorrectCredentials
Failed asserting that null is identical to 'user_1'.
```

To make the test pass the body of `getUser` needs to be adjusted to find the correct user key.
Change `getUser` to look like this:
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
Here we are looping over the constant `USER_CONFIG` that we defined earlier and pulling out the `$userData`. The `$userKey` holds the user key of each user.
We need check the supplied `$username` against the `$userData['username']` and the supplied `$password` against `$userData['password']`. If both match then we can return the `$userKey`. 

After this change to `common.php` re-run `make tests`.  All tests should now pass.

So far we have tested the correct details and empty details. Let's also test incorrect details.

Create the following test in `UserTest.php` 

```php
public function testGetUserWithIncorrectCredentials(): void
{
    $this->assertNull(getUser('howtocodewell1', 'not-valid'));
}
```
This test replicates submitting the wrong credentials on the login form. This should be covered by the first test that we created but its always a good idea to capture different unhappy paths.
Re-run `make tests`. All tests should still pass.


[^ Back to top](lesson_6.md#what-you-will-learn)

## Submit the form
Now all the tests are passing we can call `getUser` when the login form has been submitted.
Open `login.php` and add update the PHP code to look like this:
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
Here we are calling `getUser` when the form has been submitted. (When `$hasSubmitted === true`). The supplied `$username` and `$password` and passed to `getUser` and `$userKey` is returned.  If the user is not found then `NULL` is returned. Otherwise, the `user_key` is returned.
We can check if `$userKey` is not `null` and set the seesion and redirect the user to the secureed area.  If `$userKey` is `null` then we can display an error on the page.


[^ Back to top](lesson_6.md#what-you-will-learn)

## Display error when incorrect details are submitted
Alter `login.php` with the following:
```php
<?php
session_start();
require_once '../common.php';

$submitted = $_POST['submit'] ?? '';
$hasSubmitted = ($submitted === 'Login');
$error = null;

if ($hasSubmitted) {
    $_SESSION['user_key'] = null;
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
Here we are setting an error message to `$error` if `$userKey` is null.
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
Re-run `make tests` to make sure everything is OK and then run the webserver. 
Try logging in with correct and incorrect details.

[Go to lesson index](index.md)

[Go back to readme](../../README.md)