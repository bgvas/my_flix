<?php
include_once "user-dashboard.php";
include_once "../database/user_context.php";

if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html?result=usernotfound");
    exit;
}
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html?result=usernotfound");
    exit;
}

$from = 0;
$to = 0;

if(!isset($_POST['searching'])){
?>
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h2">
                        Search movies and series
                        <form action="../user/searchMoviesAndSeriesByDate.php" method="post">
                            <div class="bg-light text-dark h3">
                                <span>
                                    From:  
                                    <select class="h5" name="from">
                                        <?php 
                                            for($year = 1960; $year <= date("Y"); $year++){
                                                print "<option>".$year."</option>";
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span>
                                    To:
                                    <select class="h5" name="to">
                                        <?php 
                                            for($year = 1960; $year <= date("Y"); $year++){
                                                print "<option>".$year."</option>";
                                            }
                                        ?>
                                    </select>
                                </span>
                            </div>
                            <input type="hidden" name="searching" value="true">
                            <button type="submit" class="btn btn-primary w-50 mb-2">Search...</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    } 
    else 
    { 
        if($_POST['from'] > $_POST['to']){
            $_POST['to'] = $_POST['from'];
        } 

        $moviesArray = [];
        $seriesArray = [];
        foreach(GetAllMoviesAndSeriesByDate($user, $_POST['from'], $_POST['to']) as $project){
            if($project->movie != new stdClass()){
                $moviesArray[] = $project;
            }
            else $seriesArray[] = $project; 
        }
?>

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h2">
                        Search movies and series
                        <div class="bg-light text-dark h3">
                            <span>
                                From:  
                                <?php print $_POST['from']?>
                            </span>
                            <span>
                                To:
                                <?php print $_POST['to']?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-6">
                    <div class="bg-dark text-white h2">
                        Movies
                        <div class="bg-white text-dark h4">
                           <form action = "../movies/movieCard.php" method="post">
                                <?php 
                                if(count($moviesArray) > 0){
                                        foreach($moviesArray as $movie){
                                            $_SESSION['movie'.$movie->movie->id] = serialize($movie->movie);
                                            ?>
                                            <p>
                                                <input type="hidden" name="movieId" value="<?php print $movie->movie->id?>">
                                                <button type="submit" class="btn text-primary" style="border:0; background-color:inherit; font-weight:bold"> - <?php print $movie->title;?></button>
                                            </p>
                                        <?php }
                                    }
                                    else print "<h5>no movies found</h5>";
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-dark text-white h2">
                        Series
                        <div class="bg-white text-dark h4">
                            <form action = "../series/seriesCard.php" method="post">
                                <?php 
                                if(count($seriesArray) > 0){
                                        foreach($seriesArray as $series){
                                            $_SESSION['series'.$series->series->id] = serialize($series->series);
                                            ?>
                                            <p>
                                                <input type="hidden" name="seriesId" value="<?php print $series->series->id?>">
                                                <button type="submit" class="btn text-primary" style="border:0; background-color:inherit; font-weight:bold"> - <?php print $series->title;?></button>
                                            </p>
                                        <?php }
                                    }
                                    else print "<h5>no series found</h5>";
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }?>


