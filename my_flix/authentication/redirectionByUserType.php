<?php
ob_start();
require_once "../database/user_context.php";
require_once "../database/authenticate_context.php";


if(!isset($_POST['username']) || !isset($_POST['password'])){
    header("Location: ../authentication/login.html?result=usernotfound");
    exit;
}

if(!authenticateUser($_POST['username'], $_POST['password'])){
    header("Location: ../authentication/login.html?result=errorlogin");
    exit;
}

$user = getUserByUsernameAndPassword($_POST['username'], $_POST['password']);


switch ($user['role_id']) {
    case 1:
        header("Location: ../admin/admin-dashboard.php");
        break;
    case 2:
        header("Location: ../producer/producer-dashboard.php");
        break;
    case 3:
        header("Location: ../user/home.php");
        break;
}


