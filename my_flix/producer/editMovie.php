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

if(!isset($_SESSION['movie'.$_POST['movieId']])) {
    header("Location: ../producer/home.php");
    exit;
}


$movie = unserialize($_SESSION['movie'.$_POST['movieId']]);


if(isset($_POST['projectTitle']) && isset($_POST['projectDescription']) && isset($_POST['projectCreatedAt']) && isset($_POST['addCategory']) && isset($_POST['movieLong'])){
    UpdateProject($user, $_POST['projectTitle'], $_POST['projectDescription'], $_POST['projectCreatedAt'], $movie->project['id']);
    UpdateMovie($user, $_POST['movieLong'], $movie->movie['id']);
    InsertMovieCategories($user, $_POST['addCategory'], $movie->movie['id']);
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
                        <p class="text-center">Edit Movie <?php print $movie->project['title'] ?></p>
                        <form action="../producer/editMovie.php" method="post">
                            <div class="bg-white text-dark h5">
                                <label for="title" class="w-100">Title
                                    <input type="text" class="form-control" name="projectTitle" value="<?php print $movie->project['title'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="description" class="w-100">Description
                                    <input type="text" class="form-control" name="projectDescription" value="<?php print $movie->project['description'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="created_at" class="w-100">Created at
                                    <input type="text" class="form-control" name="projectCreatedAt" value="<?php print $movie->project['created_at'] ?>" required>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="categories" class="w-100">Categories
                                    <?php 
                                        print "<p class='form-control'> ".GetCategoriesOfMovieByMovieId($user['username'], $movie->movie['id'])."</p>";
                                    ?>
                                    add category
                                    <select class="form-select" name="addCategory">
                                    <option class='form-control'>- select category</option>
                                        <?php 
                                            foreach(GetAllCategories($user['username']) as $category){
                                                print "<option class='form-control' value='".$category->id."'>".$category->title."</option>";
                                            }
                                        ?>
                                    </select>
                                </label>
                            </div>
                            <div class="bg-white text-dark h5">
                                <label for="long" class="w-100">Long in minutes
                                    <input type="text" class="form-control" name="movieLong" value="<?php print $movie->movie['time_long'] ?>" required>
                                </label>
                            </div>
                            <input type="hidden" name="movieId" value="<?php print $movie->movie['id'] ?>">
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