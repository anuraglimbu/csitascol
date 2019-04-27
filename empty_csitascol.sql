-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2019 at 11:29 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_23801517_csitascol`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_pic` varchar(600) NOT NULL,
  `password` varchar(700) NOT NULL,
  `bio` varchar(1000) NOT NULL,
  `super_admin` int(11) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `firstname`, `lastname`, `username`, `email`, `profile_pic`, `password`, `bio`, `super_admin`, `num_posts`, `num_likes`) VALUES
(1, 'Anurag', 'Limbu', 'superadmin', 'testsuperadmin@mail.com', 'assets/images/profile_pics/defaults/1.png', '21232f297a57a5a743894a0e4a801fc3', 'I am just a random ordinary guy.', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(700) NOT NULL,
  `bio` text NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `signup_date`, `profile_pic`, `bio`, `num_posts`, `num_likes`, `admin`, `user_closed`, `friend_array`) VALUES
(1, 'testuser', 'Test', 'User', 'testuser123@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', '2019-03-09', 'assets/images/profile_pics/defaults/1.png', 'I am just a test user.', 0, 0, 1, 'no', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
