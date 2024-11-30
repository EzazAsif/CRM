-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 04:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `date_added`, `date_updated`) VALUES
(1, 'John', 'Smith', 'jsmith@sample.com', '39ce7e2a8573b41ce73b5ba41617f8f7', NULL, NULL, '2021-05-10 23:23:35', NULL),
(2, 'eZAZ', 'aSIF', 'Ezaz Asif', '57e290959274e7fc2f2b3a46ed35b50b', NULL, NULL, '2024-10-04 00:17:59', NULL),
(3, 'Ezaz', 'Rafid', 'EzazAsif', '9c72446df124ddf214b698c1e2312371', NULL, NULL, '2024-10-04 14:57:23', NULL),
(4, 'Ezaz', 'Rafid', 'Ezaz', '9c72446df124ddf214b698c1e2312371', NULL, NULL, '2024-11-30 20:56:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `Userid` int(50) DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time_from` time NOT NULL,
  `event_time_to` time NOT NULL,
  `title` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `id` int(30) NOT NULL,
  `email` varchar(250) NOT NULL,
  `service_ids` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`id`, `email`, `service_ids`, `date_created`) VALUES
(1, 'jsmith@sample.com', '3,4,2', '2021-05-11 01:08:50'),
(3, 'asifrafid8399@gmail.com', '3', '2024-10-30 15:09:59'),
(1, 'jsmith@sample.com', '3,4,2', '2021-05-11 01:08:50'),
(3, 'asifrafid8399@gmail.com', '3', '2024-10-30 15:09:59'),
(1, 'jsmith@sample.com', '3,4,2', '2021-05-11 01:08:50'),
(3, 'asifrafid8399@gmail.com', '3', '2024-10-30 15:09:59'),
(0, 'asifrafid8399@gmail.com', '3', '2024-11-30 20:56:27'),
(0, 'ishzaz.rafid@northsouth.edu', '4', '2024-11-30 20:56:34'),
(0, 'admin@gmail.com', '6', '2024-11-30 20:56:39');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `service`, `description`, `img_path`) VALUES
(3, 1, 'asdasd', 'asdasd', NULL),
(4, 1, 'Test 101', 'Sample', NULL),
(5, 1, 'yguyg', 'iuh', NULL),
(6, 2, 'knonjolm', 'ijubhiuj', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services_category`
--

CREATE TABLE `services_category` (
  `id` int(30) NOT NULL,
  `category` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Innovative Collection'),
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
  `user_id` int(50) NOT NULL,
  `user_created` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `status`, `service_id`, `user_id`, `user_created`, `date_created`, `date_updated`) VALUES
(4, 'Sample 103', '<p>Sample only</p>', 0, 3, 1, 'user', '2021-05-10 23:38:52', '2021-05-10 23:38:52'),
(5, 'yghhiguy', '<p>ughguyg</p>', 1, 4, 2, 'user', '2024-10-04 00:32:29', '2024-11-30 20:57:51'),
(6, 'hibhou', '<p>y7f678ykioh7tyf</p>', 0, 6, 4, 'user', '2024-11-30 20:56:48', '2024-11-30 20:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comment`
--

CREATE TABLE `ticket_comment` (
  `id` int(30) NOT NULL,
  `ticket_id` int(30) NOT NULL,
  `comment` text DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  `user_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_comment`
--

INSERT INTO `ticket_comment` (`id`, `ticket_id`, `comment`, `user_id`, `user_created`, `date_created`) VALUES
(5, 4, 'sample', 1, 'user', '2021-05-10 23:55:39'),
(6, 4, 'test', 1, 'admin', '2021-05-11 00:02:06');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Userid` (`Userid`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`Userid`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `services_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
  ADD CONSTRAINT `ticket_comment_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
