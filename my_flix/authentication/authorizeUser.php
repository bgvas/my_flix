<?php

require_once "../database/authenticate_context.php";
require_once "../database/user_context.php";
require_once "../helpers/auth-helper.php";

if(isset($_COOKIE['token'])) {
    $userId = GetUserIdByToken($_COOKIE['token']);
    if ($userId <= 0) {
        header("Location: authorization/Login.html");
        exit;
    }
    $token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user change page
    setcookie("token", $token, time() + (600), '/'); /// Keep token alive for 10 minutes
}
else {
        header("Location: authorization/login.html");
        exit;
    }
