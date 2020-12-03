-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sayal_schedule.articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `FK_articles_users` (`user_id`),
  CONSTRAINT `FK_articles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.articles: ~16 rows (approximately)
DELETE FROM `articles`;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`id`, `user_id`, `title`, `excerpt`, `body`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Getting to Know Laravel', 'This is very interesting book', 'Getting to Knoe Us is a very interessting book. A must read', '2020-09-30 12:23:53', '2020-10-05 11:06:02'),
	(2, 4, 'Visual Foxpro ', 'This is very nice book.', 'Visual Foxpro is a very interessting book. A must read', '2020-09-30 13:23:54', '2020-10-05 11:07:31'),
	(3, 1, 'PC Software Made Simple', 'This is very beautiful book', 'PC Software Made Simple is a very interessting book. A must read', '2020-09-30 14:23:56', '2020-10-04 18:10:05'),
	(4, 1, 'Laravel Book', 'A lovely book', 'Laravel Book  is a very interessting book. A must read', '2020-09-30 16:23:57', '2020-10-04 18:10:09'),
	(5, 5, 'Laravel Articles', 'A good book', 'Laravel Articles  is a very interessting book. A must read', '2020-09-30 16:23:57', '2020-10-04 18:10:21'),
	(6, 1, 'My New Article', 'How to enable the snippets on a file other than html?', 'How to enable the snippets on a file other than html? The easiest way is to start a git issue, I will attempt to answer ASAP else I hope someone else will answer.', '2020-10-01 19:52:24', '2020-10-04 18:10:24'),
	(14, 5, 'Est iure neque ut voluptatem accusantium ex blanditiis.', 'Eos ea saepe architecto doloremque optio ut eligendi.', 'Voluptatem alias optio veritatis mollitia. Officia ut quae molestiae assumenda minus et quos. Harum suscipit et error enim.', '2020-10-05 13:44:16', '2020-10-05 13:44:16'),
	(15, 5, 'Per-defined Article', 'Voluptas facilis laborum suscipit culpa.', 'Quae iure rerum numquam eaque iste molestiae impedit. Doloremque dolorem quam sit aut. Provident nostrum provident eveniet consequatur nulla earum sed quasi.', '2020-10-05 13:48:37', '2020-10-05 13:48:37'),
	(16, 5, 'New Title', 'Article with hardcoded userID 5', 'Article with hardcoded userID 5', '2020-10-06 15:27:11', '2020-10-06 15:27:11'),
	(19, 5, 'Article with Tags 3', 'Article with Tags', 'Article with Tags', '2020-10-06 16:52:38', '2020-10-06 16:52:38'),
	(21, 5, 'adsf asdfadsf', 'CZXc', 'zxcZXc', '2020-10-06 21:08:38', '2020-10-06 21:08:38'),
	(22, 5, 'Trough only method', 'EX Trough only method', 'Trough only method body', '2020-10-06 21:09:42', '2020-10-06 21:09:42'),
	(26, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:12:31', '2020-10-13 17:12:31'),
	(27, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:40:41', '2020-10-13 17:40:41'),
	(28, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:44:36', '2020-10-13 17:44:36'),
	(29, 5, 'Dayle', 'Dayle Excerpt', NULL, '2020-10-13 17:45:45', '2020-10-13 17:45:45');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.article_tag
CREATE TABLE IF NOT EXISTS `article_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_id` (`article_id`,`tag_id`),
  KEY `FK_article_tag_tag` (`tag_id`),
  CONSTRAINT `FK_article_tag_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `FK_article_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COMMENT='many to many relationship table to link articles with tags';

-- Dumping data for table sayal_schedule.article_tag: ~14 rows (approximately)
DELETE FROM `article_tag`;
/*!40000 ALTER TABLE `article_tag` DISABLE KEYS */;
INSERT INTO `article_tag` (`id`, `article_id`, `tag_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2020-10-05 11:06:29', '2020-10-05 11:06:29'),
	(2, 1, 2, '2020-10-05 11:06:45', '2020-10-05 11:06:45'),
	(3, 1, 3, '2020-10-05 11:06:50', '2020-10-05 11:06:50'),
	(4, 2, 3, '2020-10-05 11:07:54', '2020-10-05 11:07:54'),
	(5, 2, 7, '2020-10-05 11:08:02', '2020-10-05 11:08:02'),
	(7, 15, 1, '2020-10-06 12:35:39', '2020-10-06 12:35:39'),
	(8, 15, 5, '2020-10-06 12:35:39', '2020-10-06 12:35:39'),
	(9, 19, 1, '2020-10-06 12:52:38', '2020-10-06 12:52:38'),
	(10, 19, 3, '2020-10-06 12:52:38', '2020-10-06 12:52:38'),
	(11, 21, 1, '2020-10-06 17:08:39', '2020-10-06 17:08:39'),
	(12, 21, 3, '2020-10-06 17:08:39', '2020-10-06 17:08:39'),
	(13, 22, 1, '2020-10-06 17:09:42', '2020-10-06 17:09:42'),
	(14, 22, 3, '2020-10-06 17:09:42', '2020-10-06 17:09:42'),
	(15, 22, 4, '2020-10-06 17:09:42', '2020-10-06 17:09:42');
