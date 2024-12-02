-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 02:34 AM
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
-- Stand-in structure for view `incident_counts_each_barangay`
-- (See below for the actual view)
--
CREATE TABLE `incident_counts_each_barangay` (
`barangay_name` varchar(25)
,`total_incident_count` decimal(42,0)
);

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
-- Stand-in structure for view `incident_data_each_month_this_year`
-- (See below for the actual view)
--
CREATE TABLE `incident_data_each_month_this_year` (
`barangay` varchar(255)
,`incident_count` bigint(21)
,`incident_types` mediumtext
,`incident_month` int(2)
,`incident_year` int(4)
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
  `incident_time` time NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_incident`
--

INSERT INTO `tbl_incident` (`id`, `locationID_fk`, `incidentID_fk`, `complaint`, `rescuer_team`, `referred_hospital`, `incident_date`, `incident_time`, `created_date`) VALUES
(76, 'LID-4D141B1004', 'IID-FA616DA562', 'Stray Dog', 'Team 2', 'Sagay CIty Public Hospital', '2024-12-01', '11:19:00', '2024-12-01 03:20:19'),
(77, 'LID-55EF6AF160', 'IID-3A5FCDA43B', 'Lack of Air', 'Team 1', 'Sagay CIty Public Hospital', '2024-12-01', '12:30:00', '2024-12-01 03:23:10'),
(78, 'LID-4D141B1004', 'IID-2285E47AE6', 'Fatal Wounds', 'Team 1', 'Sagay CIty Public Hospital', '2024-08-07', '11:26:00', '2024-12-01 03:27:18'),
(79, 'LID-66BE22D95E', 'IID-37EDCF1171', 'Fatal Wounds', 'Team 5', 'Escalante CIty Public Hospital', '2024-12-09', '13:28:00', '2024-12-01 05:25:51'),
(80, 'LID-4D141B1004', 'IID-AC76B8D96D', 'Fatal Wounds', 'Team 3', 'St. Anna', '2024-01-23', '13:00:00', '2024-12-01 05:58:27'),
(81, 'LID-491954603F', 'IID-75D6540ECC', 'Fatal Wounds', 'Team 6', 'Escalante CIty Public Hospital', '2024-12-16', '14:13:00', '2024-12-01 06:14:21'),
(82, 'LID-C0AAB358FD', 'IID-F6EEF2ECE3', 'asdsd', 'asdas', 'dasdasd', '2024-12-16', '14:21:00', '2024-12-01 06:18:50'),
(83, 'LID-1211CCF8F3', 'IID-1F1100E931', 'asdsad', 'asdsad', 'asd', '2024-12-01', '14:25:00', '2024-12-01 06:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_incident_location`
--

CREATE TABLE `tbl_incident_location` (
  `id` int(11) NOT NULL,
  `locationID` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `location_purok` varchar(255) NOT NULL,
  `latitude` decimal(15,8) NOT NULL,
  `longitude` decimal(15,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_incident_location`
--

INSERT INTO `tbl_incident_location` (`id`, `locationID`, `location_name`, `location_purok`, `latitude`, `longitude`) VALUES
(84, 'LID-4D141B1004', 'Bulanon', 'Nangra', 10.91769624, 123.47277136),
(85, 'LID-55EF6AF160', 'Bato', 'Linasgasan', 10.94200079, 123.42245786),
(86, 'LID-66BE22D95E', 'Fabrica', 'Sto. Niño', 10.88917549, 123.35252116),
(87, 'LID-491954603F', 'Bulanon', 'Ipil-ipil', 10.91821877, 123.47507309),
(88, 'LID-C0AAB358FD', 'Tabao', 'Malipayon', 10.91904468, 123.44773221),
(89, 'LID-1211CCF8F3', 'Bulanon', 'Mahogany', 10.91882556, 123.47707561);

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
(78, 'IID-FA616DA562', 'PID-8E2CDA2648', 'SID-003', 'Mark', '2024-12-02', 12, 'Male', 'Bais City'),
(79, 'IID-FA616DA562', 'PID-0AB5ECB287', 'SID-002', 'David', '2024-09-25', 24, 'Male', 'Punta cabahug'),
(80, 'IID-3A5FCDA43B', 'PID-3CC644F605', 'SID-004', 'Martin', '2004-09-20', 20, 'Male', 'Banquerohan'),
(81, 'IID-2285E47AE6', 'PID-5FF724A614', 'SID-003', 'Angel', '2000-09-09', 24, 'Female', 'Punta cabahug'),
(82, 'IID-37EDCF1171', 'PID-0FDF484E1F', 'SID-004', 'Liam', '2009-09-09', 15, 'Male', 'Masubo Street'),
(83, 'IID-AC76B8D96D', 'PID-5C497C0C64', 'SID-003', 'sadasd', '2000-09-09', 24, 'Male', 'Punta cabahug'),
(84, 'IID-75D6540ECC', 'PID-1311DF53F7', 'SID-002', 'Hazel', '2006-06-06', 18, 'Male', 'Ipils Street'),
(85, 'IID-F6EEF2ECE3', 'PID-80C9C25F57', 'SID-003', '232', '2003-09-21', 2323, 'Male', '2323'),
(86, 'IID-1F1100E931', 'PID-1267CB2052', 'SID-003', 'asdsad', '2024-12-23', 2323, 'Female', '23232');

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
(34, 'IID-FA616DA562', 1, 'Vechicular Incident', 'Without proper Helmet'),
(35, 'IID-3A5FCDA43B', 0, 'Suicide', 'Depression due to fail of Grades'),
(36, 'IID-2285E47AE6', 1, 'Other Incident', 'High due to drug abuse'),
(37, 'IID-37EDCF1171', 0, 'Shooting Incident', 'Gang Issue'),
(38, 'IID-AC76B8D96D', 0, 'Medical', 'sadsadasd'),
(39, 'IID-75D6540ECC', 0, 'Drowning', 'Family Problem'),
(40, 'IID-F6EEF2ECE3', 1, 'Vechicular Incident', 'asdasdasdsadasdasd'),
(41, 'IID-1F1100E931', 0, 'Drowning', 'asdsadsad');

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
(17, 'IID-FA616DA562', 'Drunk', '4 Wheels', 'Alcholic', 1, 1),
(18, 'IID-2285E47AE6', 'Nothing', '2 Wheels', 'Alchol, Marijuana', 0, 0),
(19, 'IID-F6EEF2ECE3', 'asdasd', 'asdsad', 'asdasd', 1, 1);

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
-- Structure for view `incident_counts_each_barangay`
--
DROP TABLE IF EXISTS `incident_counts_each_barangay`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incident_counts_each_barangay`  AS SELECT `barangays`.`barangay_name` AS `barangay_name`, ifnull(sum(`incident_counts`.`incident_count`),0) AS `total_incident_count` FROM ((select 'Andres Bonifacio' AS `barangay_name` union all select 'Bato' AS `Bato` union all select 'Baviera' AS `Baviera` union all select 'Bulanon' AS `Bulanon` union all select 'Campo Himoga-an' AS `Campo Himoga-an` union all select 'Campo Santiago' AS `Campo Santiago` union all select 'Colonia Divina' AS `Colonia Divina` union all select 'Rafaela Barrera' AS `Rafaela Barrera` union all select 'Fabrica' AS `Fabrica` union all select 'General Luna' AS `General Luna` union all select 'Himoga-an Baybay' AS `Himoga-an Baybay` union all select 'Lopez Jaena' AS `Lopez Jaena` union all select 'Malubon' AS `Malubon` union all select 'Maquiling' AS `Maquiling` union all select 'Molocaboc' AS `Molocaboc` union all select 'Old Sagay' AS `Old Sagay` union all select 'Paraiso' AS `Paraiso` union all select 'Plaridel' AS `Plaridel` union all select 'Poblacion I (Barangay 1)' AS `Poblacion I (Barangay 1)` union all select 'Poblacion II (Barangay 2)' AS `Poblacion II (Barangay 2)` union all select 'Puey' AS `Puey` union all select 'Rizal' AS `Rizal` union all select 'Taba-ao' AS `Taba-ao` union all select 'Tadlong' AS `Tadlong` union all select 'Vito' AS `Vito`) `barangays` left join (select `l`.`location_name` AS `location_name`,count(`i`.`id`) AS `incident_count` from (`tbl_incident_location` `l` left join `tbl_incident` `i` on(`l`.`locationID` = `i`.`locationID_fk`)) group by `l`.`location_name`) `incident_counts` on(`barangays`.`barangay_name` = `incident_counts`.`location_name`)) GROUP BY `barangays`.`barangay_name` ;

-- --------------------------------------------------------

--
-- Structure for view `incident_count_current_month_per_barangay_with_type`
--
DROP TABLE IF EXISTS `incident_count_current_month_per_barangay_with_type`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incident_count_current_month_per_barangay_with_type`  AS SELECT `l`.`location_name` AS `barangay`, count(`i`.`locationID_fk`) AS `incident_count`, group_concat(`t`.`type_of_incident` separator ', ') AS `incident_types` FROM ((`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) join `tbl_type_incident` `t` on(`i`.`incidentID_fk` = `t`.`incidentID`)) WHERE `l`.`location_name` in ('Andres Bonifacio','Bato','Baviera','Bulanon','Campo Himoga-an','Campo Santiago','Colonia Divina','Rafaela Barrera','Fabrica','General Luna','Himoga-an Baybay','Lopez Jaena','Malubon','Maquiling','Molocaboc','Old Sagay','Paraiso','Plaridel','Poblacion I (Barangay 1)','Poblacion II (Barangay 2)','Puey','Rizal','Taba-ao','Tadlong','Vito') AND month(`i`.`incident_date`) = month(curdate()) AND year(`i`.`incident_date`) = year(curdate()) GROUP BY `l`.`location_name` ;

-- --------------------------------------------------------

--
-- Structure for view `incident_count_per_barangay_with_type`
--
DROP TABLE IF EXISTS `incident_count_per_barangay_with_type`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incident_count_per_barangay_with_type`  AS SELECT `l`.`location_name` AS `barangay`, count(`i`.`locationID_fk`) AS `incident_count`, group_concat(`t`.`type_of_incident` separator ', ') AS `incident_types` FROM ((`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) join `tbl_type_incident` `t` on(`i`.`incidentID_fk` = `t`.`incidentID`)) WHERE `l`.`location_name` in ('Andres Bonifacio','Bato','Baviera','Bulanon','Campo Himoga-an','Campo Santiago','Colonia Divina','Rafaela Barrera','Fabrica','General Luna','Himoga-an Baybay','Lopez Jaena','Malubon','Maquiling','Molocaboc','Old Sagay','Paraiso','Plaridel','Poblacion I (Barangay 1)','Poblacion II (Barangay 2)','Puey','Rizal','Taba-ao','Tadlong','Vito') GROUP BY `l`.`location_name` ;

