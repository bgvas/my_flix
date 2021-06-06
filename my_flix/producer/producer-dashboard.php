<?php

include_once "../mainMenu.php";
require_once "../database/user_context.php";

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
            <div class="col-5 text-center">
                <a href="../producer/handleOurMovies.php" role="button" class="btn btn-dark w-50">Handle Our Movies</a>
            </div>
            <div class="col-5 text-center">
                <a href="../producer/handleOurSeries.php" role="button" class="btn btn-dark w-50">Handle Our Series</a>
            </div>
        </div>
    </div>
</nav>
<body style="background-image: url(../assets/images/producer.jpg)"></body>

