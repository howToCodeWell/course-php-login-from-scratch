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
└───public/
|   └───assets/
│   login.php
│   dashboard.php
└───reports/
└───tests/
└───vendor/
```
[^ Back to top](lesson_3.md#what-you-will-learn)

## Add the HTML structure

In the new `dashboard.php` file start by adding the following HTML structure

```html
<html lang="en">
    <head>
        
    </head>
    
    <body>
    
    </body>
</html>
```
[^ Back to top](lesson_3.md#what-you-will-learn)

## Add the HTML table
Within the HTML body element create a table element which contains the header and the body elements
```html
<table>
    <thead>
    </thead>
    <tbody>
    </tbody>
</table>
```
Add a table row inside the table head
```html
<table>
    <thead>
        <tr>
            
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
```
Within this table row add 3 table head elements.  These will start the table columns

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
    </tbody>
</table>
```
Now add a table row to the table body
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
        </tr>
    </tbody>
</table>
```
Within the table bodies row add 3 table cells with test data
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
The markup should look like this
```html
<html lang="en">
    <head>
        
    </head>
    
    <body>
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
    </body>
</html>
```

Visit the page in the browser and check the output
[http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

[^ Back to top](lesson_3.md#what-you-will-learn)

[<<< Go back to readme](../../README.md) | [<< Go to lesson index](index.md) | [< Go to previous lesson](lesson_2.md) | [Go to next lesson >](lesson_4.md) 