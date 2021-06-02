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
                    <?php 
                        if(count($movies = GetMovieMessagesByUserId($user['username'], $user['id'])) == 0){
                            print "<p style='font-weight: bold'>No reminder for watching movies</p>";
                        }
                        else {
                            $movies = GetMovieMessagesByUserId($user['username'], $user['id']);
                            print "<p class='text-info' style='font-weight: bold'>We remind you to watch that movies, as you asked:</p>";
                            foreach($movies as $movie){
                                print "<p> - <span class='h3'>".$movie."  </span><button class='ml-2 btn btn-outline-info'>  watch >>></button></p>";
                            }
                        }             
                        
                    ?>
                    <hr>
                    <p style='font-weight: bold'>No reminder for watching series</p>
                </div>
            </div>
        </div>
    </div>
</div>