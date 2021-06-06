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
            <div class="col-3 text-center">
                <a href="../user/listOfAllMoviesAndSeries.php" role="button" class="btn btn-dark">List of all movies and series</a>
            </div>
            <div class="col-3 text-center">
                <a href="../user/searchMoviesAndSeriesByDate.php" role="button" class="btn btn-dark">Search movies and series by year of creation</a>
            </div>
            <div class="col-3 text-center">
                <a href="../user/searchMoviesAndSeriesByParticipants.php" role="button" class="btn btn-dark">Search movies and series by participants</a>
            </div>
            <div class="col-3 text-center">
                <a href="../user/searchMoviesAndSeriesByCategory.php" role="button" class="btn btn-dark">Search movies and series by category</a>
            </div>
        </div>
    </div>
</nav>
<body style="background-image: url(../assets/images/person.jpg)"></body>

