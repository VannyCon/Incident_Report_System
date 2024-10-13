-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 02:07 PM
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
-- Database: `incident_report_db`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `incident_count_current_month_per_barangay_with_type`
-- (See below for the actual view)
--
CREATE TABLE `incident_count_current_month_per_barangay_with_type` (
`barangay` varchar(255)
,`incident_count` bigint(21)
,`incident_types` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `incident_count_per_barangay_with_type`
-- (See below for the actual view)
--
CREATE TABLE `incident_count_per_barangay_with_type` (
`barangay` varchar(255)
,`incident_count` bigint(21)
,`incident_types` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `map_incident_cases`
-- (See below for the actual view)
--
CREATE TABLE `map_incident_cases` (
`locationID_fk` varchar(255)
,`location_count` bigint(21)
,`latitude` decimal(15,8)
,`longitude` decimal(15,8)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `month_analytics`
-- (See below for the actual view)
--
CREATE TABLE `month_analytics` (
`month_name` varchar(9)
,`incident_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `past_year_analytics`
-- (See below for the actual view)
--
CREATE TABLE `past_year_analytics` (
`incident_year` int(4)
,`incident_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_access`
--

CREATE TABLE `tbl_admin_access` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_access`
--

INSERT INTO `tbl_admin_access` (`id`, `fullname`, `username`, `password`) VALUES
(1, 'Admin 1', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_incident`
--

CREATE TABLE `tbl_incident` (
  `id` int(11) NOT NULL,
  `locationID_fk` varchar(255) NOT NULL,
  `incidentID_fk` varchar(255) NOT NULL,
  `complaint` varchar(255) DEFAULT NULL,
  `rescuer_team` varchar(100) DEFAULT NULL,
  `referred_hospital` varchar(255) DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_incident`
--

INSERT INTO `tbl_incident` (`id`, `locationID_fk`, `incidentID_fk`, `complaint`, `rescuer_team`, `referred_hospital`, `incident_date`, `created_date`) VALUES
(46, 'LID-A6BF5085FC', 'IID-87B4CA1074', 'Headache', 'Team 1', 'Cadiz CIty Public Hospital', '2023-06-09', '2024-10-08 02:34:59'),
(61, 'LID-BA94DF6805', 'IID-BE40B5C601', 'asd', 'asd', 'asd', '2024-10-09', '2024-10-09 02:23:53'),
(63, 'LID-DC225321E0', 'IID-09E8D4DA06', 'Fatal Wounds', 'Team 1', 'St. Anne', '2024-10-09', '2024-10-09 02:57:12'),
(64, 'LID-E032AD74E5', 'IID-87873C8021', 'sadsad', 'asdsad', 'sadsaddas', '2024-10-11', '2024-10-10 05:11:30'),
(65, 'LID-BA94DF6805', 'IID-66476AA06C', 'asddas', 'asddsa', 'asdsda', '2024-10-10', '2024-10-10 12:07:47'),
(66, 'LID-BA94DF6805', 'IID-68160C2BDF', 'asd', 'asdasd', 'asdsad', '2024-10-10', '2024-10-10 12:08:42'),
(68, 'LID-BA94DF6805', 'IID-62F5C6BDF0', 'Fatal Wounds', 'Team 1', 'Bacolod CIty Public Hospital', '2024-10-10', '2024-10-10 13:12:34'),
(69, 'LID-99EB9EFE47', 'IID-DE4DA147C6', 'asdsad', 'asdsads', 'asdsadsad', '2024-10-10', '2024-10-10 13:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_incident_location`
--

CREATE TABLE `tbl_incident_location` (
  `id` int(11) NOT NULL,
  `locationID` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `latitude` decimal(15,8) NOT NULL,
  `longitude` decimal(15,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_incident_location`
--

INSERT INTO `tbl_incident_location` (`id`, `locationID`, `location_name`, `latitude`, `longitude`) VALUES
(34, 'LID-DE361B4E99', 'Colonia Divina', 10.95064679, 123.33651342),
(42, 'LID-A6BF5085FC', 'Bato', 10.95649492, 123.31009208),
(55, 'LID-BA94DF6805', 'Andres Bonifacio', 10.95242063, 123.31807155),
(56, 'LID-DC225321E0', 'Bato', 10.95636431, 123.32093530),
(57, 'LID-E032AD74E5', 'Bato', 10.94988838, 123.32241179),
(58, 'LID-99EB9EFE47', 'Bulanon', 10.94857356, 123.34315532);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_info`
--

CREATE TABLE `tbl_patient_info` (
  `id` int(11) NOT NULL,
  `incidentID_fk` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `statusID` varchar(255) DEFAULT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_birthdate` varchar(255) NOT NULL,
  `patient_age` int(11) NOT NULL,
  `patient_sex` varchar(10) DEFAULT NULL,
  `patient_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patient_info`
--

INSERT INTO `tbl_patient_info` (`id`, `incidentID_fk`, `patientID`, `statusID`, `patient_name`, `patient_birthdate`, `patient_age`, `patient_sex`, `patient_address`) VALUES
(39, 'IID-87B4CA1074', 'PID-98FA3D71D5', 'SID-001', 'Heleny Porch', '', 24, 'Female', 'Hitalon City'),
(44, 'IID-87B4CA1074', 'PID-A8070E2308', 'SID-004', 'Mickey Mousess', '', 36, 'Male', 'Cadiz city'),
(52, 'IID-BE40B5C601', 'PID-D9CA33819C', 'SID-001', 'Mark', '', 43, 'Male', '4545'),
(55, 'IID-09E8D4DA06', 'PID-E5E4FE18AD', 'SID-004', 'dumm1 ', '', 23, 'Male', 'Punta'),
(56, 'IID-09E8D4DA06', 'PID-2DEA28464C', 'SID-003', 'Dummy 2', '', 24, 'Female', 'Punta cabahug'),
(57, 'IID-87873C8021', 'PID-CC7FD62E82', 'SID-001', 'justin', '', 23, 'Male', 'Banquerohan'),
(58, 'IID-66476AA06C', 'PID-4319379266', 'SID-003', 'asdffdsa', '2024-10-10', 34, 'Male', 'asdsad'),
(59, 'IID-66476AA06C', 'PID-48DAE1CEDD', 'SID-003', 'sdsda', '2024-10-10', 23, 'Male', 'asdsadsad'),
(60, 'IID-68160C2BDF', 'PID-E747DE2510', 'SID-001', 'dfdf', '2007-01-10', 23, 'Male', 'sadasd'),
(61, 'IID-62F5C6BDF0', 'PID-A5BE72F494', 'SID-002', 'Pancit Canton', '2000-09-08', 24, 'Male', 'Bais City'),
(62, 'IID-DE4DA147C6', 'PID-A293A125A5', 'SID-003', 'asdsad', '2024-10-10', 23, 'Male', 'asdsad'),
(63, 'IID-DE4DA147C6', 'PID-DB53B35B22', 'SID-001', 'asdsad', '2024-10-10', 232, 'Male', 'sdadsasd'),
(65, 'IID-66476AA06C', 'PID-3DAD25FD06', 'SID-004', 'test4', '2011-02-10', 14, 'Male', 'Punta cabahug'),
(66, 'IID-DE4DA147C6', 'PID-C4EBA280EB', 'SID-003', 'user 3', '2003-03-03', 21, 'Male', 'user 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_status`
--

CREATE TABLE `tbl_patient_status` (
  `id` int(11) NOT NULL,
  `statusID` varchar(255) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patient_status`
--

INSERT INTO `tbl_patient_status` (`id`, `statusID`, `color`, `description`) VALUES
(2, 'SID-001', 'Green', 'Minor Injuries'),
(3, 'SID-002', 'Yellow', 'Major Injuries'),
(4, 'SID-003', 'Red', 'Fatal'),
(5, 'SID-004', 'Black', 'Died');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type_incident`
--

CREATE TABLE `tbl_type_incident` (
  `id` int(11) NOT NULL,
  `incidentID` varchar(255) NOT NULL,
  `isVehiclular` tinyint(1) NOT NULL,
  `type_of_incident` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_type_incident`
--

INSERT INTO `tbl_type_incident` (`id`, `incidentID`, `isVehiclular`, `type_of_incident`, `description`) VALUES
(12, 'IID-87B4CA1074', 1, 'Other Incident', 'brake lost'),
(20, 'IID-BE40B5C601', 1, 'Vehiclular Accident', 'asdasdasd'),
(22, 'IID-09E8D4DA06', 1, 'Vehiclular Accident', 'They Didn\'t know that there is comming'),
(23, 'IID-87873C8021', 0, 'Drowning', 'asdasd'),
(24, 'IID-66476AA06C', 1, 'Other Incident', 'test 4'),
(25, 'IID-68160C2BDF', 0, 'asdsad', 'asdasd'),
(26, 'IID-62F5C6BDF0', 1, 'Vehiclular Accident', 'High due to drug abuse'),
(27, 'IID-DE4DA147C6', 1, 'Other Incident', 'USER 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicular_incident`
--

CREATE TABLE `tbl_vehicular_incident` (
  `id` int(11) NOT NULL,
  `incidentID` varchar(255) NOT NULL,
  `patient_classification` varchar(100) DEFAULT NULL,
  `vehicle_type` varchar(100) DEFAULT NULL,
  `intoxication` varchar(255) DEFAULT NULL,
  `helmet` tinyint(1) DEFAULT NULL,
  `stray` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vehicular_incident`
--

INSERT INTO `tbl_vehicular_incident` (`id`, `incidentID`, `patient_classification`, `vehicle_type`, `intoxication`, `helmet`, `stray`) VALUES
(8, 'IID-87B4CA1074', 'Classification', '4 Wheels', 'Alcholic', 1, 1),
(10, 'IID-BE40B5C601', 'asdasd', 'asdasd', 'Alcholic', 1, 1),
(11, 'IID-09E8D4DA06', 'N/A', 'PUmp Boat', 'Alcholic', 1, 1),
(12, 'IID-62F5C6BDF0', 'Nothing', '4 Wheels', 'Alchol, Marijuana', 0, 0),
(14, 'IID-66476AA06C', 's', 's', 's', 1, 1),
(15, 'IID-DE4DA147C6', 'user 3', 'user 3 ', 'user 3 ', 0, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `top_three_incidents`
-- (See below for the actual view)
--
CREATE TABLE `top_three_incidents` (
`type_of_incident` varchar(100)
,`total_cases` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `total_of_injuries`
-- (See below for the actual view)
--
CREATE TABLE `total_of_injuries` (
`minor` bigint(21)
,`major` bigint(21)
,`fatal` bigint(21)
,`died` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `incident_count_current_month_per_barangay_with_type`
--
DROP TABLE IF EXISTS `incident_count_current_month_per_barangay_with_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incident_count_current_month_per_barangay_with_type`  AS SELECT `l`.`location_name` AS `barangay`, count(`i`.`locationID_fk`) AS `incident_count`, group_concat(`t`.`type_of_incident` separator ', ') AS `incident_types` FROM ((`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) join `tbl_type_incident` `t` on(`i`.`incidentID_fk` = `t`.`incidentID`)) WHERE `l`.`location_name` in ('Andres Bonifacio','Bato','Baviera','Bulanon','Campo Himoga-an','Campo Santiago','Colonia Divina','Rafaela Barrera','Fabrica','General Luna','Himoga-an Baybay','Lopez Jaena','Malubon','Maquiling','Molocaboc','Old Sagay','Paraiso','Plaridel','Poblacion I (Barangay 1)','Poblacion II (Barangay 2)','Puey','Rizal','Taba-ao','Tadlong','Vito') AND month(`i`.`incident_date`) = month(curdate()) AND year(`i`.`incident_date`) = year(curdate()) GROUP BY `l`.`location_name` ;

-- --------------------------------------------------------

--
-- Structure for view `incident_count_per_barangay_with_type`
--
DROP TABLE IF EXISTS `incident_count_per_barangay_with_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incident_count_per_barangay_with_type`  AS SELECT `l`.`location_name` AS `barangay`, count(`i`.`locationID_fk`) AS `incident_count`, group_concat(`t`.`type_of_incident` separator ', ') AS `incident_types` FROM ((`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) join `tbl_type_incident` `t` on(`i`.`incidentID_fk` = `t`.`incidentID`)) WHERE `l`.`location_name` in ('Andres Bonifacio','Bato','Baviera','Bulanon','Campo Himoga-an','Campo Santiago','Colonia Divina','Rafaela Barrera','Fabrica','General Luna','Himoga-an Baybay','Lopez Jaena','Malubon','Maquiling','Molocaboc','Old Sagay','Paraiso','Plaridel','Poblacion I (Barangay 1)','Poblacion II (Barangay 2)','Puey','Rizal','Taba-ao','Tadlong','Vito') GROUP BY `l`.`location_name` ;

-- --------------------------------------------------------

--
-- Structure for view `map_incident_cases`
--
DROP TABLE IF EXISTS `map_incident_cases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `map_incident_cases`  AS SELECT `i`.`locationID_fk` AS `locationID_fk`, count(`i`.`locationID_fk`) AS `location_count`, `l`.`latitude` AS `latitude`, `l`.`longitude` AS `longitude` FROM (`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) GROUP BY `i`.`locationID_fk`, `l`.`latitude`, `l`.`longitude` ;

-- --------------------------------------------------------

--
-- Structure for view `month_analytics`
--
DROP TABLE IF EXISTS `month_analytics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `month_analytics`  AS SELECT monthname(`tbl_incident`.`incident_date`) AS `month_name`, count(0) AS `incident_count` FROM `tbl_incident` GROUP BY month(`tbl_incident`.`incident_date`) ORDER BY month(`tbl_incident`.`incident_date`) ASC ;

-- --------------------------------------------------------

--
-- Structure for view `past_year_analytics`
--
DROP TABLE IF EXISTS `past_year_analytics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `past_year_analytics`  AS SELECT year(`tbl_incident`.`incident_date`) AS `incident_year`, count(0) AS `incident_count` FROM `tbl_incident` WHERE `tbl_incident`.`incident_date` >= curdate() - interval 5 year GROUP BY year(`tbl_incident`.`incident_date`) ORDER BY year(`tbl_incident`.`incident_date`) ASC ;

-- --------------------------------------------------------

--
-- Structure for view `top_three_incidents`
--
DROP TABLE IF EXISTS `top_three_incidents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top_three_incidents`  AS SELECT `tbl_type_incident`.`type_of_incident` AS `type_of_incident`, count(0) AS `total_cases` FROM `tbl_type_incident` GROUP BY `tbl_type_incident`.`type_of_incident` ORDER BY count(0) DESC LIMIT 0, 3 ;

-- --------------------------------------------------------

--
-- Structure for view `total_of_injuries`
--
DROP TABLE IF EXISTS `total_of_injuries`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_of_injuries`  AS SELECT count(case when `tbl_patient_info`.`statusID` = 'SID-001' then 1 end) AS `minor`, count(case when `tbl_patient_info`.`statusID` = 'SID-002' then 1 end) AS `major`, count(case when `tbl_patient_info`.`statusID` = 'SID-003' then 1 end) AS `fatal`, count(case when `tbl_patient_info`.`statusID` = 'SID-004' then 1 end) AS `died` FROM `tbl_patient_info` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin_access`
--
ALTER TABLE `tbl_admin_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_incident`
--
ALTER TABLE `tbl_incident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locationID_fk` (`locationID_fk`),
  ADD KEY `incidentID_fk` (`incidentID_fk`);

--
-- Indexes for table `tbl_incident_location`
--
ALTER TABLE `tbl_incident_location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locationID_2` (`locationID`),
  ADD KEY `locationID` (`locationID`);

--
-- Indexes for table `tbl_patient_info`
--
ALTER TABLE `tbl_patient_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `statusID` (`statusID`),
  ADD KEY `incidentID_fk` (`incidentID_fk`);

--
-- Indexes for table `tbl_patient_status`
--
ALTER TABLE `tbl_patient_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `tbl_type_incident`
--
ALTER TABLE `tbl_type_incident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incidentID` (`incidentID`),
  ADD KEY `incidentID_2` (`incidentID`);

--
-- Indexes for table `tbl_vehicular_incident`
--
ALTER TABLE `tbl_vehicular_incident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incidentID` (`incidentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin_access`
--
ALTER TABLE `tbl_admin_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_incident`
--
ALTER TABLE `tbl_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tbl_incident_location`
--
ALTER TABLE `tbl_incident_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbl_patient_info`
--
ALTER TABLE `tbl_patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tbl_patient_status`
--
ALTER TABLE `tbl_patient_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_type_incident`
--
ALTER TABLE `tbl_type_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_vehicular_incident`
--
ALTER TABLE `tbl_vehicular_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_incident`
--
ALTER TABLE `tbl_incident`
  ADD CONSTRAINT `location_constraints` FOREIGN KEY (`locationID_fk`) REFERENCES `tbl_incident_location` (`locationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_patient_info`
--
ALTER TABLE `tbl_patient_info`
  ADD CONSTRAINT `incident_of_patient` FOREIGN KEY (`incidentID_fk`) REFERENCES `tbl_incident` (`incidentID_fk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patientStatus` FOREIGN KEY (`statusID`) REFERENCES `tbl_patient_status` (`statusID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_type_incident`
--
ALTER TABLE `tbl_type_incident`
  ADD CONSTRAINT `other_incident` FOREIGN KEY (`incidentID`) REFERENCES `tbl_incident` (`incidentID_fk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_vehicular_incident`
--
ALTER TABLE `tbl_vehicular_incident`
  ADD CONSTRAINT `incidentID` FOREIGN KEY (`incidentID`) REFERENCES `tbl_incident` (`incidentID_fk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
