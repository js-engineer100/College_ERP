-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2024 at 09:53 AM
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
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'BTECH-CSE');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `mark_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `marks_obtained` decimal(5,2) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`mark_id`, `student_id`, `marks_obtained`, `subject_id`) VALUES
(131, 42, 75.00, 143),
(132, 43, 2.00, 143),
(133, 44, 3.00, 143),
(134, 45, 4.00, 143),
(135, 46, 5.00, 143),
(136, 47, 6.00, 143),
(137, 48, 7.00, 143),
(138, 49, 8.00, 143),
(139, 50, 9.00, 143),
(140, 42, 29.00, 143);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `email`, `phone`, `password`, `otp`, `otp_expiry`, `department_id`) VALUES
(42, 'Rohini East', 're@123.com', '3473264238', '$2y$10$DRgVAgJOBrBcBNiZ3PX1V.lYkRaCK9Yji3CpYDie4049lINX9ycb.', NULL, NULL, 1),
(43, 'Rohini West', 'rw@123.com', '1236183672', '$2y$10$pmua3Nucd6.w1DbcL7jN..X891v.2H43Dv1x21qaTkS6vsh4ajlcS', NULL, NULL, 1),
(44, 'Rithala delhi', 'rd@123.com', '3435332346', '$2y$10$Oth35lU25AxkkCmW5zD5U.cyJRPe8IIG2fTHDxji5gda25h4WT7kK', NULL, NULL, 1),
(45, 'pitampura delhi', 'pd@123.com', '2132132545', '$2y$10$pUAY7sFBGe6WiJh9CIsBUefFLSc1u/XcD6Ve7WNvxy85C/lho2H8u', NULL, NULL, 1),
(46, 'Hauz Khas', 'hk@123.com', '9987876757', '$2y$10$phLjBHiY7eqdE/raKNS/w.OQ8Qyr0AjXk2pO6lQbgPtekbBpRVLeK', NULL, NULL, 1),
(47, 'Cannaght Place', 'cp@123.com', '7678547427', '$2y$10$VgbFgfEf5mHCWLqAnwXbhO/4/KfqFevI7YiBJiLZ51qA9KDwF88Wi', NULL, NULL, 1),
(48, 'Civil lines', 'cl@123.com', '6487648763', '$2y$10$lbmzz.pMPl9180/EiqTuseNlaWQIvmDvgzCbXXOBYOEygPWt5EucW', NULL, NULL, 1),
(49, 'Tilak Nagar', 'tn@123.com', '3462846328', '$2y$10$5EyHBcHzy0oCfqYzAcoileRZcXFXOcxVPLHlIz5E37U3EW3S.2HAW', NULL, NULL, 1),
(50, 'Rajaouri Garden', 'rg@123.com', '9898786786', '$2y$10$kPHGgWyZl3/KG3Yimk/4oenRnc8b2EY0WPCivUjFgTnOWukJr3rga', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `department_id`) VALUES
(143, 'DSA', 1),
(144, 'Java Programming', 1),
(145, 'Mathematics', 1),
(146, 'Operating System', 1),
(147, 'Computer Networks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_name`, `department_id`, `email`, `password`, `otp`, `otp_expiry`, `subject_id`) VALUES
(9, 'Lord Hydra', 1, 'lh@123.com', '$2y$10$3hm6RVaqdMKyMpfMgXLXRew/.t9J4wmZRR71locIjojfmMILOwkFq', NULL, NULL, 143),
(10, 'Mark Spacer', 1, 'ms@123.com', '$2y$10$E/xxEd1PLlekn2zSIUEK6eaWLOvFBR4XVeisiHJ7YQAGRyYlcD1Xe', NULL, NULL, 144),
(11, 'Teacher Coleman', 1, 'tc@123.com', '$2y$10$boKnkBoRnsA2.5WfvUP8d.JyyWlccpq5eNt2aTyQuxCCxnyxQNyc2', NULL, NULL, 145),
(12, 'Teacher Doom', 1, 'td@123.com', '$2y$10$2xuQP.i5JohkVWeEqtWyqu6EXjMGIPGdBtSb9wSABl9xkIF0qMvmO', NULL, NULL, 146),
(13, 'Teacher Superman', 1, 'ts@123.com', '$2y$10$p77VNmOmYGFM/Et/tNmSzOeoDi4IfzXvgb2CycsLE44IU6locafDa', NULL, NULL, 147);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `ticket_ref_id` varchar(255) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `ticket_status` enum('open','closed','cancelled','pending') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `closed_at` timestamp NULL DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `mark_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `ticket_ref_id`, `student_id`, `comment`, `ticket_status`, `created_at`, `closed_at`, `subject_id`, `mark_id`) VALUES
(104, 'eg3ebg', 42, 'shi se check krle bhai...', 'closed', '2024-04-26 06:57:10', '2024-04-26 07:05:38', 143, 131),
(105, 'cf29u7', 42, 'aee vedya', 'cancelled', '2024-04-26 06:57:25', '2024-04-26 07:00:09', 143, 131),
(108, 'jr8gqu', 42, '29 number wala', 'closed', '2024-04-26 07:04:29', '2024-04-26 07:06:22', 143, 140);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`mark_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_marks_subject` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_department` (`department_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `fk_department_subject` (`department_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `fk_teacher_subject` (`subject_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_subject_id` (`subject_id`),
  ADD KEY `fk_mark_id` (`mark_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `fk_marks_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_department_subject` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `fk_teacher_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `fk_mark_id` FOREIGN KEY (`mark_id`) REFERENCES `marks` (`mark_id`),
  ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
