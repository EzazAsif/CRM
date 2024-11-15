-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 10:01 AM
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
(1, 'Alice', 'Wonder', 'alice@wonder.com', 'b2e98ad6f6eb8508dd6a14cfa704bad7', NULL, NULL, '2024-11-10 15:18:48', '2024-11-10 15:18:48'),
(2, 'Bob', 'Builder', 'bob@builder.com', 'e2fc714c4727ee9395f324cd2e7f331f', NULL, NULL, '2024-11-10 15:18:48', '2024-11-10 15:18:48'),
(3, 'Ezaz', 'Rafid', 'Ezaz', '9c72446df124ddf214b698c1e2312371', NULL, NULL, '2024-11-11 17:25:06', NULL);

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

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `Userid`, `event_date`, `event_time_from`, `event_time_to`, `title`, `created_at`) VALUES
(1, 1, '2024-11-01', '09:00:00', '10:00:00', 'Project Update', '2024-11-10 15:18:48'),
(2, 2, '2024-11-05', '10:30:00', '11:30:00', 'Client Call', '2024-11-10 15:18:48');

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
(1, 'alice@wonder.com', '1,2', '2024-11-10 15:18:48'),
(2, 'bob@builder.com', '2', '2024-11-10 15:18:48');

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
(1, 1, 'Website Design', 'Responsive website design service', 'path/to/image1.jpg'),
(2, 2, 'SEO', 'Search engine optimization services', 'path/to/image2.jpg');

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
(1, 'Web Development', 'Custom web development services'),
(2, 'Marketing', 'Digital marketing services');

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
(1, 'App Version', '1.0.0'),
(2, 'Database Version', '1.0.0');

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
  `customer_id` int(50) NOT NULL,
  `user_created` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `status`, `service_id`, `customer_id`, `user_created`, `date_created`, `date_updated`) VALUES
(1, 'System Error', 'Error occurred during update', 1, 1, 1, 'Alice Wonder', '2024-11-10 15:18:48', '2024-11-10 15:18:48'),
(2, 'Feature Request', 'Request for new feature in dashboard', 0, 2, 2, 'Bob Builder', '2024-11-10 15:18:48', '2024-11-10 15:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comment`
--

CREATE TABLE `ticket_comment` (
  `id` int(30) NOT NULL,
  `ticket_id` int(30) NOT NULL,
  `comment` text DEFAULT NULL,
  `customer_id` int(50) NOT NULL,
  `user_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_comment`
--

INSERT INTO `ticket_comment` (`id`, `ticket_id`, `comment`, `customer_id`, `user_created`, `date_created`) VALUES
(1, 1, 'Investigating the issue.', 1, 'Alice Wonder', '2024-11-10 15:18:49'),
(2, 2, 'Feature request has been noted.', 2, 'Bob Builder', '2024-11-10 15:18:49');

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
(1, 'John', 'Doe', 'johndoe', 'e99a18c428cb38d5f260853678922e03', NULL, NULL, '2024-11-10 15:18:48', '2024-11-10 15:18:48'),
(2, 'Jane', 'Smith', 'janesmith', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, '2024-11-10 15:18:48', '2024-11-10 15:18:48'),
(3, 'Ezaz', 'Asif', 'Admin', 'admin123', NULL, NULL, '2024-11-11 17:26:52', NULL),
(4, 'Ezaz', 'Asif', 'Admin', 'admin123', NULL, NULL, '2024-11-11 17:27:26', NULL),
(6, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1620656340_1605601740_download.jpg', NULL, '2021-01-20 14:02:37', '2021-05-10 22:19:01'),
(7, 'admin', 'admin1', 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', NULL, NULL, '2021-05-10 22:38:34', NULL);

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
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `customer_id` (`customer_id`);

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services_category`
--
ALTER TABLE `services_category`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`Userid`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `services_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_comment`
--
ALTER TABLE `ticket_comment`
  ADD CONSTRAINT `ticket_comment_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_comment_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
