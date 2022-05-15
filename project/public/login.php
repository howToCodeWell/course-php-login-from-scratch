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
<head>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
<main>
    <form id="loginForm" method="post" action="login.php">
        <?php if (!empty($error)) : ?>
            <div class="alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
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
            <div class="input-container input-button-container">
                <input type="submit" value="Login" name="submit" required/>
            </div>
        </div>
    </form>
</main>
</body>
</html>