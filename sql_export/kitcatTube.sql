-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Nov 16, 2020 at 11:07 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kitcatTube`
--


DROP DATABASE IF EXISTS kitcatTube;
CREATE DATABASE kitcatTube CHARACTER SET UTF8MB4;
USE kitcatTube;

DROP USER IF EXISTS 'kittyHandler'@'%';
CREATE USER 'kittyHandler'@'%' IDENTIFIED BY 'bHhdwjKOV1z4ItEyhMtiFYlx8mRiXUoZP#aD*jZKxt$OPcxxd*';
REVOKE ALL PRIVILEGES ON *.* FROM 'kittyHandler'@'%';
GRANT SELECT, INSERT, DELETE, UPDATE ON kitcatTube.* TO 'kittyHandler'@'%';



-- --------------------------------------------------------

--
-- Table structure for table `active_sessions`
--

CREATE TABLE `active_sessions` (
  `id_session` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `token` char(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `lease_till` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `avatarsFiles`
--

CREATE TABLE `avatarsFiles` (
  `id_avatar` int UNSIGNED NOT NULL,
  `avatar_code` char(8) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `file_extension` enum('png','jpeg','jpg') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `avatarsFiles`
--

INSERT INTO `avatarsFiles` (`id_avatar`, `avatar_code`, `file_extension`) VALUES
(1, '00000000', 'jpg'),
(2, '00000001', 'jpg'),
(6, '00000002', 'png'),
(7, '00000003', 'png'),
(8, '00000004', 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int UNSIGNED NOT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `video_id` int UNSIGNED NOT NULL,
  `content` varchar(360) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_comment`, `author_id`, `video_id`, `content`, `post_date`) VALUES
(2, 5, 4, 'Hello, I\'m under the water.', '2020-10-26 12:25:26');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnailsFiles`
--

CREATE TABLE `thumbnailsFiles` (
  `id_thumbnail` int UNSIGNED NOT NULL,
  `thumbnail_code` char(8) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `extension` enum('png','jpeg','jpg') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `thumbnailsFiles`
--

INSERT INTO `thumbnailsFiles` (`id_thumbnail`, `thumbnail_code`, `extension`) VALUES
(1, '00000000', 'jpg'),
(2, '00000001', 'jpg'),
(3, '00000002', 'jpg'),
(4, '00000003', 'jpg'),
(5, '00000004', 'jpg'),
(15, '00000005', 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `user_username` char(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `user_email` varchar(40) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `user_password` char(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `user_username`, `user_email`, `user_password`, `creation_date`) VALUES
(2, 'hellowman', 'user@username.com', '$2y$10$4mIsEgBc1Kdmb0LAsFm4x.yb2aIqSN9GCA8pybqee/tLLQXJMVF12', '2020-10-18 13:03:16'),
(3, 'admin', 'kekw@wp.pl', '$2y$10$JdYZejYVny8W0Y8EYS5lpOCn47Lf1HkRKdjoPnQ6ETyKJqrue9wRK', '2020-10-18 13:03:16'),
(4, 'senpai', 'v34@ws.sa', '$2y$10$Khp2e0.e3Uypih/CmWSP4Oy1c9jyTnQfb.oZ9d6BcEedSRYAgwTd6', '2020-10-18 13:19:56'),
(5, 'usern', 'usern@usern.com', '$2y$10$dh/hv6ipoYf08AfTyjhXie5VkBG6TxFSgv51IeIOm8NeL.YZb25A6', '2020-10-18 17:46:06'),
(12, 'vektor', 'vektor@wp.pl', '$2y$10$MLi/IgDF/B7elVHW8pQ8iuVhnDx652evJlb3v46tNCfwSfC5AAwUq', '2020-10-18 19:24:54'),
(13, 'wpwp', 'sdfjasdjl@skljas.com', '$2y$10$7w0Q0HG.Ho759UbbFuCSqucHT88ReTyEwBXUbAHMnq6N2DUHg1Q9q', '2020-10-19 12:26:07'),
(14, 'user2', 'user@wp.pl', 'Qweasd123', '2020-10-22 16:13:32'),
(15, 'username', 'username@username.com', '$2y$10$chu0YBztxKWJd8Q2vx0USuU0HhdTJ0DOPdPRbhhbl56rnp1Dy/H7W', '2020-10-22 16:19:28'),
(16, 'sexy', 'username@user.sdf', '$2y$10$.1vJ4cJnIRNSNbYhzvEy8.uFEsMD7x4KxfJRVoTK7cgDi3D.oTR8S', '2020-10-22 16:20:42'),
(17, 'saxy', 'sexy@sexy.com', '$2y$10$ma7ODGHe.cS7StFarY2U.utqGGZCjS6IorfX26C58niWnBpEzabR.', '2020-10-22 16:22:27'),
(18, 'user23', 'lkdsjflkasjdflk@sdlkjflkdsjaf.cms', '$2y$10$JKA59vzYxaAgfOChE9KACOcKHE04V7l0DABz1zeWdjyGL/V52nyP.', '2020-10-22 16:23:49'),
(19, 'jdjd', 'jd@jd.com', '$2y$10$pFaSb7Ok2EWa8DWv4z4gRuZuyp7VN9QMjd2ZNGZUqsBdIgyDOOtjO', '2020-10-25 22:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `usersInfo`
--

CREATE TABLE `usersInfo` (
  `id_user` int UNSIGNED NOT NULL,
  `title` char(60) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `avatar_id` int UNSIGNED DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `usersInfo`
--

INSERT INTO `usersInfo` (`id_user`, `title`, `avatar_id`) VALUES
(2, 'SomethingElse', 1),
(3, 'Administrator', 8),
(4, 'Darek', 1),
(5, 'Sudo', 1),
(12, 'Vektor', 1),
(13, 'WPWP', 1),
(14, 'user2', 1),
(15, 'username', 1),
(16, 'sexy', 1),
(17, 'saxy', 1),
(18, 'user23', 1),
(19, 'jdjd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usersPermissions`
--