/*!40000 ALTER TABLE `article_tag` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.assignments
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.assignments: ~3 rows (approximately)
DELETE FROM `assignments`;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` (`id`, `body`, `completed`, `created_at`, `updated_at`, `due_date`) VALUES
	(1, 'Complete this assignment within 7 days', 1, '2020-09-28 19:23:43', '2020-09-28 19:57:35', NULL),
	(3, 'Second Assignment', 1, NULL, '2020-09-28 20:03:48', NULL),
	(4, 'Third Assignment (Big)', 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'created by user id',
  `update_user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Id of user who last updated it ',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'ON',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Hold','Past') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_clients_users` (`user_id`),
  KEY `FK_clients_users_2` (`update_user_id`),
  CONSTRAINT `FK_clients_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_clients_users_2` FOREIGN KEY (`update_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.clients: ~10 rows (approximately)
DELETE FROM `clients`;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`, `user_id`, `update_user_id`, `firstname`, `lastname`, `address`, `city`, `postalcode`, `province`, `phone`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'John', 'Lee', '5 XYZ Street', 'Scarborough', 'L7Y 2N6', 'ON', '4161111222', NULL, 'Active', '2020-10-22 17:24:28', '2020-10-24 16:27:31'),
	(2, 1, NULL, 'Mary', 'Comb', '9 ABC Street', 'Toronto', 'L7Y 1A4', 'ON', '4161111345', NULL, 'Active', '2020-10-22 17:27:42', '2020-10-24 16:27:35'),
	(3, 1, NULL, 'Phil', 'Anderson', '5 Bloor Street', 'Etobicoke', 'L7Y 1A3', 'ON', '416-1111-456', NULL, 'Active', '2020-10-22 17:28:06', '2020-10-24 16:27:21'),
	(4, 2, NULL, 'Brian', 'Greenspan', '5 Sample Av', 'North York', 'L7Y 1A2', 'ON', '416-1111-234', 'brian@brian.com', 'Active', '2020-10-22 17:28:45', '2020-11-04 14:27:42'),
	(5, 2, NULL, 'Kevin', 'Sanu', '12 Sample Street', 'AnyTown', 'L3R3G2', 'ON', '1112223333', 'kkk@kk.com', 'Active', '2020-10-22 17:29:02', '2020-11-02 18:58:26'),
	(6, 2, NULL, 'Andrew', 'Lee', '8700 Warden Av', 'Mark', 'L3R3G4', 'ON', '647-675-1234', 'lee@lee.co', 'Active', '2020-10-22 17:29:26', '2020-10-26 19:01:26'),
	(7, 1, NULL, 'Lee', 'Lary', '5 ABC Street', NULL, 'L3R 5H5', 'ON', '1112223333', 'lee@lee.com', 'Active', '2020-10-23 20:31:48', '2020-10-26 18:57:29'),
	(8, 2, NULL, 'Johny', 'Lever', '133-105 Queen Street', 'Toronto', 'M1M 1M1', 'ON', '903-123-3434', 'johny@gmail.com', 'Active', '2020-10-26 16:52:21', '2020-11-08 18:13:44'),
	(9, 2, NULL, 'Raja', 'Kumar', '8 Cheeseman Dr', 'Markham', 'L3R3G2', 'ON', '9054152420', 'rktaxali@gmail.com', 'Past', '2020-10-26 16:53:30', '2020-11-04 10:48:26'),
	(10, 2, NULL, 'Ravi', 'Taxali', '8 Cheeseman Dr', 'Markham', 'L3R3G2', 'ON', '9054152420', 'test@gmail.com', 'Active', '2020-11-20 10:12:23', '2020-11-20 10:12:23');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.client_housing
CREATE TABLE IF NOT EXISTS `client_housing` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `housing_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `allotment_start_user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'User who alloted ',
  `start_date` date DEFAULT curdate(),
  `allotment_end_user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'User who ended the allotment',
  `end_date` date DEFAULT NULL,
  `allotment_status` enum('Current','Past') DEFAULT 'Current',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_client_housing_clients` (`client_id`),
  KEY `FK_client_housing_housing` (`housing_id`),
  KEY `FK_client_housing_users` (`allotment_start_user_id`),
  KEY `FK_client_housing_users_2` (`allotment_end_user_id`),
  CONSTRAINT `FK_client_housing_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `FK_client_housing_housing` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`),
  CONSTRAINT `FK_client_housing_users` FOREIGN KEY (`allotment_start_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_client_housing_users_2` FOREIGN KEY (`allotment_end_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COMMENT='housing alloted to clients, including past allotments';

-- Dumping data for table sayal_schedule.client_housing: ~0 rows (approximately)
DELETE FROM `client_housing`;
/*!40000 ALTER TABLE `client_housing` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_housing` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.client_notes
CREATE TABLE IF NOT EXISTS `client_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `event_id` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_user_id` bigint(20) unsigned DEFAULT NULL,
  `update_user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_client_notes_clients` (`client_id`),
  KEY `FK_clients_users` (`create_user_id`) USING BTREE,
  KEY `FK_client_notes_users` (`update_user_id`),
  KEY `FK_client_notes_events` (`event_id`),
  CONSTRAINT `FK_client_notes_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `FK_client_notes_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `FK_client_notes_users` FOREIGN KEY (`update_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `client_notes_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Notes for clients. ';

-- Dumping data for table sayal_schedule.client_notes: ~0 rows (approximately)
DELETE FROM `client_notes`;
/*!40000 ALTER TABLE `client_notes` DISABLE KEYS */;
INSERT INTO `client_notes` (`id`, `client_id`, `event_id`, `note`, `create_user_id`, `update_user_id`, `created_at`, `updated_at`) VALUES
	(81, 9, 133, 'Completed med drop off', 2, NULL, '2020-11-21 17:39:01', '2020-11-21 17:39:01');
