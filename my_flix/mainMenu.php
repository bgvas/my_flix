
<?php
require_once "../database/user_context.php";

session_start();
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <title>MyFlix</title>
</head>
<body>
<nav class="navbar navbar-light bg-dark">
        <div class="container-fluid">
            <div class="row w-100 text-white">
                <div class="col-6 text-left">
                    <h1>
                        MyFlix
                    </h1>
                </div>
                <div class="col-6" style="text-align: right">
                   <div class="row">
                        <div class="col-9 h1" style="text-align: right">
                            <a role="button" class="btn btn-outline-light text-white" href="../user/home.php" style="text-decoration: none">
                                Home
                            </a>
                        </div>
                        <div class="col-3">
                            <?php
                            if($user['role_id'] == 2) {
                                print "Producer: ".$user['fullname'];
                            }
                            else if($user['role_id'] == 3) {
                                print "User: ".$user['fullname'];
                            }
                            else {
                                print "Admin";
                            }
                            ?>
                        </div>
                   </div>
                </div>
            </div>
        </div>
</nav>


