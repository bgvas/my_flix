<?php

function ConnectToDB($user, $pass){

    $host = "localhost";
    $database = "myflix_db";


    $connect = mysqli_connect($host, $user, $pass, $database);
    if(!$connect) {
        header("Location: ../authentication/login.html?result=errorlogin");
        exit;
    }

    return $connect;

}


function DisconnectFromDB($conn){

    $conn -> close();
}

