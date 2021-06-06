<?php
    include_once "../database/authenticate_context.php";


    if(isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['role']) && isset($_POST['username']) && isset($_POST['password'])){
        $newUser = new stdClass();
        $newUser->fullname = $_POST['fullName'];
        $newUser->role = $_POST['role'];
        $newUser->username = $_POST['username'];
        $newUser->password = $_POST['password'];
        $newUser->email = $_POST['email'];

       if(createUser($newUser)){
        header("Location: ../authentication/login.html?result=usercreated");
        exit;
       }
       
    }
?>


<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="description" content="MyFlix, is a project for DataBase2 Class" >
    <meta name="author" content="Vasileios Georgoulas">
    <meta name="keywords" content="HTML,CSS,JavaScript, PHP">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="../JavaScriptFunctions.js"></script>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-6">  
            <div class="row">
                <div class="col-12 bg-dark text-white">
                    <span class="h2">Register Form</span>
                    <form action="../authentication/registration.php" method="post">
                        <div class="bg-white text-dark text-left h5">
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="text-left">Full name</span>
                                    <input type="text" class="form-control" name="fullName" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="text-left">Email</span>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="text-left">Role</span>
                                    <select class="form-select" name="role">
                                        <?php 
                                            foreach(GetUserRoles() as $role){
                                                if($role['id'] != 1){
                                                    print "<option value='".$role['id']."'>".$role['title']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="text-left">Username</span>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 ">
                                    <span class="text-left">Password</span>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit w-50" class="btn btn-primary">
                                Save new user
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>