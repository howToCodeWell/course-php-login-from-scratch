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
<html lang="en">
<body>

<?php if (!empty($error)) : ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<form id="loginForm" method="post" action="login.php">
    <fieldset>
        <label for="username">
            Username
        </label>
        <input type="text" id="username" name="username" required/>
        <label for="password">
            Password
        </label>
        <input type="text" id="password" name="password" required />

        <input type="submit" value="Login" name="submit" required />
    </fieldset>
</form>
</body>
</html>