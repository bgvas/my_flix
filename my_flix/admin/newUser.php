<?php 
ob_start();
include_once '../database/admin_context.php';
include_once '../admin/admin-dashboard.php';

if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html");
    exit;
}
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}


if(isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])){
    $newUser = new stdClass();
    $newUser->username = $_POST['username'];
    $newUser->fullname = $_POST['fullname'];
    $newUser->email = $_POST['email'];
    $newUser->password = $_POST['password'];
    $newUser->role = $_POST['role'];
    createUser($newUser);
    header("Location: ../admin/home.php");
    exit;
}


?>

<div class="container-fluid">
    <div class="row mt-4 justify-content-center">
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h3 p-2 border">
                        <p class="text-center">Add new User Or Producer</p>
                        <form action="../admin/newUser.php" method="post">
                            <div class="h4">
                                Username
                                <input type="text" class="form-control" name="username"  required>
                            </div>
                            <div class="h4">
                                Full name
                                <input type="text" class="form-control" name="fullname"  required>
                            </div>
                            <div class="h4">
                                Email
                                <input type="email" class="form-control" name="email"  required>
                            </div>
                            <div class="h4">
                                Password
                                <input type="password" class="form-control" name="password"  required>
                            </div>
                            <div>
                                <select class="form-select" name="role">
                                        <?php 
                                            foreach(GetAllUserRoles() as $role){
                                                if($role['id'] != 1){
                                                    print "<option value='".$role['id']."'>".$role['title']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="w-50 btn btn-primary">Save Input</button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div> 
        </div>
    </div>
</div>