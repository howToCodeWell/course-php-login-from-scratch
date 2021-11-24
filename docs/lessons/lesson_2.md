# Lesson 2: Build the login form

# What you will learn
- How to create a HTML form
- How to run a PHP webserver via the command line
- How to access posted values

# Lesson notes

1. [Create the login file](lesson_2.md#create-the-login-file)
2. [Add HTML structure](lesson_2.md#add-the-html-structure)
3. [Add the HTML form](lesson_2.md#add-the-html-form)
4. [Access the website](lesson_2.md#access-the-website)
5. [Get submitted data](lesson_2.md#get-the-submitted-data)

## Create the login file

Create a new file called `login.php` in the public folder.
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
└───public/
|   └───assets/
│   login.php
└───reports/
└───tests/
└───vendor/
```

## Add the HTML structure

In the new `login.php` file start by adding the skelton HTML structure like so:

```html
<html lang="en">
    <head>
        
    </head>
    
    <body>
    
    </body>
</html>
```

[^ Back to top](lesson_2.md#what-you-will-learn)

## Add the HTML form
In the HTML body add the HTML form. This form will include the following:
- Username
- Password
- Submit button
- form action of 'login.php'
- form method of 'post'
```html
<form id="loginForm" method="post" action="login.php">
    <fieldset>
        <label for="username">
            Username
        </label>
        <input type="text" id="username" name="username" required/>
        <label for="password">
            Password
        </label>
        <input type="password" id="password" name="password" required />

        <input type="submit" value="Login" name="submit" required />
    </fieldset>
</form>
```
Make sure the forms action is set to `login.php`.

This is an example of the full `login.php`
```html
<html lang="en">
    <head>
    
    </head>
        <body>
        <form id="loginForm" method="post" action="login.php">
            <fieldset>
                <label for="username">
                    Username
                </label>
                <input type="text" id="username" name="username" required/>
                <label for="password">
                    Password
                </label>
                <input type="password" id="password" name="password" required />
        
                <input type="submit" value="Login" name="submit" required />
            </fieldset>
        </form>
    </body>
</html>
```

[^ Back to top](lesson_2.md#what-you-will-learn)

## Access the website
To access the website on a browser run the following PHP command in the terminal in the projects root folder
```bash
php -S localhost:8080 -t public
```

- The `-S` argument starts the PHP webserver.  Giving the value of `localhost:8080` will allow use access to the website at the address [http://localhost:8080/login.php](http://localhost:8080/login.php).
- The `-t` argument sets the document route.  As we are running this command from project route we need to tell the PHP webserver to access files in the `public` subdirectory.

[^ Back to top](lesson_2.md#what-you-will-learn)

## Get the submitted data
At the top of the `login.php` we need to access `$_POST` variable once the form is submitted.  This variable holds an array of submitted data.  
The array keys match the input names.  To get the username value we would access `$_POST['username]`.
The submit button also has a `name` which is `submit`.
```html
<input type="submit" value="Login" name="submit" required />
```
The value of 
```php 
$_POST['submit']
``` 
would be `Login`  if the form has been submitted.
If the form hasn't been submitted then the variable would be empty.

Create two variables `$submitted` and `$hasSubmitted`.

`$submitted` will hold the value of `$_POST['submit']` and default to an empty string.
```php
$submitted = $_POST['submit'] ?? '';
```
Create a ternary statement that checks the value of `$submitted`. Set the value to `true` if `$submitted` is `Login` and `false` if not.
```php
$hasSubmitted = ($submitted === 'Login');
```

As `$hasSubmitted` is a boolean we can use that to check if the form has been submitted or not.

```php
if ($hasSubmitted) {
    //.. Handle the form
}
```
Inside the body of the if statement we can create variables that hold the value of the username and password.
Use the null coalescing operator to set a default value of an empty string.
```php
if ($hasSubmitted) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
}
```
[^ Back to top](lesson_2.md#what-you-will-learn)

[Go to lesson index](index.md)

[Go back to readme](../../README.md)