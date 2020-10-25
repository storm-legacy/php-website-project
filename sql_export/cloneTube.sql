-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Oct 25, 2020 at 12:37 PM
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
-- Table structure for table `active_sessions`
--

CREATE TABLE `active_sessions` (
  `id_session` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `token` char(60) COLLATE utf8_polish_ci NOT NULL,
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
(1, '00000000', 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int UNSIGNED NOT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `video_id` int UNSIGNED NOT NULL,
  `content` varchar(360) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rating` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments_actions`
--

CREATE TABLE `comments_actions` (
  `id_commentsAction` int UNSIGNED NOT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `comment_id` int UNSIGNED NOT NULL,
  `type` enum('like','unselected','dislike') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
(5, '00000004', 'jpg');

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
(2, 'user', 'user@username.com', '$2y$10$4mIsEgBc1Kdmb0LAsFm4x.yb2aIqSN9GCA8pybqee/tLLQXJMVF12', '2020-10-18 13:03:16'),
(3, 'admin', 'admin@admin.admin', '$2y$10$XhGl9NzG1/G5fFdSl1cap.pW6mnphufzzkqr.7ZBjXmAkys9F.mNO', '2020-10-18 13:03:16'),
(4, 'senpai', 'v34@ws.sa', '$2y$10$Khp2e0.e3Uypih/CmWSP4Oy1c9jyTnQfb.oZ9d6BcEedSRYAgwTd6', '2020-10-18 13:19:56'),
(5, 'usern', 'usern@usern.com', '$2y$10$dh/hv6ipoYf08AfTyjhXie5VkBG6TxFSgv51IeIOm8NeL.YZb25A6', '2020-10-18 17:46:06'),
(12, 'vektor', 'vektor@wp.pl', '$2y$10$MLi/IgDF/B7elVHW8pQ8iuVhnDx652evJlb3v46tNCfwSfC5AAwUq', '2020-10-18 19:24:54'),
(13, 'wpwp', 'sdfjasdjl@skljas.com', '$2y$10$7w0Q0HG.Ho759UbbFuCSqucHT88ReTyEwBXUbAHMnq6N2DUHg1Q9q', '2020-10-19 12:26:07'),
(14, 'user2', 'user@wp.pl', 'Qweasd123', '2020-10-22 16:13:32'),
(15, 'username', 'username@username.com', '$2y$10$chu0YBztxKWJd8Q2vx0USuU0HhdTJ0DOPdPRbhhbl56rnp1Dy/H7W', '2020-10-22 16:19:28'),
(16, 'sexy', 'username@user.sdf', '$2y$10$.1vJ4cJnIRNSNbYhzvEy8.uFEsMD7x4KxfJRVoTK7cgDi3D.oTR8S', '2020-10-22 16:20:42'),
(17, 'saxy', 'sexy@sexy.com', '$2y$10$ma7ODGHe.cS7StFarY2U.utqGGZCjS6IorfX26C58niWnBpEzabR.', '2020-10-22 16:22:27'),
(18, 'user23', 'lkdsjflkasjdflk@sdlkjflkdsjaf.cms', '$2y$10$JKA59vzYxaAgfOChE9KACOcKHE04V7l0DABz1zeWdjyGL/V52nyP.', '2020-10-22 16:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `usersInfo`
--

CREATE TABLE `usersInfo` (
  `id_user` int NOT NULL,
  `title` char(60) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `avatar_id` varchar(14) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `usersInfo`
--

INSERT INTO `usersInfo` (`id_user`, `title`, `avatar_id`) VALUES
(2, 'HelloKitty', '1'),
(3, 'Administrator', '1'),
(4, 'Darek', '1'),
(5, 'Sudo', '1'),
(12, 'Vektor', '1'),
(13, 'WPWP', '1'),
(14, 'user2', '1'),
(15, 'username', '1'),
(16, 'sexy', '1'),
(17, 'saxy', '1'),
(18, 'user23', '1');

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
(18, 0, 0, 0);

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
  `thumbnailFile_id` int UNSIGNED NOT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `status` enum('public','private','unlisted') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT 'public',
  `upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id_video`, `title`, `description`, `views`, `rating`, `videoFile_id`, `thumbnailFile_id`, `author_id`, `status`, `upload_date`) VALUES
(2, 'Lorem ipsum dolor sit amet', 'Accumsan sit amet nulla facilisi. Amet nisl suscipit adipiscing bibendum est ultricies. Pulvinar pellentesque habitant morbi tristique senectus et netus et', 330, 0, 1, 1, 15, 'public', '2018-08-15 19:35:18'),
(3, 'Consectetur adipiscing elit', 'A arcu cursus vitae congue. Malesuada fames ac turpis egestas integer eget. Nibh tortor id aliquet lectus. Pretium vulputate sapien nec sagittis aliquam. Diam sit amet nisl suscipit adipiscing bibendum est ultricies.', 7936, 0, 2, 2, 14, 'public', '2020-10-24 19:35:18'),
(4, 'Sed do eiusmod tempor incididunt', 'Elit pellentesque habitant morbi tristique senectus et. Cursus risus at ultrices mi. Quam viverra orci sagittis eu volutpat odio facilisis mauris sit. Mattis nunc sed blandit libero volutpat sed. Sapien et ligula ullamcorper malesuada proin.', 97907, 0, 3, 3, 14, 'public', '2020-10-24 19:35:18'),
(5, 'Ut labore et dolore magna aliqua', 'Tincidunt ornare massa eget egestas purus. Pharetra massa massa ultricies mi. Non pulvinar neque laoreet suspendisse interdum.', 513537, 0, 4, 4, 17, 'public', '2020-10-24 19:35:18'),
(6, 'Feugiat in ante metus dictum at tempor commodo ullamcorper', 'Suspendisse in est ante in. Sit amet consectetur adipiscing elit ut. Euismod elementum nisi quis eleifend quam adipiscing vitae. Nam libero justo laoreet sit amet cursus.', 2630447, 0, 5, 5, 4, 'public', '2020-10-24 19:35:18');

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
(5, '00000004', 'mp4', 3);

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
  ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `comments_actions`
--
ALTER TABLE `comments_actions`
  ADD PRIMARY KEY (`id_commentsAction`);

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
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `usersPermissions`
--
ALTER TABLE `usersPermissions`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`);

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
  ADD PRIMARY KEY (`id_videosAction`);

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
  MODIFY `id_avatar` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments_actions`
--
ALTER TABLE `comments_actions`
  MODIFY `id_commentsAction` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thumbnailsFiles`
--
ALTER TABLE `thumbnailsFiles`
  MODIFY `id_thumbnail` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `videosFiles`
--
ALTER TABLE `videosFiles`
  MODIFY `id_videoFile` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `videos_actions`
--
ALTER TABLE `videos_actions`
  MODIFY `id_videosAction` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