/*!40000 ALTER TABLE `client_notes` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.days
CREATE TABLE IF NOT EXISTS `days` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `day_name` varchar(50) NOT NULL DEFAULT '',
  `day_abbr` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sayal_schedule.days: ~6 rows (approximately)
DELETE FROM `days`;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` (`id`, `day_name`, `day_abbr`) VALUES
	(1, 'Monday', 'Mon'),
	(2, 'Tuesday', 'Tue'),
	(3, 'Wednesday', 'Wed'),
	(4, 'Thursday', 'Thu'),
	(5, 'Friday', 'Fri'),
	(6, 'Saturday', 'Sat'),
	(7, 'Sunday', 'Sun');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.employee_default_schedules
CREATE TABLE IF NOT EXISTS `employee_default_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `day` tinyint(3) unsigned DEFAULT NULL COMMENT '(1 to 7 )  Mon - Sunday',
  `store_id` int(10) unsigned DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK__users` (`user_id`) USING BTREE,
  KEY `FK__stores` (`store_id`) USING BTREE,
  CONSTRAINT `employee_default_schedules_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`),
  CONSTRAINT `employee_default_schedules_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='Employee schedules';

-- Dumping data for table sayal_schedule.employee_default_schedules: ~6 rows (approximately)
DELETE FROM `employee_default_schedules`;
/*!40000 ALTER TABLE `employee_default_schedules` DISABLE KEYS */;
INSERT INTO `employee_default_schedules` (`id`, `user_id`, `day`, `store_id`, `starttime`, `endtime`, `created_at`, `updated_at`) VALUES
	(16, 5, 1, 1, '08:00:00', '19:00:00', '2020-12-03 17:32:15', NULL),
	(17, 5, 2, 2, '08:00:00', '17:00:00', '2020-12-03 17:32:15', NULL),
	(18, 5, 3, 3, '09:00:00', '14:00:00', '2020-12-03 17:32:15', NULL),
	(19, 5, 4, 4, '09:30:00', '18:00:00', '2020-12-03 17:32:15', NULL),
	(20, 5, 5, 5, '10:00:00', '14:00:00', '2020-12-03 17:32:15', NULL),
	(21, 5, 6, 6, '11:00:00', '14:55:00', '2020-12-03 17:32:15', NULL),
	(23, 16, 1, 1, '08:30:00', '17:30:00', '2020-12-03 17:41:54', NULL),
	(24, 16, 2, 2, '09:00:00', '17:00:00', '2020-12-03 17:41:54', NULL),
	(25, 16, 3, 2, '09:00:00', '17:00:00', '2020-12-03 17:41:54', NULL),
	(26, 16, 4, 3, '08:30:00', '17:30:00', '2020-12-03 17:41:54', NULL),
	(27, 16, 5, 4, '09:00:00', '15:00:00', '2020-12-03 17:41:54', NULL),
	(28, 16, 6, 1, '09:00:00', '16:00:00', '2020-12-03 17:41:54', NULL),
	(30, 18, 1, 1, '08:00:00', '17:00:00', '2020-12-03 17:50:33', NULL),
	(31, 18, 2, 1, '08:00:00', '17:30:00', '2020-12-03 17:50:33', NULL),
	(32, 18, 3, 1, '08:00:00', '18:00:00', '2020-12-03 17:50:33', NULL),
	(33, 18, 4, 1, '08:30:00', '17:30:00', '2020-12-03 17:50:33', NULL),
	(34, 18, 5, 2, '08:00:00', '17:00:00', '2020-12-03 17:50:33', NULL);
