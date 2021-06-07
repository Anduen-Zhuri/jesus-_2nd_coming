-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 02:10 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `children_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) NOT NULL,
  `child_name` varchar(99) DEFAULT NULL,
  `child_birth_date` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`children_ID`, `user_uuid`, `child_name`, `child_birth_date`) VALUES
(5, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', 'tdududu', 'dtudtud');

-- --------------------------------------------------------

--
-- Table structure for table `civilservice_eligibility`
--

CREATE TABLE `civilservice_eligibility` (
  `Cs_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) NOT NULL,
  `user_id` varchar(99) NOT NULL,
  `eligibility` varchar(99) DEFAULT NULL,
  `rating` varchar(99) DEFAULT NULL,
  `exam_date` varchar(99) DEFAULT NULL,
  `exam_place` varchar(99) DEFAULT NULL,
  `license_number` varchar(99) DEFAULT NULL,
  `license_date_validity` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `education_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) DEFAULT NULL,
  `level` varchar(99) DEFAULT NULL,
  `school` varchar(99) DEFAULT NULL,
  `degree_course` varchar(99) DEFAULT NULL,
  `attendance_from` varchar(99) DEFAULT NULL,
  `attendance_to` varchar(99) DEFAULT NULL,
  `units_earned` varchar(99) DEFAULT NULL,
  `graduate_year` varchar(99) DEFAULT NULL,
  `awards_scholarship` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`education_ID`, `user_uuid`, `level`, `school`, `degree_course`, `attendance_from`, `attendance_to`, `units_earned`, `graduate_year`, `awards_scholarship`) VALUES
(1, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', 'xfhxfhx', 'zgzdgzgzg', 'xfhxfhx', 'fhxfxhfxfhx', '', 'fxhxffhxh', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(99) NOT NULL,
  `user` varchar(999) NOT NULL,
  `date_from` varchar(999) NOT NULL,
  `date_to` varchar(999) NOT NULL,
  `designation` varchar(999) NOT NULL,
  `status` varchar(999) NOT NULL,
  `monthly_salary` varchar(999) NOT NULL,
  `assignment_place` varchar(999) NOT NULL,
  `LAWOP` varchar(999) NOT NULL,
  `separation_date` varchar(999) NOT NULL,
  `separation_cause` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user`, `date_from`, `date_to`, `designation`, `status`, `monthly_salary`, `assignment_place`, `LAWOP`, `separation_date`, `separation_cause`) VALUES
