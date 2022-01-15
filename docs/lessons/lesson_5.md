# Lesson 5: Style the secure area

# What you will learn
- How to style a HTML table

# Lesson notes
1. [Link the style sheet to the secure area](lesson_5.md#link-the-stylesheet-to-the-login-page)
2. [Add a username to the secure area](lesson_5.md#add-the-username-to-the-secure-area)
3. [Style the username](lesson_5.md#style-the-username)
4. [Style the table elements](lesson_5.md#style-the-table-elements)

Open `public/dashboard.php` and link the `main.css` stylesheet
```html
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/main.css">
</head>
```

## Add the username to the secure area
Add the following to `dashboard.php`. We will be updating the username dynamically later
```html
<body>
    <header>
        <p>Welcome, TestUser Name</p>
    </header>
```
Also add a `<main>` element to the HTML. The `dashboard.php` should now look like this

```html

<html lang="en">
<head>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>

        <header>
            <p>Welcome, TestUser Name</p>
        </header>
        <main>
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
    </main>
</body>
</html>
```
## Style the username
Open `main.css` and add the following to style the header element
```css
header {
    text-align: center;
    margin-bottom: 40px;
    margin-top: 100px;
    color: #FFF;
}
```
## Style the table elements
```css
table {
    width: 100%;
    border-spacing: 0;
}

td, th {
    text-align: center;
    padding: 5px;
    border-bottom: 1px solid black;
}

th {
    background-color: #14252c;
    color: #f687b3;
}
```
[^ Back to top](lesson_4.md#what-you-will-learn)

[Go to lesson index](index.md)

[Go back to readme](../../README.md)