/*!40000 ALTER TABLE `employee_default_schedules` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.employee_schedules
CREATE TABLE IF NOT EXISTS `employee_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `day` tinyint(3) unsigned DEFAULT NULL COMMENT '(1 to 7 )  Mon - Sunday',
  `date` date DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__users` (`user_id`),
  KEY `FK__stores` (`store_id`),
  KEY `FK_employee_schedules_schedules` (`schedule_id`),
  CONSTRAINT `FK__stores` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_employee_schedules_schedules` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COMMENT='Employee schedules';

-- Dumping data for table sayal_schedule.employee_schedules: ~1 rows (approximately)
DELETE FROM `employee_schedules`;
/*!40000 ALTER TABLE `employee_schedules` DISABLE KEYS */;
INSERT INTO `employee_schedules` (`id`, `schedule_id`, `user_id`, `day`, `date`, `store_id`, `starttime`, `endtime`, `created_at`, `updated_at`) VALUES
	(56, 1, 5, 1, '2020-11-30', 1, '10:00:00', '16:00:00', NULL, NULL),
	(59, 12, 5, 1, '2020-12-07', 1, '08:00:00', '19:00:00', NULL, NULL),
	(60, 12, 5, 2, '2020-12-08', 2, '08:00:00', '17:00:00', NULL, NULL),
	(61, 12, 5, 3, '2020-12-09', 3, '09:00:00', '14:00:00', NULL, NULL),
	(62, 12, 5, 4, '2020-12-10', 4, '09:30:00', '18:00:00', NULL, NULL),
	(63, 12, 5, 5, '2020-12-11', 5, '10:00:00', '14:00:00', NULL, NULL),
	(64, 12, 5, 6, '2020-12-12', 6, '11:00:00', '14:55:00', NULL, NULL),
	(65, 13, 5, 1, '2020-12-14', 1, '08:00:00', '19:00:00', NULL, NULL),
	(66, 13, 5, 2, '2020-12-15', 2, '08:00:00', '17:00:00', NULL, NULL),
	(67, 13, 5, 3, '2020-12-16', 3, '09:00:00', '14:00:00', NULL, NULL),
	(68, 13, 5, 4, '2020-12-17', 4, '09:30:00', '18:00:00', NULL, NULL),
	(69, 13, 5, 5, '2020-12-18', 5, '10:00:00', '14:00:00', NULL, NULL),
	(70, 13, 5, 6, '2020-12-19', 6, '11:00:00', '14:55:00', NULL, NULL),
	(71, 1, 16, 1, '2020-11-30', 1, '08:30:00', '17:30:00', NULL, NULL),
	(72, 1, 16, 2, '2020-12-01', 2, '09:00:00', '17:00:00', NULL, NULL),
	(73, 1, 16, 3, '2020-12-02', 2, '09:00:00', '17:00:00', NULL, NULL),
	(74, 1, 16, 4, '2020-12-03', 3, '08:30:00', '17:30:00', NULL, NULL),
	(75, 1, 16, 5, '2020-12-04', 4, '09:00:00', '15:00:00', NULL, NULL),
	(76, 1, 16, 6, '2020-12-05', 1, '09:00:00', '16:00:00', NULL, NULL),
	(80, 1, 18, 1, '2020-11-30', 1, '08:00:00', '17:00:00', NULL, NULL),
	(81, 1, 18, 2, '2020-12-01', 1, '08:00:00', '17:30:00', NULL, NULL),
	(82, 1, 18, 3, '2020-12-02', 1, '08:00:00', '18:00:00', NULL, NULL),
	(83, 1, 18, 4, '2020-12-03', 1, '08:30:00', '17:30:00', NULL, NULL),
	(84, 1, 18, 5, '2020-12-04', 2, '08:00:00', '17:00:00', NULL, NULL),
	(85, 13, 18, 1, '2020-12-14', 1, '08:00:00', '17:00:00', NULL, NULL),
	(86, 13, 18, 2, '2020-12-15', 1, '08:00:00', '17:30:00', NULL, NULL),
	(87, 13, 18, 3, '2020-12-16', 1, '08:00:00', '18:00:00', NULL, NULL),
	(88, 13, 18, 4, '2020-12-17', 1, '08:30:00', '17:30:00', NULL, NULL),
	(89, 13, 18, 5, '2020-12-18', 1, '09:00:00', '17:00:00', NULL, NULL),
	(90, 13, 18, 6, '2020-12-19', 1, '09:00:00', '14:00:00', NULL, NULL),
	(91, 13, 18, 1, '2020-12-14', 1, '08:00:00', '17:00:00', NULL, NULL),
	(92, 13, 18, 2, '2020-12-15', 1, '08:00:00', '17:30:00', NULL, NULL),
	(93, 13, 18, 3, '2020-12-16', 1, '08:00:00', '18:00:00', NULL, NULL),
	(94, 13, 18, 4, '2020-12-17', 1, '08:30:00', '17:30:00', NULL, NULL),
	(95, 13, 18, 5, '2020-12-18', 1, '09:00:00', '17:00:00', NULL, NULL),
	(96, 13, 18, 6, '2020-12-19', 1, '09:00:00', '14:00:00', NULL, NULL);
/*!40000 ALTER TABLE `employee_schedules` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `event_status_id` int(10) unsigned NOT NULL DEFAULT 1,
  `event_type_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repeat_events_id` int(10) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_events_users` (`user_id`),
  KEY `FK_events_clients` (`client_id`),
  KEY `FK_events_event_colours` (`event_status_id`) USING BTREE,
  KEY `FK_events_repeat_events` (`repeat_events_id`),
  KEY `FK_events_event_type` (`event_type_id`),
  CONSTRAINT `FK_events_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `FK_events_event_status` FOREIGN KEY (`event_status_id`) REFERENCES `event_status` (`id`),
  CONSTRAINT `FK_events_event_type` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`),
  CONSTRAINT `FK_events_repeat_events` FOREIGN KEY (`repeat_events_id`) REFERENCES `repeat_events` (`id`),
  CONSTRAINT `FK_events_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.events: ~7 rows (approximately)
DELETE FROM `events`;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` (`id`, `user_id`, `client_id`, `event_status_id`, `event_type_id`, `title`, `description`, `repeat_events_id`, `date`, `start`, `end`, `created_at`, `updated_at`) VALUES
	(123, 2, 4, 1, 2, 'Visual Foxpro Changed2', NULL, NULL, '2020-11-11', '2020-11-11 09:00:00', '2020-11-11 09:30:00', '2020-11-21 17:26:54', '2020-11-21 17:34:04'),
	(133, 2, 9, 2, 3, 'Med drop off', NULL, 21, '2020-11-12', '2020-11-12 09:30:00', '2020-11-12 09:45:00', '2020-11-21 17:38:03', '2020-11-21 17:39:01'),
	(134, 2, 9, 1, 3, 'Med drop off', NULL, 21, '2020-11-19', '2020-11-19 09:30:00', '2020-11-19 09:45:00', '2020-11-21 17:38:03', '2020-11-21 17:38:03'),
	(135, 2, 9, 1, 3, 'Med drop off', NULL, 21, '2020-11-26', '2020-11-26 09:30:00', '2020-11-26 09:45:00', '2020-11-21 17:38:03', '2020-11-21 17:38:03'),
	(136, 2, 9, 1, 3, 'Med drop off', NULL, 21, '2020-12-03', '2020-12-03 09:30:00', '2020-12-03 09:45:00', '2020-11-21 17:38:03', '2020-11-21 17:38:03'),
	(137, 2, 9, 1, 3, 'Med drop off', NULL, 21, '2020-12-10', '2020-12-10 09:30:00', '2020-12-10 09:45:00', '2020-11-21 17:38:03', '2020-11-21 17:38:03'),
	(138, 2, 9, 1, 3, 'Med drop off', NULL, 21, '2020-12-17', '2020-12-17 09:30:00', '2020-12-17 09:45:00', '2020-11-21 17:38:03', '2020-11-21 17:38:03');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.event_status
CREATE TABLE IF NOT EXISTS `event_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` char(15) NOT NULL DEFAULT '',
  `color` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sortorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sayal_schedule.event_status: ~5 rows (approximately)
DELETE FROM `event_status`;
/*!40000 ALTER TABLE `event_status` DISABLE KEYS */;
INSERT INTO `event_status` (`id`, `status`, `color`, `created_at`, `sortorder`) VALUES
	(1, 'Pending', 'blue', '2020-11-09 06:38:45', 1),
	(2, 'Completed', 'green', '2020-11-09 06:39:21', 2),
	(3, 'Cencelled', 'red', '2020-11-09 06:39:35', 3),
	(4, 'Suspended', 'yellow', '2020-11-09 06:40:51', 4),
	(5, 'Transferred', 'orange', '2020-11-09 06:39:52', 5);
