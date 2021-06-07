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

// take agreement for delete //
if(isset($_POST['userToDeleteId'])){
    $userId = $_POST['userToDeleteId'];
        print "<div class='container-fluid mt-5'>
        <div class='row justify-content-center'>
            <div class='col-3'>
                <div class='row'>
                    <div class='col-12'>
                        <div class='bg-dark text-danger text-center h3 p-2 border border-danger'>
                            <span style='font-weight:bold'>
                                Do you want to Delete this user? 
                                <form action='../admin/home.php' method='post'>
                                    <input type='hidden' name='delete' value='true'>
                                    <input type='hidden' name='userIdToDelete' value='".$userId."'>
                                    <input type='hidden' name='usernameToDelete' value='".$_POST['usernameForDelete']."'>
                                    <button type='submit' class='btn btn-danger'>Delete anyway</button>
                                    <a href='../admin/home.php' class='btn btn-secondary' role='button'>Cancel</a> 
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    exit;
}

// take agreement for delete //
if(isset($_POST['producerToDeleteId'])){
    $userId = $_POST['producerToDeleteId'];
        print "<div class='container-fluid mt-5'>
        <div class='row justify-content-center'>
            <div class='col-3'>
                <div class='row'>
                    <div class='col-12'>
                        <div class='bg-dark text-danger text-center h3 p-2 border border-danger'>
                            <span style='font-weight:bold'>
                                Do you want to Delete this producer? 
                                <form action='../admin/home.php' method='post'>
                                    <input type='hidden' name='delete' value='true'>
                                    <input type='hidden' name='userIdToDelete' value='".$userId."'>
                                    <input type='hidden' name='usernameToDelete' value='".$_POST['producerNameToDelete']."'>
                                    <button type='submit' class='btn btn-danger'>Delete anyway</button>
                                    <a href='../admin/home.php' class='btn btn-secondary' role='button'>Cancel</a> 
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    exit;
}

if(isset($_POST['delete'])){
    DeleteUserById($user, $_POST['userIdToDelete'], $_POST['usernameToDelete']);
    header("Location: ../admin/home.php");
    exit;
}





?>

<div class="container-fluid">
    <div class="row mt-4 justify-content-center">
        <div class="col-6">
            <div class="row">
                <div class="col-6">
                    <div class="bg-dark text-white h4 p-2 text-center border">
                        List Of Users
                        <div class="bg-white text-dark">
                            <table class="w-100">
                                <tr class="h5">
                                    <td>Index</td><td>Full name</td><td>User name</td><td></td><td></td>
                                </tr>
                                    <?php 
                                    $counter = 1;
                                    $allUsers = GetAllUsers($user);
                                    if(count($allUsers) > 0){
                                        foreach($allUsers as $users){
                                            print "<tr class='h6'>
                                                        <td>".$counter."</td>
                                                        <td>".$users['fullname']."</td>
                                                        <td>".$users['username']."</td>
                                                        <td>
                                                            <form method='post' action='../admin/editUser.php'>
                                                                <input type='hidden' name='userToEditId' value='".$users['id']."'>
                                                                <button type='submit' class='btn btn-secondary'>
                                                                    edit
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form method='post' action='../admin/home.php'>
                                                                <input type='hidden' name='userToDeleteId' value='".$users['id']."'>
                                                                <input type='hidden' name='usernameForDelete' value='".$users['username']."'>
                                                                <button type='submit' class='btn btn-danger'>
                                                                    delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>";
                                            $counter++;
                                        }
                                    }
                                    else print "<a>No user found</a>"; 
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-dark text-white h4 p-2 text-center border">
                        List Of Producers
                        <div class="bg-white text-dark h5">
                        <table class="w-100">
                                <tr class="h5">
                                    <td>Index</td><td>Full name</td><td>User name</td><td></td><td></td>
                                </tr>
                                    <?php 
                                    $counter = 1;
                                    $allProducers = GetAllProducers($user);
                                    if(count($allProducers) > 0){
                                        foreach($allProducers as $producer){
                                            print "<tr class='h6'>
                                                        <td>".$counter."</td>
                                                        <td>".$producer['fullname']."</td>
                                                        <td>".$producer['username']."</td>
                                                        <td>
                                                            <form method='post' action='../admin/editUser.php'>
                                                                <input type='hidden' name='userToEditId' value='".$producer['id']."'>
                                                                <button type='submit' class='btn btn-secondary'>
                                                                    edit
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form method='post' action='../admin/home.php'>
                                                                <input type='hidden' name='producerToDeleteId' value='".$producer['id']."'>
                                                                <input type='hidden' name='producerNameToDelete' value='".$producer['username']."'>
                                                                <button type='submit' class='btn btn-danger'>
                                                                    delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>";
                                            $counter++;
                                        }
                                    }
                                    else print "<a>No producer found</a>"; 
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <a href="../admin/newUser.php" role="button" class="btn btn-secondary w-100 p-2 border border-danger">
                        + Add new User or producer
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>