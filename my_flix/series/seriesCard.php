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

if(!isset($_POST['seriesId'])){
    header("Location: ../user/listOfAllMoviesAndSeries.php");
    exit;
}



if(!isset($_SESSION['series'.$_POST['seriesId']])) {
    header("Location: ../user/listOfAllMoviesAndSeries.php");
    exit;
}


$series = unserialize($_SESSION['series'.$_POST['seriesId']]);

?>



<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="border">
                <div class="row">
                    <div class="col-12">
                        <div class="bg-dark text-white p-2">
                            <h2>
                                Series: <?php print $series->title?>
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
                                            <strong>Description: </strong><?php print $series->description?>
                                        </div>
                                        <div>
                                            <strong>Category: </strong><?php print $series->categories?>
                                        </div>
                                        <div>
                                            <strong>Year of creation: </strong><?php print $series->year?>
                                        </div>
                                        <div>
                                            <strong>Number of Seasons: </strong><?php print $series->seasons?>
                                        </div>
                                        <div>
                                            <strong>Number of episodes: </strong><?php print $series->episodes?>
                                        </div>
                                        <div>
                                            <strong>Select an episode: </strong>
                                        </div>
                                        <div class="row">     
                                            <?php
                                                if($series->episodes > 0){ 
                                                    $episodesArray = GetAllEpisodesOfSeriesBySeriesId($user['username'], $series->id);
                                                    $counter = 1;
                                                    foreach($episodesArray as $episode){?>
                                                        <div class="col-1"> <!-- display episodes as buttons -->
                                                            <form action="../series/episodeCard.php" method="post">
                                                                <input type="hidden" name="episodeId" value="<?php print $episode['id'] ?>">
                                                                <input type="hidden" name="long" value="<?php print $episode['time_long'] ?>">
                                                                <input type="hidden" name="episodeIndex" value="<?php print $counter ?>">
                                                                <input type="hidden" name="seriesId" value="<?php print $series->id ?>">
                                                                <button class="btn text-primary" style="background-color: inherit; border: 0" type="submit">
                                                                    <?php print $counter;?>
                                                                </button>
                                                            </form>
                                                        </div>
                                                   <?php 
                                                   $counter++;
                                                   }
                                                }
                                            ?>
                                        </div>
                                        <hr class="mb-1 mt-1">
                                        <div>
                                            <strong>
                                                Participants:
                                            </strong>
                                            <div style="font-size: smaller; overflow: auto; height: 80px">
                                               <?php
                                             $counter = 1;
                                                $participants = GetSeriesParticipantsBySeriesId($user['username'], $series->id);
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
                                            for($i = 1; $i <= $series->valuation; $i++){  // display valuation
                                                print " * ";
                                            }
                                            ?>
                                            </span>
                                        </div>
                                        <hr class="mb-1 mt-1">
                                        <div>
                                           <strong>         <!-- Display comments  -->
                                               Comments:
                                           </strong>
                                           <div class = "mb-1" style="font-size: smaller;overflow: auto; height:80px">
                                                <?php
                                                    $counter = 1;
                                                    $comments= GetSeriesCommentsBySeriesId($user['username'], $series->id);
                                                    if($comments == null) {
                                                        $comments = [];
                                                    }
                                                    foreach ($comments as $comment){
                                                        $commentBy = GetUserByUserId($user['username'],$comment->userId);
                                                ?>
                                                <div style="width: 100%">
                                                    <?php print $counter.") ".$comment->comment."  <span style='font-size: x-small'>(by user: ".$commentBy['username']." )</span>"; ?>
                                                </div>
                                                <?php $counter++;} ?>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="bg-dark text-center text-white">
                                                Your Feedback for <?php print $series->title ?>
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
                                                        <?php $favoriteSeries = isFavoriteSeries($user, $series->id) || 0;?>
                                                        Add to favorites <input type="checkbox" name="favorite" value="<?php print $favoriteSeries?>" <?php $favoriteSeries == 1?print "checked":""?>>
                                                </div>
                                                <input type="hidden" name="seriesId" value="<?php print $series->id ?>">
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

