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

if(isset($_POST['comment']) || isset($_POST['valuation']) || isset($_POST['schedule'])){
    print SaveMovieFeedBack($user['username'], $user['id'],$_POST['comment'], $_POST['valuation'], $_POST['schedule'], $_POST['movieId']);
}


?>
<div class="container-fluid h-90" >
    <div class="row w-100 justify-content-center">
        <div class="col-6">
            <div class="row justify-content-center">
                <div class="col-10 border shadow mt-4">
                    <div class="row">
                        <div class="col-12 bg-dark p-2">
                            <h3 class="text-center text-light">
                                List of all movies
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 border bg-light">
                            <table>
                               <tr style="font-weight: bold; width: 100%">
                                   <td class="text-center" style="width: 10%">Index</td>
                                   <td class="text-center" style="width: 50%">Title</td>
                                   <td class="text-center" style="width: 50%">Categories</td>
                                   <td class="text-center" style="width: 10%">Year</td>
                               </tr>
                               <?php
                                    $movies = GetAllMovies($user['username']);
                                    if($movies == null){
                                        print "<tr><td class='text-danger' style='width: 10%'>
                                                    No movies found
                                               </td></tr>";
                                    }
                                    else {
                                        $counter = 0;
                                        foreach ($movies as $movie){
                                            if($counter % 2 == 0){              // if $counter is even, then background is white //
                                                print "<tr class='bg-white' style='width: 100%'>";
                                            }
                                            else print "<tr style='width: 100%'>";
                                            $_SESSION['movie'.$movie->id] = serialize($movie);
                               ?>
                                   <td class="text-center" style="width: 10%"><?php print $movie->id; ?></td>
                                   <td class="text-center" style="width: 40%">
                                       <form action="../movies/movieCard.php" method="post">
                                           <?php print "<input name='movieId' type='hidden' value = ".$movie->id.">";?>  <!--decode selected movie object to post it to movieCard page-->
                                           <button class="btn text-primary" style="background-color: inherit; border: 0" type="submit">
                                               <?php print $movie->title?>
                                           </button>
                                       </form>
                                   </td>
                                   <td class="text-center " style="width: 40%"><?php print $movie->categories; ?></td>
                                   <td class="text-center " style="width: 10%"><?php print $movie->year; ?></td>
                                </tr>
                               <?php
                                  $counter++;  }}
                               ?>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row justify-content-center">
                <div class="col-10 border shadow mt-4">
                    <div class="row">
                        <div class="col-12 bg-dark p-2">
                            <h3 class="text-center text-light">
                                List of all Series
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 border bg-light">
                            <table>
                                <tr style="font-weight: bold; width: 100%">
                                    <td class="text-center" style="width: 10%">Index</td>
                                    <td class="text-center" style="width: 50%">Title</td>
                                    <td class="text-center" style="width: 50%">Categories</td>
                                    <td class="text-center" style="width: 10%">Year</td>
                                </tr>
                                <a href="">
                                    <?php
                                    $serieses = GetAllSeries($user['username']);
                                    if($serieses == null){
                                        print "<tr><td class='text-danger' style='width: 10%'>
                                                    No Series found
                                               </td></tr>";
                                    }
                                    else {
                                    $counter = 0;
                                    foreach ($serieses as $series){
                                    if($counter % 2 == 0){
                                        print "<tr class='bg-white' style='width: 100%'>";
                                    }
                                    else print "<tr style='width: 100%'>";
                                    ?>
                                    <td class="text-center" style="width: 10%"><?php print $series->id; ?></td>
                                    <td class="text-center" style="width: 40%"><?php print "<a href=''>".$series->title."</a>"; ?></td>
                                    <td class="text-center " style="width: 40%"><?php print $series->categories; ?></td>
                                    <td class="text-center " style="width: 10%"><?php print $series->year; ?></td>
                                    </tr>
                                </a>
                                <?php
                                $counter++;  }}
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







