-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 12:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uni_tour_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(11) NOT NULL,
  `university_id` int(11) DEFAULT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `university_id`, `name_ar`, `name_en`, `category`) VALUES
(1, 2, 'إدارة أعمال', 'Business Administration', 'إداري'),
(2, 2, 'تسويق', 'Marketing', 'إداري'),
(3, 2, 'محاسبة', 'Accounting', 'إداري'),
(4, 2, 'إدارة مالية', 'Finance', 'إداري'),
(5, 1, 'شريعة', 'Sharia', 'شرعي'),
(6, 1, 'فقه', 'Fiqh', 'شرعي'),
(7, 1, 'أصول دين', 'Islamic Studies', 'شرعي'),
(8, 1, 'تمريض', 'Nursing', 'صحة وحياة'),
(9, 1, 'علوم صحية', 'Health Sciences', 'صحة وحياة'),
(10, 1, 'مختبرات طبية', 'Medical Lab', 'صحة وحياة'),
(11, 1, 'صيدلة', 'Pharmacy', 'صحة وحياة'),
(12, 4, 'هندسة حاسب', 'Computer Engineering', 'هندسة حاسب'),
(13, 2, 'علوم الحاسب', 'Computer Science', 'هندسة حاسب'),
(14, 2, 'تقنية معلومات', 'Information Technology', 'هندسة حاسب'),
(15, 2, 'أمن سيبراني', 'Cyber Security', 'هندسة حاسب'),
(16, 2, 'ذكاء اصطناعي', 'Artificial Intelligence', 'هندسة حاسب'),
(17, 3, 'لغة عربية', 'Arabic Language', 'عام'),
(18, 3, 'لغة إنجليزية', 'English Language', 'عام'),
(19, 3, 'تاريخ', 'History', 'عام'),
(20, 3, 'جغرافيا', 'Geography', 'عام'),
(21, 3, 'علم اجتماع', 'Sociology', 'عام');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_accounts`
--

CREATE TABLE `oauth_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_options`
--

CREATE TABLE `quiz_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `text_ar` varchar(255) DEFAULT NULL,
  `text_en` varchar(255) DEFAULT NULL,
  `track_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_options`
--

