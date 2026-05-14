-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 07:48 PM
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
-- Database: `cv_editor`
--

-- --------------------------------------------------------

--
-- Table structure for table `cv_entries`
--

CREATE TABLE `cv_entries` (
  `id` int(11) NOT NULL,
  `section_key` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv_entries`
--

INSERT INTO `cv_entries` (`id`, `section_key`, `title`, `description`, `created_at`) VALUES
(1, 'personal_info', 'Alfa Amos Mbemba', 'P.O Box 90, Nyasa', '2026-05-14 16:26:15'),
(2, 'education', 'Ng\'ombo Primary school', 'From 2011 to 2017', '2026-05-14 16:27:17'),
(3, 'job_experiences', 'TANESCO, Nyasa', 'IT Expert', '2026-05-14 16:27:51'),
(4, 'programming_languages', 'HTML', 'Expert', '2026-05-14 16:28:22'),
(5, 'hobbies', 'Football', 'Games', '2026-05-14 16:28:48'),
(6, 'referees', 'Mr. Amos Mbemba', 'Engineer', '2026-05-14 16:29:29'),
(7, 'role_models', 'David Mwita', 'Web Developer', '2026-05-14 16:30:01'),
(8, 'education', 'Nyasa Secondary School', 'From 2018 to 2021', '2026-05-14 16:31:00'),
(9, 'programming_languages', 'C', 'Beginer', '2026-05-14 16:31:22'),
(10, 'hobbies', 'Movies', 'Into the Badlands\nPrison Break', '2026-05-14 16:32:07'),
(11, 'education', 'Rungwe High school', 'From 2022 to 2024', '2026-05-14 16:33:24'),
(12, 'job_experiences', 'Nyasa Secondary school', 'Physics $ Mathe Teacher', '2026-05-14 16:34:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cv_entries`
--
ALTER TABLE `cv_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cv_entries`
--
ALTER TABLE `cv_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