/*!40000 ALTER TABLE `event_status` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.event_type
CREATE TABLE IF NOT EXISTS `event_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(15) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sortorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table sayal_schedule.event_type: ~4 rows (approximately)
DELETE FROM `event_type`;
/*!40000 ALTER TABLE `event_type` DISABLE KEYS */;
INSERT INTO `event_type` (`id`, `type`, `created_at`, `sortorder`) VALUES
	(1, 'Home Visit', '2020-11-09 06:38:45', 1),
	(2, 'Phone Call', '2020-11-09 06:39:21', 2),
	(3, 'Office Visit', '2020-11-09 06:39:35', 3),
	(4, 'Other', '2020-11-09 06:40:51', 4);
/*!40000 ALTER TABLE `event_type` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.housing
CREATE TABLE IF NOT EXISTS `housing` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability_status` enum('Available','Being Fixed','Allotted') COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.housing: ~11 rows (approximately)
DELETE FROM `housing`;
/*!40000 ALTER TABLE `housing` DISABLE KEYS */;
INSERT INTO `housing` (`id`, `address`, `city`, `postalcode`, `province`, `availability_status`, `created_at`, `updated_at`) VALUES
	(1, '1 Carroll Avenue Apt. 553', 'Toronto', 'M1W 1M1', 'ON', 'Available', '2020-10-29 11:23:31', '2020-11-20 10:12:51'),
	(2, '222 Will Row Suite 559', 'Toronto', 'M1W 1M1', 'ON', 'Available', '2020-10-29 11:28:52', '2020-11-04 20:20:30'),
	(3, '333 Walton Circle Suite 432', 'Etobicoke', 'M1W 1M4', 'ON', 'Available', '2020-10-29 11:28:52', '2020-11-04 18:59:22'),
	(4, '444 Harber Mill', 'Etobicoke', 'M1W 1M4', 'ON', 'Allotted', '2020-10-29 11:28:52', '2020-11-04 20:52:58'),
	(5, '555 Malcolm Plain Suite 449', 'Toronto', 'M1W 1M5', 'ON', 'Available', '2020-10-29 11:28:52', '2020-11-04 18:59:33'),
	(6, '61553 Stroman Cliff', 'Scarborough', 'L1W 1M1', 'ON', 'Available', '2020-10-29 11:28:52', '2020-11-04 14:05:58'),
	(7, '777 Athena Parkways', 'Toronto', 'M1S 1M5', 'ON', 'Available', '2020-10-29 11:28:53', '2020-11-04 18:59:40'),
	(8, '8222 Reilly Mount', 'South Leonoramouth', 'M1W 3G5', 'ON', 'Available', '2020-10-29 11:28:53', '2020-11-04 18:59:50'),
	(9, '968 Addie Fall', 'Scarborough', 'M1W 9G5', 'ON', 'Being Fixed', '2020-10-29 11:28:53', '2020-11-04 20:40:02'),
	(10, '1000 Tabitha Mews Apt. 298', 'Toronto', 'M1W K5G', 'ON', 'Allotted', '2020-10-29 11:28:53', '2020-11-04 18:59:56'),
	(11, '11 Matteo Forest', 'Toronto', 'M5H J4F', 'ON', 'Allotted', '2020-10-29 11:28:53', '2020-11-04 19:00:09');
