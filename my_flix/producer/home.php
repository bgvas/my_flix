<?php 

include_once '../producer/producer-dashboard.php';
include_once '../database/producer_context.php';


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

<div class="container-fluid">
    <div class="row mt-4 justify-content-center">
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h3 p-2 text-center border">
                        List Of All Our Projects
                    </div>
                </div>  
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="bg-dark text-white h4 p-2 text-center border">
                        List Of Movies
                        <div class="bg-white text-dark h5">
                            <?php 
                                $counter = 1;
                                $allMovies = GetAllMoviesByProducer($user);
                                if(count($allMovies) > 0){
                                    foreach($allMovies as $movie){
                                        print "<p>".$counter.")".$movie->project['title']."</p>";
                                        $counter++;
                                    }
                                }
                                else print "<a>You don't have create any movie</a>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-dark text-white h4 p-2 text-center border">
                        List Of Series
                        <div class="bg-white text-dark h5">
                            <?php 
                                $counter = 1;
                                $allSeries = GetAllSeriesByProducer($user);
                                if(count($allSeries) > 0){
                                    foreach($allSeries as $series){
                                        print "<p>".$counter.")".$series->project['title']."</p>";
                                        $counter++;
                                    }
                                }
                                else print "<a>You don't have create any series</a>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <a href="../producer/newMovie.php" role="button" class="btn btn-secondary w-100 p-2 border border-danger">
                        + Add new Movie
                    </a>
                </div>
                <div class="col-6">
                    <a href="../producer/newSeries.php" role="button" class="btn btn-secondary w-100 p-2 border border-warning">
                        + Add new Series
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>