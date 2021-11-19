# Lesson 2: Build the login form

# What you will learn
- How to create a HTML form

# Lesson notes

1. [Create the login file](lesson_2.md#create-the-login-file)
2. [Add HTML structure](lesson_2.md#add-the-html-structure)

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
[Go to lesson index](index.md)

[Go back to readme](../../README.md)