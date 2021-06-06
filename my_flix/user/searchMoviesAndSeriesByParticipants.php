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


if(!isset($_POST['searching'])){
?>
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h2">
                        Search movies and series
                        <form action="../user/searchMoviesAndSeriesByParticipants.php" method="post">
                            <div class="bg-light text-dark h5">
                                <label for="participant">
                                    Type the name of participant  
                                    <input type="text" class="form-control" name="participant" required>
                                </label>
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
    
    $moviesArray = GetAllMoviesByParticipantName($user['username'], $_POST['participant']);
    $seriesArray = GetAllSeriesByParticipantName($user['username'], $_POST['participant']);
    $fullName  = GetParticipantFullNameByParticipantName($user['username'], $_POST['participant']);
?>

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h2">
                        Search movies and series
                        <div class="bg-light text-dark h4">
                           <?php
                                if($fullName != null){ 
                                    print "with: ".$fullName;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <?php if($_POST['participant'] == null){
                    print "<div class='col-6'>";
                        print "<div class='bg-dark text-white h2'>";
                            print "Movies";
                            print "<div class='bg-white text-dark h4'>";
                                print"<h5>no movies found with this participant</h5>";
                            print "</div>";
                        print "</div>";
                    print "</div>";
                    print"<div class='col-6'>";
                            print"<div class='bg-dark text-white h2'>";
                                print "Series";
                                print "<div class='bg-white text-dark h4'>";
                                    print"<h5>no series found with this participant</h5>";
                                print "</div>";
                            print "</div>";
                    print "</div>";
                    exit;} 
                ?>
                <div class="col-6">
                    <div class="bg-dark text-white h2">
                        Movies
                        <div class="bg-white text-dark h4">
                            <form action = "../movies/movieCard.php" method="post">
                                <?php   
                                    if(count($moviesArray) > 0){
                                        foreach($moviesArray as $movie) {
                                            $_SESSION['movie'.$movie->movie->id] = serialize($movie->movie); ?>
                                            <p>
                                                <input type="hidden" name="movieId" value="<?php print $movie->movie->id?>">
                                                <button type="submit" class="btn text-primary" style="border:0; background-color:inherit; font-weight:bold"> - <?php print $movie->movie->title;?></button>
                                            </p>
                                <?php   } 
                                    }
                                    else print "<h5>no movies found with this participant</h5>";    
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
                                        foreach($seriesArray as $series) {
                                            $_SESSION['series'.$series->series->id] = serialize($series->series); ?>
                                            <p>
                                                <input type="hidden" name="seriesId" value="<?php print $series->series->id?>">
                                                <button type="submit" class="btn text-primary" style="border:0; background-color:inherit; font-weight:bold"> - <?php print $series->series->title;?></button>
                                            </p>
                                <?php   } 
                                    }
                                    else print "<h5>no series found with this participant</h5>";    
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