/*!40000 ALTER TABLE `housing` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(500) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='logs table for testing ';

-- Dumping data for table sayal_schedule.logs: ~6 rows (approximately)
DELETE FROM `logs`;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`id`, `message`, `timestamp`) VALUES
	(9, 'In Else', '2020-11-06 13:55:22'),
	(10, 'In Else', '2020-11-06 13:55:24'),
	(11, 'In Else', '2020-11-06 13:56:54'),
	(12, 'In Else', '2020-11-06 13:56:56'),
	(13, 'In Else', '2020-11-06 13:58:08'),
	(14, 'In Else', '2020-11-06 13:58:09');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.migrations: ~13 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`, `timestamp`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1, '2020-10-30 11:06:43'),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1, '2020-10-30 11:06:43'),
	(4, '2020_04_03_170309_create_tasks_table', 2, '2020-10-30 11:06:43'),
	(5, '2014_10_12_100000_create_password_resets_table', 3, '2020-10-30 11:06:43'),
	(13, '2020_09_28_175305_create_posts_table', 4, '2020-10-30 11:06:43'),
	(14, '2020_09_28_184617_create_assignments_table', 4, '2020-10-30 11:06:43'),
	(15, '2020_09_30_184053_create_articles_table', 5, '2020-10-30 11:06:43'),
	(17, '2020_10_08_150047_create_products_table', 6, '2020-10-30 11:06:43'),
	(18, '2020_10_15_224452_create_jobs_table', 7, '2020-10-30 11:06:43'),
	(19, '2020_10_29_103901_create_housing_table', 0, '2020-10-30 11:08:24'),
	(20, '2020_10_30_105628_create_permission_tables', 8, '2020-10-30 11:08:50'),
	(22, '2020_11_05_102012_create_events_table', 9, '2020-11-05 10:36:38'),
	(23, '2020_11_22_141051_create_tasks_table', 10, '2020-11-22 14:17:22');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.model_has_permissions: ~7 rows (approximately)
DELETE FROM `model_has_permissions`;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`, `created_at`) VALUES
	(4, 'App\\Models\\User', 2, '2020-11-27 14:57:18'),
	(7, 'App\\Models\\User', 2, '2020-11-23 11:39:32'),
	(9, 'App\\Models\\User', 2, '2020-11-27 14:57:18'),
	(9, 'App\\Models\\User', 16, '2020-11-27 14:57:18'),
	(10, 'App\\Models\\User', 18, '2020-11-27 14:57:18'),
	(12, 'App\\Models\\User', 4, '2020-11-27 14:57:18'),
	(13, 'App\\Models\\User', 1, '2020-11-27 14:57:18');
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.model_has_roles: ~0 rows (approximately)
DELETE FROM `model_has_roles`;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(6, 'App\\Models\\User', 3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.password_resets: ~2 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('test@test.com', '$2y$10$GbIxX8GgMXiyUULVBElV9eq1WMy4HCSoi5oQuqcgVXJcWuGWvpVDa', '2020-10-07 18:53:40'),
	('ravi@ravitaxali.com', '$2y$10$3aF9PjD66As.3Md/A2rRc.tded8/PIpI3ZpqEjstdwy2AJMW8z0Ua', '2020-11-17 12:05:46');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.permissions: ~7 rows (approximately)
DELETE FROM `permissions`;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `comments`, `created_at`, `updated_at`) VALUES
	(4, 'create_user', 'web', '', '2020-10-30 12:21:35', '2020-10-30 12:21:35'),
	(7, 'Permission', 'web', NULL, '2020-10-30 18:42:10', '2020-10-30 18:42:10'),
	(9, 'create_store_schedule', 'web', NULL, '2020-11-23 11:16:33', '2020-11-23 11:16:33'),
	(10, 'create_warehouse_schedule', 'web', NULL, '2020-11-23 11:17:31', '2020-11-23 11:17:31'),
	(11, 'approve_schedule', 'web', NULL, '2020-11-23 11:17:47', '2020-11-23 11:17:47'),
	(12, 'view_all_schedules', 'web', NULL, '2020-11-23 11:22:25', '2020-11-23 11:22:25'),
	(13, 'approve_schedule', 'web', NULL, '2020-11-23 11:22:45', '2020-11-23 11:22:45');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postID` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uniqueID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uuid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.posts: ~0 rows (approximately)
DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(22,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.products: ~3 rows (approximately)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `description`, `price`, `created_at`, `updated_at`) VALUES
	(1, 'Paper', 'Paper 1200', 1234567.12, '2020-10-08 12:37:08', NULL),
	(2, 'Pen', 'Pen Blue 2', 9.40, '2020-10-08 12:37:38', '2020-10-09 21:52:18'),
	(4, 'Kumar', NULL, 123.00, '2020-10-09 19:47:03', '2020-10-09 19:47:03');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.repeat_events
CREATE TABLE IF NOT EXISTS `repeat_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sayal_schedule.repeat_events: ~0 rows (approximately)
DELETE FROM `repeat_events`;
/*!40000 ALTER TABLE `repeat_events` DISABLE KEYS */;
INSERT INTO `repeat_events` (`id`, `title`, `user_id`, `client_id`, `startdate`, `enddate`, `frequency`, `created_at`) VALUES
	(21, 'Med drop off', 2, 4, '2020-11-12', '2020-12-18', 'Weekly', '2020-11-21 17:38:03');
