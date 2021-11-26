# Lesson 4: Style the login form

# What you will learn
 ~ Document what will be learnt ~

# Lesson notes
1. [Create a stylesheet](lesson_4.md#create-a-stylesheet)
2. [Style the document body](lesson_4.md#style-the-document-body)
3. [Link the style sheet to the login page](lesson_4.md#link-the-stylesheet-to-the-login-page)
4. [Add a main element](lesson_4.md#add-a-main-element)
5. [Style the main element](lesson_4.md#style-the-main-element)
6. [Wrap the form elements in a form container](lesson_4.md#wrap-the-form-element-in-a-form-container)
7. [Style the form container](lesson_4.md#style-the-form-container)
8. [Wrap the form inputs in a input container](lesson_4.md#wrap-the-form-inputs-in-a-input-containers)
9. [Style the input containers](lesson_4.md#style-the-form-input-containers)
10. [Check the CSS file](lesson_4.md#style-the-form-container)

## Create a stylesheet

Create a new file called `main.css` in the assets folder.
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
│       main.css
│   login.php
│   dashboard.php
└───reports/
└───tests/
└───vendor/
```
[^ Back to top](lesson_4.md#what-you-will-learn)

## Style the document body

In `main.css` add a block for the body element
```css
body {
    font-size: 16px;
    font-family: Arial;
    background-color: #4a5568;
}
```
[^ Back to top](lesson_4.md#what-you-will-learn)

## Link the stylesheet to the login page
Open`login.php` and add the following to include the stylesheet
```html
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
```
[^ Back to top](lesson_4.md#what-you-will-learn)

## Add a main element
Put the form element inside a main element
```html
<main>
    <form id="loginForm" method="post" action="login.php">

    </form>
</main>
```
[^ Back to top](lesson_4.md#what-you-will-learn)

## Style the main element
Add the following to the `main.css` file. Setting the `display` to `flex` and `justify-content` to `center` will center the form on the page.
```css

main {
    display: flex;
    justify-content: center;
    margin: auto;
}
```
[^ Back to top](lesson_4.md#what-you-will-learn)
## Wrap the form element in a form container
Place the form elements in a div with `class=form-content`

```html
<main>
    <form id="loginForm" method="post" action="login.php">
        <div class="form-content">
            <label for="username">
                Username
            </label>
            <input type="text" id="username" name="username" required/>
            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password" required/>
            <input type="submit" value="Login" name="submit" required/>
        </div>
    </form>
</main>
```
[Go back to readme](../../README.md)

## Style the form container
Add the following to the `main.css` file. This will add a background colour and padding to the form container.

```css
.form-content {
    background-color: #1a202c;
    padding: 10px;
    border: none;
    color: #000;
}
```
## Wrap the form inputs in input containers
Within the `form-content` wrap each input and label group in a `input-container` class. 
```html
<main>
    <form id="loginForm" method="post" action="login.php">
        <div class="form-content">
            <div class="input-container">
                <label for="username">
                    Username
                </label>
                <input type="text" id="username" name="username" required/>
            </div>
            <div class="input-container">
                <label for="password">
                    Password
                </label>
                <input type="password" id="password" name="password" required/>
            </div>
            <div class="input-container">
                <input type="submit" value="Login" name="submit" required/>
            </div>
        </div>
    </form>
</main>
```
## Style the form input containers
In `main.css` add the following.  This will git the containers a margin and width
```css
.input-container {
    margin: 10px;
    width: 100%;
}
```
Add the following the `main.css` to set the width and display of the labels within the input container.
```css
.input-container label {
    width: 100px;
    display: inline-block;
    color: #FFF;
}
```

## Style the input elements

To se the width of both the password and text input types add the following:
```css
.input-container input[type=text], .input-container input[type=password] {
    width: 250px;
}
```
Give each input a padding and border
```css
input {
    padding: 5px;
    border: 1px solid gray;
}
```
Target the submit button and override the input `padding` from `5px` to `10px`
```css
input[type=submit] {
    padding: 10px;
    background-color: #38a169;
    color: #FFF;
    font-weight: bold;
    border: none;
}
```
Change the background colour of the submit buttons hover state.
```css
input[type=submit]:hover {
    background-color: dodgerblue;
}
```
Give the form element 100px margin top
```css
form {
    margin-top: 100px;
}
```
### Check the CSS file
The `main.css` should look similar to this this
```css
body {
    font-size: 16px;
    font-family: Arial;
    background-color: #4a5568;
}

main {
    display: flex;
    justify-content: center;
    margin: auto;
}

form {
    margin-top: 100px;
}

.form-content {
    background-color: #1a202c;
    padding: 10px;
    border: none;
    color: #000;
}

.input-container {
    margin: 10px;
    width: 100%;
}

.input-button-container {
    display: flex;
    justify-content: end;
    width: auto;
}

.input-container label {
    width: 100px;
    display: inline-block;
    color: #FFF;
}

.input-container input[type=text], .input-container input[type=password] {
    width: 250px;
}

input {
    padding: 5px;
    border: 1px solid gray;
}

input[type=submit] {
    padding: 10px;
    background-color: #38a169;
    color: #FFF;
    font-weight: bold;
    border: none;
}

input[type=submit]:hover {
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: dodgerblue;
}
```
[Go back to readme](../../README.md)