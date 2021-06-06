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


if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['createdAt']) && isset($_POST['movieLong']) && isset($_POST['category']) && isset($_POST['participant']) && isset($_POST['participantRole'])){
    AddNewMovie($user, $_POST['title'], $_POST['description'], $_POST['createdAt'], $_POST['movieLong'], $_POST['category'], $_POST['participant'], $_POST['participantRole']);
}


?>

<div class="container-fluid">
    <div class="row mt-4 justify-content-center">
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h3 p-2 border">
                        <p class="text-center">Add new Movie</p>
                        <form action = "../producer/newMovie.php" method = "post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-white text-dark h4 p-3 border">
                                    Title
                                    <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-white text-dark h4 p-3 border">
                                    Description
                                    <input type="text" name="description" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-white text-dark h4 p-3 border">
                                    Created at
                                        <select class="form-select" name="createdAt">
                                        <option>- select year -</option>
                                            <?php for($year = 2015; $year < 2022; $year++){
                                                    print "<option value=".$year.">".$year."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-white text-dark h4 p-3 border">
                                    Long
                                        <select name="movieLong" class="form-select">
                                            <option>-enter time-long in minutes-</option>
                                            <?php 
                                                for($minutes = 60; $minutes < 121; $minutes++){
                                                    print "<option value=".$minutes.">".$minutes."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-white text-dark h4 p-3 border">
                                    Category
                                        <select name="category" class="form-select">
                                            <option>-select a category-</option>
                                            <?php 
                                                foreach(GetAllCategories($user['username']) as $category){
                                                    print "<option class='form-control' value='".$category->id."'>".$category->title."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-white text-dark h4 p-3 border">
                                        Participants
                                        <input type="text" name="participant" class="form-control" required>
                                        <div class="bg-white text-dark h4 p-3 border">
                                            Role
                                            <select name="participantRole" class="form-select">
                                                <option>-select a role-</option>
                                                <?php 
                                                    foreach(GetAllParticipantRoles($user) as $role){
                                                        print "<option class='form-control' value='".$role['id']."'>".$role['role']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-50">Save New Movie</button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div> 
        </div>
    </div>
</div>