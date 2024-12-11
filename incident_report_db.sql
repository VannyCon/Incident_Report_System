-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 02:06 PM
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
-- Table structure for table `tbl`
--

CREATE TABLE `tbl` (
  `id` int(11) NOT NULL,
  `baranggay_id_fk` varchar(255) NOT NULL,
  `purok_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `tbl_baranggay`
--

CREATE TABLE `tbl_baranggay` (
  `id` int(255) NOT NULL,
  `baranggay_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_baranggay`
--

INSERT INTO `tbl_baranggay` (`id`, `baranggay_name`) VALUES
(1, 'Bato'),
(2, 'Bulanon'),
(3, 'Fabrica'),
(4, 'General Luna'),
(5, 'Molocaboc'),
(6, 'Paraiso'),
(7, 'Puey'),
(8, 'Tabao');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crud_incident_type`
--

CREATE TABLE `tbl_crud_incident_type` (
  `id` int(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `incident_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_crud_incident_type`
--

INSERT INTO `tbl_crud_incident_type` (`id`, `value`, `incident_name`) VALUES
(1, 'isVehiclular', 'Vehicular Incident'),
(2, 'Drowning', 'Drowning'),
(3, 'Suicide', 'Suicide'),
(4, 'Shooting Incident', 'Shooting Incident'),
(5, 'Medical', 'Medical'),
(6, 'Trauma', 'Trauma'),
(7, 'Walk In', 'Walk In'),
(11, 'zxzxcv', 'zxcvzxcvxczv');

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
(83, 'LID-1211CCF8F3', 'IID-1F1100E931', 'asdsad', 'asdsad', 'asd', '2024-12-01', '14:25:00', '2024-12-01 06:25:36'),
(84, 'LID-147B5B758B', 'IID-CB8AE51D91', 'sadsad', 'sad', 'dasdsad', '2024-12-16', '10:48:00', '2024-12-04 02:45:48');

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
(89, 'LID-1211CCF8F3', 'Bulanon', 'Mahogany', 10.91882556, 123.47707561),
(90, 'LID-147B5B758B', 'Paraiso', 'Mahidaeton', 10.90357106, 123.44823081),
(91, 'LID-146A8A9972', 'Bato', 'Kabulakan', 10.91503231, 123.43601897);

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
(86, 'IID-1F1100E931', 'PID-1267CB2052', 'SID-003', 'asdsad', '2024-12-23', 2323, 'Female', '23232'),
(87, 'IID-CB8AE51D91', 'PID-0D33D3DF4B', 'SID-004', 'ss', '2024-12-19', 34, 'Male', 'sadsad');

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
-- Table structure for table `tbl_purok`
--

CREATE TABLE `tbl_purok` (
  `id` int(255) NOT NULL,
  `baranggay_name` varchar(255) NOT NULL,
  `purok_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_purok`
--

INSERT INTO `tbl_purok` (`id`, `baranggay_name`, `purok_name`) VALUES
(1, 'Bato', 'Pagla-um'),
(2, 'Bato', 'Linasgasan'),
(3, 'Bato', 'Mabinuligon'),
(4, 'Bato', 'Bagong Lipunan'),
(5, 'Bato', 'Kakahuyan'),
(6, 'Bato', 'Kabulakan'),
(7, 'Bato', 'Paghida-et'),
(8, 'Bato', 'Halandumon'),
(9, 'Bato', 'Marang'),
(10, 'Bato', 'Kalubihan'),
(11, 'Bato', 'Gerard'),
(12, 'Bato', 'Bagong Silang'),
(13, 'Bato', 'Mainuswagon'),
(14, 'Bato', 'Matam-is'),
(15, 'Bato', 'Mahinangpanon'),
(16, 'Bato', 'Masinadyahon'),
(17, 'Bulanon', 'Mabolo'),
(18, 'Bulanon', 'Indian Mango'),
(19, 'Bulanon', 'Nangra'),
(20, 'Bulanon', 'Lansones'),
(21, 'Bulanon', 'Serguelas'),
(22, 'Bulanon', 'Atis'),
(23, 'Bulanon', 'Tisa'),
(24, 'Bulanon', 'Acasia'),
(25, 'Bulanon', 'Avocado'),
(26, 'Bulanon', 'Tambis'),
(27, 'Bulanon', 'Tambis (Housing)'),
(28, 'Bulanon', 'Pili'),
(29, 'Bulanon', 'Mahogany'),
(30, 'Bulanon', 'Firetree'),
(31, 'Bulanon', 'Bangkal'),
(32, 'Bulanon', 'Ipil-ipil'),
(33, 'Bulanon', 'Pinetree'),
(34, 'Bulanon', 'Kulo'),
(35, 'Bulanon', 'Starapple'),
(36, 'Bulanon', 'Robles'),
(37, 'Bulanon', 'Kalubihan'),
(38, 'Bulanon', 'Talisay'),
(39, 'Fabrica', 'Paghidaet'),
(40, 'Fabrica', 'Israel'),
(41, 'Fabrica', 'Malipayon'),
(42, 'Fabrica', 'Sto. Niño'),
(43, 'Fabrica', 'GLES'),
(44, 'Fabrica', 'San Juan'),
(45, 'Fabrica', 'Pag-asa'),
(46, 'Fabrica', 'Mabuhay'),
(47, 'Fabrica', 'Leonor'),
(48, 'Fabrica', 'Tophills'),
(49, 'Fabrica', 'Katilingban'),
(50, 'Fabrica', 'Riverhillside'),
(51, 'Fabrica', 'Demikrasya'),
(52, 'Fabrica', 'Freedom'),
(53, 'Fabrica', 'United'),
(54, 'Fabrica', 'Paghili-usa'),
(55, 'Fabrica', 'Mahigugmaon'),
(56, 'General Luna', 'Bombit'),
(57, 'General Luna', 'Buntod'),
(58, 'General Luna', 'Camansi 1'),
(59, 'General Luna', 'Camansi 2'),
(60, 'General Luna', 'Constancia'),
(61, 'General Luna', 'Erlinda II'),
(62, 'General Luna', 'Esperanza'),
(63, 'General Luna', 'Gemelina'),
(64, 'General Luna', 'Hapit-anay'),
(65, 'General Luna', 'Kawayan'),
(66, 'General Luna', 'Kakahuyan'),
(67, 'General Luna', 'Malipayon'),
(68, 'General Luna', 'Makig-angay'),
(69, 'General Luna', 'Mabinuligon'),
(70, 'General Luna', 'Maligaya'),
(71, 'General Luna', 'Mahinangpanon'),
(72, 'General Luna', 'Maloloy-on'),
(73, 'General Luna', 'Pinetree'),
(74, 'General Luna', 'Paghedait'),
(75, 'General Luna', 'Santan'),
(76, 'General Luna', 'Roma'),
(77, 'Molocaboc', 'Sta. Maria A-Mantua'),
(78, 'Molocaboc', 'Sta. Maria B1-Patiño'),
(79, 'Molocaboc', 'Sta. Maria B2-Batayen'),
(80, 'Molocaboc', 'Sta. Maria C-Dayon'),
(81, 'Molocaboc', 'Tuble A1-Rojas'),
(82, 'Molocaboc', 'Tuble A2-Juanico'),
(83, 'Molocaboc', 'Tuble B-Dela Cruz'),
(84, 'Molocaboc', 'Himoga-an Proper-Vargas'),
(85, 'Molocaboc', 'Bebo-Abria'),
(86, 'Molocaboc', 'Proper Sawmill A-Silva'),
(87, 'Molocaboc', 'Proper Sawmill B-Siosan'),
(88, 'Molocaboc', 'Crossing Sawmill A-Pagunsan'),
(89, 'Molocaboc', 'Crossing Sawmill B-Sanchez'),
(90, 'Molocaboc', 'Kalubihan-Dante'),
(91, 'Molocaboc', 'Balongay-Ortiz'),
(92, 'Molocaboc', 'Pandanan-Sipat'),
(93, 'Molocaboc', 'Tapon A-Betita'),
(94, 'Molocaboc', 'Tapon B-Rosenda'),
(95, 'Molocaboc', 'Tapon C-Cena'),
(96, 'Molocaboc', 'Intaplan A-Cabahug'),
(97, 'Molocaboc', 'Intaplan B-Derla'),
(98, 'Molocaboc', 'Intaplan C-Cena'),
(99, 'Molocaboc', 'Ulbuhan-Descartin'),
(100, 'Molocaboc', 'Dalakit/Teresa-Villacampa'),
(101, 'Molocaboc', 'Talamnan-Demaraye'),
(102, 'Molocaboc', 'Docol-docol A-Canillada'),
(103, 'Molocaboc', 'Docol-docol B-Chaves'),
(104, 'Molocaboc', 'Olontawo-Baldonebro'),
(105, 'Molocaboc', 'Isabelita/Cubay-Magno'),
(106, 'Molocaboc', 'IC-Flores'),
(107, 'Molocaboc', 'Lawis-Paderes'),
(108, 'Molocaboc', 'Hupac-Abuhat'),
(109, 'Paraiso', 'Masinulodon'),
(110, 'Paraiso', 'Jordan'),
(111, 'Paraiso', 'Uneversal'),
(112, 'Paraiso', 'Riverside'),
(113, 'Paraiso', 'Malipayon'),
(114, 'Paraiso', 'Mahirup'),
(115, 'Paraiso', 'Paghidaet'),
(116, 'Paraiso', 'Greenhills'),
(117, 'Paraiso', 'Japan'),
(118, 'Paraiso', 'Mahidaeton'),
(119, 'Paraiso', 'Pagay'),
(120, 'Paraiso', 'Holy'),
(121, 'Paraiso', 'Hillside'),
(122, 'Puey', 'Pagla-um'),
(123, 'Puey', 'Linasgasan'),
(124, 'Puey', 'Mabinuligon'),
(125, 'Puey', 'Bagong Lipunan'),
(126, 'Puey', 'Kakahuyan'),
(127, 'Puey', 'Kabulakan'),
(128, 'Puey', 'Paghida-et'),
(129, 'Puey', 'Halandumon'),
(130, 'Puey', 'Marang'),
(131, 'Puey', 'Kalubihan'),
(132, 'Puey', 'Gerard'),
(133, 'Puey', 'Bagong Silang'),
(134, 'Puey', 'Mainuswagon'),
(135, 'Puey', 'Matam-is'),
(136, 'Puey', 'Mahinangpanon'),
(137, 'Puey', 'Masinadyahon'),
(138, 'Tabao', 'Paglaum'),
(139, 'Tabao', 'San Pedro'),
(140, 'Tabao', 'Punta Roma'),
(141, 'Tabao', 'Mabinuligon'),
(142, 'Tabao', 'Mainawa-on'),
(143, 'Tabao', 'Maghimpay'),
(144, 'Tabao', 'Gasang'),
(145, 'Tabao', 'Malipayon'),
(146, 'Tabao', 'Matinahuron'),
(147, 'Tabao', 'Halandumon'),
(148, 'Tabao', 'San Isidro'),
(149, 'Tabao', 'Tuburan');

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
(41, 'IID-1F1100E931', 0, 'Drowning', 'asdsadsad'),
(42, 'IID-CB8AE51D91', 0, 'Drowning', 'sdasd');

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
-- Indexes for table `tbl`
--
ALTER TABLE `tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_access`
--
ALTER TABLE `tbl_admin_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_baranggay`
--
ALTER TABLE `tbl_baranggay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `baranggay_name` (`baranggay_name`);

--
-- Indexes for table `tbl_crud_incident_type`
--
ALTER TABLE `tbl_crud_incident_type`
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
-- Indexes for table `tbl_purok`
--
ALTER TABLE `tbl_purok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `baranggay_name` (`baranggay_name`);

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
-- AUTO_INCREMENT for table `tbl`
--
ALTER TABLE `tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin_access`
--
ALTER TABLE `tbl_admin_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_baranggay`
--
ALTER TABLE `tbl_baranggay`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_crud_incident_type`
--
ALTER TABLE `tbl_crud_incident_type`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_incident`
--
ALTER TABLE `tbl_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tbl_incident_location`
--
ALTER TABLE `tbl_incident_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_patient_info`
--
ALTER TABLE `tbl_patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tbl_patient_status`
--
ALTER TABLE `tbl_patient_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_purok`
--
ALTER TABLE `tbl_purok`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `tbl_type_incident`
--
ALTER TABLE `tbl_type_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
-- Constraints for table `tbl_purok`
--
ALTER TABLE `tbl_purok`
  ADD CONSTRAINT `baranggay_scope` FOREIGN KEY (`baranggay_name`) REFERENCES `tbl_baranggay` (`baranggay_name`) ON DELETE CASCADE ON UPDATE CASCADE;

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
