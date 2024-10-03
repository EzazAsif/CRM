-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2021 at 07:28 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `date_added`, `date_updated`) VALUES
(1, 'John', 'Smith', 'jsmith@sample.com', '39ce7e2a8573b41ce73b5ba41617f8f7', NULL, NULL, '2021-05-10 23:23:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `id` int(30) NOT NULL,
  `email` varchar(250) NOT NULL,
  `service_ids` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`id`, `email`, `service_ids`, `date_created`) VALUES
(1, 'jsmith@sample.com', '3,4,2', '2021-05-11 01:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `service` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `img_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `service`, `description`, `img_path`) VALUES
(2, 2, 'Service 102', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus placerat sem et porta sagittis. Cras interdum varius risus, quis tincidunt orci convallis quis. Sed eget orci augue. Pellentesque mollis blandit nibh, vitae dapibus diam fringilla sed. Integer elementum felis vel elit feugiat auctor. Nunc fermentum tincidunt enim, non dignissim turpis pharetra ac. Proin pellentesque commodo diam. Morbi sem risus, blandit in egestas eget, suscipit quis tellus. Aenean varius quis turpis eu maximus. Nam feugiat sollicitudin ex. Etiam mollis ultricies turpis, a faucibus neque laoreet non. Integer et magna ultrices, faucibus felis quis, blandit quam.', 'uploads/services/2_img.jpg'),
(3, 1, 'asdasd', 'asdasd', NULL),
(4, 1, 'Test 101', 'Sample', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services_category`
--

CREATE TABLE `services_category` (
  `id` int(30) NOT NULL,
  `category` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_category`
--

INSERT INTO `services_category` (`id`, `category`, `description`) VALUES
(1, 'Sample Category', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus placerat sem et porta sagittis. Cras interdum varius risus, quis tincidunt orci convallis quis. Sed eget orci augue. Pellentesque mollis blandit nibh, vitae dapibus diam fringilla sed. Integer elementum felis vel elit feugiat auctor. Nunc fermentum tincidunt enim, non dignissim turpis pharetra ac. Proin pellentesque commodo diam. Morbi sem risus, blandit in egestas eget, suscipit quis tellus. Aenean varius quis turpis eu maximus. Nam feugiat sollicitudin ex. Etiam mollis ultricies turpis, a faucibus neque laoreet non. Integer et magna ultrices, faucibus felis quis, blandit quam.'),
(2, 'Sample Category 102', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus placerat sem et porta sagittis. Cras interdum varius risus, quis tincidunt orci convallis quis. Sed eget orci augue. Pellentesque mollis blandit nibh, vitae dapibus diam fringilla sed. Integer elementum felis vel elit feugiat auctor. Nunc fermentum tincidunt enim, non dignissim turpis pharetra ac. Proin pellentesque commodo diam. Morbi sem risus, blandit in egestas eget, suscipit quis tellus. Aenean varius quis turpis eu maximus. Nam feugiat sollicitudin ex. Etiam mollis ultricies turpis, a faucibus neque laoreet non. Integer et magna ultrices, faucibus felis quis, blandit quam.');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Customer Relationship Management System'),
(4, 'intro', 'Hi! I&apos;m Johnny, a ChatBot of this application. How can I help you?'),
(6, 'short_name', 'CRMS'),
(10, 'no_result', 'I am sorry. I can&apos;t understand your question. Please rephrase your question and make sure it is related to this site. Thank you :)'),
(11, 'logo', 'uploads/1620608940_tech-logo.png'),
(12, 'bot_avatar', 'uploads/bot_avatar.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'welcome_message', '');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(30) NOT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(5) NOT NULL DEFAULT 0,
  `service_id` int(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `user_created` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `status`, `service_id`, `user_id`, `user_created`, `date_created`, `date_updated`) VALUES
(1, 'Sample Ticket 102', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus placerat sem et porta sagittis. Cras interdum varius risus, quis tincidunt orci convallis quis. Sed eget orci augue. Pellentesque mollis blandit nibh, vitae dapibus diam fringilla sed. Integer elementum felis vel elit feugiat auctor. Nunc fermentum tincidunt enim, non dignissim turpis pharetra ac. Proin pellentesque commodo diam. Morbi sem risus, blandit in egestas eget, suscipit quis tellus. Aenean varius quis turpis eu maximus. Nam feugiat sollicitudin ex. Etiam mollis ultricies turpis, a faucibus neque laoreet non. Integer et magna ultrices, faucibus felis quis, blandit quam.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif;\">Morbi tincidunt malesuada ullamcorper. Nam blandit eros sit amet gravida mollis. Etiam ullamcorper magna et enim tempor bibendum. In mollis lectus non tellus euismod imperdiet. Duis nec vestibulum leo. Vivamus vel metus mattis, fringilla erat in, blandit risus. Fusce dolor ligula, consequat vel varius vel, cursus nec nibh. Integer vel condimentum lorem. Aliquam tincidunt aliquam eros eu tincidunt.</p>', 2, 2, '-1', 'developer', '2021-05-10 13:59:54', '2021-05-10 21:55:55'),
(4, 'Sample 103', '<p>Sample only</p>', 0, 3, '1', 'user', '2021-05-10 23:38:52', '2021-05-10 23:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comment`
--

CREATE TABLE `ticket_comment` (
  `id` int(30) NOT NULL,
  `ticket_id` int(30) NOT NULL,
  `comment` text DEFAULT NULL,
  `user_id` varchar(30) NOT NULL,
  `user_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_comment`
--

INSERT INTO `ticket_comment` (`id`, `ticket_id`, `comment`, `user_id`, `user_created`, `date_created`) VALUES
(2, 1, 'Sample comment..', '-1', 'developer', '2021-05-10 16:36:21'),
(4, 1, 'Sample', '-1', 'developer', '2021-05-10 21:55:34'),
(5, 4, 'sample', '1', 'user', '2021-05-10 23:55:39'),
(6, 4, 'test', '1', 'admin', '2021-05-11 00:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1620656340_1605601740_download.jpg', NULL, '2021-01-20 14:02:37', '2021-05-10 22:19:01'),
(6, 'admin', 'admin1', 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', NULL, NULL, '2021-05-10 22:38:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_category`
--
ALTER TABLE `services_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services_category`
--
ALTER TABLE `services_category`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