-- --------------------------------------------------------

--
-- Structure for view `incident_data_each_month_this_year`
--
DROP TABLE IF EXISTS `incident_data_each_month_this_year`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incident_data_each_month_this_year`  AS SELECT `l`.`location_name` AS `barangay`, count(`i`.`locationID_fk`) AS `incident_count`, group_concat(distinct `t`.`type_of_incident` separator ', ') AS `incident_types`, month(`i`.`incident_date`) AS `incident_month`, year(`i`.`incident_date`) AS `incident_year` FROM ((`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) join `tbl_type_incident` `t` on(`i`.`incidentID_fk` = `t`.`incidentID`)) WHERE `l`.`location_name` in ('Andres Bonifacio','Bato','Baviera','Bulanon','Campo Himoga-an','Campo Santiago','Colonia Divina','Rafaela Barrera','Fabrica','General Luna','Himoga-an Baybay','Lopez Jaena','Malubon','Maquiling','Molocaboc','Old Sagay','Paraiso','Plaridel','Poblacion I (Barangay 1)','Poblacion II (Barangay 2)','Puey','Rizal','Taba-ao','Tadlong','Vito') GROUP BY `l`.`location_name`, month(`i`.`incident_date`), year(`i`.`incident_date`) ;

-- --------------------------------------------------------

