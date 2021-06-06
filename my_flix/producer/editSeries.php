<?php 

include_once '../producer/producer-dashboard.php';
include_once '../database/producer_context.php';
include_once '../database/user_context.php';


if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html");
    exit;
}
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}

if(!isset($_SESSION['series'.$_POST['seriesId']])) {
    header("Location: ../producer/home.php");
    exit;
}


$series = unserialize($_SESSION['series'.$_POST['seriesId']]);


if(isset($_POST['projectTitle']) && isset($_POST['projectDescription']) && isset($_POST['projectCreatedAt']) && isset($_POST['addCategory']) && isset($_POST['seriesSeasons']) && isset($_POST['newEpisodeTimeLong'])){
    UpdateProject($user, $_POST['projectTitle'], $_POST['projectDescription'], $_POST['projectCreatedAt'], $series->project['id']);
    UpdateSeries($user, $_POST['seriesSeasons'], $series->series['id']);
    InsertSeriesCategories($user, $_POST['addCategory'], $series->series['id']);
    InsertNewEpisode($user, $_POST['newEpisodeTimeLong'], $series->series['id']);
    header("Location: ../producer/home.php");
    exit;
}

?>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h3 p-2 border">
                        <p class="text-center">Edit the Series "<?php print $series->project['title'] ?>"</p>
                        <form action="../producer/editSeries.php" method="post">
                            <div class="bg-white text-dark h5">
                                <label for="title" class="w-100">Title
                                    <input type="text" class="form-control" name="projectTitle" value="<?php print $series->project['title'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="description" class="w-100">Description
                                    <input type="text" class="form-control" name="projectDescription" value="<?php print $series->project['description'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="created_at" class="w-100">Created at
                                    <input type="text" class="form-control" name="projectCreatedAt" value="<?php print $series->project['created_at'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="categories" class="w-100">Categories
                                    <?php 
                                        print "<p class='form-control'> ".GetCategoriesOfSeriesBySeriesId($user['username'], $series->series['id'])."</p>";
                                    ?>
                                    add category
                                    <select class="form-select" name="addCategory">
                                    <option class='form-control'>- select category -</option>
                                        <?php 
                                            foreach(GetAllCategories($user['username']) as $category){
                                                print "<option class='form-control' value='".$category->id."'>".$category->title."</option>";
                                            }
                                        ?>
                                    </select>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="Number Of Seasons" class="w-100">Number Of Seasons
                                    <input type="number" class="form-control" name="seriesSeasons" min="<?php print $series->series['number_of_seasons'] ?>" step="1" value="<?php print $series->series['number_of_seasons'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="Number Of episodes" class="w-100">Number Of episodes
                                    <input type="number" class="form-control" value="<?php print $series->series['number_of_episodes'] ?>" disabled>
                                </label>
                                Add new episode
                                <select name="newEpisodeTimeLong" class="form-select">
                                    <option>-enter time-long in minutes-</option>
                                    <?php 
                                        for($minutes = 40; $minutes < 61; $minutes++){
                                            print "<option value=".$minutes.">".$minutes."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="seriesId" value="<?php print $series->series['id'] ?>">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-50">
                                        Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>