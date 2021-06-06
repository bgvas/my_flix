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
        $sql = "SELECT username FROM users WHERE id = ".$id;
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
               $movie->long = $row['time_long'];
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

    function SaveSeriesFeedBack($username, $userId, $comment, $valuation, $seriesId, $favorite){
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
        }
        $favoriteSql = "INSERT INTO favorite_series (user_id, series_id, favorite)VALUE($userId, $seriesId, $favorite) ON DUPLICATE KEY UPDATE favorite = $favorite";
        if($favoriteResult = mysqli_query($connect, $favoriteSql)){
        }

        DisconnectFromDB($connect);
        
    }

    function SaveEpisodeFeedBack($username, $userId, $comment, $valuation, $seriesId, $episodeId, $episodeIndex, $schedule){
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
        }
        if($schedule != null){
            $schedule = date("Y-m-d", strtotime($schedule));
            $sqlSchedule = "INSERT INTO schedule_watching_series (series_id, episode_index, user_id, date) VALUES (".$seriesId.",".$episodeIndex.",".$userId.",'".$schedule."')";
            if($scheduleResult = mysqli_query($connect, $sqlSchedule)){
            }
        }
        DisconnectFromDB($connect);
       
    }


    function SaveMovieFeedBack($username, $userId, $comment, $valuation, $schedule, $movieId, $favorite){
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
            $date = date("Y-m-d", strtotime($schedule));
            $sqlSchedule = "INSERT INTO schedule_watching_movie (movie_id, user_id, date) VALUES (".$movieId.",".$userId.",'".$date."')";
            if($scheduleResult = mysqli_query($connect, $sqlSchedule)){
            }
        }
        $favoriteSql = "INSERT INTO favorite_movies (user_id, movie_id, favorite)VALUE($userId, $movieId, $favorite) ON DUPLICATE KEY UPDATE favorite = $favorite";
        if($favoriteResult = mysqli_query($connect, $favoriteSql)){
        }

        DisconnectFromDB($connect);
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

    function GetSeriesEpisodeMessagesByUserId($username, $userId) {
        $dateNow = date("Y-m-d");
        $connect = ConnectToDB($username, '1111');
        $sqlMessages = "SELECT series_id, episode_index FROM schedule_watching_series WHERE user_id = ".$userId." AND date = '".$dateNow."'";
        if($messagesResult = mysqli_query($connect, $sqlMessages)){
            $episodesArray = [];
            while($message = mysqli_fetch_array($messagesResult)){
                $sqlSeries = "SELECT project_id FROM series WHERE id = ".$message['series_id'];
                if($seriesResult = mysqli_query($connect, $sqlSeries)){
                    while($series = mysqli_fetch_array($seriesResult)){
                        $sqlProject = "SELECT title FROM visual_project WHERE id = ".$series['project_id'];
                        if($projectResult = mysqli_query($connect, $sqlProject)){
                            while($project = mysqli_fetch_array($projectResult)){
                                $seriesSchedule = new stdClass();
                                $seriesSchedule->episode = $message['episode_index'];
                                $seriesSchedule->title = $project['title'];
                                $episodesArray [] = $seriesSchedule;
                            }
                        }
                    }
                }
            }
            DisconnectFromDB($connect);
            return $episodesArray;
        }
    }




    function GetMovieParticipantsByMovieId($username, $movieId){
        $connect = ConnectToDB($username, '1111');
        $sqlMovieParticipants = "SELECT participant_id FROM `participants_of_movie` WHERE movie_id = ".$movieId;
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
        $sqlEpisodesSeries = "SELECT id, time_long FROM episodes WHERE series_id = ".$seriesId;
        if($episodesSeriesResult = mysqli_query($connect, $sqlEpisodesSeries)){
            $episodesArray = [];
            while($episode = mysqli_fetch_array($episodesSeriesResult)){
                $episodesArray[] = $episode;
            }
            DisconnectFromDB($connect);
            return $episodesArray;
        }

    }


    function IsFavoriteMovie($user, $movieId){
        $connect = ConnectToDB($user['username'], '1111');
        $sqlFavorite = "SELECT favorite FROM favorite_movies WHERE user_id = ".$user['id']." AND movie_id = ".$movieId;
        if($movieResult = mysqli_query($connect, $sqlFavorite)){
            while($movie = mysqli_fetch_array($movieResult)){
                return $movie['favorite'];
            }
        }
    }

    function IsFavoriteSeries($user, $seriesId){
        $connect = ConnectToDB($user['username'], '1111');
        $sqlFavorite = "SELECT favorite FROM favorite_series WHERE user_id = ".$user['id']." AND series_id = ".$seriesId;
        if($seriesResult = mysqli_query($connect, $sqlFavorite)){
            while($series = mysqli_fetch_array($seriesResult)){
                return $series['favorite'];
            }
        }
    }

    function GetAllFavoriteMoviesByUserId($user){
        $connect = ConnectToDB($user['username'], '1111');
        $sqlFavorite = "SELECT movie_id FROM favorite_movies WHERE user_id = ".$user['id']." AND favorite = 1";
        if($movieResult = mysqli_query($connect, $sqlFavorite)){
            $favoriteMoviesArray = [];
            while($movie = mysqli_fetch_array($movieResult)){
                $movieProjectSql = "SELECT project_id FROM movies WHERE id = ".$movie['movie_id'];
                if($movieProjectResult = mysqli_query($connect, $movieProjectSql)){
                    while($projectIdResult = mysqli_fetch_array($movieProjectResult)){
                        $projectSql = "SELECT title FROM visual_project WHERE id = ".$projectIdResult['project_id'];
                        if($projectResult = mysqli_query($connect, $projectSql)){
                            while($project = mysqli_fetch_array($projectResult)){
                                $favoriteMoviesArray[] = $project['title'];
                            }
                        }
                    }
                }
            }
            return $favoriteMoviesArray;
            DisconnectFromDB($connect);
        }
    }

    function GetAllFavoriteSeriesByUserId($user){
        $connect = ConnectToDB($user['username'], '1111');
        $sqlFavorite = "SELECT series_id FROM favorite_series WHERE user_id = ".$user['id']." AND favorite = 1";
        if($seriesResult = mysqli_query($connect, $sqlFavorite)){
            $favoriteSeriesArray = [];
            while($series = mysqli_fetch_array($seriesResult)){
                $seriesProjectSql = "SELECT project_id FROM series WHERE id = ".$series['series_id'];
                if($seriesProjectResult = mysqli_query($connect, $seriesProjectSql)){
                    while($projectIdResult = mysqli_fetch_array($seriesProjectResult)){
                        $projectSql = "SELECT title FROM visual_project WHERE id = ".$projectIdResult['project_id'];
                        if($projectResult = mysqli_query($connect, $projectSql)){
                            while($project = mysqli_fetch_array($projectResult)){
                                $favoriteSeriesArray[] = $project['title'];
                            }
                        }
                    }
                }
            }
            return $favoriteSeriesArray;
            DisconnectFromDB($connect);
        }
    }

    function GetAllMoviesAndSeriesByDate($user, $fromDate, $toDate){
        $connect = ConnectToDB($user['username'], '1111');
        $fromDate = "$fromDate"."-01-01"; 
        $toDate = "$toDate"."-12-31";
        $sqlSearch = "SELECT id, title FROM visual_project WHERE created_at BETWEEN '$fromDate' AND '$toDate'";
        if($sqlResult = mysqli_query($connect,$sqlSearch)){
            $projectsArray = [];
            while($project = mysqli_fetch_array($sqlResult)){
                $foundedProject = new stdClass();
                $foundedProject->title = $project['title'];
                $foundedProject->movie = GetMovieByProjectId($user['username'], $project['id']);
                $foundedProject->series = GetSeriesByProjectId($user['username'], $project['id']);
                $projectsArray[] = $foundedProject;
            }
            DisconnectFromDB($connect);
            return $projectsArray;
        }
        
    } 

    function GetMovieByProjectId($username, $projectId){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT * FROM movies WHERE project_id = ".$projectId;
        if($result = mysqli_query($connect, $sql)){
            $movie = new stdClass();
            while ($row = mysqli_fetch_array($result)) {
               $movie->id = $row['id'];
               $movie->long = $row['time_long'];
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
            }
            DisconnectFromDB($connect);
            return $movie;
        }
    }

    function GetSeriesByProjectId($username, $projectId){
        $connect = ConnectToDB($username, '1111');
        $sql = "SELECT * FROM series WHERE project_id = ".$projectId;
        if($result = mysqli_query($connect, $sql)){
            $series = new stdClass();
            while ($row = mysqli_fetch_array($result)) {
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
            }
            DisconnectFromDB($connect);
            return $series;
        }
    }

    function GetAllMoviesByParticipantName($username, $participant){
        $connect = ConnectToDB($username, '1111');
        $sqlSearch = "SELECT id, full_name FROM participants WHERE full_name LIKE '%$participant%' LIMIT 1";
        if($sqlResult = mysqli_query($connect,$sqlSearch)){
            $moviesArray = [];
            while($participant = mysqli_fetch_array($sqlResult)){
              $sqlMovie = "SELECT movie_id FROM participants_of_movie WHERE participant_id = ".$participant['id'];
               if($resultMovie = mysqli_query($connect, $sqlMovie)){
                   while($movie = mysqli_fetch_array($resultMovie)){
                        $addMovie = new stdClass();
                        $addMovie->movie = GetMovieByMovieId($username, $movie['movie_id']);
                        $addMovie->name = $participant['full_name'];
                        $moviesArray[] = $addMovie;
                   }
               }
            }
            DisconnectFromDB($connect);
            return $moviesArray;
        }
    }

    function GetAllSeriesByParticipantName($username, $participant){
        $connect = ConnectToDB($username, '1111');
        $sqlSearch = "SELECT id, full_name FROM participants WHERE full_name LIKE '%$participant%' LIMIT 1";
        if($sqlResult = mysqli_query($connect,$sqlSearch)){
            $seriesArray = [];
            while($participant = mysqli_fetch_array($sqlResult)){
              $sqlSeries = "SELECT series_id FROM participants_of_series WHERE participant_id = ".$participant['id'];
               if($resultSeries = mysqli_query($connect, $sqlSeries)){
                   while($series = mysqli_fetch_array($resultSeries)){
                        $addSeries = new stdClass();
                        $addSeries->series = GetSeriesBySeriesId($username, $series['series_id']);
                        $addSeries->name = $participant['full_name'];
                        $seriesArray[] = $addSeries;
                   }
               }
            }
            DisconnectFromDB($connect);
            return $seriesArray;
        }
    }

    function GetMovieByMovieId($username, $movieId){
        $connect = ConnectToDB($username, '1111');
        $sqlSearch = "SELECT * FROM movies WHERE id = ".$movieId;
        if($sqlResult = mysqli_query($connect, $sqlSearch)){
            $movie = new stdClass();
            while($movieResults = mysqli_fetch_array($sqlResult)){
                $movie->id = $movieId;
                $movie->long = $movieResults['time_long'];
                $movie->categories = GetCategoriesOfMovieByMovieId($username, $movieId);
                $project = GetProjectDetailsById($username, $movieResults['project_id']);
                $movie->year = $project->year;
                $movie->description = $project->description;
                $movie->valuation = $project->valuation;
                $movie->title = $project->title;
            }

            DisconnectFromDB($connect);
            return $movie;
        }
    }

    function GetSeriesBySeriesId($username, $seriesId){
        $connect = ConnectToDB($username, '1111');
        $sqlSearch = "SELECT * FROM series WHERE id = ".$seriesId;
        if($sqlResult = mysqli_query($connect, $sqlSearch)){
            $series = new stdClass();
            while($seriesResults = mysqli_fetch_array($sqlResult)){
                $series->id = $seriesId;
                $series->categories = GetCategoriesOfSeriesBySeriesId($username, $seriesId);
                $project = GetProjectDetailsById($username, $seriesResults['project_id']);
                $series->year = $project->year;
                $series->description = $project->description;
                $series->valuation = $project->valuation;
                $series->episodes = $seriesResults['number_of_episodes'];
                $series->seasons = $seriesResults['number_of_seasons'];
                $series->title = $project->title;
            }

            DisconnectFromDB($connect);
            return $series;
        }
    }


    function GetParticipantFullNameByParticipantName($username, $participant){
        $connect = ConnectToDB($username, '1111');
        $sqlSearch = "SELECT full_name FROM participants WHERE full_name LIKE '%$participant%'";
        if($sqlResult = mysqli_query($connect,$sqlSearch)){
            while($participant = mysqli_fetch_array($sqlResult)){
                DisconnectFromDB($connect);
                return $participant['full_name'];
            }
            
        }
    }

    function GetAllCategories($username){
        $connect = ConnectToDB($username, '1111');
        $sqlSearch = "SELECT * FROM categories";
        if($sqlResult = mysqli_query($connect,$sqlSearch)){
            $categoriesArray = [];
            while($categoryResult = mysqli_fetch_array($sqlResult)){
               $category = new stdClass();
               $category->id = $categoryResult['id'];
               $category->title = $categoryResult['title'];
               $categoriesArray[] = $category; 
            }
            DisconnectFromDB($connect);
            return $categoriesArray;
        }
    }

    function GetAllMoviesByCategoryId($username, $categoryId){
        $connect = ConnectToDB($username, '1111');
        $sqlCategorySearch = "SELECT movie_id FROM category_of_movie WHERE category_id = ".$categoryId;
        if($sqlCategoryResult = mysqli_query($connect,$sqlCategorySearch)){
            $moviesArray = [];
            while($category = mysqli_fetch_array($sqlCategoryResult)){
                $moviesArray[] = GetMovieByMovieId($username, $category['movie_id']);
            }
            DisconnectFromDB($connect);
            return $moviesArray;
        }
    }

    function GetAllSeriesByCategoryId($username, $categoryId){
        $connect = ConnectToDB($username, '1111');
        $sqlCategorySearch = "SELECT series_id FROM category_of_series WHERE category_id = ".$categoryId;
        if($sqlCategoryResult = mysqli_query($connect,$sqlCategorySearch)){
            $seriesArray = [];
            while($category = mysqli_fetch_array($sqlCategoryResult)){
                $seriesArray[] = GetSeriesBySeriesId($username, $category['series_id']);
            }
            DisconnectFromDB($connect);
            return $seriesArray;
        }
    }

    function GetCategoryTitleById($username, $categoryId){
        $connect = ConnectToDB($username, '1111');
        $sqlCategory = "SELECT title FROM categories WHERE id = ".$categoryId;
        if($resultCategory = mysqli_query($connect, $sqlCategory)){
            while($category = mysqli_fetch_array($resultCategory)){
                DisconnectFromDB($connect);
                return $category['title'];
            }
        }
    }