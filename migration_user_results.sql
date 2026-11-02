-- شغّليه مرة واحدة في DBeaver (قاعدة railway) وبعدين على XAMPP في phpMyAdmin
CREATE TABLE IF NOT EXISTS `user_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `school` decimal(6,2) DEFAULT NULL,
  `qudrat` decimal(6,2) DEFAULT NULL,
  `tahsili` decimal(6,2) DEFAULT NULL,
  `weighted` decimal(6,2) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `track_selected` varchar(20) DEFAULT NULL,
  `result_track` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
