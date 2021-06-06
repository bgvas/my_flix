-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 06 Ιουν 2021 στις 20:49:20
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
(5, 1),
(5, 3),
(5, 6),
(6, 1),
(6, 5),
(7, 1),
(7, 3),
(7, 5),
(17, 2),
(17, 5);

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
(1, 4);

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
(35, 'yuuuuu', 1, 2),
(36, '', 1, 5),
(37, '', 1, 1),
(38, 'Nice movie', 1, 4),
(39, '', 1, 0),
(40, '', 1, 0),
(41, 'Good', 1, 0),
(42, '', 1, 0),
(43, '', 1, 0),
(44, '', 1, 0),
(45, '', 1, 0),
(46, '', 1, 0),
(47, '', 1, 3),
(48, 'rrrr', 1, 0),
(49, '', 1, 5),
(50, '', 1, 1),
(51, 'aaaa', 1, 0),
(52, 'aaaa', 1, 0),
(53, 'aaaa', 1, 0),
(54, 'aaaa', 1, 0),
(55, 'sdfsdfsdf', 1, 0),
(56, 'sdfsdfsdf', 1, 0),
(57, 'sdfsdfsdf', 1, 0),
(58, '', 1, 5),
(59, '', 1, 5),
(60, '', 1, 5),
(61, '', 1, 5),
(62, '', 1, 5),
(63, 'Hello', 1, 5),
(64, 'ggggggggggggggggggeeeeee', 1, 1),
(65, 'frfrfr', 1, 5),
(66, 'rrrr', 1, 5),
(67, 'frfrf', 1, 5),
(68, 'yuyuyuyu', 1, 0),
(69, '--------', 1, 5),
(70, 'dfgdfgdfg', 1, 5),
(71, 'oioioioioioi', 1, 5),
(72, '', 1, 1),
(73, '+++++', 1, 1),
(74, '', 1, 1),
(75, '', 1, 5),
(76, '', 1, 5),
(77, 'sdgfsdgfsdgfsdg', 1, 0),
(78, '', 1, 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `comments_for_episode_of_series`
--

CREATE TABLE `comments_for_episode_of_series` (
  `comment_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `comments_for_episode_of_series`
--

INSERT INTO `comments_for_episode_of_series` (`comment_id`, `episode_id`, `series_id`) VALUES
(63, 17, 1),
(70, 20, 1),
(71, 2, 1),
(72, 17, 1),
(73, 17, 1),
(74, 2, 1),
(76, 15, 1),
(77, 15, 1);

--
-- Δείκτες `comments_for_episode_of_series`
--
DELIMITER $$
CREATE TRIGGER `episode valuation` AFTER INSERT ON `comments_for_episode_of_series` FOR EACH ROW UPDATE episodes SET episodes.valuation = 
IF(episodes.valuation = 0,(SELECT valuation FROM comments WHERE id = new.comment_id),
   (IF((SELECT COUNT(valuation) FROM comments WHERE id = new.comment_id AND valuation > 0) > 0,
       (ROUND((episodes.valuation + (SELECT valuation FROM comments WHERE id = new.comment_id AND valuation > 0))/2)),
       (episodes.valuation))
   )
)
WHERE id = new.episode_id
$$
DELIMITER ;

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
(5, 42),
(6, 36),
(6, 37),
(6, 38),
(6, 43),
(6, 44),
(6, 45),
(6, 46),
(6, 47),
(6, 48),
(6, 49),
(6, 50);

--
-- Δείκτες `comments_for_movie`
--
DELIMITER $$
CREATE TRIGGER `movie_valuation` AFTER INSERT ON `comments_for_movie` FOR EACH ROW update visual_project set valuation = 
			IF(visual_project.valuation = 0,
				(select valuation FROM comments WHERE id = new.comment_id),
				(IF((select count(valuation) FROM comments WHERE id = new.comment_id AND valuation > 0) > 0,
				    (round((visual_project.valuation + (select valuation FROM comments WHERE id = new.comment_id AND comments.valuation > 0))/2)),
				    (visual_project.valuation)	
				))
			)	
where id = (SELECT project_id FROM movies WHERE id = new.movie_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `comments_for_series`
--

CREATE TABLE `comments_for_series` (
  `series_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `comments_for_series`
--

INSERT INTO `comments_for_series` (`series_id`, `comment_id`) VALUES
(1, 52),
(1, 54),
(1, 56),
(1, 57),
(1, 61),
(1, 64),
(1, 66);

--
-- Δείκτες `comments_for_series`
--
DELIMITER $$
CREATE TRIGGER `series_valuation` AFTER INSERT ON `comments_for_series` FOR EACH ROW update visual_project set valuation = 
			IF(visual_project.valuation = 0,
				(select valuation FROM comments WHERE id = new.comment_id),
				(IF((select count(valuation) FROM comments WHERE id = new.comment_id AND valuation > 0) > 0,
				    (round((visual_project.valuation + (select valuation FROM comments WHERE id = new.comment_id AND comments.valuation > 0))/2)),
				    (visual_project.valuation)	
				))
			)	
where id = (SELECT project_id FROM series WHERE id = new.series_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `valuation` int(11) NOT NULL,
  `time_long` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `episodes`
--

INSERT INTO `episodes` (`id`, `series_id`, `valuation`, `time_long`) VALUES
(1, 1, 0, 150),
(2, 1, 3, 150),
(15, 1, 5, 150),
(16, 1, 0, 150),
(17, 1, 4, 150),
(18, 1, 0, 150),
(19, 1, 0, 150),
(20, 1, 5, 150),
(21, 1, 0, 150),
(22, 1, 0, 150),
(23, 1, 5, 150),
(24, 1, 0, 150),
(25, 1, 0, 60);

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
-- Δομή πίνακα για τον πίνακα `favorite_movies`
--

CREATE TABLE `favorite_movies` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `favorite` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `favorite_movies`
--

INSERT INTO `favorite_movies` (`id`, `movie_id`, `user_id`, `favorite`) VALUES
(1, 5, 1, 0),
(6, 6, 1, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `favorite_series`
--

CREATE TABLE `favorite_series` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `favorite` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `favorite_series`
--

INSERT INTO `favorite_series` (`id`, `series_id`, `user_id`, `favorite`) VALUES
(9, 1, 1, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `time_long` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `movies`
--

INSERT INTO `movies` (`id`, `project_id`, `time_long`) VALUES
(5, 8, 150),
(6, 9, 125),
(7, 10, 150),
(14, 14, 120),
(17, 17, 180);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `movies_by_producers`
--

CREATE TABLE `movies_by_producers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `movies_by_producers`
--

INSERT INTO `movies_by_producers` (`id`, `user_id`, `movie_id`, `project_id`) VALUES
(2, 13, 5, 8),
(3, 13, 6, 9),
(4, 13, 7, 10),
(8, 13, 17, 17);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `participants`
--

INSERT INTO `participants` (`id`, `full_name`) VALUES
(1, 'Denzel Washington'),
(2, 'Robert De Niro'),
(3, 'Nicolas Cage'),
(4, 'Jennifer Aniston'),
(5, 'Courteney Cox'),
(6, 'Lisa Kudrow'),
(7, 'Tom Cruise'),
(8, 'Elijah Wood');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participants_of_movie`
--

CREATE TABLE `participants_of_movie` (
  `movie_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `participants_of_movie`
--

INSERT INTO `participants_of_movie` (`movie_id`, `participant_id`, `role_id`) VALUES
(5, 3, 1),
(6, 2, 1),
(7, 1, 1),
(17, 8, 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participants_of_series`
--

CREATE TABLE `participants_of_series` (
  `series_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `participants_of_series`
--

INSERT INTO `participants_of_series` (`series_id`, `participant_id`, `role_id`) VALUES
(1, 4, 1),
(1, 5, 1),
(1, 6, 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `participant_role`
--

CREATE TABLE `participant_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `participant_role`
--

INSERT INTO `participant_role` (`id`, `role`) VALUES
(1, 'actor'),
(2, 'director'),
(3, 'technician');

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

--
-- Άδειασμα δεδομένων του πίνακα `schedule_watching_movie`
--

INSERT INTO `schedule_watching_movie` (`id`, `movie_id`, `user_id`, `date`) VALUES
(23, 5, 1, '2021-06-30'),
(25, 6, 1, '2021-06-30');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `schedule_watching_series`
--

CREATE TABLE `schedule_watching_series` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `episode_index` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `schedule_watching_series`
--

INSERT INTO `schedule_watching_series` (`id`, `series_id`, `user_id`, `date`, `episode_index`) VALUES
(16, 1, 1, '2021-06-04', 2);

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
(1, 1, 3, 13);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `series_by_producers`
--

CREATE TABLE `series_by_producers` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `series_by_producers`
--

INSERT INTO `series_by_producers` (`id`, `series_id`, `project_id`, `user_id`) VALUES
(1, 1, 1, 13);

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
(1, 'bill', 'f6bcfd38791545be871770ef3b087c43fee5a84a2b69f4fe9a147953ff39d7b9b542dbcfbdae3f9b7d080088c676d72c684f8648e5e9d815767c5232884942ca', 'b_gvas@yahoo.gr', 'Vasilis Georgoulas', '0d8a71dd4a686fd055504fe7189b9bc7436f69161b49e77ab17ea1a35e582a4181c9b8cf520df869dfe42b3c597a4fe74f29004d8c76aed12d0959949625cf2d', 1, '2021-05-19 03:54:58', '2021-06-06 08:44:58'),
(13, 'netflix', 'f6bcfd38791545be871770ef3b087c43fee5a84a2b69f4fe9a147953ff39d7b9b542dbcfbdae3f9b7d080088c676d72c684f8648e5e9d815767c5232884942ca', 'info@netflix.com', 'Netflix S.A', 'a443e737c278c7ea13370afb8a55197b4de81bd943f31ac979b70dddc4008402a9afda7c3f59f51385ff5195688eab23cb63f671b642f53db94639c6a2df53e9', 2, '2021-06-05 20:36:11', '2021-06-06 15:39:05'),
(29, 'dimitris', 'f6bcfd38791545be871770ef3b087c43fee5a84a2b69f4fe9a147953ff39d7b9b542dbcfbdae3f9b7d080088c676d72c684f8648e5e9d815767c5232884942ca', 'a@a.a', 'dimitris', '7f6bb015b39f3a108861bab72b06723fc386c1807329f0ae292f1252f62afca93ecd49ee7778fadb679e12d36a1f5346cbc83e70e75f6c8d8692c9e314a02e18', 3, '2021-06-06 08:37:02', '2021-06-06 08:37:59');

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
(1, 'Friends', 'Follows the personal and professional lives of six twenty to thirty-something-year-old friends living in Manhattan.', 1994, 4),
(8, 'Face off', 'To foil a terrorist plot, an FBI agent undergoes facial transplant surgery to assume the identity of the criminal mastermind who murdered his only son, but the criminal wakes up prematurely and seeks revenge.', 1997, 0),
(9, 'The Irish man', 'Sheeran goes to jail, as do most of his associates, who either die in prison or are murdered before they could even be locked up behind bars. Ultimately, Sheeran is left alone in a rundown ­nursing home and preparing for his own death, as he picks out his own coffin and burial plot, repeatedly visits a priest, and tries to remind people who Hoffa was.', 2019, 3),
(10, 'Training Day', 'A rookie cop spends his first day as a Los Angeles narcotics officer with a rogue detective who isn\'t what he appears to be.', 2001, 0),
(14, 'The firm', 'A young lawyer joins a prestigious law firm only to discover that it has a sinister dark side.', 2015, 0),
(17, 'The Lord Of The Rings 1', 'A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron.', 2001, 0);

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
  ADD KEY `comment_episode_fk` (`episode_id`),
  ADD KEY `comment_series_fk` (`series_id`);

--
-- Ευρετήρια για πίνακα `comments_for_movie`
--
ALTER TABLE `comments_for_movie`
  ADD PRIMARY KEY (`movie_id`,`comment_id`),
  ADD KEY `comment_movie_fk` (`movie_id`),
  ADD KEY `comment_comments_fk` (`comment_id`);

--
-- Ευρετήρια για πίνακα `comments_for_series`
--
ALTER TABLE `comments_for_series`
  ADD PRIMARY KEY (`series_id`,`comment_id`),
  ADD KEY `commentid_for_series_fk` (`comment_id`);

--
-- Ευρετήρια για πίνακα `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_series_fk` (`series_id`);

--
-- Ευρετήρια για πίνακα `favorite_movies`
--
ALTER TABLE `favorite_movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `movie_id` (`movie_id`,`user_id`),
  ADD KEY `favorite_movie_user_fk` (`user_id`);

--
-- Ευρετήρια για πίνακα `favorite_series`
--
ALTER TABLE `favorite_series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `series_id` (`series_id`,`user_id`),
  ADD KEY `favorite_series_user_fk` (`user_id`);

--
-- Ευρετήρια για πίνακα `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UniqueProjectId` (`project_id`);

--
-- Ευρετήρια για πίνακα `movies_by_producers`
--
ALTER TABLE `movies_by_producers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_producer_user_fk` (`user_id`),
  ADD KEY `movie_movieId_fk` (`movie_id`),
  ADD KEY `movie_producer_project_fk` (`project_id`);

--
-- Ευρετήρια για πίνακα `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `participants_of_movie`
--
ALTER TABLE `participants_of_movie`
  ADD PRIMARY KEY (`movie_id`,`participant_id`,`role_id`),
  ADD KEY `participant_movie_participantId_fk` (`participant_id`),
  ADD KEY `participant_movie_roleId_fk` (`role_id`);

--
-- Ευρετήρια για πίνακα `participants_of_series`
--
ALTER TABLE `participants_of_series`
  ADD PRIMARY KEY (`series_id`,`participant_id`,`role_id`),
  ADD KEY `participant_series_participantId_fk` (`participant_id`),
  ADD KEY `participant_series_roleId_fk` (`role_id`);

--
-- Ευρετήρια για πίνακα `participant_role`
--
ALTER TABLE `participant_role`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `movie_id` (`movie_id`,`user_id`,`date`),
  ADD KEY `schedule_movie_user_fk` (`user_id`);

--
-- Ευρετήρια για πίνακα `schedule_watching_series`
--
ALTER TABLE `schedule_watching_series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`date`,`episode_index`,`series_id`) USING BTREE,
  ADD KEY `schedule_series_fk` (`series_id`),
  ADD KEY `schedule_episode_fk` (`episode_index`);

--
-- Ευρετήρια για πίνακα `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_project_fk` (`project_id`) USING BTREE;

--
-- Ευρετήρια για πίνακα `series_by_producers`
--
ALTER TABLE `series_by_producers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_producer_series_fk` (`series_id`),
  ADD KEY `series_producer_project_fk` (`project_id`),
  ADD KEY `series_producer_user_fk` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UniqueTitle` (`title`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT για πίνακα `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT για πίνακα `favorite_movies`
--
ALTER TABLE `favorite_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT για πίνακα `favorite_series`
--
ALTER TABLE `favorite_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT για πίνακα `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT για πίνακα `movies_by_producers`
--
ALTER TABLE `movies_by_producers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT για πίνακα `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT για πίνακα `participant_role`
--
ALTER TABLE `participant_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT για πίνακα `schedule_watching_movie`
--
ALTER TABLE `schedule_watching_movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT για πίνακα `schedule_watching_series`
--
ALTER TABLE `schedule_watching_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT για πίνακα `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `series_by_producers`
--
ALTER TABLE `series_by_producers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT για πίνακα `visual_project`
--
ALTER TABLE `visual_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  ADD CONSTRAINT `comment_episode_fk` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `comments_for_movie`
--
ALTER TABLE `comments_for_movie`
  ADD CONSTRAINT `comment_movie_comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `comments_for_series`
--
ALTER TABLE `comments_for_series`
  ADD CONSTRAINT `comment_for_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentid_for_series_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episode_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `favorite_movies`
--
ALTER TABLE `favorite_movies`
  ADD CONSTRAINT `favorite_movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_movie_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `favorite_series`
--
ALTER TABLE `favorite_series`
  ADD CONSTRAINT `favorite_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_series_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movie_project_fk` FOREIGN KEY (`project_id`) REFERENCES `visual_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `movies_by_producers`
--
ALTER TABLE `movies_by_producers`
  ADD CONSTRAINT `movie_movieId_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_producer_project_fk` FOREIGN KEY (`project_id`) REFERENCES `visual_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_producer_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `participants_of_movie`
--
ALTER TABLE `participants_of_movie`
  ADD CONSTRAINT `participant_movie_movieId_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_movie_participantId_fk` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_movie_roleId_fk` FOREIGN KEY (`role_id`) REFERENCES `participant_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `participants_of_series`
--
ALTER TABLE `participants_of_series`
  ADD CONSTRAINT `participant_series_participantId_fk` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_series_roleId_fk` FOREIGN KEY (`role_id`) REFERENCES `participant_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
-- Περιορισμοί για πίνακα `series_by_producers`
--
ALTER TABLE `series_by_producers`
  ADD CONSTRAINT `series_producer_project_fk` FOREIGN KEY (`project_id`) REFERENCES `visual_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_producer_series_fk` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_producer_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Συμβάντα
--
CREATE DEFINER=`root`@`localhost` EVENT `Delete movie reminder` ON SCHEDULE EVERY 2 DAY STARTS '2021-06-03 16:19:22' ON COMPLETION PRESERVE ENABLE DO DELETE FROM schedule_watching_movie WHERE date < CURRENT_DATE$$

CREATE DEFINER=`root`@`localhost` EVENT `Delete series-episode reminder` ON SCHEDULE EVERY 2 DAY STARTS '2021-06-03 16:20:21' ON COMPLETION PRESERVE ENABLE DO DELETE FROM schedule_watching_series WHERE date < CURRENT_DATE$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
