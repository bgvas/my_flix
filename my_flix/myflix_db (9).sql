-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 29 Μάη 2021 στις 08:28:21
-- Έκδοση διακομιστή: 10.4.19-MariaDB
-- Έκδοση PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `myflix_db`
--
CREATE DATABASE IF NOT EXISTS `myflix_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `myflix_db`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'drama'),
(2, 'war'),
(3, 'terror'),
(4, 'commedy'),
(5, 'action'),
(6, 'fantasy');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `category_of_movie`
--

CREATE TABLE `category_of_movie` (
  `movie_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `category_of_movie`
--

INSERT INTO `category_of_movie` (`movie_id`, `category_id`) VALUES
(2, 1),
(2, 2),
(2, 5),
(3, 1),
(3, 2),
(3, 4);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `category_of_series`
--

CREATE TABLE `category_of_series` (
  `series_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `category_of_series`
--

INSERT INTO `category_of_series` (`series_id`, `category_id`) VALUES
(1, 3),
(1, 5),
(2, 4);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `userId` int(11) NOT NULL,
  `valuation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `comments`
--

INSERT INTO `comments` (`id`, `comment`, `userId`, `valuation`) VALUES
(16, 'test', 1, 4),
(17, 'testing', 1, 2),
(19, '', 1, 0),
(20, '', 1, 0),
(21, '', 1, 0),
(22, '', 1, 0),
(23, 'sdfsafd', 1, 5),
(24, 'This is my comment', 1, 5),
(25, 'ggggggggggg', 1, 5),
(26, 'jjkykyihkuikuik', 1, 0),
(27, 'fghfghfghghf', 1, 0),
(28, '', 1, 0),
(29, '', 1, 0),
(30, 'a', 1, 0),
(31, 'iiiii', 1, 5),
(32, 'jjj', 1, 5),
(33, 'fff', 1, 1),
(34, 'jjjjjj', 1, 1),
(35, 'yuuuuu', 1, 2);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `comments_for_episode_of_series`
--

CREATE TABLE `comments_for_episode_of_series` (
  `comment_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `comments_for_movie`
--

CREATE TABLE `comments_for_movie` (
  `movie_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `comments_for_movie`
--

INSERT INTO `comments_for_movie` (`movie_id`, `comment_id`) VALUES
(2, 16),
(2, 17),
(2, 24),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(3, 22),
(3, 23),
(3, 25),
(3, 35);

--
-- Δείκτες `comments_for_movie`
--
DELIMITER $$
CREATE TRIGGER `ProjectValuation` AFTER INSERT ON `comments_for_movie` FOR EACH ROW update visual_project set valuation = IF(visual_project.valuation = 0,(select valuation FROM comments WHERE id = new.comment_id), round((visual_project.valuation + (select valuation FROM comments WHERE id = new.comment_id))/2))  
where id = (SELECT project_id FROM movies WHERE id = new.movie_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `episodes`
--

INSERT INTO `episodes` (`id`, `series_id`) VALUES
(1, 1),
(2, 1),
(15, 1),
(11, 2),
(12, 2),
(13, 2),
(14, 2);

--
-- Δείκτες `episodes`
--
DELIMITER $$
CREATE TRIGGER `count` AFTER INSERT ON `episodes` FOR EACH ROW UPDATE series SET number_of_episodes =
(SELECT COUNT(*) FROM episodes WHERE episodes.series_id = series.id )
WHERE  id = series.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `movie-participants`
--

CREATE TABLE `movie-participants` (
  `movie_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `movies`
--

INSERT INTO `movies` (`id`, `project_id`) VALUES
(2, 3),
(3, 6);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participants_of_series`
--

CREATE TABLE `participants_of_series` (
  `series_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'producer'),
(3, 'user');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `schedule_watching_movie`
--

CREATE TABLE `schedule_watching_movie` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `schedule_watching_series`
--

CREATE TABLE `schedule_watching_series` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `number_of_seasons` int(11) NOT NULL,
  `number_of_episodes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `series`
--

INSERT INTO `series` (`id`, `project_id`, `number_of_seasons`, `number_of_episodes`) VALUES
(1, 1, 2, 3),
(2, 2, 2, 4);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `token`, `role_id`, `createdAt`, `updatedAt`) VALUES
(1, 'bill', 'f6bcfd38791545be871770ef3b087c43fee5a84a2b69f4fe9a147953ff39d7b9b542dbcfbdae3f9b7d080088c676d72c684f8648e5e9d815767c5232884942ca', 'b_gvas@yahoo.gr', 'Vasilis Georgoulas', '71f62abbd476100b89ab3a3daba1b25a0bb8f29040008b6b39dfb8ce1941b91f9fee1b092fb5c8379942ac2346bf456a622575578563a37cc3009cf6c51c13a9', 3, '2021-05-19 03:54:58', '2021-05-29 03:43:28');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `visual_project`
--

CREATE TABLE `visual_project` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `valuation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `visual_project`
--

INSERT INTO `visual_project` (`id`, `title`, `description`, `created_at`, `valuation`) VALUES
(1, 'Hello', 'My new Series', 2010, 5),
(2, 'Funny Series', 'Funny Series', 1985, 2),
(3, 'The last of the Mohicans', 'Indians and France', 1999, 2),
(6, 'Rocky I', 'Boxing games', 1980, 4);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `category_of_movie`
--
ALTER TABLE `category_of_movie`
  ADD PRIMARY KEY (`movie_id`,`category_id`),
  ADD KEY `category_of_movie_categoryId_fk` (`category_id`);

--
-- Ευρετήρια για πίνακα `category_of_series`
--
ALTER TABLE `category_of_series`
  ADD PRIMARY KEY (`series_id`,`category_id`),
  ADD KEY `category_of_series_categoryId_fk` (`category_id`);

--
-- Ευρετήρια για πίνακα `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_user_fk` (`userId`);

--
-- Ευρετήρια για πίνακα `comments_for_episode_of_series`
--
ALTER TABLE `comments_for_episode_of_series`
  ADD PRIMARY KEY (`comment_id`,`episode_id`),
  ADD KEY `comment_episode_fk` (`episode_id`);

--
-- Ευρετήρια για πίνακα `comments_for_movie`
--
ALTER TABLE `comments_for_movie`
  ADD PRIMARY KEY (`movie_id`,`comment_id`),
  ADD KEY `comment_movie_fk` (`movie_id`),
  ADD KEY `comment_comments_fk` (`comment_id`);

--
-- Ευρετήρια για πίνακα `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_series_fk` (`series_id`);

--
-- Ευρετήρια για πίνακα `movie-participants`
--
ALTER TABLE `movie-participants`
  ADD PRIMARY KEY (`movie_id`,`participant_id`),
  ADD KEY `participant_movie_participantId_fk` (`participant_id`);

--
-- Ευρετήρια για πίνακα `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_project_fk` (`project_id`);

--
-- Ευρετήρια για πίνακα `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `participants_of_series`
--
ALTER TABLE `participants_of_series`
  ADD PRIMARY KEY (`series_id`,`participant_id`),
  ADD KEY `participant_series_participantId_fk` (`participant_id`);

--
-- Ευρετήρια για πίνακα `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `schedule_watching_movie`
--
ALTER TABLE `schedule_watching_movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_movie_fk` (`movie_id`),
  ADD KEY `schedule_movie_user_fk` (`user_id`);

--
-- Ευρετήρια για πίνακα `schedule_watching_series`
--
ALTER TABLE `schedule_watching_series`
  ADD KEY `schedule_series_fk` (`series_id`),
  ADD KEY `schedule_series_user_fk` (`user_id`);

--
-- Ευρετήρια για πίνακα `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_project_fk` (`project_id`) USING BTREE;

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_fk` (`role_id`);

--
-- Ευρετήρια για πίνακα `visual_project`
--
ALTER TABLE `visual_project`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT για πίνακα `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT για πίνακα `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT για πίνακα `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `schedule_watching_movie`
--
ALTER TABLE `schedule_watching_movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT για πίνακα `visual_project`
--
ALTER TABLE `visual_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `category_of_movie`
--
ALTER TABLE `category_of_movie`
  ADD CONSTRAINT `category_of_movie_categoryId_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_of_movie_movieId_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `category_of_series`
--
ALTER TABLE `category_of_series`
  ADD CONSTRAINT `category_of_series_categoryId_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_of_series_seriesId_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `comments_for_episode_of_series`
--
ALTER TABLE `comments_for_episode_of_series`
  ADD CONSTRAINT `comment_comments_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_episode_fk` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `comments_for_movie`
--
ALTER TABLE `comments_for_movie`
  ADD CONSTRAINT `comment_movie_comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episode_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `movie-participants`
--
ALTER TABLE `movie-participants`
  ADD CONSTRAINT `participant_movie_movieId_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_movie_participantId_fk` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `visual_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `participants_of_series`
--
ALTER TABLE `participants_of_series`
  ADD CONSTRAINT `participant_series_participantId_fk` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_series_seriesId_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `schedule_watching_movie`
--
ALTER TABLE `schedule_watching_movie`
  ADD CONSTRAINT `schedule_movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_movie_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `schedule_watching_series`
--
ALTER TABLE `schedule_watching_series`
  ADD CONSTRAINT `schedule_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_series_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_project_fk` FOREIGN KEY (`project_id`) REFERENCES `visual_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
