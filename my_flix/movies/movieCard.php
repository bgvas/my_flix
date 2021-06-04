<?php
include_once "../user/user-dashboard.php";
include_once "../database/user_context.php";

if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html?result=errorlogin");
    exit;
}
$user = GetUserByToken($_SESSION['token']);


if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}

if(!isset($_POST['movieId'])){
    header("Location: ../user/listOfAllMoviesAndSeries.php");
    exit;
}



if(!isset($_SESSION['movie'.$_POST['movieId']])) {
    header("Location: ../user/listOfAllMoviesAndSeries.php");
    exit;
}


$movie = unserialize($_SESSION['movie'.$_POST['movieId']]);
?>



<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="border">
                <div class="row">
                    <div class="col-12">
                        <div class="bg-dark text-white p-2">
                            <h2>
                                Movie: <?php print $movie->title?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="border">
                <div class="row">
                    <div class="col-12">
                        <div class="bg-light text-dark p-2">
                            <div class="row">
                                <div class="col-8">
                                    <div class="shadow bg-white">
                                        <div>
                                            <strong>Description: </strong><?php print $movie->description?>
                                        </div>
                                        <div>
                                            <strong>Category: </strong><?php print $movie->categories?>
                                        </div>
                                        <div>
                                            <strong>long: </strong><?php print $movie->long?> minutes
                                        </div>
                                        <div>
                                            <strong>Year of creation: </strong><?php print $movie->year?>
                                        </div>
                                        <hr class="mb-1 mt-1">
                                        <div>
                                            <strong>
                                                Participants:
                                            </strong>
                                            <div style="font-size: smaller; overflow: auto; height: 80px">
                                               <?php
                                             $counter = 1;
                                                $participants = GetMovieParticipantsByMovieId($user['username'], $movie->id);
                                                foreach ($participants as $participant){
                                                    ?>
                                                    <div style="overflow: auto; width: 100%">
                                                        <?php print $counter.") ".$participant.""; ?>
                                                   </div>
                                                    <?php $counter++;} ?>
                                            </div>
                                        </div>
                                        <hr class="mb-1 mt-1">
                                        <div>
                                            <strong>
                                                Valuation:
                                            </strong>
                                            <span class="h2 text-warning">
                                            <?php
                                            for($i = 1; $i <= $movie->valuation; $i++){  // display valuation
                                                print " * ";
                                            }
                                            ?>
                                            </span>
                                        </div>
                                        <hr class="mb-1 mt-1">
                                        <div>
                                           <strong>
                                               Comments:
                                           </strong>
                                           <div class = "mb-1" style="font-size: smaller;overflow: auto; height:80px">
                                                <?php
                                                    $counter = 1;
                                                    $comments[] = GetMovieCommentsByMovieId($user['username'], $movie->id);
                                                    foreach ($comments[0] as $comment){
                                                        $commentBy = GetUserByUserId($user['username'],$comment->userId);
                                                ?>
                                                <div style="width: 100%">
                                                    <?php print $counter.") ".$comment->comment."  <span style='font-size: x-small'>(by user: ".$commentBy['username']." )</span>"; ?>
                                                </div>
                                                <?php $counter++;} ?>
                                           </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary">Play this movie now >>></button>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="bg-dark text-center text-white">
                                                Your Feedback
                                            </div>
                                            <form action="../user/listOfAllMoviesAndSeries.php" method="post">
                                                <div class="bg-white shadow">
                                                    <strong>Add comment: </strong>
                                                    <textarea class="form-control" style="border: 0; height: 100px; resize: none" name="comment"></textarea>
                                                </div>
                                                <div class="mt-3 p-2 bg-white shadow">
                                                    <strong>Select valuation: </strong>
                                                    <select class="form-select text-warning" style="font-size: x-large" name="valuation">
                                                        <option class="h3 text-warning" value="0">0</option>
                                                        <option class="h3 text-warning" value="1">*</option>
                                                        <option class="h3 text-warning" value="2">* *</option>
                                                        <option class="h3 text-warning" value="3">* * *</option>
                                                        <option class="h3 text-warning" value="4">* * * *</option>
                                                        <option class="h3 text-warning" value="5">* * * * *</option>
                                                    </select>
                                                </div>
                                                <div class=" mt-3 p-2 bg-white shadow">
                                                    <strong>
                                                        <?php $favoriteMovie = isFavoriteMovie($user, $movie->id) || 0;?>
                                                        Add to favorites <input type="checkbox" name="favorite" value="<?php print $favoriteMovie?>" <?php $favoriteMovie == 1?print "checked":""?>>
                                                </div>
                                                <div class=" mt-3 p-2 bg-white shadow">
                                                    <strong>
                                                        Remind me to see this movie at
                                                    </strong>
                                                    <?php
                                                        include_once "../assets/datePicker.html";
                                                    ?>
                                                </div>
                                                <input type="hidden" name="movieId" value="<?php print $movie->id ?>">
                                                <button class="mt-3 w-100 btn btn-primary">Save my feedback</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

