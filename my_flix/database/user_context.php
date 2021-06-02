<?php
   
    include_once "Connect.php";


    function GetUserByToken($token)
    {
        $connect = ConnectToDB('root', '');
        $sql = "SELECT * FROM users WHERE token ='$token'";
        if ($result = mysqli_query($connect, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                DisconnectFromDB($connect);
                return $row;
            }
        } else {
            DisconnectFromDB($connect);
        }
    }

    function GetUserByUserId($username, $id)
    {
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT * FROM users WHERE id = ".$id;
        if ($result = mysqli_query($connect, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                DisconnectFromDB($connect);
                return $row;
            }
        } else {
            DisconnectFromDB($connect);
        }
    }

    function GetAllMovies($username){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT * FROM movies ";
        if($result = mysqli_query($connect, $sql)){
            $movies = [];
            while ($row = mysqli_fetch_array($result)) {
               $movie = new stdClass();
               $movie->id = $row['id'];
               $project = GetProjectDetailsById($username, $row['project_id']);
                if ($project != null) {
                    $movie->title = $project->title;
                    $movie->year = $project->year;
                    $movie->description = $project->description;
                    $movie->valuation = $project->valuation;
                }
                $categories = GetCategoriesOfMovieByMovieId($username, $row['id']);
                if($categories == null) {
                    $movie->categories = "";
                }
                else {
                    $movie->categories = $categories;
                }
                $movies[] = $movie;
            }
            DisconnectFromDB($connect);
            return $movies;
        }
    }