(39, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', '05/22/2002', '05/22/2002', '05/22/2002', '05/22/2002', '05/22/2002', '05/22/2002', '05/22/2002', '05/22/2002', '05/22/2002');

-- --------------------------------------------------------

--
-- Table structure for table `learning_and_development`
--

CREATE TABLE `learning_and_development` (
  `lrd_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) DEFAULT NULL,
  `lrd_title` varchar(99) DEFAULT NULL,
  `date_from` varchar(99) DEFAULT NULL,
  `date_to` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `personal_information`
--

CREATE TABLE `personal_information` (
  `personal_information_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) NOT NULL,
  `surname` varchar(99) DEFAULT NULL,
  `first_name` varchar(99) DEFAULT NULL,
  `middle_name` varchar(99) DEFAULT NULL,
  `name_extension` varchar(99) DEFAULT NULL,
  `citizenship` varchar(99) DEFAULT NULL,
  `civil_status` varchar(99) DEFAULT NULL,
  `gender` varchar(99) DEFAULT NULL,
  `birth_date` varchar(99) DEFAULT NULL,
  `place_of_birth` varchar(99) DEFAULT NULL,
  `height` tinyint(99) DEFAULT NULL,
  `weight` tinyint(99) DEFAULT NULL,
  `blood_type` varchar(99) DEFAULT NULL,
  `gsis_id_no` varchar(99) DEFAULT NULL,
  `pagibig_id_no` varchar(99) DEFAULT NULL,
  `philhealth_no` varchar(99) DEFAULT NULL,
  `sss_no` varchar(99) DEFAULT NULL,
  `tin_no` varchar(99) DEFAULT NULL,
  `agency_employee_no` varchar(99) DEFAULT NULL,
  `tel_no` varchar(99) DEFAULT NULL,
  `mobile_no` varchar(99) DEFAULT NULL,
  `email` varchar(99) DEFAULT NULL,
  `date_recorded` varchar(99) DEFAULT NULL,
  `res_hbl` varchar(99) DEFAULT NULL,
  `res_street` varchar(99) DEFAULT NULL,
  `res_subvil` varchar(99) DEFAULT NULL,
  `res_barangay` varchar(99) DEFAULT NULL,
  `res_city_municipality` varchar(99) DEFAULT NULL,
  `res_province` varchar(99) DEFAULT NULL,
  `res_zipcode` varchar(99) DEFAULT NULL,
  `perm_hbl` varchar(99) DEFAULT NULL,
  `perm_street` varchar(99) DEFAULT NULL,
  `perm_subvil` varchar(99) DEFAULT NULL,
  `perm_barangay` varchar(99) DEFAULT NULL,
  `perm_city_municipality` varchar(99) DEFAULT NULL,
  `perm_province` varchar(99) DEFAULT NULL,
  `perm_zipcode` varchar(99) DEFAULT NULL,
  `spouse_surname` varchar(99) DEFAULT NULL,
  `spouse_first_name` varchar(99) DEFAULT NULL,
  `spouse_middle_name` varchar(99) DEFAULT NULL,
  `spouse_name_extension` varchar(99) DEFAULT NULL,
  `spouse_occupation` varchar(99) DEFAULT NULL,
  `spouse_employer_business` varchar(99) DEFAULT NULL,
  `spouse_business_address` varchar(99) DEFAULT NULL,
  `telephone_number` varchar(99) DEFAULT NULL,
  `fathers_surname` varchar(99) DEFAULT NULL,
  `fathers_first_name` varchar(99) DEFAULT NULL,
  `fathers_middle_name` varchar(99) DEFAULT NULL,
  `fathers_name_extension` varchar(99) DEFAULT NULL,
  `mothers_maiden_name` varchar(99) DEFAULT NULL,
  `mothers_sur_name` varchar(99) DEFAULT NULL,
  `mothers_first_name` varchar(99) DEFAULT NULL,
  `mothers_middle_name` varchar(99) DEFAULT NULL,
  `gov_issued_id` varchar(99) DEFAULT NULL,
  `id_lic_pass` varchar(99) DEFAULT NULL,
  `issued_date` varchar(99) DEFAULT NULL,
  `membership_name` varchar(99) DEFAULT NULL,
  `non_acad_distinction` varchar(99) DEFAULT NULL,
  `hobby` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `personal_information`
--

INSERT INTO `personal_information` (`personal_information_ID`, `user_uuid`, `surname`, `first_name`, `middle_name`, `name_extension`, `citizenship`, `civil_status`, `gender`, `birth_date`, `place_of_birth`, `height`, `weight`, `blood_type`, `gsis_id_no`, `pagibig_id_no`, `philhealth_no`, `sss_no`, `tin_no`, `agency_employee_no`, `tel_no`, `mobile_no`, `email`, `date_recorded`, `res_hbl`, `res_street`, `res_subvil`, `res_barangay`, `res_city_municipality`, `res_province`, `res_zipcode`, `perm_hbl`, `perm_street`, `perm_subvil`, `perm_barangay`, `perm_city_municipality`, `perm_province`, `perm_zipcode`, `spouse_surname`, `spouse_first_name`, `spouse_middle_name`, `spouse_name_extension`, `spouse_occupation`, `spouse_employer_business`, `spouse_business_address`, `telephone_number`, `fathers_surname`, `fathers_first_name`, `fathers_middle_name`, `fathers_name_extension`, `mothers_maiden_name`, `mothers_sur_name`, `mothers_first_name`, `mothers_middle_name`, `gov_issued_id`, `id_lic_pass`, `issued_date`, `membership_name`, `non_acad_distinction`, `hobby`) VALUES
(6, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', 'testttt', 'zdyzdhz', 'hzhzh', 'zhxzh', 'xhxf', 'jcgjcgjcg', 'jcgjgcjgc', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '09/05/07', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) DEFAULT NULL,
  `question` varchar(99) DEFAULT NULL,
  `yes_no` varchar(99) DEFAULT NULL,
  `details` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `refference`
--

CREATE TABLE `refference` (
  `refference_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) DEFAULT NULL,
  `ref_name` varchar(99) DEFAULT NULL,
  `ref_address` varchar(99) DEFAULT NULL,
  `ref_tel_no` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(99) NOT NULL,
  `uuid` varchar(999) NOT NULL,
  `first_name` varchar(99) NOT NULL,
  `middle_name` varchar(99) NOT NULL,
  `last_name` varchar(99) NOT NULL,
  `birth_day` varchar(999) NOT NULL,
  `birth_place` varchar(99) NOT NULL,
  `email` varchar(999) NOT NULL,
  `password` varchar(99) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `first_name`, `middle_name`, `last_name`, `birth_day`, `birth_place`, `email`, `password`, `is_admin`) VALUES
(13, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', 'Anduen', '', 'Zhuri', '11/22/2002', 'Albania', 'andueni15@gmail.com', '5c74277d4f42f91d0afcee606be00893', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voluntary_work`
--

CREATE TABLE `voluntary_work` (
  `voluntary_work_id` int(99) NOT NULL,
  `user_uuid` varchar(99) DEFAULT NULL,
  `name_and_address` varchar(99) DEFAULT NULL,
  `date_from` varchar(99) DEFAULT NULL,
  `date_to` varchar(99) DEFAULT NULL,
  `work` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voluntary_work`
--

INSERT INTO `voluntary_work` (`voluntary_work_id`, `user_uuid`, `name_and_address`, `date_from`, `date_to`, `work`) VALUES
(1, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', 'hxfhfxh', 'xxfhxfh', 'ffff', 'ffggg'),
(2, '1786fc4c-5655-4a68-93fe-e039f56d0a9f', 'ffff', 'dddd', 'ssss', 'aaaa');

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

CREATE TABLE `work_experience` (
  `work_experience_ID` int(99) NOT NULL,
  `user_uuid` varchar(99) DEFAULT NULL,
  `position_title` varchar(99) DEFAULT NULL,
  `department` varchar(99) DEFAULT NULL,
  `monthly_salary` varchar(99) DEFAULT NULL,
  `salary_grade` varchar(99) DEFAULT NULL,
  `appointment_status` varchar(99) DEFAULT NULL,
  `gov_service` varchar(99) DEFAULT NULL,
  `duration_from` varchar(99) DEFAULT NULL,
  `duration_to` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`children_ID`);

--
-- Indexes for table `civilservice_eligibility`
--
ALTER TABLE `civilservice_eligibility`
  ADD PRIMARY KEY (`Cs_ID`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`education_ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_and_development`
--
ALTER TABLE `learning_and_development`
  ADD PRIMARY KEY (`lrd_ID`);

--
-- Indexes for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD PRIMARY KEY (`personal_information_ID`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_ID`);

--
-- Indexes for table `refference`
--
ALTER TABLE `refference`
  ADD PRIMARY KEY (`refference_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`) USING HASH;

--
-- Indexes for table `voluntary_work`
--
ALTER TABLE `voluntary_work`
  ADD PRIMARY KEY (`voluntary_work_id`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`work_experience_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `children_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `civilservice_eligibility`
--
ALTER TABLE `civilservice_eligibility`
  MODIFY `Cs_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `education_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `learning_and_development`
--
ALTER TABLE `learning_and_development`
  MODIFY `lrd_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `personal_information_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `refference`
--
ALTER TABLE `refference`
  MODIFY `refference_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `voluntary_work`
--
ALTER TABLE `voluntary_work`
  MODIFY `voluntary_work_id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `work_experience_ID` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
