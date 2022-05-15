# Lesson 10: Handle redirects

# What you will learn
- How to redirect HTTP requests using the PHP header function
- How to clear PHP session data
- How to logout a user

# Lesson notes
- [Create the index page](lesson_10.md#create-the-index-page)
- [Logging out](lesson_10.md#logging-out)
- [Redirect the login form](lesson_10.md#redirect-the-login-form)
- [Create a logout link](lesson_10.md#create-a-logout-link)
- [Try the application](lesson_10.md#try-the-application)

## Create the index page
The `public/index.php` page will be the first page that a user will access when reaching the website.  It can be used to control where the user is redirect too.  

If the user has logged in then the user should be sent to the secure `public/dashboard.php`. If the user isn't logged in then they would be sent to the `public/login.php` page.

Create `public/index.php` with the following code

```php
<?php

session_start();
require_once '../common.php';

if (isLoggedIn()) {
    // Redirect to `dashboard.php`
}
// Redirect to `login.php`
```
Two redirects are needed.  The first will be called when `isLoggedIn()` returns `true`. As PHP will redirect and stop the flow to the application the second redirection can be called outside the if block and this will send a user who isn't logged in to the `public/login.php` page.
The header function is used to send a raw HTTP header. Passing a `Location:` will cause the PHP page to redirect to the new location. It is good practice to terminate the PHP process by calling the `exit` function straight after the `header` function to ensure that no other PHP code can be executed.
There must not be any output above the header function call. This includes HTML tags, blank lines or other output.  

The `common.php` include doesn't have any output so the header function can be called.

Update `public/index.php` with the following header function calls .
```php
<?php

session_start();
require_once '../common.php';

if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit;
}
header('Location: /login.php');
exit;

```

[^ Back to top](lesson_10.md#what-you-will-learn)

## Logging out
There is currently no way of logging out of the application.  Create `public/logout.php` and start the session before requiring the `common.php` file.
```php
<?php

session_start();
require_once '../common.php';
```
This file will need to call a function called `logout` which will remove all the session data. 

Create the new test file `tests/LogoutTest.php` with the following test method

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
This tests ensures that after the `logout` function is called the `$_SESSION` variable is `empty`.

After running `composer test-unit` you should see a similar error

```bash
There was 1 error:

1) Test\LogoutTest::testLogout
Error: Call to undefined function Test\logout()

```

To fix this failing test add the  following `logout` function to `common.php`

```php
function logout(): void
{
    unset($_SESSION['user_key']);
}
```
This function unsets all the data stored in `$_SESSION` which means the user is no longer logged into the application.

Re-run `composer test-unit` and all tests should pass.

Call the `logout()` function in `public/logout.php` under the `common.php` file include.
```php
session_start();
require_once '../common.php';
logout();
```
After the session data has been removed the user needs to be redirected back to the `public/login.php` page.  

To do this use the `header` PHP function. Add the following header redirect after the `logout()` call in `public/logout.php`
```php
session_start();
require_once '../common.php';
logout();
header('Location: /index.php');
exit;
```

Login via the login form and then manually go to `logout.php` in the browser.  You should be redirected to the `index.php` which should then redirect you back to the `login.php` page.

[^ Back to top](lesson_10.md#what-you-will-learn)

## Redirect the login form
Adjust `public/login.php` to redirect the user to the secure `dashboard.php` page after a successful login.
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
        // Start the session
        $_SESSION['user_key'] = $userKey;
        // redirect to dashboard
        header('Location: /dashboard.php');
        exit;
    } else {
        $error = 'Invalid login, please try again';
    }
}

?>
```
## Create a logout link
In `public/dashboard.php` add a link to `logout.php` in the header HTML element
```html
<header>
    <p>Welcome, <?php echo $userName; ?> <a class="btn" href="logout.php">logout</a></p>
</header>
```
[^ Back to top](lesson_10.md#what-you-will-learn)

## Try the application
Now all the PHP has been created try the application and make sure it works.  

If you're logged in then go to `logout.php`.

From the `login.php` page enter a valid username and password. You should be redirected to `dashboard.php` and you should see the users order items.

Now click the logout link by the username.  This should redirect you to `logout.php` which should remove the session data and then redirect you to the `index.php` page which in turn should redirect you back to the `login.php` page

If this isn't working or if you have errors in the code then run `composer test` to run all the test scripts.  Use the output to help debug the code.

[^ Back to top](lesson_10.md#what-you-will-learn)

[<<< Go back to readme](../../README.md) | [<< Go to lesson index](index.md) | [< Go to previous lesson](lesson_9.md)