CREATE TABLE `usersPermissions` (
  `id_user` int UNSIGNED NOT NULL,
  `cpanel_access` tinyint(1) NOT NULL DEFAULT '0',
  `perm_modifyUsers` tinyint(1) NOT NULL DEFAULT '0',
  `perm_modifyVideos` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `usersPermissions`
--

INSERT INTO `usersPermissions` (`id_user`, `cpanel_access`, `perm_modifyUsers`, `perm_modifyVideos`) VALUES
(2, 0, 0, 0),
(3, 1, 1, 1),
(4, 0, 0, 0),
(5, 0, 0, 0),
(12, 0, 0, 0),
(13, 0, 0, 0),
(14, 0, 0, 0),
(15, 0, 0, 0),
(16, 0, 0, 0),
(17, 0, 0, 0),
(18, 0, 0, 0),
(19, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id_video` int UNSIGNED NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(480) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `rating` int NOT NULL DEFAULT '0',
  `videoFile_id` int UNSIGNED NOT NULL,
  `thumbnailFile_id` int UNSIGNED DEFAULT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `status` enum('public','private','unlisted') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT 'public',
  `upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id_video`, `title`, `description`, `views`, `rating`, `videoFile_id`, `thumbnailFile_id`, `author_id`, `status`, `upload_date`) VALUES
(2, 'Lorem ipsum dolor sit amet', 'Accumsan sit amet nulla facilisi. Amet nisl suscipit adipiscing bibendum est ultricies. Pulvinar pellentesque habitant morbi tristique senectus et netus et', 585, -1, 1, 1, 15, 'public', '2018-08-15 19:35:18'),
(3, 'Consectetur adipiscing elit', 'A arcu cursus vitae congue. Malesuada fames ac turpis egestas integer eget. Nibh tortor id aliquet lectus. Pretium vulputate sapien nec sagittis aliquam. Diam sit amet nisl suscipit adipiscing bibendum est ultricies.', 8161, -1, 2, 2, 14, 'public', '2020-10-24 19:35:18'),
(4, 'Sed do eiusmod tempor incididunt', 'Elit pellentesque habitant morbi tristique senectus et. Cursus risus at ultrices mi. Quam viverra orci sagittis eu volutpat odio facilisis mauris sit. Mattis nunc sed blandit libero volutpat sed. Sapien et ligula ullamcorper malesuada proin.', 98474, 1, 3, 3, 14, 'public', '2020-10-24 19:35:18'),
(5, 'Ut labore et dolore magna aliqua', 'Tincidunt ornare massa eget egestas purus. Pharetra massa massa ultricies mi. Non pulvinar neque laoreet suspendisse interdum.', 513581, 2, 4, 4, 17, 'public', '2020-10-24 19:35:18'),
(6, 'Feugiat in ante metus dictum at tempor commodo ullamcorper', 'Suspendisse in est ante in. Sit amet consectetur adipiscing elit ut. Euismod elementum nisi quis eleifend quam adipiscing vitae. Nam libero justo laoreet sit amet cursus.', 2630466, -1, 5, 5, 4, 'public', '2020-10-24 19:35:18'),
(58, 'Sudo kill me plz', 'Sudo kill me plz', 15, 1, 17, 15, 3, 'public', '2020-11-15 15:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `videosFiles`
--

CREATE TABLE `videosFiles` (
  `id_videoFile` int UNSIGNED NOT NULL,
  `video_code` char(8) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `extension` enum('mp4','avi') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `duration` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `videosFiles`
--

INSERT INTO `videosFiles` (`id_videoFile`, `video_code`, `extension`, `duration`) VALUES
(1, '00000000', 'mp4', 3),
(2, '00000001', 'mp4', 3),
(3, '00000002', 'mp4', 3),
(4, '00000003', 'mp4', 3),
(5, '00000004', 'mp4', 3),
(17, '00000005', 'mp4', 3);

-- --------------------------------------------------------

--
-- Table structure for table `videos_actions`
--

CREATE TABLE `videos_actions` (
  `id_videosAction` int UNSIGNED NOT NULL,
  `video_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` enum('like','unselected','dislike') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `videos_actions`
--

INSERT INTO `videos_actions` (`id_videosAction`, `video_id`, `user_id`, `type`) VALUES
(1, 3, 2, 'dislike'),
(2, 3, 3, 'dislike'),
(3, 2, 3, 'dislike'),
(4, 4, 3, 'like'),
(5, 6, 3, 'dislike'),
(6, 4, 2, 'dislike'),
(7, 5, 2, 'like'),
(8, 5, 3, 'like'),
(9, 58, 3, 'like');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_sessions`
--
ALTER TABLE `active_sessions`
  ADD PRIMARY KEY (`id_session`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `avatarsFiles`
--
ALTER TABLE `avatarsFiles`
  ADD PRIMARY KEY (`id_avatar`),
  ADD UNIQUE KEY `avatar_code` (`avatar_code`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `comment_author_fk` (`author_id`),
  ADD KEY `commet_video_fk` (`video_id`);

--
-- Indexes for table `thumbnailsFiles`
--
ALTER TABLE `thumbnailsFiles`
  ADD PRIMARY KEY (`id_thumbnail`),
  ADD UNIQUE KEY `thumbnail_code` (`thumbnail_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username-email` (`user_username`,`user_email`);

--
-- Indexes for table `usersInfo`
--
ALTER TABLE `usersInfo`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `avatar_avatars_fk` (`avatar_id`);

--
-- Indexes for table `usersPermissions`
--
ALTER TABLE `usersPermissions`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `author_id_users_fk` (`author_id`),
  ADD KEY `thumbnail_id_thumbnailsFiles_fk` (`thumbnailFile_id`),
  ADD KEY `videoFile_id_videosFiles_fk` (`videoFile_id`);

--
-- Indexes for table `videosFiles`
--
ALTER TABLE `videosFiles`
  ADD PRIMARY KEY (`id_videoFile`),
  ADD UNIQUE KEY `file_code` (`video_code`);

--
-- Indexes for table `videos_actions`
--
ALTER TABLE `videos_actions`
  ADD PRIMARY KEY (`id_videosAction`),
  ADD KEY `user_id_users_fk` (`user_id`),
  ADD KEY `video_id_videos_fk` (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_sessions`
--
ALTER TABLE `active_sessions`
  MODIFY `id_session` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avatarsFiles`
--
ALTER TABLE `avatarsFiles`
  MODIFY `id_avatar` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `thumbnailsFiles`
--
ALTER TABLE `thumbnailsFiles`
  MODIFY `id_thumbnail` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `videosFiles`
--
ALTER TABLE `videosFiles`
  MODIFY `id_videoFile` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `videos_actions`
--
ALTER TABLE `videos_actions`
  MODIFY `id_videosAction` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_author_fk` FOREIGN KEY (`author_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commet_video_fk` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usersInfo`
--
ALTER TABLE `usersInfo`
  ADD CONSTRAINT `avatar_avatars_fk` FOREIGN KEY (`avatar_id`) REFERENCES `avatarsFiles` (`id_avatar`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `userID_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usersPermissions`
--
ALTER TABLE `usersPermissions`
  ADD CONSTRAINT `id_user_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `author_id_users_fk` FOREIGN KEY (`author_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thumbnail_id_thumbnailsFiles_fk` FOREIGN KEY (`thumbnailFile_id`) REFERENCES `thumbnailsFiles` (`id_thumbnail`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `videoFile_id_videosFiles_fk` FOREIGN KEY (`videoFile_id`) REFERENCES `videosFiles` (`id_videoFile`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `videos_actions`
--
ALTER TABLE `videos_actions`
  ADD CONSTRAINT `user_id_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_id_videos_fk` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
