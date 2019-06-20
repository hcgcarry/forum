-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2019 年 05 月 19 日 21:27
-- 伺服器版本: 5.7.26-0ubuntu0.16.04.1
-- PHP 版本： 7.0.33-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `forum`
--

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `categoriesID` int(8) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `categories_describtion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `categories`
--

INSERT INTO `categories` (`categoriesID`, `categories_name`, `categories_describtion`) VALUES
(10, '國際新聞', '');

-- --------------------------------------------------------

--
-- 資料表結構 `comments`
--

CREATE TABLE `comments` (
  `postID` int(8) DEFAULT NULL,
  `replyID` int(8) DEFAULT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `memberID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `comments`
--

INSERT INTO `comments` (`postID`, `replyID`, `content`, `date`, `memberID`) VALUES
(1, NULL, 'fdsfsdf', '2019-05-19 09:00:04', 7),
(1, NULL, 'fsdfsd', '2019-05-19 09:00:07', 7);

-- --------------------------------------------------------

--
-- 資料表結構 `members`
--

CREATE TABLE `members` (
  `memberID` int(8) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `member_signup_date` datetime NOT NULL,
  `level` int(8) NOT NULL DEFAULT '0',
  `active` varchar(80) NOT NULL,
  `resetToken` varchar(200) DEFAULT 'no',
  `resetComplete` varchar(3) DEFAULT 'no',
  `selfDetail` varchar(300) DEFAULT NULL,
  `profile` varchar(100) DEFAULT '/forum/uploads/users/profile/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `members`
--

INSERT INTO `members` (`memberID`, `nickname`, `username`, `password`, `email`, `member_signup_date`, `level`, `active`, `resetToken`, `resetComplete`, `selfDetail`, `profile`) VALUES
(7, 'ko no dio da', 'hcgcarry', '$2y$10$maAdJBz2np7dWB9cvzXfpOo7m9Ittefwe5BU9wFUvtxq574QH015K', 'hcgcarry@gmail.com', '2018-08-25 09:40:44', 1, 'Yes', '55f48d76f47dadb51a847524d0b67618', 'Yes', 'wryyy', '/forum/uploads/users/profile/481258l.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `posts`
--

CREATE TABLE `posts` (
  `topic` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `memberID` int(8) NOT NULL,
  `categoriesID` int(8) NOT NULL,
  `postID` int(8) NOT NULL,
  `goodPoint` int(8) NOT NULL DEFAULT '0',
  `badPoint` int(8) NOT NULL DEFAULT '0',
  `hasGiveGoodPoint` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `hasGiveBadPoint` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `hasEdit` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `posts`
--

INSERT INTO `posts` (`topic`, `content`, `date`, `memberID`, `categoriesID`, `postID`, `goodPoint`, `badPoint`, `hasGiveGoodPoint`, `hasGiveBadPoint`, `hasEdit`) VALUES
('頭香', '如題', '2019-05-19 08:55:46', 7, 10, 1, 15, 12, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `replys`
--

CREATE TABLE `replys` (
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `memberID` int(8) NOT NULL,
  `postID` int(8) NOT NULL,
  `replyID` int(11) NOT NULL,
  `goodPoint` int(8) NOT NULL DEFAULT '0',
  `badPoint` int(8) NOT NULL DEFAULT '0',
  `hasGiveGoodPoint` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hasGiveBadPoint` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hasEdit` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoriesID`),
  ADD UNIQUE KEY `cat_name_unique` (`categories_name`);

--
-- 資料表索引 `comments`
--
ALTER TABLE `comments`
  ADD KEY `replyID` (`replyID`),
  ADD KEY `postID` (`postID`);

--
-- 資料表索引 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `categoriesID` (`categoriesID`);

--
-- 資料表索引 `replys`
--
ALTER TABLE `replys`
  ADD PRIMARY KEY (`replyID`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `categoriesID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 使用資料表 AUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `memberID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `replys`
--
ALTER TABLE `replys`
  MODIFY `replyID` int(11) NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`categoriesID`) REFERENCES `categories` (`categoriesID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
