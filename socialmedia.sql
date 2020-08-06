-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2020 at 08:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialmedia2`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seen`
--

CREATE TABLE `seen` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL DEFAULT 'Hello, I am a new user!',
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `banned` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `the_post` (`post_id`),
  ADD KEY `the_user` (`user_id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD KEY `followed_user` (`followed_user_id`),
  ADD KEY `this_user` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD KEY `user` (`user_id`),
  ADD KEY `post` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user` (`user_id`);

--
-- Indexes for table `seen`
--
ALTER TABLE `seen`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `the_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `the_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `followed_user` FOREIGN KEY (`followed_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `this_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `seen`
--
ALTER TABLE `seen`
  ADD CONSTRAINT `post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