/*!40000 ALTER TABLE `repeat_events` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.roles: ~5 rows (approximately)
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Case Manager', 'web', '2020-10-30 12:14:29', '2020-10-30 12:14:29'),
	(2, 'Doctor', 'web', '2020-10-30 12:14:46', '2020-10-30 12:14:46'),
	(3, 'Housing Coordinator', 'web', '2020-10-30 12:15:08', '2020-10-30 12:15:08'),
	(4, 'Case Manager', 'web', '2020-10-30 12:16:16', '2020-10-30 12:16:16'),
	(6, 'Admin', 'web', '2020-10-30 12:31:37', '2020-10-30 12:31:37');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.role_has_permissions: ~1 rows (approximately)
DELETE FROM `role_has_permissions`;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(4, 6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.schedules
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL COMMENT 'Schedule start date, beginning Monday',
  `prepared_user_id` bigint(20) unsigned DEFAULT NULL,
  `approved_user_id` bigint(20) unsigned DEFAULT NULL,
  `revised_user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_schedules_users` (`prepared_user_id`),
  KEY `FK_schedules_users_2` (`revised_user_id`),
  KEY `FK_schedules_users_3` (`approved_user_id`),
  CONSTRAINT `FK_schedules_users` FOREIGN KEY (`prepared_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_schedules_users_2` FOREIGN KEY (`revised_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_schedules_users_3` FOREIGN KEY (`approved_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sayal_schedule.schedules: ~3 rows (approximately)
DELETE FROM `schedules`;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` (`id`, `start_date`, `prepared_user_id`, `approved_user_id`, `revised_user_id`, `created_at`, `updated_at`) VALUES
	(1, '2020-11-30', NULL, NULL, NULL, NULL, NULL),
	(12, '2020-12-07', NULL, NULL, NULL, NULL, NULL),
	(13, '2020-12-14', NULL, NULL, NULL, NULL, NULL),
	(14, '2020-12-21', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.schedule_dates
CREATE TABLE IF NOT EXISTS `schedule_dates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) unsigned DEFAULT NULL,
  `day_id` tinyint(3) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_schedule_dates_schedules` (`schedule_id`),
  KEY `FK_schedule_dates_days` (`day_id`),
  CONSTRAINT `FK_schedule_dates_days` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`),
  CONSTRAINT `FK_schedule_dates_schedules` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sayal_schedule.schedule_dates: ~28 rows (approximately)
DELETE FROM `schedule_dates`;
/*!40000 ALTER TABLE `schedule_dates` DISABLE KEYS */;
INSERT INTO `schedule_dates` (`id`, `schedule_id`, `day_id`, `date`, `created_at`) VALUES
	(1, 1, 1, '2020-11-30', NULL),
	(25, 12, 1, '2020-12-07', '2020-11-27 19:21:20'),
	(26, 12, 2, '2020-12-08', '2020-11-27 19:21:20'),
	(27, 12, 3, '2020-12-09', '2020-11-27 19:21:20'),
	(28, 12, 4, '2020-12-10', '2020-11-27 19:21:20'),
	(29, 12, 5, '2020-12-11', '2020-11-27 19:21:20'),
	(30, 12, 6, '2020-12-12', '2020-11-27 19:21:20'),
	(31, 12, 7, '2020-12-13', '2020-11-27 19:21:20'),
	(32, 13, 1, '2020-12-14', '2020-11-27 21:41:01'),
	(33, 13, 2, '2020-12-15', '2020-11-27 21:41:01'),
	(34, 13, 3, '2020-12-16', '2020-11-27 21:41:01'),
	(35, 13, 4, '2020-12-17', '2020-11-27 21:41:01'),
	(36, 13, 5, '2020-12-18', '2020-11-27 21:41:02'),
	(37, 13, 6, '2020-12-19', '2020-11-27 21:41:02'),
	(38, 13, 7, '2020-12-20', '2020-11-27 21:41:02'),
	(39, 14, 1, '2020-12-21', '2020-11-27 21:41:10'),
	(40, 14, 2, '2020-12-22', '2020-11-27 21:41:10'),
	(41, 14, 3, '2020-12-23', '2020-11-27 21:41:10'),
	(42, 14, 4, '2020-12-24', '2020-11-27 21:41:10'),
	(43, 14, 5, '2020-12-25', '2020-11-27 21:41:10'),
	(44, 14, 6, '2020-12-26', '2020-11-27 21:41:10'),
	(45, 14, 7, '2020-12-27', '2020-11-27 21:41:10'),
	(46, 1, 2, '2020-12-01', '2020-11-28 21:33:12'),
	(47, 1, 3, '2020-12-02', '2020-11-28 21:34:01'),
	(48, 1, 4, '2020-12-03', '2020-11-28 21:34:55'),
	(49, 1, 5, '2020-12-04', '2020-11-28 21:35:04'),
	(50, 1, 6, '2020-12-05', '2020-11-28 21:35:12'),
	(51, 1, 7, '2020-12-06', '2020-11-28 21:35:23');
/*!40000 ALTER TABLE `schedule_dates` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.stores
CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postalcode` varchar(7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='List of stores';

-- Dumping data for table sayal_schedule.stores: ~6 rows (approximately)
DELETE FROM `stores`;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` (`id`, `name`, `phone`, `address`, `city`, `postalcode`, `created_at`) VALUES
	(1, 'Victoria Park', NULL, NULL, NULL, NULL, '2020-11-25 11:20:49'),
	(2, 'Markham', NULL, NULL, NULL, NULL, '2020-11-25 11:21:11'),
	(3, 'Mississauga', NULL, NULL, NULL, NULL, '2020-11-25 11:21:29'),
	(4, 'Vaughan', NULL, NULL, NULL, NULL, '2020-11-25 11:21:43'),
	(5, 'Barrie', NULL, NULL, NULL, NULL, '2020-11-25 11:21:50'),
	(6, 'Burlington', NULL, NULL, NULL, NULL, '2020-11-25 11:21:57'),
	(7, 'Cambridge', NULL, NULL, NULL, NULL, '2020-11-25 11:22:47');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='tags that may be linked to articles';

-- Dumping data for table sayal_schedule.tags: ~8 rows (approximately)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Laravel', '2020-10-05 11:04:16', '2020-10-05 11:04:16'),
	(2, 'PHP', '2020-10-05 11:04:23', '2020-10-05 11:04:23'),
	(3, 'Education', '2020-10-05 11:04:30', '2020-10-05 11:04:30'),
	(4, 'Personal', '2020-10-05 11:04:38', '2020-10-05 11:04:38'),
	(5, 'JavaScript', '2020-10-05 11:04:51', '2020-10-05 11:04:51'),
	(6, 'Phython', '2020-10-05 11:05:00', '2020-10-05 11:05:00'),
	(7, 'VFP', '2020-10-05 11:07:19', '2020-10-05 11:07:19'),
	(8, 'WordStar', '2020-10-13 17:04:42', '2020-10-13 17:04:42');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.tasks: ~0 rows (approximately)
DELETE FROM `tasks`;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `task`, `created_at`, `updated_at`) VALUES
	(1, 'new task', '2020-11-22 14:32:35', '2020-11-22 14:32:35');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.uploaded_files
CREATE TABLE IF NOT EXISTS `uploaded_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mimeType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.uploaded_files: ~2 rows (approximately)
DELETE FROM `uploaded_files`;
/*!40000 ALTER TABLE `uploaded_files` DISABLE KEYS */;
INSERT INTO `uploaded_files` (`id`, `user_id`, `original_name`, `upload_path`, `mimeType`, `size`, `created_at`, `updated_at`) VALUES
	(40, 2, '1588887711-3886.png', 'public/uploads/eONzSBHegvYbKtMBsy70jGt0k0vOJpgNfMZBA1Y1.png', 'image/png', 685971, '2020-10-24 19:21:13', '2020-10-24 19:21:13'),
	(42, 2, 'Weeks_4_5_6.jpg', 'public/uploads/6qYf820HhoXLBBb497I1YRU8SNxCzOikSNGkTSH5.jpeg', 'image/jpeg', 961770, '2020-10-27 21:05:05', '2020-10-27 21:05:05');