--
-- Structure for view `map_incident_cases`
--
DROP TABLE IF EXISTS `map_incident_cases`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `map_incident_cases`  AS SELECT `i`.`locationID_fk` AS `locationID_fk`, count(`i`.`locationID_fk`) AS `location_count`, `l`.`latitude` AS `latitude`, `l`.`longitude` AS `longitude` FROM (`tbl_incident` `i` join `tbl_incident_location` `l` on(`i`.`locationID_fk` = `l`.`locationID`)) GROUP BY `i`.`locationID_fk`, `l`.`latitude`, `l`.`longitude` ;

-- --------------------------------------------------------

--
-- Structure for view `month_analytics`
--
DROP TABLE IF EXISTS `month_analytics`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `month_analytics`  AS SELECT monthname(`tbl_incident`.`incident_date`) AS `month_name`, count(0) AS `incident_count` FROM `tbl_incident` GROUP BY month(`tbl_incident`.`incident_date`) ORDER BY month(`tbl_incident`.`incident_date`) ASC ;

-- --------------------------------------------------------

--
-- Structure for view `past_year_analytics`
--
DROP TABLE IF EXISTS `past_year_analytics`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `past_year_analytics`  AS SELECT year(`tbl_incident`.`incident_date`) AS `incident_year`, count(0) AS `incident_count` FROM `tbl_incident` WHERE `tbl_incident`.`incident_date` >= curdate() - interval 5 year GROUP BY year(`tbl_incident`.`incident_date`) ORDER BY year(`tbl_incident`.`incident_date`) ASC ;

-- --------------------------------------------------------

--
-- Structure for view `top_three_incidents`
--
DROP TABLE IF EXISTS `top_three_incidents`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `top_three_incidents`  AS SELECT `tbl_type_incident`.`type_of_incident` AS `type_of_incident`, count(0) AS `total_cases` FROM `tbl_type_incident` GROUP BY `tbl_type_incident`.`type_of_incident` ORDER BY count(0) DESC LIMIT 0, 3 ;

-- --------------------------------------------------------

--
-- Structure for view `total_of_injuries`
--
DROP TABLE IF EXISTS `total_of_injuries`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `total_of_injuries`  AS SELECT count(case when `tbl_patient_info`.`statusID` = 'SID-001' then 1 end) AS `minor`, count(case when `tbl_patient_info`.`statusID` = 'SID-002' then 1 end) AS `major`, count(case when `tbl_patient_info`.`statusID` = 'SID-003' then 1 end) AS `fatal`, count(case when `tbl_patient_info`.`statusID` = 'SID-004' then 1 end) AS `died` FROM `tbl_patient_info` ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_incident_location`
--
ALTER TABLE `tbl_incident_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `tbl_patient_info`
--
ALTER TABLE `tbl_patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tbl_patient_status`
--
ALTER TABLE `tbl_patient_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_type_incident`
--
ALTER TABLE `tbl_type_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_vehicular_incident`
--
ALTER TABLE `tbl_vehicular_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
