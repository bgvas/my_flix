<?php
ob_start();
session_start();
include_once "connect.php";
include_once "../helpers/auth-helper.php";


function createUser($newUser) {
    if ($newUser !== "") {
        $connect = ConnectToDB('root', '');

        $pass = Hashing($newUser->password);
        $token = GenerateToken();

        $sql = "INSERT INTO users (username, password, email, fullname, token, role) values ('$newUser->username', '$pass', '$newUser->email', '$newUser->fullname', '$token', '$newUser->role')";
        if(!$result = mysqli_query($connect, $sql)){
            DisconnectFromDB($connect);
            return false;
        }

        $sql = "CREATE USER '$newUser->username'@localhost IDENTIFIED BY '$newUser->password'";
        if(!$result = mysqli_query($connect, $sql)) {
            DisconnectFromDB($connect);
            return false;
        }
        DisconnectFromDB($connect);
        return true;
    }
}


function authenticateUser($username, $password) {

    $connect = ConnectToDB($username, '1111');
    $pass = Hashing($password);

    $sql = "SELECT * FROM users WHERE username ='$username' AND password='$pass'";

    if($result = mysqli_query($connect, $sql)){
        if(mysqli_num_rows($result) <= 0){
            DisconnectFromDB($connect);
            print "<script>console.log('not match')</script>";
            return false;
        }
        else {
            $token = GenerateToken();
            $_SESSION['token'] = $token;
            while ($row = mysqli_fetch_array($result)) {
                $sql = "UPDATE users SET token = '$token' WHERE id = '$row[id]'";
                if ($sqlResult = mysqli_query($connect, $sql)) {
                    DisconnectFromDB($connect);
                    return true;
                }
            }
            print "<script>console.log('update problem')</script>";
            DisconnectFromDB($connect);
            return false;
        }
    }
    else{
        print "<script>console.log('Select problem')</script>";
        DisconnectFromDB($connect);
        return false;
    }
}


function getUserByUsernameAndPassword($username, $password) {

        $connect = ConnectToDB($username, '1111');
        $pass = Hashing($password);

        $sql = "SELECT * FROM users WHERE username ='$username' AND password='$pass'";

        if($result = mysqli_query($connect, $sql)){
            while ($row = mysqli_fetch_array($result)) {
                return $row;
            }
        }
}

