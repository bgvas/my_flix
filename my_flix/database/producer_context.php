<?php
   
    include_once "Connect.php";


  function GetAllMoviesByProducer($user){
      $connect = ConnectToDB($user['username'], '1111');
      $sql = "SELECT * FROM movies_by_producers WHERE user_id = ".$user['id'];
      if($sqlResult = mysqli_query($connect, $sql)){
          $moviesArray = [];
          while($producer = mysqli_fetch_array($sqlResult)){
            $movie = new stdClass();
            $movie->movie = GetMovieById($user, $producer['movie_id']);
            $movie->project = GetProjectById($user, $producer['project_id']);
            $moviesArray[] = $movie;
          }
          DisconnectFromDB($connect);
          return $moviesArray;
      }
  }

  function GetAllSeriesByProducer($user){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM series_by_producers WHERE user_id = ".$user['id'];
    if($sqlResult = mysqli_query($connect, $sql)){
        $seriesArray = [];
        while($producer = mysqli_fetch_array($sqlResult)){
          $series = new stdClass();
          $series->series = GetSeriesById($user, $producer['series_id']);
          $series->project = GetProjectById($user, $producer['project_id']);
          $seriesArray[] = $series;
        }
        DisconnectFromDB($connect);
        return $seriesArray;
    }
}


  function GetMovieById($user, $movieId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM movies WHERE id = ".$movieId;
    if($sqlResult = mysqli_query($connect, $sql)){
        while($movie = mysqli_fetch_array($sqlResult)){
            return $movie;
        }
        DisconnectFromDB($connect);
    }
  }

  function GetSeriesById($user, $seriesId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM series WHERE id = ".$seriesId;
    if($sqlResult = mysqli_query($connect, $sql)){
        while($series = mysqli_fetch_array($sqlResult)){
            return $series;
        }
        DisconnectFromDB($connect);
    }
  }


  function GetProjectById($user, $id){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM visual_project WHERE id = ".$id;
    if($sqlResult = mysqli_query($connect, $sql)){
        while($project = mysqli_fetch_array($sqlResult)){
            return $project;
        }
        DisconnectFromDB($connect);
    }
  }


  function DeleteProjectById($user, $id){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "DELETE FROM visual_project WHERE id = ".$id;
    mysqli_query($connect, $sql);
    DisconnectFromDB($connect);
  }

function GetCategoriesOfMovie($user, $movieId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM category_of_movie WHERE movie_id = ".$movieId;
    if($sqlResult = mysqli_query($connect, $sql)){
        $categoriesArray = [];
        while($categoryOfMovie = mysqli_fetch_array($sqlResult)){
            $sqlCategory = "SELECT * FROM categories WHERE id = ".$categoryOfMovie['movie_id'];
            if($resultCategory = mysqli_query($connect, $sqlCategory)){
                while($category = mysqli_fetch_array($resultCategory)){
                    $categoriesArray[] = $category;
                }
            }
        }
        DisconnectFromDB($connect);
        return $categoriesArray;
    }
}

function UpdateProject($user, $title, $description, $createdAt, $projectId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "UPDATE visual_project set title = '$title', description = '$description', created_at = '$createdAt' WHERE id = ".$projectId;
    mysqli_query($connect, $sql);
}

function UpdateMovie($user, $movieLong, $movieId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "UPDATE movies set time_long = '$movieLong' WHERE id = ".$movieId;
    mysqli_query($connect, $sql);
}

function UpdateSeries($user, $seriesSeasons, $seriesId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "UPDATE series set number_of_seasons = '$seriesSeasons' WHERE id = ".$seriesId;
    mysqli_query($connect, $sql);
}

function InsertMovieCategories($user, $categoryId, $movieId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "INSERT INTO category_of_movie (movie_id, category_id) VALUES($movieId, $categoryId)";
    mysqli_query($connect, $sql);
}

function InsertSeriesCategories($user, $addCategory, $seriesId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "INSERT INTO category_of_series (series_id, category_id) VALUES($seriesId, $addCategory)";
    mysqli_query($connect, $sql);
}

function InsertNewEpisode($user, $newEpisodeTimeLong, $seriesId){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "INSERT INTO episodes (series_id, time_long) VALUES($seriesId, $newEpisodeTimeLong)";
    mysqli_query($connect, $sql);
}

function GetAllParticipantRoles($user){
    $connect = ConnectToDB($user['username'], '1111');
    $sql = "SELECT * FROM participant_role";
    if($sqlResult = mysqli_query($connect, $sql)){
        $rolesArray = [];
        while($role = mysqli_fetch_array($sqlResult)){
            $rolesArray[] = $role;
        }
        return $rolesArray;
    }
}


function AddNewMovie($user, $title, $description, $createdAt, $long, $category, $participant, $participantRole){

    $connect = ConnectToDB($user['username'], '1111');
    $projectId = 0;
    $movieId = 0;
    $participantId = 0;
    
    $sqlProject = "INSERT INTO visual_project (title, description, created_at) VALUES ('$title', '$description', '$createdAt')";
    if($resultProject = mysqli_query($connect, $sqlProject)){
        $sqlProjectId = "SELECT id FROM visual_project WHERE title = '$title'";
        if($resultProjectId = mysqli_query($connect, $sqlProjectId)){
            while($newProject = mysqli_fetch_array($resultProjectId)){
                $projectId = $newProject['id'];
            }
        }
    }

    $sqlMovie = "INSERT INTO movies (project_id, time_long) VALUES ($projectId, $long)";
    if($resultMovie = mysqli_query($connect, $sqlMovie)){
        $sqlNewMovie = "SELECT id FROM movies WHERE project_id = ".$projectId;
        if($resultNewMovie = mysqli_query($connect, $sqlNewMovie)){
            while($newMovie = mysqli_fetch_array($resultNewMovie)){
                $movieId = $newMovie['id'];
            }
        }
    }

    $sqlMoviesOfProducer = "INSERT INTO movies_by_producers (movie_id, project_id, user_id) VALUES ($movieId, $projectId, ".$user['id'].")";
    mysqli_query($connect, $sqlMoviesOfProducer);

    $sqlMovieCategory = "INSERT INTO category_of_movie (movie_id, category_id) VALUES ($movieId, $category)";
    mysqli_query($connect, $sqlMovieCategory);

    $participantFromDb = GetParticipantByParticipantName($user, $participant);
    
    if($participantFromDb == null){
        $sqlNewParticipant = "INSERT INTO participants (full_name) VALUES ('$participant')";
        if(mysqli_query($connect, $sqlNewParticipant)){
            $sqlNewParticipant = "SELECT id FROM participants ORDER BY id DESC LIMIT 1";
            if($resultNewParticipant = mysqli_query($connect, $sqlNewParticipant)){
                while($newParticipant = mysqli_fetch_array($resultNewParticipant)){
                    $participantId = $newParticipant['id'];
                }
            }
        }
    }
    else {
        $participantId = $participantFromDb['id'];
    }

    $sqlParticipantOfMovie = "INSERT INTO participants_of_movie (movie_id, participant_id, role_id) VALUES ($movieId, $participantId, $participantRole)";
    mysqli_query($connect, $sqlParticipantOfMovie); 
}

function GetParticipantByParticipantName($user, $participant){
    $connect = ConnectToDB($user['username'], '1111');
    $sqlSearch = "SELECT * FROM participants WHERE full_name LIKE '%$participant%' LIMIT 1";
    if($sqlResult = mysqli_query($connect,$sqlSearch)){
        while($participant = mysqli_fetch_array($sqlResult)){
            DisconnectFromDB($connect);
            return $participant;
        }
    }
}