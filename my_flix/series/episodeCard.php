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

if(!isset($_POST['episodeId'])){
    header("Location: ../user/listOfAllMoviesAndSeries.php");
    exit;
}

$episode_id = $_POST['episodeId'];

$series = unserialize($_SESSION['series'.$_POST['seriesId']]);

?>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="border">
                <div class="row">
                    <div class="col-12">
                        <div class="bg-dark text-white p-2 text-center">
                            <h2>
                                Series: <?php print $series->title?>
                            </h2>
                            <h4>
                                episode: <?php print $_POST['episodeIndex']?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="border">
                <div class="row">
                    <div class="col-12">
                        <div class="bg-light text-dark p-2">
                            <div class="row">
                                <div class="col-6">
                                    <div class="border shadow">
                                        <strong>
                                            Comments for this episode:
                                        </strong>
                                        <div class = "mb-1" style="font-size: smaller;overflow: auto; height:80px">
                                            <?php
                                                $counter = 1;
                                                $comments = GetEpisodeCommentsByEpisodeId($user['username'], $episode_id);
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
                                        <hr class="mb-1 mt-1">
                                        <div>
                                            <strong>
                                                Valuation:
                                            </strong>
                                            <span class="h2 text-warning">
                                            <?php
                                              for($i = 1; $i <= GetValuationForEpisodeByEpisodeId($user['username'], $episode_id); $i++){  // display valuation
                                                 print " * ";
                                               }
                                            ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border text-center bg-dark text-white">
                                        <strong>
                                            Your feedback for this episode
                                        </strong>
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
                                                <input type="hidden" name="seriesId" value="<?php print $series->id ?>">
                                                <input type="hidden" name="episodeId" value="<?php print $episode_id ?>">
                                                <button class="mt-3 w-100 btn btn-primary">Save my feedback</button>
                                            </form>
                                </div>
                                <div class="col-12 mt-2">
                                    <button class="btn btn-outline-primary">Play episode now >>></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>