# Lesson 3: Build the secure area

# What you will learn
- How to create a HTML table

# Lesson notes

1. [Create the dashboard file](lesson_3.md#create-the-dashboard-file)
2. [Add HTML structure](lesson_3.md#add-the-html-structure)
3. [Add the HTML table](lesson_3.md#add-the-html-table)

## Create the dashboard file

Create a new file called `dashboard.php` in the public folder.
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
│   dashboard.php
└───reports/
└───tests/
└───vendor/
```
[Go to lesson index](index.md)

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
[Go to lesson index](index.md)

## Add the HTML table

```html
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Date ordered</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Test name</td>
            <td>5.95</td>
            <td>13/04/2021</td>
        </tr>
    </tbody>
</table>
```

[Go back to readme](../../README.md)