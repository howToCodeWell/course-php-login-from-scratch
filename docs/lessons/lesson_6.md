# Lesson 6: Create PHP user config

# What you will learn
 ~ Document what will be learnt ~

# Lesson notes
- [Create user config](lesson_6.md#create-user-config)
- [Add user array data](lesson_6.md#add-user-array-data)
- [Include user config](lesson_6.md#include-user-config)
- [Get a user](lesson_6.md#get-a-user)

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

[Go to lesson index](index.md)

[Go back to readme](../../README.md)