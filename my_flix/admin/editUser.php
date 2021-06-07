<?php 

include_once '../admin/admin-dashboard.php';
include_once '../database/admin_context.php';


if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html");
    exit;
}
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}

if(isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['userIdToUpdate']) && isset($_POST['oldUserName'])){
    UpdateUser($user, $_POST['username'], $_POST['fullname'], $_POST['email'], $_POST['userIdToUpdate'], $_POST['oldUserName']);
    header("Location: ../admin/home.php");
    exit;
}

$userToEdit = GetUserById($user, $_POST['userToEditId']);


?>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="row">
                <div class="col-12">
                    <div class="bg-dark text-white h3 p-2 border">
                        <p class="text-center">Edit <?php if($userToEdit['role_id'] == 2){print "producer ";}else print "user "; print $userToEdit['username']; ?></p>
                        <form action="../admin/editUser.php" method="post">
                            <div class="h4">
                                Username
                                <input type="text" class="form-control" name="username" value="<?php print $userToEdit['username'] ?>" required>
                            </div>
                            <div class="h4">
                                Full name
                                <input type="text" class="form-control" name="fullname" value="<?php print $userToEdit['fullname'] ?>" required>
                            </div>
                            <div class="h4">
                                Email
                                <input type="email" class="form-control" name="email" value="<?php print $userToEdit['email'] ?>" required>
                            </div>
                            <input type="hidden" name="userIdToUpdate" value="<?php print $userToEdit['id'] ?>">
                            <input type="hidden" name="oldUserName" value="<?php print $userToEdit['username'] ?>">
                            <div class="text-center">
                                <button type="submit" class="w-50 btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>