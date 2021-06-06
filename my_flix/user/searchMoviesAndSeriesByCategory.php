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
    $categoriesArray = GetAllCategories($user['username']);
?>
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h2">
                        Search movies and series
                        <form action="../user/searchMoviesAndSeriesByCategory.php" method="post">
                            <div class="bg-light text-dark h3">
                                <span>
                                    By Category:  
                                    <select class="form-select" name="categoryId" style="font-weight:bold">
                                        <?php 
                                            foreach($categoriesArray as $category){
                                                print "<option class='form-control' value='".$category->id."' style='font-weight:bold'>".$category->title."</option>";
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
        
    $categoryTitle = GetCategoryTitleById($user['username'], $_POST['categoryId']);
    $moviesArray = GetAllMoviesByCategoryId($user['username'], $_POST['categoryId']);
    $seriesArray = GetAllSeriesByCategoryId($user['username'], $_POST['categoryId']);
?>

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h2">
                        Search movies and series
                        <div class="bg-light text-dark h3">
                            in category <?php print $categoryTitle?>
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
                                            $_SESSION['movie'.$movie->id] = serialize($movie);
                                            ?>
                                            <p>
                                                <input type="hidden" name="movieId" value="<?php print $movie->id;?>">
                                                <button type="submit" class="btn text-primary" style="border:0; background-color:inherit; font-weight:bold"> 
                                                    <?php  print " - ".$movie->title;?>
                                                </button>
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
                            <?php 
                                if(count($seriesArray) > 0){
                                        foreach($seriesArray as $series){
                                            $_SESSION['series'.$series->id] = serialize($series);
                            ?>
                            <form action = "../series/seriesCard.php" method="post">
                                            <p>
                                                <input type="hidden" name="seriesId" value="<?php  print $series->id?>" >
                                                <button type="submit" class="btn text-primary" style="border:0; background-color:inherit; font-weight:bold"> 
                                                     <?php  print " - ".$series->title;?>
                                                </button>
                                            </p>
                                        <?php  }
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