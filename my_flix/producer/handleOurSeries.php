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

// take agreement for delete //
if(isset($_POST['projectId'])){
    $projectId = $_POST['projectId'];
    if(isset($_SESSION['project'.$projectId])){
        print "<div class='container-fluid mt-5'>
        <div class='row justify-content-center'>
            <div class='col-3'>
                <div class='row'>
                    <div class='col-12'>
                        <div class='bg-dark text-danger text-center h3 p-2 border border-danger'>
                            <span style='font-weight:bold'>
                                Do you want to Delete this project? 
                                <form action='../producer/handleOurMovies.php' method='post'>
                                    <input type='hidden' name='delete' value='true'>
                                    <input type='hidden' name='projectToDelete' value='".$projectId."'>
                                    <button type='submit' class='btn btn-danger'>Delete anyway</button>
                                    <a href='../producer/home.php' class='btn btn-secondary' role='button'>Cancel</a> 
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }
    exit;
}

if(isset($_POST['delete'])){
    DeleteProjectById($user, $_POST['projectToDelete']);
    header("Location: ../producer/home.php");
    exit;
}


?>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h3 p-2 text-center border">
                        Handle Our Series
                        <div class="bg-white text-dark h5">
                            <table class="w-100">
                                <tr>
                                    <td style="width:10%; font-weight:bold">Index</td>
                                    <td style="width:40%; font-weight:bold">Title</td>
                                    <td style="width:20%; font-weight:bold">Created at</td>
                                    <td style="width:10%; font-weight:bold">Seasons</td>
                                    <td style="width:10%; font-weight:bold">Episodes</td>
                                    <td style="width:10%"></td>
                                    <td style="width:10%"></td>
                                </tr>
                                    <?php
                                        $counter = 1;
                                        $allSeries = GetAllSeriesByProducer($user);
                                        if(count($allSeries) > 0){
                                            foreach($allSeries as $series){
                                                $_SESSION['series'.$series->series['id']] = serialize($series);
                                                $_SESSION['project'.$series->project['id']] = serialize($series);
                                                print "<tr>
                                                    <td class='text-primary' style='width:10%'>".$counter."</td>
                                                    <td class='text-primary' style='width:40%'>".$series->project['title']."</td>
                                                    <td class='text-primary' style='width:20%'>".$series->project['created_at']."</td>
                                                    <td class='text-primary' style='width:10%'>".$series->series['number_of_seasons']."</td>
                                                    <td class='text-primary' style='width:10%'>".$series->series['number_of_episodes']."</td>
                                                    <td style='width:10%'>
                                                        <form method='post' action='../producer/editSeries.php'>
                                                            <input type='hidden' name='seriesId' value='".$series->series['id']."'>
                                                            <button type='submit' class='btn btn-secondary'>
                                                                edit
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td style='width:10%'>                                                       
                                                        <form method='post' action='../producer/handleOurSeries.php'>
                                                            <input type='hidden' name='projectId' value='".$series->project['id']."'>
                                                            <button type='submit' class='btn btn-danger'>
                                                                delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>";
                                                $counter++;
                                            }
                                        }
                                        else print "<tr><td>You don't have create any series</td><td></td><td></td><td></td><td></td><td></td></tr>";
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>