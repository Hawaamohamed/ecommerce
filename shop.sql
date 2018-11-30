-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 09:22 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `allow_comment` tinyint(4) NOT NULL DEFAULT '0',
  `allow_ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `parent`, `ordering`, `visibility`, `allow_comment`, `allow_ads`) VALUES
(5, 'Rings', '', 0, 1, 0, 0, 0),
(6, 'Bracelets', '', 0, 2, 0, 0, 0),
(7, 'Necklace', '', 0, 3, 0, 0, 0),
(9, 'Diamond', '', 0, 5, 0, 0, 0),
(12, 'Silver', '', 0, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(2, 'This Comment This Comment ', 0, '2018-08-15', 3, 1),
(3, 'This Comment This Comment ', 0, '2018-08-30', 4, 5),
(4, 'Second Comment', 1, '2018-08-07', 3, 1),
(5, 'Phone Comment', 1, '2018-08-17', 9, 1),
(15, 'Well Computer', 1, '2018-08-17', 9, 1),
(16, 'Well Computer', 0, '2018-08-17', 9, 1),
(17, 'Well Computer', 0, '2018-08-17', 9, 1),
(18, 'Well Computer', 0, '2018-08-17', 9, 1),
(19, 'Well Computer', 0, '2018-08-17', 9, 1),
(20, 'Well Computer', 0, '2018-08-17', 9, 1),
(21, 'Well Computer', 0, '2018-08-17', 9, 1),
(22, 'Well Computer', 0, '2018-08-17', 9, 1),
(23, 'Well Computer', 0, '2018-08-17', 9, 1),
(24, 'Well Computer', 0, '2018-08-17', 9, 1),
(25, 'Well Computer', 0, '2018-08-17', 9, 1),
(26, 'Well Computer', 0, '2018-08-17', 9, 1),
(27, 'Well Computer', 0, '2018-08-17', 9, 1),
(28, 'Well Computer', 0, '2018-08-17', 9, 1),
(29, 'Well Computer', 0, '2018-08-17', 9, 1),
(30, 'Well Computer', 0, '2018-08-17', 9, 1),
(31, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 1, '2018-08-17', 9, 1),
(32, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(33, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(34, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(35, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(36, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(37, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(38, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(39, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(40, 'nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment nice comment', 0, '2018-08-17', 9, 1),
(41, 'comment', 0, '2018-08-17', 9, 1),
(42, 'comment', 0, '2018-08-17', 9, 1),
(43, 'comment', 0, '2018-08-17', 9, 1),
(44, 'comment', 0, '2018-08-17', 9, 1),
(45, 'jvnvjnjvjv', 0, '2018-08-17', 9, 1),
(46, 'jvnvjnjvjv', 0, '2018-08-17', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `approve` smallint(6) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL,
  `memberid` int(11) NOT NULL,
  `size` tinyint(4) NOT NULL,
  `caliber` tinyint(4) NOT NULL,
  `grammes` tinyint(4) NOT NULL,
  `address` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `shop` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `shopid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemid`, `name`, `description`, `price`, `add_date`, `country_made`, `image`, `status`, `rating`, `approve`, `catid`, `memberid`, `size`, `caliber`, `grammes`, `address`, `tags`, `shop`, `city`, `shopid`) VALUES
(51, '', '', 0, '2018-11-30', '', '2.jpg', '', 0, 0, 5, 1, 21, 21, 5, 'ElZamalik', '', 'El3dawy', 'Cairo', 1),
(54, '', '', 0, '2018-11-30', '', '3.jpg', '', 0, 0, 5, 1, 23, 24, 10, 'Eljomhoria', '', 'El3dawy', 'Assiut', 1),
(59, '', '', 0, '2018-11-30', '', '1.png', '', 0, 0, 9, 1, 25, 21, 8, 'ElZamalik', '', 'El3dawy', 'Cairo', 1),
(62, '', '', 0, '2018-11-30', '', 'pexels-photo-713148.jpeg', '', 0, 0, 12, 1, 56, 21, 76, 'Assiut', '', 'El3dawy', 'Assiut', 1),
(66, '', '', 0, '2018-11-30', '', '21.jpeg', '', 0, 0, 12, 1, 20, 24, 20, 'Alex', '', 'El3dawy', 'Alex', 1),
(68, '', '', 0, '2018-11-30', '', '22.jpeg', '', 0, 0, 12, 1, 18, 18, 20, 'Menia', '', 'El3dawy', 'Menia', 1),
(73, '', '', 0, '2018-11-30', '', '24.jpeg', '', 0, 0, 7, 1, 27, 24, 15, 'Assiut', '', 'AlMokhtar', 'Assiut', 2),
(74, '', '', 0, '2018-11-30', '', '26.jpeg', '', 0, 0, 12, 1, 20, 24, 17, 'Sohage', '', 'AlMokhtar', 'Sohage', 2),
(75, '', '', 0, '2018-11-30', '', '27.jpeg', '', 0, 0, 7, 1, 20, 24, 22, 'Assiut', '', 'AlMokhtar', 'Assiut', 2),
(76, '', '', 0, '2018-11-30', '', '23.jpg', '', 0, 0, 9, 1, 20, 21, 13, 'Assiut', '', 'AlMokhtar', 'Assiut', 2),
(77, '', '', 0, '2018-11-30', '', '30.jpg', '', 0, 0, 7, 1, 26, 24, 22, 'Cairo', '', 'AlMokhtar', 'Cairo', 2),
(78, '', '', 0, '2018-11-30', '', '31.jpg', '', 0, 0, 7, 1, 25, 18, 16, 'Sohage', '', 'AlMokhtar', 'Sohage', 2),
(79, '', '', 0, '2018-11-30', '', '32.jpg', '', 0, 0, 9, 1, 45, 21, 11, 'Assiut', '', 'AlMokhtar', 'Assiut', 2),
(80, '', '', 0, '2018-11-30', '', '10.jpg', '', 0, 0, 12, 1, 19, 21, 9, 'Assiut', '', 'AlMokhtar', 'Assiut', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `name`, `address`, `city`, `userid`) VALUES
(1, 'El3dawy', 'Eljomhoria', 'Assiut', 1),
(2, 'AlMokhtar', 'Assiut', 'Assiut', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL COMMENT 'to identify user',
  `username` varchar(255) NOT NULL COMMENT 'username to login',
  `password` varchar(255) NOT NULL COMMENT 'password to login',
  `email` varchar(255) NOT NULL COMMENT 'username to login',
  `fullname` varchar(255) NOT NULL COMMENT 'password to login',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT 'identify user group',
  `truststatus` int(11) NOT NULL DEFAULT '0' COMMENT 'seller rank',
  `ragstatus` int(11) NOT NULL DEFAULT '0' COMMENT 'user approval',
  `shop` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `email`, `fullname`, `groupid`, `truststatus`, `ragstatus`, `shop`, `date`, `avatar`) VALUES
(1, 'hawaa', '1c3f0880538889b1be354bbb17afedda41cf3358', 'hawaamohamed111@outlook.com', 'hawaa mohamed mohamed', 1, 0, 1, '', '0000-00-00', '356842_1.jpg'),
(3, 'Adam', '46295fcb2eee0ac3b097d6e78562910fe9d7f27b', 'hawaamohamed111@outlook.com', 'adam', 0, 0, 1, '', '0000-00-00', ''),
(7, 'Dina', 'ed6e2ba79981a2b7a2bfe64abc4ba40b6586e391', 'dina@gmail.com', 'Mohamed', 0, 0, 1, '', '2018-07-14', ''),
(8, 'salma', '0592b3308a5a9a46e632dc552a14a74bb6edbcfd', 'salma@gmail.com', 'salma', 0, 0, 1, '', '2018-07-15', ''),
(9, 'marwa', '1f9f97582f558e614feb188c622eba1daecddc15', 'marwa@gmail.com', 'marwa', 0, 0, 1, '', '2018-07-15', ''),
(10, 'nada', 'a3fcfe3a3beb195ab63588e6190e6129bdcd7a87', 'nada@gmail.com', 'nada', 0, 0, 1, '', '2018-07-15', ''),
(11, 'asmaa', '720b38554914ac1c7eedc9f8b82abb63f5de4b58', 'asmaa@gmail.com', 'asmaa', 0, 0, 1, '', '2018-07-15', ''),
(12, 'adnan', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'adnan@gmail.com', '', 0, 0, 1, '', '2018-08-15', ''),
(13, 'jehad', '1c6637a8f2e1f75e06ff9984894d6bd16a3a36a9', 'jehad@gmail.com', '', 0, 0, 1, '', '2018-08-15', ''),
(14, 'mohameddd', 'd34fa1f8f0b1a76ae79daca432f5ad6c21b71e0c', 'moh@gmail.com', '', 0, 0, 1, '', '2018-08-15', ''),
(19, 'mama', '99df988b77e60a1718e9e6fecdaf22552047be28', 'mama@gmail.com', '', 0, 0, 0, 'mama', '2018-11-30', ''),
(28, 'qqq', 'a056c8d05ae9ac6ca180bc991b93b7ffe37563e0', 'qqq@ii', '', 0, 0, 0, 'qqq', '2018-11-30', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `shopid` (`shopid`),
  ADD KEY `catid` (`catid`),
  ADD KEY `catid_2` (`catid`),
  ADD KEY `memberid` (`memberid`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify user', AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
