-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Oct 13, 2020 at 09:55 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cloneTube`
--

-- --------------------------------------------------------

--
-- Table structure for table `perms`
--

CREATE TABLE `perms` (
  `id_user` int UNSIGNED NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `perms`
--

INSERT INTO `perms` (`id_user`, `admin`) VALUES
(8, 1),
(9, 0),
(10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `user_username` char(30) COLLATE utf8_polish_ci NOT NULL,
  `user_email` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `user_password` char(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `user_username`, `user_email`, `user_password`) VALUES
(8, 'admin', 'kekw@wp.pl', '$2y$10$7rJ40RvswpWOoXqkBwxMhO5ggGyvTaorDGOicV5uH2V/uZGlVRakS'),
(9, 'user', 'user@wp.pl', '$2y$10$gG/cb6tepewLAP570Lw8/umLYrgoMX10M0vtSy4YQ3kTa8KGTxwVi'),
(10, 'HelloKitty', 'hello@kitty.kek', '$2y$10$cUNBqCt1xQWPCT3f6AoZduApnUsHyd5QfSIYJdIzpJeHJsP/c82KW');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id_video` int UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(480) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `rating` int NOT NULL DEFAULT '0',
  `duration` int NOT NULL,
  `file_video` char(8) COLLATE utf8_polish_ci NOT NULL,
  `file_thumbnail` char(8) COLLATE utf8_polish_ci NOT NULL,
  `author_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id_video`, `title`, `description`, `views`, `rating`, `duration`, `file_video`, `file_thumbnail`, `author_id`) VALUES
(1, 'First video', 'Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else ', 45674, 0, 120, '00000000', '00000000', 8),
(2, 'Second video', 'Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else Lorem ipsum something else ', 6752453, 0, 360, '00000001', '00000001', 9),
(3, 'Third video or smthing, let me die', 'Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem Lorem ipsum dolorem ni no nie wiem', 0, 0, 4625, '00000002', '00000002', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `perms`
--
ALTER TABLE `perms`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username-email` (`user_username`,`user_email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`),
  ADD UNIQUE KEY `files` (`file_video`,`file_thumbnail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perms`
--
ALTER TABLE `perms`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
