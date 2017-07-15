-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2017 at 08:36 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `songs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` smallint(6) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `filepostfix` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `thumbw` int(3) NOT NULL,
  `thumbh` int(3) NOT NULL,
  `set` varchar(255) NOT NULL,
  `dthumbw` int(3) NOT NULL,
  `dthumbh` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `sitename`, `filepostfix`, `title`, `thumbw`, `thumbh`, `set`, `dthumbw`, `dthumbh`) VALUES
(1, 'admin', 'admin', 'ravi2katre@gmail.com', 'whooore.com', '-whooore.com', 'Welcome to whooore.com', 50, 60, 'aHR0cDovL3NhdGlzaHdhcC5jb20v', 50, 60);

-- --------------------------------------------------------

--
-- Table structure for table `admin_groups`
--

CREATE TABLE `admin_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_groups`
--

INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES
(1, 'webmaster', 'Webmaster'),
(2, 'admin', 'Administrator'),
(3, 'manager', 'Manager'),
(4, 'staff', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_attempts`
--

CREATE TABLE `admin_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_setting`
--

CREATE TABLE `admin_setting` (
  `id` double NOT NULL,
  `name` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `value` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `adminsetting_id` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES
(1, '127.0.0.1', 'webmaster', '$2y$08$/X5gzWjesYi78GqeAv5tA.dVGBVP7C1e1PzqnYCVe5s1qhlDIPPES', NULL, NULL, NULL, NULL, NULL, NULL, 1451900190, 1499952371, 1, 'Webmaster', ''),
(2, '127.0.0.1', 'admin', '$2y$08$7Bkco6JXtC3Hu6g9ngLZDuHsFLvT7cyAxiz1FzxlX5vwccvRT7nKW', NULL, NULL, NULL, NULL, NULL, NULL, 1451900228, 1465489580, 1, 'Admin', ''),
(3, '127.0.0.1', 'manager', '$2y$08$snzIJdFXvg/rSHe0SndIAuvZyjktkjUxBXkrrGdkPy1K6r5r/dMLa', NULL, NULL, NULL, NULL, NULL, NULL, 1451900430, 1465489585, 1, 'Manager', ''),
(4, '127.0.0.1', 'staff', '$2y$08$NigAXjN23CRKllqe3KmjYuWXD5iSRPY812SijlhGeKfkrMKde9da6', NULL, NULL, NULL, NULL, NULL, NULL, 1451900439, 1465489590, 1, 'Staff', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users_groups`
--

CREATE TABLE `admin_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users_groups`
--

INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `api_access`
--

CREATE TABLE `api_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(40) NOT NULL DEFAULT '',
  `controller` varchar(50) NOT NULL DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'anonymous', 1, 1, 0, NULL, 1463388382);

-- --------------------------------------------------------

--
-- Table structure for table `api_limits`
--

CREATE TABLE `api_limits` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_logs`
--

CREATE TABLE `api_logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parentid` double NOT NULL,
  `name` varchar(256) NOT NULL,
  `path` text NOT NULL,
  `pathc` text NOT NULL,
  `totalitem` double NOT NULL,
  `folder` text NOT NULL,
  `newitemtag` tinyint(1) NOT NULL,
  `updateitemtag` tinyint(1) NOT NULL,
  `subcate` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `clink` text NOT NULL,
  `des` text NOT NULL,
  `thumb` text NOT NULL,
  `kram` double NOT NULL,
  `sub` text NOT NULL,
  `tags` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parentid`, `name`, `path`, `pathc`, `totalitem`, `folder`, `newitemtag`, `updateitemtag`, `subcate`, `date`, `clink`, `des`, `thumb`, `kram`, `sub`, `tags`) VALUES
(1, 0, 'Bollywood Music', '&nbsp;&raquo;&nbsp;<a href="?pid=1">Bollywood Music</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/1/Bollywood Music.html">Bollywood Music</a>', 1, 'upload_files/1/', 0, 0, 0, '2017-06-26 12:12:56', 'Bollywood Music', '', '', 0, '', NULL),
(2, 0, 'DJ Remix Mp3 Songs', '&nbsp;&raquo;&nbsp;<a href="?pid=2">DJ Remix Mp3 Songs</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/2/DJ Remix Mp3 Songs.html">DJ Remix Mp3 Songs</a>', 1, 'upload_files/2/', 0, 0, 0, '2017-06-26 12:12:57', 'DJ Remix Mp3 Songs', '', '', 0, '', NULL),
(3, 0, 'Indipop Mp3 Songs', '&nbsp;&raquo;&nbsp;<a href="?pid=3">Indipop Mp3 Songs</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/3/Indipop Mp3 Songs.html">Indipop Mp3 Songs</a>', 1, 'upload_files/3/', 0, 0, 0, '2017-06-26 12:12:57', 'Indipop Mp3 Songs', '', '', 0, '', NULL),
(4, 0, 'Instrumental Songs Collections', '&nbsp;&raquo;&nbsp;<a href="?pid=4">Instrumental Songs Collections</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/4/Instrumental Songs Collections.html">Instrumental Songs Collections</a>', 1, 'upload_files/4/', 0, 0, 0, '2017-06-26 12:12:57', 'Instrumental Songs Collections', '', '', 0, '', NULL),
(5, 0, 'Punjabi Music', '&nbsp;&raquo;&nbsp;<a href="?pid=5">Punjabi Music</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/5/Punjabi Music.html">Punjabi Music</a>', 0, 'upload_files/5/', 0, 0, 1, '2017-06-26 12:12:57', 'Punjabi Music', '', '8340e-47-download-gif-124.gif', 0, '', NULL),
(6, 5, '2016', '&nbsp;&raquo;&nbsp;<a href="?pid=5">Punjabi Music</a>&nbsp;&raquo;&nbsp;<a href="?pid=6">2016</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/5/Punjabi Music.html">Punjabi Music</a>&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/6/2016.html">2016</a>', 1, 'upload_files/5/6/', 0, 0, 0, '2017-06-26 12:12:57', 'Punjabi Music/2016', '', '', 0, '', NULL),
(7, 5, '2017', '&nbsp;&raquo;&nbsp;<a href="?pid=5">Punjabi Music</a>&nbsp;&raquo;&nbsp;<a href="?pid=7">2017</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/5/Punjabi Music.html">Punjabi Music</a>&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/7/2017.html">2017</a>', 1, 'upload_files/5/7/', 0, 0, 0, '2017-06-26 12:12:57', 'Punjabi Music/2017', '', '', 0, '', NULL),
(8, 5, '2018', '&nbsp;&raquo;&nbsp;<a href="?pid=5">Punjabi Music</a>&nbsp;&raquo;&nbsp;<a href="?pid=8">2018</a>', '&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/5/Punjabi Music.html">Punjabi Music</a>&nbsp;&raquo;&nbsp;<a href="http://songs.ravikatre.in/category/8/2018.html">2018</a>', 0, 'upload_files/5/8/', 0, 0, 0, '2017-07-12 07:06:31', 'Punjabi Music/2018', '', '', 3, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cat_pages`
--

CREATE TABLE `cat_pages` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_servers`
--

CREATE TABLE `client_servers` (
  `id` int(11) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `mp3_thumb` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL DEFAULT '',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `track` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dowload_count`
--

CREATE TABLE `dowload_count` (
  `id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` double NOT NULL,
  `name` text NOT NULL,
  `dname` text NOT NULL,
  `cid` double NOT NULL,
  `ext` varchar(5) NOT NULL,
  `thumbext` varchar(5) NOT NULL,
  `size` varchar(10) NOT NULL,
  `desc` text NOT NULL,
  `download` double NOT NULL,
  `view` double NOT NULL,
  `newtag` tinyint(1) NOT NULL,
  `imagetype` tinyint(1) NOT NULL,
  `kram` int(11) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `name`, `dname`, `cid`, `ext`, `thumbext`, `size`, `desc`, `download`, `view`, `newtag`, `imagetype`, `kram`, `meta_keywords`, `meta_description`, `entry_date`) VALUES
(1, '13122013746', '13122013746', 1, 'jpg', 'jpg', '1415012', '', 0, 0, 0, 1, 0, '', '', '2017-06-26 12:12:56'),
(2, '13122013746', '13122013746', 2, 'jpg', 'jpg', '1415012', '', 0, 0, 0, 1, 0, '', '', '2017-06-26 12:12:57'),
(3, '13122013746', '13122013746', 3, 'jpg', 'jpg', '1415012', '', 0, 0, 0, 1, 0, '', '', '2017-06-26 12:12:57'),
(4, '13122013746', '13122013746', 4, 'jpg', 'jpg', '1415012', '', 0, 0, 0, 1, 0, '', '', '2017-06-26 12:12:57'),
(5, '13122013746', '13122013746', 6, 'jpg', 'jpg', '1415012', '', 0, 0, 0, 1, 0, '', '', '2017-06-26 12:12:57'),
(6, '13122013746', '13122013746', 7, 'jpg', 'jpg', '1415012', '', 0, 0, 0, 1, 0, '', '', '2017-06-26 12:12:57');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `guest_book`
--

CREATE TABLE `guest_book` (
  `id` double NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uagent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uprofile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `guest_book`
--

INSERT INTO `guest_book` (`id`, `name`, `mobile`, `email`, `message`, `ip`, `flag`, `uagent`, `uprofile`, `date`) VALUES
(52384, 'gggg', '1111111111', 'ravi2katre@gmail.com', 'ff', '127.0.0.1', '(Private Address)', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0', '', '2012-11-06 18:22:46'),
(52385, 'ravi', '6666666666', 'ravi2katre@gmail.com', 'hi testing', '127.0.0.1', '(Private Address)', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0', '', '2012-11-21 19:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` mediumtext,
  `slug` varchar(100) NOT NULL DEFAULT '#',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `meta_tag` varchar(100) NOT NULL DEFAULT '#',
  `meta_keywords` mediumtext,
  `meta_description` text NOT NULL,
  `meta_title` varchar(100) NOT NULL DEFAULT '#',
  `sort` int(4) NOT NULL DEFAULT '100',
  `disabled` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `description`, `slug`, `parent_id`, `meta_tag`, `meta_keywords`, `meta_description`, `meta_title`, `sort`, `disabled`) VALUES
(5, 'Salman Khan', NULL, 'salman-khan', 0, '', NULL, '', '', 0, 0),
(6, 'Ravi Katre', '<div class="g">\r\n	<div data-hveid="49" data-ved="0ahUKEwjlmp3bn4PVAhVDC8AKHeJlBi4QFQgxKAEwAQ">\r\n		<div class="rc">\r\n			<h3 class="r">\r\n				<a href="https://www.google.co.in/url?sa=t&amp;rct=j&amp;q=&amp;esrc=s&amp;source=web&amp;cd=2&amp;cad=rja&amp;uact=8&amp;ved=0ahUKEwjlmp3bn4PVAhVDC8AKHeJlBi4QFggyMAE&amp;url=https%3A%2F%2Fstackoverflow.com%2Fquestions%2F19397386%2Fgrocery-crud-multiselect-field&amp;usg=AFQjCNEWFIqxIzaUvKSPLkKAzhWzVR1P3A" target="_blank">multi select - grocery crud multiselect field - Stack Overflow</a></h3>\r\n			<div class="s">\r\n				<div>\r\n					<div class="f kv _SWb" style="white-space:nowrap">\r\n						<cite class="_Rm">https://stackoverflow.com/questions/19397386/grocery-crud-multiselect-field</cite></div>\r\n				</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<div class="g">\r\n	<div data-hveid="49" data-ved="0ahUKEwjlmp3bn4PVAhVDC8AKHeJlBi4QFQgxKAEwAQ">\r\n		<div class="rc">\r\n			<div class="s">\r\n				<div>\r\n					<span class="st"><span class="f">Oct 16, 2013 - </span>You need to actually do a foreach here. In our case you need to do something like this&nbsp;...</span></div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<h3 class="r">\r\n	<a href="https://www.google.co.in/url?sa=t&amp;rct=j&amp;q=&amp;esrc=s&amp;source=web&amp;cd=3&amp;cad=rja&amp;uact=8&amp;ved=0ahUKEwjlmp3bn4PVAhVDC8AKHeJlBi4QFgg4MAI&amp;url=https%3A%2F%2Fstackoverflow.com%2Fquestions%2F31075573%2Fgrocery-crud-multi-select-drop-down-list&amp;usg=AFQjCNFJLjCzh6QX0czD6CNlqgUj6-m5ow" target="_blank">codeigniter - Grocery CRUD multi select drop down list - Stack Overflow</a></h3>\r\n<p>\r\n	<cite class="_Rm">https://stackoverflow.com/questions/.../grocery-crud-multi-select-drop-down-list</cite></p>\r\n', 'ravi-katre', 0, '', NULL, '', '', 0, 0),
(7, 'My second page', NULL, 'my-second-page', 0, '', NULL, '', '#', 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag_pages`
--

CREATE TABLE `tag_pages` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `update`
--

CREATE TABLE `update` (
  `id` double NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `home` tinyint(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `update`
--

INSERT INTO `update` (`id`, `name`, `link`, `home`, `date`) VALUES
(17, 'file3', 'http://www.whoore.com', 1, '2012-11-22 01:09:56'),
(18, 'Cattwo', 'http://www.whoore.com', 1, '2012-11-22 01:32:21'),
(19, 'Catone', 'http://www.whoore.com', 1, '2012-11-22 01:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'member', '$2y$08$kkqUE2hrqAJtg.pPnAhvL.1iE7LIujK5LZ61arONLpaBBWh/ek61G', NULL, 'member@member.com', NULL, NULL, NULL, NULL, 1451903855, 1451905011, 1, 'Member', 'One', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_groups`
--
ALTER TABLE `admin_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login_attempts`
--
ALTER TABLE `admin_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_setting`
--
ALTER TABLE `admin_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_access`
--
ALTER TABLE `api_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_limits`
--
ALTER TABLE `api_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_logs`
--
ALTER TABLE `api_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_index` (`id`),
  ADD KEY `date_index` (`date`),
  ADD KEY `parentid_index` (`parentid`),
  ADD KEY `kramindex` (`kram`);

--
-- Indexes for table `cat_pages`
--
ALTER TABLE `cat_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `client_servers`
--
ALTER TABLE `client_servers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain` (`domain`);

--
-- Indexes for table `dowload_count`
--
ALTER TABLE `dowload_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_index` (`id`),
  ADD KEY `download_index` (`download`),
  ADD KEY `kramindex` (`kram`),
  ADD KEY `cidindex` (`cid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_book`
--
ALTER TABLE `guest_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fuseaction` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_pages`
--
ALTER TABLE `tag_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `update`
--
ALTER TABLE `update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admin_groups`
--
ALTER TABLE `admin_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `admin_login_attempts`
--
ALTER TABLE `admin_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_setting`
--
ALTER TABLE `admin_setting`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `api_access`
--
ALTER TABLE `api_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `api_limits`
--
ALTER TABLE `api_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `api_logs`
--
ALTER TABLE `api_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cat_pages`
--
ALTER TABLE `cat_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `client_servers`
--
ALTER TABLE `client_servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dowload_count`
--
ALTER TABLE `dowload_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `guest_book`
--
ALTER TABLE `guest_book`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52386;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tag_pages`
--
ALTER TABLE `tag_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `update`
--
ALTER TABLE `update`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cat_pages`
--
ALTER TABLE `cat_pages`
  ADD CONSTRAINT `key_parent_cat` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_parent_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tag_pages`
--
ALTER TABLE `tag_pages`
  ADD CONSTRAINT `key_tag_pages_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_tag_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
