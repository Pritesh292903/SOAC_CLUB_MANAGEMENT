-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2026 at 02:44 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soae_club`
--

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` int NOT NULL,
  `clubimage` varchar(255) DEFAULT NULL,
  `clubname` varchar(100) DEFAULT NULL,
  `faculty_id` int NOT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `totalmembers` int DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `clubdescription` varchar(255) DEFAULT NULL,
  `club_paid` enum('Paid','Unpaid') DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `clubimage`, `clubname`, `faculty_id`, `faculty`, `totalmembers`, `status`, `clubdescription`, `club_paid`) VALUES
(54, '1775443833_1775077624_c2.jpg', 'Music CLub', 7, 'Prof. Yashgiri Gauswami', 12, 'Active', 'Welcome Music Club', 'Unpaid'),
(55, '1775444123_1775118027_c1.jpg', 'Sports Club', 8, 'Prof. Jay Pithadiya', 14, 'Active', 'Welcome Sports Club', 'Unpaid'),
(56, '1776360457_Miles morales.jpg', 'dasdfasd', 10, 'Prof. Chhaya Patel', 20, 'Active', 'jfytiy', 'Paid'),
(57, '1776923813_t3.jpg', 'Tach Club', 7, 'Prof. Yashgiri Gauswami', 20, 'Active', 'This is a Technical club so you can join this club', 'Paid'),
(58, '1776590962_c2.jpg', 'Music Consert', 10, 'Prof. Chhaya Patel', 12, 'Inactive', 'This is demo Clube', 'Paid'),
(60, '1776923751_c1.jpg', 'Sports Club', 7, 'Prof. Yashgiri Gauswami', 12, 'Active', 'This is sports club so you can join all the sports activity club', 'Paid'),
(61, '1776672583_Spiderman Painting Wallpaper 4K HD free download Background UltraHD for PC laptop and mobile.jpg', 'new clube', 15, 'pritesh bharadwa', 45, 'Active', 'this is demo club for joining', 'Paid'),
(62, '1776672637_e3.jpg', 'Metting club', 15, 'pritesh bharadwa', 12, 'Active', 'This is unpaid club', 'Unpaid'),
(63, '1776925460_c1.jpg', 'demo club', 7, 'Prof. Yashgiri Gauswami', 12, 'Active', 'dnaskljd;ashckjasij', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `club_join_requests`
--

CREATE TABLE `club_join_requests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `club_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `event_type` enum('Paid','Unpaid') DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `image`, `name`, `date`, `status`, `description`, `created_at`, `event_type`) VALUES
(19, '1775410664_Cricket tournament.jpg', 'Cricket Tournament', '2026-04-08', 'Active', 'A cricket tournament is an exciting sporting event where multiple teams compete against each other in a series of matches to determine the ultimate champion. It brings together players, fans, and communities, creating an atmosphere full of energy, teamwork, and sportsmanship.', '2026-04-05 17:36:45', 'Unpaid'),
(20, '1775410939_technoplanet.jpg', 'Technical Events', '2026-04-07', 'Active', 'Technical events in colleges are designed to inspire innovation, creativity, and practical learning among students. These events provide a platform where participants can showcase their technical knowledge, problem-solving skills, and ability to work in teams.', '2026-04-05 17:42:00', 'Paid'),
(21, '1775411302_cultural.png', 'Cultural & Fun Events', '2026-04-15', 'Active', 'The Cultural & Fun Events at RK University are a vibrant celebration of creativity, talent, and student life. These events bring together students from different departments to showcase their skills in dance, music, fashion, and entertainment activities, creating a lively and energetic campus atmosphere.', '2026-04-05 17:48:09', 'Unpaid'),
(22, '1776923667_high-quality-photo-photographer-taking-260nw-2461408413.webp', 'photografy', '2026-04-15', 'Active', 'this is a photogrphy Event', '2026-04-06 03:31:48', 'Paid'),
(41, '1776921905_5534.webp', 'demo', '2026-04-24', 'Upcoming', 'pritesh prajapati', '2026-04-23 05:25:05', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `event_join_requests`
--

CREATE TABLE `event_join_requests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_join_requests`
--

INSERT INTO `event_join_requests` (`id`, `user_id`, `event_id`, `created_at`, `status`, `payment_id`) VALUES
(33, 33, 19, '2026-04-23 06:21:40', 'pending', NULL),
(34, 33, 20, '2026-04-23 06:22:41', 'pending', 'pay_SgpkT86QQkOKp5');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_register`
--

CREATE TABLE `faculty_register` (
  `id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','faculty','user') DEFAULT 'faculty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculty_register`
--

INSERT INTO `faculty_register` (`id`, `image`, `name`, `email`, `mobile`, `department`, `designation`, `password`, `role`) VALUES
(7, 'uploads/1776923383_WhatsApp Image 2026-04-23 at 11.16.01 AM.jpeg', 'Prof. Yashgiri Gauswami', 'ygauswami150@gmail.com', '9316934085', 'IT', 'O.S', '123123', 'faculty'),
(8, '1776351741_Miles morales.jpg', 'Prof. Jay Pithadiya', 'yashgoswami3251@gmail.com', '93', 'BCA', 'Cultural event', 'yash@2006', 'faculty'),
(10, '1776351488_avatar-profile-icon-flat-style-female-user-vector-illustration-isolated-background-women-sign-business-concept-321407993.webp', 'Prof. Chhaya Patel', 'yashashokgiri@gmail.com', '9316934085', 'B-Tech', 'Sports club', '123123', 'faculty'),
(11, '1776351312_png-radiant-rhythms-unleashing-creativity-with-sticker-anime-characters-through-neon-lines_1142283-37191.avif', 'Prof. Mitulgiri Gauswami', 'marmikkalariya33@gmail.com', '9316934085', 'B-Tech', 'Technical Events', '123123', 'faculty'),
(15, '1776672518_20241016_073225.jpg', 'pritesh bharadwa', 'p@gmail.com', '7896541236', 'hod', 'python', '$2y$10$Nz14BBTwHoVm7jqOjIAenOQaibtDoG5uT.ARaCVnPmbwIUKp1ABxe', 'faculty');

-- --------------------------------------------------------

--
-- Table structure for table `manage_clubs`
--

CREATE TABLE `manage_clubs` (
  `Club_id` int NOT NULL,
  `club_name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'Active',
  `Club_member` int NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manage_clubs`
--

INSERT INTO `manage_clubs` (`Club_id`, `club_name`, `Description`, `Category`, `Status`, `Club_member`, `Image`) VALUES
(1, '', 'Hello welcome Cultural club', 'Sports ', 'Active', 12, 'uploads/1775114073_4870.jpg'),
(7, 'Coding club', 'Techno planet coding club', 'Sports', 'Active', 12, 'uploads/1775044791_9600.jpg'),
(8, 'Galore 2028', 'hello everyone', 'Sports', 'Upcoming', 56, 'uploads/1775101207_6744.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `my_club`
--

CREATE TABLE `my_club` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'Active',
  `Club_member` int NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `my_club`
--

INSERT INTO `my_club` (`id`, `name`, `Description`, `Category`, `Status`, `Club_member`, `images`) VALUES
(1, 'Galore 2026', 'SOE galore ', 'Cultural', 'Active', 100, '1775066985_9889.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `otp`, `created_at`) VALUES
(8, 'ygauswami150@gmail.com', '256429', '2026-04-01 20:49:27'),
(18, 'marmikkalariya33@gmail.com', '155264', '2026-04-01 21:29:41'),
(22, 'yashgoswami3251@gmail.com', '220882', '2026-04-06 03:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `slider_images`
--

CREATE TABLE `slider_images` (
  `id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slider_images`
--

INSERT INTO `slider_images` (`id`, `image`) VALUES
(26, '1773425707_2693_e2.jpg'),
(28, '1773425707_1785_e3.webp'),
(30, '1775013763_7695_e3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `enrollment` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `club` varchar(50) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_master`
--

CREATE TABLE `students_master` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `club_or_event` varchar(100) DEFAULT NULL,
  `type` enum('club','event') DEFAULT NULL,
  `join_date` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students_master`
--

INSERT INTO `students_master` (`id`, `name`, `email`, `phone`, `club_or_event`, `type`, `join_date`, `status`, `created_at`) VALUES
(33, 'Aaryan bharavadiya', 'admin@gmail.com', '0720299633', 'culural yashgiri', 'club', '2026-04-03 15:43:56', 'pending', '2026-04-03 10:16:04'),
(34, 'yash gauswami', 'ygauswami150@gmail.com', '0720299633', 'culural yashgiri', 'club', '2026-04-03 15:43:36', 'pending', '2026-04-03 10:16:04'),
(35, 'yash_gauswami', 'ygauswami150@gmail.com', '0720299633', 'Java devlopers', 'event', '2026-04-03 15:44:21', 'pending', '2026-04-03 10:16:04'),
(36, 'aryanahir', 'abc@gmail.com', '0720299633', 'culural yashgiri', 'club', '2026-04-03 15:47:16', 'pending', '2026-04-03 10:17:22'),
(37, 'smit', 'ygauswami150@gmail.com', '0720299633', 'Culture', 'event', '2026-04-03 16:21:51', 'approved', '2026-04-03 10:52:11'),
(38, '', '', '', '', 'club', '2026-04-03 16:28:33', 'pending', '2026-04-04 07:33:01'),
(39, '', '', '', '', 'event', '2026-04-03 16:08:19', 'pending', '2026-04-04 07:33:01'),
(40, 'mahadev ', 'mahadev@gmail.com', '1236547896', 'N/A', 'club', '2026-04-04 13:11:33', 'approved', '2026-04-04 07:50:36'),
(41, 'Bharadwa Pritesh', 'user@gmail.com', '1234567899', 'N/A', 'club', '2026-04-04 13:36:00', 'approved', '2026-04-04 08:06:12'),
(42, 'Bharadwa Pritesh', 'user@gmail.com', '1234567899', 'culural yashgiri', 'club', '2026-04-04 13:36:00', 'approved', '2026-04-04 08:12:15'),
(43, 'mahadev ', 'mahadev@gmail.com', '1236547896', 'culural yashgiri', 'club', '2026-04-04 13:11:33', 'approved', '2026-04-04 08:12:15'),
(44, 'Bharadwa Pritesh', 'user@gmail.com', '1234567899', 'Java devlopers', 'event', '2026-04-04 13:43:43', 'approved', '2026-04-04 08:13:52'),
(45, 'Bharadwa Pritesh', 'user@gmail.com', '1234567899', 'Hackathon 2025', 'event', '2026-04-04 13:44:12', 'approved', '2026-04-04 08:14:22'),
(46, 'Bharadwa Pritesh', 'user@gmail.com', '1234567899', 'Music CLub', 'club', '2026-04-06 08:28:40', 'approved', '2026-04-06 03:03:27'),
(47, 'Bharadwa Pritesh', 'user@gmail.com', '1234567899', 'N/A', 'event', '2026-04-04 13:44:12', 'approved', '2026-04-06 03:03:27'),
(48, 'Bharadwa ', 'user@gmail.com', '1234567899', 'Sports Club', 'club', '2026-04-06 09:25:08', 'approved', '2026-04-06 03:57:28'),
(49, 'Bharadwa Pritesh', 'priteshprajapati278@gmail.com', '7405437207', 'Sports Club', 'club', '2026-04-06 08:44:41', 'approved', '2026-04-06 03:57:28'),
(50, 'marmik ', 'yash12@gmail.com', '0720299633', 'Spiderman', 'club', '2026-04-16 23:01:50', 'approved', '2026-04-16 17:34:04'),
(51, 'Demo Account', 'demo@gmail.com', '1236547896', 'DEMO EVENT', 'event', '2026-04-19 17:57:02', 'approved', '2026-04-19 12:29:56'),
(52, 'Bharadwa Pritesh', 'priteshprajapati278@gmail.com', '7405437207', 'photografy', 'event', '2026-04-06 09:13:44', 'approved', '2026-04-19 12:29:56'),
(53, 'Demo Account', 'demo@gmail.com', '1236547896', 'Music Consert', 'club', '2026-04-20 12:26:19', 'approved', '2026-04-20 08:11:59'),
(54, 'Demo Account', 'demo@gmail.com', '1236547896', 'hello', 'club', '2026-04-20 12:15:56', 'approved', '2026-04-20 08:11:59'),
(55, 'Demo Pritesh ', 'demo@gmail.com', '1236547896', 'new clube', 'club', '2026-04-20 13:45:40', 'approved', '2026-04-20 08:36:10'),
(56, 'Demo Pritesh ', 'demo@gmail.com', '1236547896', 'Metting club', 'club', '2026-04-20 13:43:19', 'approved', '2026-04-20 08:36:10'),
(57, 'marmik ', 'yash12@gmail.com', '0720299633', 'photografy', 'event', '2026-04-20 14:04:12', 'approved', '2026-04-20 08:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `student_requests`
--

CREATE TABLE `student_requests` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `club_id` int NOT NULL,
  `request_date` date NOT NULL,
  `request_time` time NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `clubimage` varchar(255) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `enrollment` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `role` enum('admin','faculty','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `clubimage`, `fullname`, `email`, `department`, `enrollment`, `mobile`, `password`, `reset_token`, `role`) VALUES
(22, '1776347458_20241107_115319.jpg', 'Bharadwa Pritesh', 'priteshprajapati278@gmail.com', 'CE', '25SOECE13045', '7405437207', 'Pritesh@29', NULL, 'admin'),
(31, '20241105_104656.jpg', 'mahadev ', 'mahadev@gmail.com', 'BBA', '25SOEIT13047', '7405437207', 'M@123', NULL, 'user'),
(32, '20250103_195941.jpg', 'Bharadwa ', 'user@gmail.com', 'CE', '25SOEIT13047', '1234567899', '$2y$10$7a9MhOmzh8jiYyeWdyRzuengpNpYTDMcvNT/HfGswdeDhCXVYkLPO', NULL, 'user'),
(33, 'user_1776923252.jpeg', 'marmik kalariya', 'mkalariya518@rku.ac.in', 'IT', '25SOEIT13018', '9726866944', 'Marmik@123', NULL, 'user'),
(34, 'WhatsApp Image 2025-08-02 at 124220_a51434bc.jpg', 'yash Gauswami', 'ygauswami150@gmail.com', 'IT', '25SOEIT13018', '0720299633', '$2y$10$KTIg.69neFm0QmwlUGS08.ACNn/BjaaFi2p19OlePBhcQkn9WQO8W', NULL, 'user'),
(36, '20241109_201251.jpg', 'Demo Pritesh ', 'demo@gmail.com', 'Demo', 'Demo123654', '1236547896', 'demo123', NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `club_join_requests`
--
ALTER TABLE `club_join_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_join_requests`
--
ALTER TABLE `event_join_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_register`
--
ALTER TABLE `faculty_register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `manage_clubs`
--
ALTER TABLE `manage_clubs`
  ADD PRIMARY KEY (`Club_id`);

--
-- Indexes for table `my_club`
--
ALTER TABLE `my_club`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_images`
--
ALTER TABLE `slider_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_master`
--
ALTER TABLE `students_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_requests`
--
ALTER TABLE `student_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `club_join_requests`
--
ALTER TABLE `club_join_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `event_join_requests`
--
ALTER TABLE `event_join_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `faculty_register`
--
ALTER TABLE `faculty_register`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `manage_clubs`
--
ALTER TABLE `manage_clubs`
  MODIFY `Club_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `my_club`
--
ALTER TABLE `my_club`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `slider_images`
--
ALTER TABLE `slider_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_master`
--
ALTER TABLE `students_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `student_requests`
--
ALTER TABLE `student_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_requests`
--
ALTER TABLE `student_requests`
  ADD CONSTRAINT `student_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_requests_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
