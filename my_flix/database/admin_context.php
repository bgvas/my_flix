<?php
   
    include_once "Connect.php";
    include_once "../helpers/auth-helper.php";



function GetAllUsers($user){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM users WHERE role_id = 3";
    if($results = mysqli_query($connect, $sql)){
        $usersArray = [];
        while($users = mysqli_fetch_array($results)){
            $usersArray[] = $users;
        }
        DisconnectFromDB($connect);
        return $usersArray;
    }
}

function GetAllProducers($user){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM users WHERE role_id = 2";
    if($results = mysqli_query($connect, $sql)){
        $usersArray = [];
        while($users = mysqli_fetch_array($results)){
            $usersArray[] = $users;
        }
        DisconnectFromDB($connect);
        return $usersArray;
    }
}

function DeleteUserById($user, $userId, $username){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "DELETE FROM users WHERE id = ".$userId;
    if(mysqli_query($connect, $sql)){
        $sqlDelete = "DROP USER '$username'@'localhost'";
        mysqli_query($connect, $sqlDelete);
    }
}

function GetUserById($user, $userId){
    $connect = ConnectToDB($user['username'], '1111');
    $sqlUser = "SELECT * FROM users WHERE id = ".$userId;
    if($resultsUser = mysqli_query($connect, $sqlUser)){
        while($user = mysqli_fetch_array($resultsUser)){
            return $user;
        }
        DisconnectFromDB($connect);
    }
}

function UpdateUser($user, $username, $fullname, $email, $userIdToUpdate, $oldUsername){
    $connect = ConnectToDB($user['username'], '1111');
    $sqlUser = "UPDATE users SET username = '$username', fullname = '$fullname', email = '$email' WHERE id = ".$userIdToUpdate;
    if(mysqli_query($connect, $sqlUser)){
        $sqlDbUser = "RENAME USER '$oldUsername'@'localhost' TO '$username'@'localhost'";
        mysqli_query($connect, $sqlDbUser);
    }
}


function createDbUser($username, $password, $role){
    $connect = ConnectToDB('root', '');
    $sql = "CREATE USER '$username'@'localhost' IDENTIFIED  BY '$password'";
    if($sqlResult = mysqli_query($connect, $sql)){
        if($role == 1){  // create admin
            $sqlPrivileges = "GRANT ALL PRIVILEGES ON `myflix_db`.* TO '$username'@'localhost' WITH GRANT OPTION";
            if($resultPrivileges = mysqli_query($connect, $sqlPrivileges)){
                return true;
            }
        }
        if($role == 2){ // create producer
            $sqlPrivileges[] = "
            GRANT USAGE ON *.* TO '$username'@'localhost' IDENTIFIED  '$password'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.* TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.movies_by_producers TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.series_by_producers TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`category_of_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`category_of_movie`  TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`categories` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`participant_role` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`movies` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`episodes` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`participants_of_movie` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, REFERENCES ON `myflix_db`.`participants` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`participants_of_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES ON `myflix_db`.`visual_project` TO '$username'@'localhost'";

            $done = false;
            foreach($sqlPrivileges as $privileges){
                if(mysqli_query($connect, $privileges)){
                    $done = true;
                }
                else $done = false;
            }
            return $done;
        }
        if($role == 3){ // create user
            $sqlPrivileges[] = "
            GRANT USAGE ON *.* TO '$username'@'localhost' IDENTIFIED  '$password'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.* TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE (valuation) ON `myflix_db`.`comments` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT ON `myflix_db`.`comments_for_episode_of_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.`favorite_movies` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`categories` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT ON `myflix_db`.`comments_for_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT (id, username, fullname), REFERENCES (id, username, fullname) ON `myflix_db`.`users` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`participants` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`category_of_movie` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`category_of_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.`schedule_watching_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.`favorite_series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT, UPDATE ON `myflix_db`.`schedule_watching_movie` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, UPDATE (valuation) ON `myflix_db`.`episodes` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`participants_of_movie` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`series` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT, INSERT ON `myflix_db`.`comments_for_movie` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`movies` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`visual_project` TO '$username'@'localhost'";
            $sqlPrivileges[] = "
            GRANT SELECT ON `myflix_db`.`participants_of_series` TO '$username'@'localhost'";

            $done = false;
            foreach($sqlPrivileges as $privileges){
                if(mysqli_query($connect, $privileges)){
                    $done = true;
                }
                else $done = false;
            }
            return $done;
        }
       
    }

}


function createUser($newUser) {
    if ($newUser != new stdClass()) {
        
        $connect = ConnectToDB('root', '');

        $pass = Hashing($newUser->password);
        $token = GenerateToken();

        $sql = "INSERT INTO users (username, password, email, fullname, token, role_id) values ('$newUser->username', '$pass', '$newUser->email', '$newUser->fullname', '$token', $newUser->role)";
        if($result = mysqli_query($connect, $sql)){
            if(createDbUser($newUser->username, '1111', $newUser->role)){
                return true;
            } 
        }
        
        DisconnectFromDB($connect);
        return false;
    }
}

function GetAllUserRoles(){
    $connect = ConnectToDB('root', '');
    $sql = "SELECT * FROM roles";
    if($sqlResult = mysqli_query($connect, $sql)){
        $roleArray = [];
        while($role = mysqli_fetch_array($sqlResult)){
            $roleArray[] = $role;
        }
        return $roleArray;
    }
}