/*!40000 ALTER TABLE `uploaded_files` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned DEFAULT NULL COMMENT 'Default store id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_hours` decimal(10,2) DEFAULT NULL,
  `status` enum('Active','Inactive','Archive','Fixed') COLLATE utf8mb4_unicode_ci DEFAULT 'Active' COMMENT 'Schedule will be prepared only for active employees',
  `max_hours` decimal(10,2) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `FK_users_stores` (`store_id`),
  CONSTRAINT `FK_users_stores` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sayal_schedule.users: ~9 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `store_id`, `name`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `min_hours`, `status`, `max_hours`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Savita Taxali', 'Savita', 'Taxali', 'ritu@sayal.com', '2020-10-04 21:31:12', '$2y$10$7i3ohPDdud89Dj/P./QEPO7pifAmVhuSRFw9BZjmSOZGfoeCNhXjC', 35.00, 'Fixed', 55.00, 'sdfBdkjYq8Ddm9MLB6UgOwIN7tWb33wHRfPVKbFSbKzt03uulzQ49O95WHoe', '2020-10-04 21:31:13', '2020-11-27 12:11:38'),
	(2, NULL, 'Sayal Admin', 'Sayal', 'Admin', 'rktaxali@gmail.com', '2020-10-04 21:32:47', '$2y$10$7i3ohPDdud89Dj/P./QEPO7pifAmVhuSRFw9BZjmSOZGfoeCNhXjC', 35.00, 'Fixed', 43.00, 'YSKBM5xd6xlWLj9g0cUpct175jAOiu1nav0yK5fWg5rY7ub1OYARlJ2utZJv', '2020-10-04 21:32:47', '2020-11-27 12:04:00'),
	(4, NULL, 'Kevin Sayal', 'Kevin', 'Sayal', 'kacey21@example.net', '2020-10-04 21:37:23', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 35.00, 'Fixed', 43.00, 'cMX5G4XeH9', '2020-10-04 21:37:23', '2020-10-04 21:37:23'),
	(5, 1, 'Vinay Pandhi', 'Vinay', 'Pandhi', 'vinay@sayal.com', '2020-10-04 21:37:23', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 35.00, 'Active', 43.00, 'uy6iENBH9a', '2020-10-04 21:37:23', '2020-11-27 12:06:07'),
	(16, 1, 'Ajay Sharma', 'Ajay', 'Sharma', 'ajay@sayal.com', NULL, '$2y$10$FA5zYlq1F89i/8khnfvLgOqWdGy8eY6UkYzNE3QYzYRL5DIg2B062', 35.00, 'Active', 47.50, NULL, '2020-11-22 23:24:08', '2020-11-27 12:54:17'),
	(18, 1, 'Atanu De', 'Atanu', 'De', 'atanu@sayal.com', NULL, '$2y$10$cfVfr//./PtU45FopeK3Ku2kccD.xnTJblhs33ObJqL1tocojsJue', 35.00, 'Active', 42.50, NULL, '2020-11-23 16:46:50', '2020-12-03 17:47:35'),
	(24, NULL, 'Malti Arora', 'Malti', 'Arora', 'stasdg@te.com', NULL, '$2y$10$uk9jTFzlgtD8qUtGCs1tdeGcLsRLoJz0LaDqxvAnw7lWBLq44Vose', 35.00, 'Fixed', 47.50, NULL, '2020-11-24 16:27:45', '2020-11-26 16:40:15'),
	(25, 2, 'Pankaj Manchanda', 'Pankaj', 'Manchanda', 'pankaj@sayal.com', NULL, '$2y$10$AXioD8fC1lh8UPzFtLC/7OTVg48DxqzSgYQtFQY2gar67oFSM0WKe', 35.00, 'Active', 47.50, NULL, '2020-11-24 16:32:34', '2020-11-26 13:56:40'),
	(26, 5, 'Parvez Khan', 'Parvez', 'Khan', 'parvez@sayal.com', NULL, '$2y$10$F.BDpV81RyXCR9cNOT9dv.WgQ5.nIWR5PbEOtEaXerrLQGU.VIUne', 35.00, 'Active', 40.00, NULL, '2020-11-24 16:50:32', '2020-11-24 16:50:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table sayal_schedule._posts
CREATE TABLE IF NOT EXISTS `_posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`postID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table sayal_schedule._posts: ~2 rows (approximately)
DELETE FROM `_posts`;
/*!40000 ALTER TABLE `_posts` DISABLE KEYS */;
INSERT INTO `_posts` (`postID`, `slug`, `body`) VALUES
	(1, 'my-first-post', 'This is my first post'),
	(2, 'my-second-post', 'This is my Second post');
/*!40000 ALTER TABLE `_posts` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
