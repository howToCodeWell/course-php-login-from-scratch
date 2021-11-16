<?php
session_start();
require_once '../common.php';
logout();
header('Location: /index.php');
exit;