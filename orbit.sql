-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 01, 2026 at 01:01 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orbit`
--

-- --------------------------------------------------------

--
-- Table structure for table `carpool`
--

DROP TABLE IF EXISTS `carpool`;
CREATE TABLE IF NOT EXISTS `carpool` (
  `carpool_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` timestamp NOT NULL,
  `car_colour` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_plate` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`carpool_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carpool_request`
--

DROP TABLE IF EXISTS `carpool_request`;
CREATE TABLE IF NOT EXISTS `carpool_request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `carpool_id` int NOT NULL,
  `approval` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `user_id` (`user_id`),
  KEY `carpool_id` (`carpool_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `classroom_id` int NOT NULL AUTO_INCREMENT,
  `location_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL,
  `access` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`classroom_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `type`) VALUES
('AFCF', 'Certificate'),
('APDF', 'Degree'),
('APUMF', 'Master'),
('UCDF', 'Diploma'),
('UCFF', 'Foundation');

-- --------------------------------------------------------

--
-- Table structure for table `course_module`
--

DROP TABLE IF EXISTS `course_module`;
CREATE TABLE IF NOT EXISTS `course_module` (
  `course_module_id` int NOT NULL AUTO_INCREMENT,
  `module_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lecturer_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`course_module_id`),
  KEY `module_id` (`module_id`),
  KEY `lecturer_id` (`lecturer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intake`
--

DROP TABLE IF EXISTS `intake`;
CREATE TABLE IF NOT EXISTS `intake` (
  `intake_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `total_register` int NOT NULL,
  `total_active` int NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`intake_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
CREATE TABLE IF NOT EXISTS `lecturer` (
  `lecturer_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `qualification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`lecturer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `lecturer`
--
DROP TRIGGER IF EXISTS `before_lecturer_insert`;
DELIMITER $$
CREATE TRIGGER `before_lecturer_insert` BEFORE INSERT ON `lecturer` FOR EACH ROW BEGIN
    DECLARE next_num INT;
    SELECT COALESCE(MAX(CAST(SUBSTRING(lecturer_id, 2) AS UNSIGNED)), 0) + 1
    INTO next_num
    FROM lecturer;

    SET NEW.lecturer_id = CONCAT('L', LPAD(next_num, 6, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `location_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `name`, `floor`) VALUES
('A0401', 'A-04-01', '4'),
('A0402', 'A-04-02', '4'),
('A0403', 'A-04-03', '4'),
('A0404', 'A-04-04', '4'),
('A0405', 'A-04-05', '4'),
('AIL', 'Analogue Instrumentation Lab', '4'),
('Audi4', 'Auditorium 4', '3'),
('Audi5', 'Auditorium 5', '3'),
('Audi6', 'Auditorium 6', '3'),
('Audi7', 'Auditorium 7', '3'),
('AVBSO', 'Administrative Visa and Bursary Office', '4'),
('B0401', 'B-04-01 Computer Lab', '4'),
('B0402', 'B-04-02', '4'),
('B0403', 'B-04-03 Library', '4'),
('B0404', 'B-04-04 Senior Management Office', '4'),
('B0405', 'B-04-05 Academic Office', '4'),
('B0406', 'B-04-06 Admin Office', '4'),
('B0407', 'B-04-07', '4'),
('B0408', 'B-04-08', '4'),
('B0409', 'B-04-09', '4'),
('B0410', 'B-04-10', '4'),
('CL308', 'CAD/CAM Lab 3-08', '3'),
('CRDIOT', 'Center for Research & Development of IoT', '4'),
('DL', 'Digital Lab', '4'),
('DL302', 'Design Lab 3-02', '3'),
('EPI', 'Engineering Project Incubator', '3'),
('ETSC', 'Engineering Tech Support Center', '3'),
('EV31', 'First Elevator L3', '3'),
('EV32', 'Block B Elevator L3', '3'),
('EV33', 'Block E Elevator L3', '3'),
('EV34', 'Block C Elevator L3', '3'),
('EV41', 'First Elevator L4', '4'),
('EV42', 'Block B Elevator L4', '4'),
('EV43', 'Block E Elevator L4', '4'),
('EV44', 'Block C Elevator L4', '4'),
('FL301', 'Fabrication Lab 3-01', '3'),
('GCE', 'Google Centre of Excellence', '4'),
('Library', 'Library', '4'),
('MCL', 'Microprocessor / Communication Lab', '4'),
('MOL', 'Microwave Optic Lab', '4'),
('PC', 'Postgraduate Center', '3'),
('PL1', 'Power Lab 1', '3'),
('PL2', 'Power Lab 2', '3'),
('PMR', 'Postgraduate Meeting Room', '3'),
('PP306', 'PLC & Pneumatics Lab 3-06', '3'),
('RE305', 'Robotic Engineering 3-05', '3'),
('RL307', 'Robotics Lab 3-07', '3'),
('S0401', 'S-04-01', '4'),
('S0402', 'S-04-02', '4'),
('ST31', 'First Staircase L3', '3'),
('ST32', 'Block B Staircase L3', '3'),
('ST33', 'Block D Staircase L3', '3'),
('ST34', 'Block E Staircase L3', '3'),
('ST35', 'Last Staircase L3', '3'),
('ST36', 'Middle Staircase L3', '3'),
('ST37', 'Block C Staircase L3', '3'),
('ST41', 'First Staircase L4', '4'),
('ST42', 'Block B Staircase L4', '4'),
('ST43', 'Block D Staircase L4', '4'),
('ST44', 'Block E Staircase L4', '4'),
('ST45', 'Last Staircase L4', '4'),
('ST46', 'Middle Staircase L4', '4'),
('ST47', 'Block C Staircase L4', '4'),
('TL402', 'Tech Lab 4-02', '4'),
('TL403', 'Tech Lab 4-03', '4'),
('TL404', 'Tech Lab 4-04', '4'),
('TL405', 'Tech Lab 4-05', '4'),
('TL406', 'Tech Lab 4-06', '4'),
('TL407', 'Tech Lab 4-07', '4'),
('TS4', 'Technical Support', '4');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
CREATE TABLE IF NOT EXISTS `major` (
  `major_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`major_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`major_id`, `name`) VALUES
('AAF', 'Accounting & Finance'),
('ARC', 'Architecture'),
('AS', 'Actuarial Studies'),
('BAF', 'Banking & Finance'),
('BAM', 'Business & Management'),
('CT', 'Computing & Technology'),
('DCM', 'Design & Creative Media'),
('DMM', 'Digital Marketing & Media'),
('EDU', 'Education'),
('ENG', 'Engineering'),
('GD', 'Game Development'),
('HT', 'Hospitality & Tourism'),
('IR', 'International Relations'),
('PSY', 'Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `module_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `major_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`),
  KEY `major_id` (`major_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_group`
--

DROP TABLE IF EXISTS `module_group`;
CREATE TABLE IF NOT EXISTS `module_group` (
  `module_group_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_module_id` int NOT NULL,
  `hours` decimal(2,1) NOT NULL,
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`module_group_id`),
  KEY `course_module_id` (`course_module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_intake`
--

DROP TABLE IF EXISTS `module_intake`;
CREATE TABLE IF NOT EXISTS `module_intake` (
  `module_intake_id` int NOT NULL AUTO_INCREMENT,
  `intake_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_module_id` int NOT NULL,
  PRIMARY KEY (`module_intake_id`),
  KEY `intake_id` (`intake_id`),
  KEY `course_module_id` (`course_module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int NOT NULL AUTO_INCREMENT,
  `module_group_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `classroom_id` int NOT NULL,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL,
  PRIMARY KEY (`schedule_id`),
  KEY `module_group_id` (`module_group_id`),
  KEY `classroom_id` (`classroom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `student`
--
DROP TRIGGER IF EXISTS `before_student_insert`;
DELIMITER $$
CREATE TRIGGER `before_student_insert` BEFORE INSERT ON `student` FOR EACH ROW BEGIN
    DECLARE next_num INT;
    SELECT COALESCE(MAX(CAST(SUBSTRING(student_id, 3) AS UNSIGNED)), 0) + 1
    INTO next_num
    FROM student;

    SET NEW.student_id = CONCAT('TP', LPAD(next_num, 6, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student_intake`
--

DROP TABLE IF EXISTS `student_intake`;
CREATE TABLE IF NOT EXISTS `student_intake` (
  `student_intake_id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `intake_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`student_intake_id`),
  KEY `student_id` (`student_id`),
  KEY `intake_id` (`intake_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `email`, `phone`, `picture`, `role`) VALUES
(1, 'User Admin', '$2y$10$8uN9/8QvoXrTXD8Q2QeAeODyrEr8GSJFQMRqioZi6qtPq7ayWByGm', 'admin@example.com', '+123456789', NULL, 'User Admin'),
(2, 'Course Admin', '$2y$10$jrp4jUEmucYqfJrXGUOrr.Qu0Zd6CP2j/s56vd9e6Vozyhh2gUk3y', 'academic@example.com', '+234567891', NULL, 'Course Admin'),
(3, 'Schedule Admin', '$2y$10$oMWHGlPK9yVXzWBrWhkWRewMxTlxlNYK8/81LgTt07DAS2TtAhPt2', 'schedule@example.com', '+345678912', NULL, 'Schedule Admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carpool`
--
ALTER TABLE `carpool`
  ADD CONSTRAINT `carpool_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `carpool_request`
--
ALTER TABLE `carpool_request`
  ADD CONSTRAINT `carpool_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carpool_request_ibfk_2` FOREIGN KEY (`carpool_id`) REFERENCES `carpool` (`carpool_id`) ON DELETE CASCADE;

--
-- Constraints for table `classroom`
--
ALTER TABLE `classroom`
  ADD CONSTRAINT `classroom_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_module`
--
ALTER TABLE `course_module`
  ADD CONSTRAINT `course_module_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_module_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE CASCADE;

--
-- Constraints for table `intake`
--
ALTER TABLE `intake`
  ADD CONSTRAINT `intake_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`major_id`) REFERENCES `major` (`major_id`) ON DELETE CASCADE;

--
-- Constraints for table `module_group`
--
ALTER TABLE `module_group`
  ADD CONSTRAINT `module_group_ibfk_1` FOREIGN KEY (`course_module_id`) REFERENCES `course_module` (`course_module_id`) ON DELETE CASCADE;

--
-- Constraints for table `module_intake`
--
ALTER TABLE `module_intake`
  ADD CONSTRAINT `module_intake_ibfk_1` FOREIGN KEY (`intake_id`) REFERENCES `intake` (`intake_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `module_intake_ibfk_2` FOREIGN KEY (`course_module_id`) REFERENCES `course_module` (`course_module_id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`module_group_id`) REFERENCES `module_group` (`module_group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`classroom_id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_intake`
--
ALTER TABLE `student_intake`
  ADD CONSTRAINT `student_intake_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_intake_ibfk_2` FOREIGN KEY (`intake_id`) REFERENCES `intake` (`intake_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