INSERT INTO `quiz_options` (`id`, `question_id`, `text_ar`, `text_en`, `track_id`) VALUES
(1, 1, 'إدارة الأعمال', 'Business Administration', 1),
(2, 1, 'العلوم الشرعية', 'Sharia Sciences', 2),
(3, 1, 'الطب والتمريض', 'Medical and Health', 3),
(4, 1, 'البرمجة والتقنية', 'Programming and Technology', 4),
(5, 1, 'مجالات متنوعة', 'Various Fields', 5),
(6, 2, 'إدارة فريق وتنظيم العمل', 'Managing teams and organizing work', 1),
(7, 2, 'التدريس والإرشاد الديني', 'Religious teaching and guidance', 2),
(8, 2, 'مساعدة المرضى', 'Helping patients', 3),
(9, 2, 'تطوير برامج وأنظمة', 'Developing software systems', 4),
(10, 2, 'أعمال متنوعة', 'Various tasks', 5),
(11, 3, 'الاقتصاد والإدارة', 'Economics and management', 1),
(12, 3, 'الفقه والتفسير', 'Fiqh and Quran interpretation', 2),
(13, 3, 'الأحياء والعلوم الصحية', 'Biology and health sciences', 3),
(14, 3, 'الرياضيات والحاسب', 'Math and computer science', 4),
(15, 3, 'مواد مختلفة', 'Various subjects', 5),
(16, 4, 'التخطيط والتنظيم', 'Planning and organizing', 1),
(17, 4, 'البحث في العلوم الشرعية', 'Research in Islamic studies', 2),
(18, 4, 'العناية بالمرضى', 'Caring for patients', 3),
(19, 4, 'حل المشكلات البرمجية', 'Solving programming problems', 4),
(20, 4, 'تجربة أشياء مختلفة', 'Trying different things', 5),
(21, 5, 'شخص قيادي', 'Leadership personality', 1),
(22, 5, 'مهتم بالدين', 'Interested in religion', 2),
(23, 5, 'محب لمساعدة الآخرين', 'Helping others', 3),
(24, 5, 'تحب التقنية', 'Interested in technology', 4),
(25, 5, 'تحب التنوع', 'Love variety', 5),
(26, 6, 'بيئة عمل منظمة', 'Organized work environment', 1),
(27, 6, 'بيئة علمية شرعية', 'Religious learning environment', 2),
(28, 6, 'بيئة طبية', 'Medical environment', 3),
(29, 6, 'بيئة تقنية', 'Technology environment', 4),
(30, 6, 'أي بيئة مناسبة', 'Any environment', 5),
(31, 7, 'إدارة المشاريع', 'Project management', 1),
(32, 7, 'التعليم الديني', 'Religious education', 2),
(33, 7, 'العمل في المستشفيات', 'Working in hospitals', 3),
(34, 7, 'تطوير التطبيقات', 'Developing applications', 4),
(35, 7, 'العمل في مجالات متعددة', 'Multiple fields', 5),
(36, 8, 'مشاريع تجارية', 'Business projects', 1),
(37, 8, 'مشاريع دينية', 'Religious projects', 2),
(38, 8, 'مشاريع صحية', 'Health projects', 3),
(39, 8, 'مشاريع تقنية', 'Tech projects', 4),
(40, 8, 'مشاريع متنوعة', 'Various projects', 5),
(41, 9, 'القيادة والتنظيم', 'Leadership and organization', 1),
(42, 9, 'التحليل الشرعي', 'Islamic analysis', 2),
(43, 9, 'العناية الصحية', 'Health care', 3),
(44, 9, 'البرمجة', 'Programming', 4),
(45, 9, 'مهارات عامة', 'General skills', 5),
(46, 10, 'مدير أعمال', 'Business manager', 1),
(47, 10, 'عالم شرعي', 'Islamic scholar', 2),
(48, 10, 'طبيب أو ممرض', 'Doctor or nurse', 3),
(49, 10, 'مهندس حاسب', 'Computer engineer', 4),
(50, 10, 'مجال متنوع', 'Various career', 5);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `question_ar` varchar(255) DEFAULT NULL,
  `question_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `question_ar`, `question_en`) VALUES
(1, 'ما المجال الذي تميل إليه أكثر؟', 'Which field are you most interested in?'),
(2, 'أي نوع من الأعمال يناسبك أكثر؟', 'Which type of work suits you best?'),
(3, 'أي مادة كنت تحبها أكثر؟', 'Which subject did you enjoy the most?'),
(4, 'ما نوع المهام التي تفضلها؟', 'What type of tasks do you prefer?'),
(5, 'كيف تصف نفسك؟', 'How would you describe yourself?'),
(6, 'ما البيئة الدراسية التي تفضلها؟', 'What study environment do you prefer?'),
(7, 'أي نشاط يجذبك أكثر؟', 'Which activity attracts you the most?'),
(8, 'ما نوع المشاريع التي تحبها؟', 'What type of projects do you prefer?'),
(9, 'أي مهارة تعتبرها الأقرب لك؟', 'Which skill feels closest to you?'),
(10, 'ماذا تتخيل نفسك تعمل مستقبلًا؟', 'What do you imagine yourself doing in the future?');

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(100) DEFAULT NULL,
  `name_en` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `name_ar`, `name_en`) VALUES
(1, 'إداري', 'Admin'),
(2, 'شرعي', 'Sharia'),
(3, 'صحة وحياة', 'Health & Life'),
(4, 'هندسة حاسب', 'Computer Engineering'),
(5, 'عام', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `city_ar` varchar(100) DEFAULT NULL,
  `city_en` varchar(100) DEFAULT NULL,
  `gender_allowed` varchar(20) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `name_ar`, `name_en`, `city_ar`, `city_en`, `gender_allowed`, `logo_url`) VALUES
(1, 'جامعة القصيم - فرع عنيزة للبنات', 'Qassim University - Unaizah Female Campus', 'عنيزة', 'Unaizah', 'female', 'images/qu.png'),
(2, 'جامعة الملك سعود', 'King Saud University', 'الرياض', 'Riyadh', 'both', 'images/ksu.png'),
(3, 'جامعة الأميرة نورة بنت عبدالرحمن', 'Princess Nourah University', 'الرياض', 'Riyadh', 'female', 'images/pnu.png'),
(4, 'جامعة الملك عبدالله للعلوم والتقنية', 'KAUST', 'ثول', 'Thuwal', 'both', 'images/kaust.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'ghada saleh', 'ghadaeng20@gmail.com', '$2y$10$/Bu61gfNwJ8fS45ektkziefp2Ibt.GPhSZV2Q5fSH72GMbDJwQE/u');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_scores`
--

CREATE TABLE `user_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `track_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `virtual_tours`
--

CREATE TABLE `virtual_tours` (
  `id` int(11) NOT NULL,
  `university_id` int(11) DEFAULT NULL,
  `tour_type` varchar(50) DEFAULT NULL,
  `tour_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `virtual_tours`
--

INSERT INTO `virtual_tours` (`id`, `university_id`, `tour_type`, `tour_url`) VALUES
(1, 2, 'custom', 'https://tour.ksu.edu.sa/ksu-ar.html'),
(2, 3, 'custom', 'https://pnu.edu.sa/ar/VirtualTour/Pages/VT/index.html'),
(3, 4, 'custom', 'https://www.kaust.edu.sa/en/virtual-tour'),
(4, 1, 'custom', 'https://www.qu.edu.sa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_accounts`
--
ALTER TABLE `oauth_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtual_tours`
--
ALTER TABLE `virtual_tours`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `oauth_accounts`
--
ALTER TABLE `oauth_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_options`
--
ALTER TABLE `quiz_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_scores`
--
ALTER TABLE `user_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `virtual_tours`
--
ALTER TABLE `virtual_tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
