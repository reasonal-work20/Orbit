-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 12, 2026 at 03:01 AM
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
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `name`, `floor`, `type`) VALUES
('6Audi2', 'Auditorium 2 L6', '6', 'Auditorium / Lecture Halls'),
('7Audi1', 'Auditorium 1 L7', '7', 'Auditorium / Lecture Halls'),
('7Audi2', 'Auditorium 2 L7', '7', 'Auditorium / Lecture Halls'),
('8Audi1', 'Auditorium 1 L8', '8', 'Auditorium / Lecture Halls'),
('A0401', 'A-04-01', '4', 'Classroom'),
('A0402', 'A-04-02', '4', 'Classroom'),
('A0403', 'A-04-03', '4', 'Classroom'),
('A0404', 'A-04-04', '4', 'Classroom'),
('A0405', 'A-04-05', '4', 'Classroom'),
('A0501', 'A-05-01', '5', 'Classroom'),
('A0502', 'A-05-02', '5', 'Classroom'),
('A0503', 'A-05-03', '5', 'Classroom'),
('A0504', 'A-05-04', '5', 'Classroom'),
('A0505', 'A-05-05', '5', 'Classroom'),
('A0601', 'A-06-01', '6', 'Classroom'),
('A0602', 'A-06-02', '6', 'Classroom'),
('A0603', 'A-06-03', '6', 'Classroom'),
('A0604', 'A-06-04', '6', 'Classroom'),
('A0605', 'A-06-05', '6', 'Classroom'),
('AIL', 'Analogue Instrumentation Lab', '4', 'Labs / Workshops / Studios / Suites'),
('ANI', 'Tech Lab 6-17 (Animation Suite)', '6', 'Labs / Workshops / Studios / Suites'),
('APCA', 'Asia Pacific Center for Analytics', '5', 'Other Facilities'),
('ARST', 'Architecture Studio', '5', 'Other Facilities'),
('Audi3', 'Auditorium 3 L9', '9', 'Auditorium / Lecture Halls'),
('Audi4', 'Auditorium 4', '3', 'Auditorium / Lecture Halls'),
('Audi5', 'Auditorium 5', '3', 'Auditorium / Lecture Halls'),
('Audi6', 'Auditorium 6', '3', 'Auditorium / Lecture Halls'),
('Audi7', 'Auditorium 7', '3', 'Auditorium / Lecture Halls'),
('AVBSO', 'Administrative Visa and Bursary Office', '4', 'Other Facilities'),
('AVRS', 'Tech Lab 6-19 (Audio Visual Production and Recording Studio)', '6', 'Labs / Workshops / Studios / Suites '),
('B0401', 'B-04-01 Computer Lab', '4', 'Classroom'),
('B0402', 'B-04-02', '4', 'Auditorium / Lecture Halls'),
('B0403', 'B-04-03 Library', '4', 'Other Facilities'),
('B0404', 'B-04-04 Senior Management Office', '4', 'Other Facilities'),
('B0405', 'B-04-05 Academic Office', '4', 'Other Facilities'),
('B0406', 'B-04-06 Admin Office', '4', 'Other Facilities'),
('B0407', 'B-04-07', '4', 'Auditorium / Lecture Halls'),
('B0408', 'B-04-08', '4', 'Auditorium / Lecture Halls'),
('B0409', 'B-04-09', '4', 'Auditorium / Lecture Halls'),
('B0410', 'B-04-10', '4', 'Classroom'),
('B0501', 'B-05-01', '5', 'Classroom'),
('B0502', 'B-05-02', '5', 'Classroom'),
('B0503', 'B-05-03', '5', 'Classroom'),
('B0504', 'B-05-04', '5', 'Classroom'),
('B0505', 'B-05-05', '5', 'Classroom'),
('B0506', 'B-05-06', '5', 'Classroom'),
('B0507', 'B-05-07', '5', 'Classroom'),
('B0508', 'B-05-08', '5', 'Classroom'),
('B0509', 'B-05-09', '5', 'Classroom'),
('B0510', 'B-05-10', '5', 'Classroom'),
('B0601', 'B-06-01', '6', 'Classroom'),
('B0602', 'B-06-02', '6', 'Classroom'),
('B0603', 'B-06-03', '6', 'Classroom'),
('B0604', 'B-06-04', '6', 'Classroom'),
('B0605', 'B-06-05', '6', 'Classroom'),
('B0606', 'B-06-06', '6', 'Classroom'),
('B0607', 'B-06-07', '6', 'Classroom'),
('B0608', 'B-06-08', '6', 'Classroom'),
('B0609', 'B-06-09', '6', 'Classroom'),
('B0610', 'B-06-10', '6', 'Classroom'),
('B0701', 'B-07-01', '7', 'Classroom'),
('B0702', 'B-07-02', '7', 'Classroom'),
('B0703', 'B-07-03', '7', 'Classroom'),
('B0704', 'B-07-04', '7', 'Classroom'),
('B0705', 'B-07-05', '7', 'Classroom'),
('B0706', 'B-07-06', '7', 'Classroom'),
('B0707', 'B-07-07', '7', 'Classroom'),
('B0708', 'B-07-08', '7', 'Classroom'),
('B0709', 'B-07-09', '7', 'Classroom'),
('B0801', 'B-08-01', '8', 'Classroom'),
('B0802', 'B-08-02', '8', 'Classroom'),
('B0803', 'B-08-03', '8', 'Classroom'),
('B0804', 'B-08-04', '8', 'Classroom'),
('B0805', 'B-08-05', '8', 'Classroom'),
('B0806', 'B-08-06', '8', 'Classroom'),
('B0807', 'B-08-07', '8', 'Classroom'),
('B0808', 'B-08-08', '8', 'Classroom'),
('B0809', 'B-08-09', '8', 'Classroom'),
('B0810', 'B-08-10', '8', 'Classroom'),
('C0901', 'C-09-01', '9', 'Classroom'),
('C0902', 'C-09-02', '9', 'Classroom'),
('CGI', 'Tech Lab 6-15 (CGI Suite)', '6', 'Labs / Workshops / Studios / Suites'),
('Cisco', 'Cisco Networking Academy', '5', 'Other Facilities'),
('CL308', 'CAD/CAM Lab 3-08', '3', 'Labs / Workshops / Studios / Suites'),
('CR', 'Cyber Range', '5', 'Other Facilities'),
('CRDIOT', 'Center for Research & Development of IoT', '4', 'Other Facilities'),
('D0602', 'D-06-02', '6', 'Classroom '),
('D0604', 'D-06-04', '6', 'Classroom'),
('D0605', 'D-06-05', '6', 'Classroom'),
('D0606', 'D-06-06', '6', 'Classroom'),
('D0607', 'D-06-07', '6', 'Classroom'),
('D0608', 'D-06-08', '6', 'Classroom'),
('D0609', 'D-06-09', '6', 'Classroom'),
('D0610', 'D-06-10', '6', 'Classroom'),
('D0611', 'D-06-11', '6', 'Classroom'),
('D0612', 'D-06-12', '6', 'Classroom'),
('D0613', 'D-06-13', '6', 'Classroom'),
('D0701', 'D-07-01', '7', 'Classroom'),
('D0702', 'D-07-02', '7', 'Classroom'),
('D0703', 'D-07-03', '7', 'Classroom'),
('D0704', 'D-07-04', '7', 'Classroom'),
('D0705', 'D-07-05', '7', 'Classroom'),
('D0706', 'D-07-06', '7', 'Classroom'),
('D0707', 'D-07-07', '7', 'Classroom'),
('D0708', 'D-07-08', '7', 'Classroom'),
('D0709', 'D-07-09', '7', 'Classroom'),
('D0710', 'D-07-10', '7', 'Classroom'),
('D0711', 'D-07-11', '7', 'Classroom'),
('D0712', 'D-07-12', '7', 'Classroom'),
('D0713', 'D-07-13', '7', 'Classroom'),
('D0714', 'D-07-14', '7', 'Classroom'),
('D0715', 'D-07-15', '7', 'Classroom'),
('D0716', 'D-07-16', '7', 'Classroom'),
('D0717', 'D-07-17', '7', 'Classroom'),
('D0801', 'D-08-01', '8', 'Classroom'),
('D0802', 'D-08-02', '8', 'Classroom'),
('D0803', 'D-08-03', '8', 'Classroom'),
('D0804', 'D-08-04', '8', 'Classroom'),
('D0805', 'D-08-05', '8', 'Classroom'),
('D0806', 'D-08-06', '8', 'Classroom'),
('D0807', 'D-08-07', '8', 'Classroom'),
('D0808', 'D-08-08', '8', 'Classroom'),
('D0809', 'D-08-09', '8', 'Classroom'),
('D0810', 'D-08-10', '8', 'Classroom'),
('D0811', 'D-08-11', '8', 'Classroom'),
('D0812', 'D-08-12', '8', 'Classroom'),
('D0813', 'D-08-13', '8', 'Classroom'),
('D0814', 'D-08-14', '8', 'Classroom'),
('D0815', 'D-08-15', '8', 'Classroom'),
('D0901', 'D-09-01', '9', 'Classroom'),
('D0902', 'D-09-02', '9', 'Classroom'),
('D0903', 'D-09-03', '9', 'Classroom'),
('D0904', 'D-09-04', '9', 'Classroom'),
('D0905', 'D-09-05', '9', 'Classroom'),
('D0906', 'D-09-06', '9', 'Classroom'),
('D0907', 'D-09-07', '9', 'Classroom'),
('D0908', 'D-09-08', '9', 'Classroom'),
('D0909', 'D-09-09', '9', 'Classroom'),
('D0910', 'D-09-10', '9', 'Classroom'),
('D0911', 'D-09-11', '9', 'Classroom'),
('D0912', 'D-09-12', '9', 'Classroom'),
('DL', 'Digital Lab', '4', 'Labs / Workshops / Studios / Suites'),
('DL302', 'Design Lab 3-02', '3', 'Labs / Workshops / Studios / Suites'),
('E0701', 'E-07-01', '7', 'Classroom'),
('E0702', 'E-07-02', '7', 'Classroom'),
('E0703', 'E-07-03', '7', 'Classroom'),
('E0704', 'E-07-04', '7', 'Classroom'),
('E0705', 'E-07-05', '7', 'Classroom'),
('E0706', 'E-07-06', '7', 'Classroom'),
('E0707', 'E-07-07', '7', 'Classroom'),
('E0708', 'E-07-08', '7', 'Classroom'),
('E0709', 'E-07-09', '7', 'Classroom'),
('E0801', 'E-08-01', '8', 'Classroom'),
('E0802', 'E-08-02', '8', 'Classroom'),
('E0803', 'E-08-03', '8', 'Classroom'),
('E0804', 'E-08-04', '8', 'Classroom'),
('E0805', 'E-08-05', '8', 'Classroom'),
('E0806', 'E-08-06', '8', 'Classroom'),
('E0807', 'E-08-07', '8', 'Classroom'),
('E0808', 'E-08-08', '8', 'Classroom'),
('E0809', 'E-08-09', '8', 'Classroom'),
('E0810', 'E-08-10', '8', 'Classroom'),
('E0811', 'E-08-11', '8', 'Classroom'),
('E0901', 'E-09-01', '9', 'Classroom'),
('E0902', 'E-09-02', '9', 'Classroom'),
('E0903', 'E-09-03', '9', 'Classroom'),
('E0904', 'E-09-04', '9', 'Classroom'),
('E0905', 'E-09-05', '9', 'Classroom'),
('E0906', 'E-09-06', '9', 'Classroom'),
('E0907', 'E-09-07', '9', 'Classroom'),
('E0908', 'E-09-08', '9', 'Classroom'),
('E0909', 'E-09-09', '9', 'Classroom'),
('E0910', 'E-09-10', '9', 'Classroom'),
('E0911', 'E-09-11', '9', 'Classroom'),
('EPI', 'Engineering Project Incubator', '3', 'Labs / Workshops / Studios / Suites'),
('ETSC', 'Engineering Tech Support Center', '3', 'Other Facilities'),
('EV31', 'First Elevator L3', '3', 'Connector'),
('EV32', 'Block B Elevator L3', '3', 'Connector'),
('EV33', 'Block E Elevator L3', '3', 'Connector'),
('EV34', 'Block C Elevator L3', '3', 'Connector'),
('EV41', 'First Elevator L4', '4', 'Connector'),
('EV42', 'Block B Elevator L4', '4', 'Connector'),
('EV43', 'Block E Elevator L4', '4', 'Connector'),
('EV44', 'Block C Elevator L4', '4', 'Connector'),
('EV51', 'First Elevator L5', '5', 'Connector'),
('EV52', 'Block B Elevator L5', '5', 'Connector'),
('EV53', 'Block E Elevator L5', '5', 'Connector'),
('EV54', 'Block C Elevator L5', '5', 'Connector'),
('EV61', 'First Elevator L6', '6', 'Connector'),
('EV62', 'Block B Elevator L6', '6', 'Connector'),
('EV63', 'Block E Elevator L6', '6', 'Connector'),
('EV64', 'Block C Elevator L6', '6', 'Connector'),
('EV71', 'First Elevator L7', '7', 'Connector'),
('EV72', 'Block B Elevator L7', '7', 'Connector'),
('EV73', 'Block E Elevator L7', '7', 'Connector'),
('EV74', 'Block C Elevator L7', '7', 'Connector'),
('EV81', 'First Elevator L8', '8', 'Connector'),
('EV82', 'Block B Elevator L8', '8', 'Connector'),
('EV83', 'Block E Elevator L8', '8', 'Connector'),
('EV91', 'First Elevator L9', '9', 'Connector'),
('EV92', 'Block B Elevator L9', '9', 'Connector'),
('Exam', 'Exam Hall', '5', 'Other Facilities'),
('FL301', 'Fabrication Lab 3-01', '3', 'Labs / Workshops / Studios / Suites'),
('FSec', 'Forensics and Cybersecurity Research Centre', '5', 'Other Facilities'),
('GCE', 'Google Centre of Excellence', '4', 'Other Facilities'),
('GLS', 'Game Lab and Studio', '5', 'Other Facilities'),
('iMac', 'Tech Lab 6-15 (iMac Suite)', '6', 'Labs / Workshops / Studios / Suites'),
('Library', 'Library', '4', 'Other Facilities'),
('MCL', 'Microprocessor / Communication Lab', '4', 'Labs / Workshops / Studios / Suites'),
('MOL', 'Microwave Optic Lab', '4', 'Labs / Workshops / Studios / Suites'),
('MR1', 'Meeting Room 1', '5', 'Other Facilities'),
('MR2', 'Meeting Room 2', '5', 'Other Facilities'),
('P1', 'Presentation 1', '5', 'Other Facilities'),
('P2', 'Presentation 2', '5', 'Other Facilities'),
('P3', 'Presentation 3', '5', 'Other Facilities'),
('PC', 'Postgraduate Center', '3', 'Other Facilities'),
('PL1', 'Power Lab 1', '3', 'Labs / Workshops / Studios / Suites'),
('PL2', 'Power Lab 2', '3', 'Labs / Workshops / Studios / Suites'),
('PMR', 'Postgraduate Meeting Room', '3', 'Other Facilities'),
('PP306', 'PLC & Pneumatics Lab 3-06', '3', 'Labs / Workshops / Studios / Suites'),
('RE305', 'Robotic Engineering 3-05', '3', 'Labs / Workshops / Studios / Suites'),
('RL307', 'Robotics Lab 3-07', '3', 'Labs / Workshops / Studios / Suites'),
('S0401', 'S-04-01', '4', 'Classroom'),
('S0402', 'S-04-02', '4', 'Classroom'),
('S0501', 'S-05-01', '5', 'Classroom'),
('S0502', 'S-05-02', '5', 'Classroom'),
('S0601', 'S-06-01', '6', 'Classroom'),
('S0602', 'S-06-02', '6', 'Classroom'),
('S0701', 'S-07-01', '7', 'Classroom'),
('S0702', 'S-07-02', '7', 'Classroom'),
('S0801', 'S-08-01', '8', 'Classroom'),
('S0802', 'S-08-02', '8', 'Classroom'),
('S0803', 'S-08-03', '8', 'Classroom'),
('S0804', 'S-08-04', '8', 'Classroom'),
('S0805', 'S-08-05', '8', 'Classroom'),
('S0806', 'S-08-06', '8', 'Classroom'),
('S0807', 'S-08-07', '8', 'Classroom'),
('SCOA', 'School of Architecture', '5', 'Other Facilities'),
('SOC', 'Security Operations Center', '5', 'Other Facilities'),
('ST31', 'First Staircase L3', '3', 'Connector'),
('ST32', 'Block B Staircase L3', '3', 'Connector'),
('ST33', 'Block D Staircase L3', '3', 'Connector'),
('ST34', 'Block E Staircase L3', '3', 'Connector'),
('ST35', 'Last Staircase L3', '3', 'Connector'),
('ST36', 'Middle Staircase L3', '3', 'Connector'),
('ST37', 'Block C Staircase L3', '3', 'Connector'),
('ST41', 'First Staircase L4', '4', 'Connector'),
('ST42', 'Block B Staircase L4', '4', 'Connector'),
('ST43', 'Block D Staircase L4', '4', 'Connector'),
('ST44', 'Block E Staircase L4', '4', 'Connector'),
('ST45', 'Last Staircase L4', '4', 'Connector'),
('ST46', 'Middle Staircase L4', '4', 'Connector'),
('ST47', 'Block C Staircase L4', '4', 'Connector'),
('ST51', 'First Staircase L5', '5', 'Connector'),
('ST52', 'Block B Staircase L5', '5', 'Connector'),
('ST53', 'Block D Staircase L5', '5', 'Connector'),
('ST54', 'Block E Staircase L5', '5', 'Connector'),
('ST55', 'Last Staircase L5', '5', 'Connector'),
('ST56', 'Middle Staircase L5', '5', 'Connector'),
('ST57', 'Block C Staircase L5', '5', 'Connector'),
('ST61', 'First Staircase L6', '6', 'Connector'),
('ST62', 'Block B Staircase L6', '6', 'Connector'),
('ST63', 'Block D Staircase L6', '6', 'Connector'),
('ST64', 'Block E Staircase L6', '6', 'Connector'),
('ST65', 'Last Staircase L6', '6', 'Connector'),
('ST66', 'Middle Staircase L6', '6', 'Connector'),
('ST67', 'Block C Staircase L6', '6', 'Connector'),
('ST71', 'First Staircase L7', '7', 'Connector'),
('ST72', 'Block B Staircase L7', '7', 'Connector'),
('ST73', 'Block D Staircase L7', '7', 'Connector'),
('ST74', 'Block E Staircase L7', '7', 'Connector'),
('ST75', 'Last Staircase L7', '7', 'Connector'),
('ST76', 'Middle Staircase L7', '7', 'Connector'),
('ST77', 'Block C Staircase L7', '7', 'Connector'),
('ST81', 'First Staircase L8', '8', 'Connector'),
('ST82', 'Block B Staircase L8', '8', 'Connector'),
('ST83', 'Block D Staircase L8', '8', 'Connector'),
('ST84', 'Block E Staircase L8', '8', 'Connector'),
('ST85', 'Last Staircase L8', '8', 'Connector'),
('ST86', 'Middle Staircase L8', '8', 'Connector'),
('ST91', 'First Staircase L9', '9', 'Connector'),
('ST92', 'Block B Staircase L9', '9', 'Connector'),
('ST93', 'Block D Staircase L9', '9', 'Connector'),
('TL402', 'Tech Lab 4-02', '4', 'Labs / Workshops / Studios / Suites'),
('TL403', 'Tech Lab 4-03', '4', 'Labs / Workshops / Studios / Suites'),
('TL404', 'Tech Lab 4-04', '4', 'Labs / Workshops / Studios / Suites'),
('TL405', 'Tech Lab 4-05', '4', 'Labs / Workshops / Studios / Suites'),
('TL406', 'Tech Lab 4-06', '4', 'Labs / Workshops / Studios / Suites'),
('TL407', 'Tech Lab 4-07', '4', 'Labs / Workshops / Studios / Suites'),
('TL501', 'Tech Lab 5-01 Financial Trading Center', '5', 'Labs / Workshops / Studios / Suites'),
('TL601', 'Tech Lab 6-01', '6', 'Labs / Workshops / Studios / Suites'),
('TL602', 'Tech Lab 6-02', '6', 'Labs / Workshops / Studios / Suites '),
('TL603', 'Tech Lab 6-03', '6', 'Labs / Workshops / Studios / Suites'),
('TL604', 'Tech Lab 6-04', '6', 'Labs / Workshops / Studios / Suites'),
('TL605', 'Tech Lab 6-05', '6', 'Labs / Workshops / Studios / Suites'),
('TL606', 'Tech Lab 6-06', '6', 'Labs / Workshops / Studios / Suites'),
('TL607', 'Tech Lab 6-07', '6', 'Labs / Workshops / Studios / Suites'),
('TL608', 'Tech Lab 6-08', '6', 'Labs / Workshops / Studios / Suites'),
('TL609', 'Tech Lab 6-09', '6', 'Labs / Workshops / Studios / Suites'),
('TL610', 'Tech Lab 6-10', '6', 'Labs / Workshops / Studios / Suites'),
('TL611', 'Tech Lab 6-11', '6', 'Labs / Workshops / Studios / Suites'),
('TL612', 'Tech Lab 6-12', '6', 'Labs / Workshops / Studios / Suites'),
('TL613', 'Tech Lab 6-13', '6', 'Labs / Workshops / Studios / Suites'),
('TL614', 'Tech Lab 6-14', '6', 'Labs / Workshops / Studios / Suites'),
('TS4', 'Technical Support', '4', 'Other Facilities'),
('VAS', 'Visionary AI Studio', '5', 'Other Facilities'),
('VFX', 'Tech Lab 6-18 (VFX Suite)', '6', 'Labs / Workshops / Studios / Suites'),
('VGM', 'Video Game Mini Museum', '5', 'Other Facilities'),
('XR', 'XR Studio', '6', 'Labs / Workshops / Studios / Suites');

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
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `user_id`, `status`) VALUES
('TP000001', 4, 'Active'),
('TP000002', 5, 'Active'),
('TP000003', 6, 'Active'),
('TP000004', 7, 'Active'),
('TP000005', 8, 'Active'),
('TP000006', 9, 'Active'),
('TP000007', 10, 'Active'),
('TP000008', 11, 'Active'),
('TP000009', 12, 'Active'),
('TP000010', 13, 'Active');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `email`, `phone`, `picture`, `role`) VALUES
(1, 'User Admin', '$2y$10$8uN9/8QvoXrTXD8Q2QeAeODyrEr8GSJFQMRqioZi6qtPq7ayWByGm', 'admin@example.com', '+123456789', NULL, 'User Admin'),
(2, 'Course Admin', '$2y$10$jrp4jUEmucYqfJrXGUOrr.Qu0Zd6CP2j/s56vd9e6Vozyhh2gUk3y', 'academic@example.com', '+234567891', NULL, 'Course Admin'),
(3, 'Schedule Admin', '$2y$10$oMWHGlPK9yVXzWBrWhkWRewMxTlxlNYK8/81LgTt07DAS2TtAhPt2', 'schedule@example.com', '+345678912', NULL, 'Schedule Admin'),
(4, 'Alice Tan', '$2y$10$Gbv5ok1UiAQbfcGCKhFyUOVzXeIUcwyvz1qTV2o9zJoD2Ex0z9zsi', 'TP000001@mail.apu.edu.my', '+6012-345789', 'Al-1778539143.png', 'Student'),
(5, 'Brian Lee', '$2y$10$lphrCAvn7aKOjUMB.H2TxOVBzanGqogUT6UXU.tTuqqaJA12.oILi', 'TP000002@mail.apu.edu.my', '+6013-9876543', 'Br-1778539196.png', 'Student'),
(6, 'Chloe Wong', '$2y$10$DvlgsxvUNP7sXObVB.T7j.th1GYpKr1PxKMsOc9X6uMNcxcS6/td2', 'TP000003@mail.apu.edu.my', '+6014-2233445', 'Ch-1778539239.png', 'Student'),
(7, 'Daniel Lim', '$2y$10$4O6RtaB2EeRvx0InvdYfBODFFOFb64PFd1g827MW5GMAn/VfXvztG', 'TP000004@mail.apu.edu.my', '+6015-5566778', 'Da-1778539396.png', 'Student'),
(8, 'Emily Ng', '$2y$10$faIDigVHDUBU6WmxouligO/bs1MltSL/0HISYO9kNtVTQhsTAF2FO', 'TP000005@mail.apu.edu.my', '+6016-1122334', 'Em-1778539435.png', 'Student'),
(9, 'Farah Ahmad', '$2y$10$G95kxAWFN4tPzlMYSJxsGeN0lZr8YZLT/.yua0EhtbslGvlFua0sy', 'TP000006@mail.apu.edu.my', '+6017-4455667', 'Fa-1778543283.png', 'Student'),
(10, 'Grabriel Chan', '$2y$10$rg5TRrBjvlsPrdB77aIY2.C7HIO2asSh5ufz6X/PwcZwKurhCZrXe', 'TP000007@mail.apu.edu.my', '+6018-7788990', 'Gr-1778543323.png', 'Student'),
(11, 'Hannah Goh', '$2y$10$XH9e0q0Da6BhtPDL8.G3C.Tpxh51av.AjvRyC5ROG4.qUvgwZTg5.', 'TP000008@mail.apu.edu.my', '+6019-3344556', 'Ha-1778543362.png', 'Student'),
(12, 'Ivan Tan', '$2y$10$9ARFFifaLPH4H5JFg3YmlOh.LNBe/bxxvk4//u0wLcV2HeUJp0LVC', 'TP000009@mail.apu.edu.my', '+6011-6677889', 'Iv-1778543399.png', 'Student'),
(13, 'Jasmine Lau', '$2y$10$TJ3e0lFkB8W13NEEaSrckOm8dPfW2M2mkYevy6JgcYCpMaZXJ6ijq', 'TP000010@mail.apu.edu.my', '+6010-9988776', 'Ja-1778543440.png', 'Student');

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
