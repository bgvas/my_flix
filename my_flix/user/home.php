<?php 

include_once '../user/user-dashboard.php';


if(!isset($_SESSION['token'])) {
    header("Location: ../authentication/login.html");
    exit;
}
$user = GetUserByToken($_SESSION['token']);

if($user == null){
    header("Location: ../authentication/login.html");
    exit;
}


?>

<div class="container">
    <div class="row mt-4 justify-content-center">
        <div class="col-8">
            <div class="border bg-dark">
                <div class="text-white h4 text-center p-2">
                    Messages Box
                </div>
                <div class="bg-white p-2">
                    Body
                </div>
            </div>
        </div>
    </div>
</div>