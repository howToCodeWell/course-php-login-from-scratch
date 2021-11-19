<?php

session_start();
require_once '../common.php';

if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit;
}
header('Location: /login.php');
exit;
