<?php

include_once "../mainMenu.php";
require_once "../database/admin_context.php";

if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html");
    exit;
}
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}

?>
<nav class="navbar navbar-light border bg-light">
    <div class="container-fluid">
        <div class="row w-100 text-white justify-content-center">
            <div class="col-12 text-center text-dark h3">
                Admin Dashboard
            </div>
        </div>
    </div>
</nav>
<body style="background-image: url(../assets/images/administrator.jpg)"></body>