function GetAllSeries($username){
    $connect = ConnectToDB($username, '1111');
    $sql = "SELECT * FROM series ";
    if($result = mysqli_query($connect, $sql)){
        $seriesArray = [];
        while ($row = mysqli_fetch_array($result)) {
            $series = new stdClass();
            $series->id = $row['id'];
            $series->seasons = $row['number_of_seasons'];
            $series->episodes = $row['number_of_episodes'];
            $project = GetProjectDetailsById($username, $row['project_id']);
            if ($project != null) {
                $series->title = $project->title;
                $series->year = $project->year;
                $series->description = $project->description;
                $series->valuation = $project->valuation;
            }
            $categories = GetCategoriesOfSeriesBySeriesId($username, $row['id']);
            if($categories == null) {
                $series->categories = "";
            }
            else {
                $series->categories = $categories;
            }
            $seriesArray[] = $series;
        }
        DisconnectFromDB($connect);
        return $seriesArray;
    }
}

    function GetProjectDetailsById($username, $id) {
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT * FROM visual_project WHERE id = ".$id;
        if($result = mysqli_query($connect, $sql)){
            $projectDetails = new stdClass();
            while($project = mysqli_fetch_array($result)){
               $projectDetails->id = $project['id'];
               $projectDetails->title = $project['title'];
               $projectDetails->description = $project['description'];
               $projectDetails->year = $project['created_at'];
               $projectDetails->valuation = $project['valuation'];
            }
            DisconnectFromDB($connect);
            return $projectDetails;
        }
    }

    function GetCategoriesOfMovieByMovieId($username, $id) {
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT category_id FROM category_of_movie WHERE movie_id = ".$id;
        if($result = mysqli_query($connect, $sql)){
            $categories = '';
            while($movie = mysqli_fetch_array($result)){
               $categorySql = "SELECT title FROM categories WHERE id = ".$movie['category_id'];
               if($categoryResult = mysqli_query($connect, $categorySql)){
                   while($category = mysqli_fetch_array($categoryResult)) {
                       $categories .= $category['title']." ";
                   }
                  
               }
            }
            DisconnectFromDB($connect);
            return $categories;
        }
    }

    function GetCategoriesOfSeriesBySeriesId($username, $id) {
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT category_id FROM category_of_series WHERE series_id = ".$id;
        if($result = mysqli_query($connect, $sql)){
            $categories = '';
            while($series = mysqli_fetch_array($result)){
                $categorySql = "SELECT title FROM categories WHERE id = ".$series['category_id'];
                if($categoryResult = mysqli_query($connect, $categorySql)){
                    while($category = mysqli_fetch_array($categoryResult)) {
                        $categories .= $category['title']." ";
                    }
                }
            }
            DisconnectFromDB($connect);
            return $categories;
        }
    }

    function GetMovieCommentsByMovieId($username, $id){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT comment_id FROM comments_for_movie WHERE movie_id = ".$id;
        if($result = mysqli_query($connect, $sql)){
            $commentsArray = [];
            while($comment = mysqli_fetch_array($result)){
                $commentsSql = "SELECT comment, userId FROM comments WHERE id = ".$comment['comment_id'];
                if($commentsResult = mysqli_query($connect, $commentsSql)){
                    while($comments = mysqli_fetch_array($commentsResult)){
                        $comment = new stdClass();
                        $comment->userId = $comments['userId'];
                        $comment->comment = $comments['comment'];
                        $commentsArray[] = $comment;
                    }
                }
            }
        }
        DisconnectFromDB($connect);
        return $commentsArray;
    }


    function GetSeriesCommentsBySeriesId($username, $id){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT comment_id FROM comments_for_series WHERE series_id = ".$id;
        if($result = mysqli_query($connect, $sql)){
            $commentsArray = [];
            while($comment = mysqli_fetch_array($result)){
                $commentsSql = "SELECT comment, userId FROM comments WHERE id = ".$comment['comment_id'];
                if($commentsResult = mysqli_query($connect, $commentsSql)){
                    while($comments = mysqli_fetch_array($commentsResult)){
                        $comment = new stdClass();
                        $comment->userId = $comments['userId'];
                        $comment->comment = $comments['comment'];
                        $commentsArray[] = $comment;
                    }
                }
            }
            DisconnectFromDB($connect);
            return $commentsArray;
        }
        
    }

    function GetEpisodeCommentsByEpisodeId($username, $id){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT comment_id FROM comments_for_episode_of_series WHERE episode_id = ".$id;
        if($result = mysqli_query($connect, $sql)){
            $commentsArray = [];
            while($comment = mysqli_fetch_array($result)){
                $commentsSql = "SELECT comment, userId FROM comments WHERE id = ".$comment['comment_id'];
                if($commentsResult = mysqli_query($connect, $commentsSql)){
                    while($comments = mysqli_fetch_array($commentsResult)){
                        $comment = new stdClass();
                        $comment->userId = $comments['userId'];
                        $comment->comment = $comments['comment'];
                        $commentsArray[] = $comment;
                    }
                }
            }
            DisconnectFromDB($connect);
            return $commentsArray;
        }
        
    }

    function GetValuationForEpisodeByEpisodeId($username, $episodeId){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT valuation FROM episodes WHERE id = ".$episodeId;
        if($result = mysqli_query($connect, $sql)){
            while($episode = mysqli_fetch_array($result)){
                return $episode['valuation'];
            }
        }
    }

    function SaveSeriesFeedBack($username, $userId, $comment, $valuation, $seriesId){
        $connect = ConnectToDB($username, '1111');
        if($comment != null || $valuation != 0){
            $sqlComment = "INSERT INTO comments (comment, userId, valuation)value('$comment', $userId, $valuation)";
            if($resultComment = mysqli_query($connect, $sqlComment)){
                $sqlCommentId = "SELECT id FROM comments WHERE userId = '$userId' ORDER BY id DESC LIMIT 1";
                if($commentIdResult = mysqli_query($connect, $sqlCommentId)){
                    while($commentId = mysqli_fetch_array($commentIdResult)){
                        $sqlSeriesComment = "INSERT INTO comments_for_series(series_id, comment_id)VALUE(".$seriesId.",".$commentId['id'].")";
                        if($sqlSeriesCommentResult = mysqli_query($connect, $sqlSeriesComment)){
                        }
                    }
                }
            }
            DisconnectFromDB($connect);
            return false;
        }
        
    }

    function SaveEpisodeFeedBack($username, $userId, $comment, $valuation, $seriesId, $episodeId){
        $connect = ConnectToDB($username, '1111');
        if($comment != null || $valuation != 0){
            $sqlComment = "INSERT INTO comments (comment, userId, valuation)value('$comment', $userId, $valuation)";
            if($resultComment = mysqli_query($connect, $sqlComment)){
                $sqlCommentId = "SELECT id FROM comments WHERE userId = '$userId' ORDER BY id DESC LIMIT 1";
                if($commentIdResult = mysqli_query($connect, $sqlCommentId)){
                    while($commentId = mysqli_fetch_array($commentIdResult)){
                        $sqlEpisodeComment = "INSERT INTO comments_for_episode_of_series(series_id, comment_id, episode_id)VALUE(".$seriesId.",".$commentId['id'].",".$episodeId.")";
                        if($sqlEpisodeCommentResult = mysqli_query($connect, $sqlEpisodeComment)){
                        }
                    }
                }
            }
            DisconnectFromDB($connect);
            return false;
        } 
    }


    function SaveMovieFeedBack($username, $userId, $comment, $valuation, $schedule, $movieId){
        $connect = ConnectToDB($username, '1111');
        if($comment != null || $valuation != 0){
            $sqlComment = "INSERT INTO comments (comment, userId, valuation)value('$comment', $userId, $valuation)";
            if($resultComment = mysqli_query($connect, $sqlComment)){
                $sqlCommentId = "SELECT id FROM comments WHERE userId = '$userId' ORDER BY id DESC LIMIT 1";
                if($commentIdResult = mysqli_query($connect, $sqlCommentId)){
                    while($commentId = mysqli_fetch_array($commentIdResult)){
                        $sqlMovieComment = "INSERT INTO comments_for_movie(movie_id, comment_id)VALUE(".$movieId.",".$commentId['id'].")";
                        if($sqlMovieCommentResult = mysqli_query($connect, $sqlMovieComment)){
                        }
                    }
                }
            }
        }
        if($schedule != null){
            $sqlSchedule = "INSERT INTO schedule_watching_movie (movie_id, user_id, date) VALUES (".$movieId.",".$userId.",'".date('Y-m-d')."')";
            if($scheduleResult = mysqli_query($connect, $sqlSchedule)){
                DisconnectFromDB($connect);
                return true;
            }
        }
        DisconnectFromDB($connect);
        return false;
    }
    

    function GetMovieMessagesByUserId($username, $userId) {
        $dateNow = date("Y-m-d");
        $connect = ConnectToDB($username, '1111');
        $sqlMessages = "SELECT movie_id FROM schedule_watching_movie WHERE user_id = ".$userId." AND date = '".$dateNow."'";
        if($messagesResult = mysqli_query($connect, $sqlMessages)){
            $moviesArray = [];
            while($message = mysqli_fetch_array($messagesResult)){
                $sqlMovie = "SELECT project_id FROM movies WHERE id = ".$message['movie_id'];
                if($movieResult = mysqli_query($connect, $sqlMovie)){
                    while($movie = mysqli_fetch_array($movieResult)){
                        $sqlProject = "SELECT title FROM visual_project WHERE id = ".$movie['project_id'];
                        if($projectResult = mysqli_query($connect, $sqlProject)){
                            while($project = mysqli_fetch_array($projectResult)){
                                $moviesArray [] = $project['title'];
                            }
                        }
                    }
                }
            }
            DisconnectFromDB($connect);
            return $moviesArray;
        }
    }

    function GetMovieParticipantsByMovieId($username, $movieId){
        $connect = ConnectToDB($username, '1111');
        $sqlMovieParticipants = "SELECT participant_id FROM `movie-participants` WHERE movie_id = ".$movieId;
        if($participantResults = mysqli_query($connect, $sqlMovieParticipants)){
            $participantsArray = [];
            while($participant = mysqli_fetch_array($participantResults)){
                $sqlActor = "SELECT full_name FROM participants WHERE id = ".$participant['participant_id'];
                if($sqlActorResult = mysqli_query($connect, $sqlActor)){
                    while($actor = mysqli_fetch_array($sqlActorResult)){
                        $participantsArray[] = $actor['full_name'];
                    }
                }
            }
            DisconnectFromDB($connect);
            return $participantsArray;
        }
    }

    function GetSeriesParticipantsBySeriesId($username, $seriesId){
        $connect = ConnectToDB($username, '1111');
        $sqlSeriesParticipants = "SELECT participant_id FROM participants_of_series WHERE series_id = ".$seriesId;
        if($participantResults = mysqli_query($connect, $sqlSeriesParticipants)){
            $participantsArray = [];
            while($participant = mysqli_fetch_array($participantResults)){
                $sqlActor = "SELECT full_name FROM participants WHERE id = ".$participant['participant_id'];
                if($sqlActorResult = mysqli_query($connect, $sqlActor)){
                    while($actor = mysqli_fetch_array($sqlActorResult)){
                        $participantsArray[] = $actor['full_name'];
                    }
                }
            }
            DisconnectFromDB($connect);
            return $participantsArray;
        }
    }


    function GetAllEpisodesOfSeriesBySeriesId($username, $seriesId){
        $connect = ConnectToDB($username, '1111');
        $sqlEpisodesSeries = "SELECT id FROM episodes WHERE series_id = ".$seriesId;
        if($episodesSeriesResult = mysqli_query($connect, $sqlEpisodesSeries)){
            $episodesArray = [];
            while($episode = mysqli_fetch_array($episodesSeriesResult)){
                $episodesArray[] = $episode['id'];
            }
            DisconnectFromDB($connect);
            return $episodesArray;
        }

    }


