-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2021 at 02:20 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_desc` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_desc`, `date_added`) VALUES
(1, 'Antipyretics', 'reducing fever', '2021-04-23 11:50:08'),
(2, 'Analgesics', 'reducing pain ', '2021-04-23 11:50:08'),
(3, 'Antimalarial drugs', 'treating malaria', '2021-04-23 11:53:05'),
(4, 'Antibiotics', 'inhibiting germ growth', '2021-04-23 11:53:43'),
(5, 'Antiseptics', 'prevention of germ growth near burns, cuts and wounds', '2021-04-23 11:54:29'),
(6, 'Mood stabilizers', ' lithium and valpromide', '2021-04-23 11:55:02'),
(7, 'Hormone replacements', 'Premarin', '2021-04-23 11:55:24'),
(8, 'Oral contraceptives', 'Enovid, \"biphasic\" pill, and \"triphasic\" pill', '2021-04-23 11:55:24'),
(9, 'Stimulants', ' methylphenidate, amphetamine', '2021-04-23 11:56:32'),
(10, 'Tranquilizers', ' meprobamate, chlorpromazine, reserpine, chlordiazepoxide, diazepam, and alprazolam', '2021-04-23 11:56:32'),
(18, 'Malaria tablet', '                                    Cures malaria', '2021-06-09 14:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(10) NOT NULL,
  `patient_name` varchar(50) NOT NULL,
  `patient_mobile` varchar(15) NOT NULL,
  `patient_age` varchar(3) NOT NULL,
  `patient_comments` text NOT NULL,
  `patient_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_name`, `patient_mobile`, `patient_age`, `patient_comments`, `patient_date`) VALUES
(1, 'Dennis Kamau', '0723910135', '23', '                                    Diagnosed with cold Flu', '2021-04-24 12:39:26'),
(2, 'Steve Wonder', '0798873704', '14', '                                    fsd dsf hsdf sdfhsdhu', '2021-05-12 15:20:34'),
(3, 'Henry', '0723910135', '25', '                                    A new patient', '2021-06-09 15:01:38'),
(4, 'John', '2547657483465', '23', '                                    Hkgd dkhd', '2021-06-10 14:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `p_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `daily_times` varchar(5) NOT NULL,
  `pills_daily` varchar(3) NOT NULL,
  `total_days` varchar(5) NOT NULL,
  `total_pills` varchar(5) NOT NULL,
  `total_price` varchar(11) NOT NULL,
  `served_by` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'unpaid',
  `date` datetime NOT NULL,
  `date_paid` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`p_id`, `patient_id`, `medicine_id`, `daily_times`, `pills_daily`, `total_days`, `total_pills`, `total_price`, `served_by`, `status`, `date`, `date_paid`) VALUES
(9, 1, 1, '3', '3', '8', '72', '10800', 'James', 'unpaid', '2021-06-10 14:24:49', '2021-06-10 14:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `bar_code` varchar(255) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `used_quantity` int(11) NOT NULL,
  `remain_quantity` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `company` varchar(100) NOT NULL,
  `actual_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `profit_price` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `bar_code`, `medicine_name`, `pic`, `cat_id`, `quantity`, `used_quantity`, `remain_quantity`, `register_date`, `expire_date`, `company`, `actual_price`, `selling_price`, `profit_price`, `status`) VALUES
(1, '31232131212', 'Augmenti', 'augmentin.jpeg', 1, 2700, 0, 2700, '2021-04-27', '2021-04-27', 'Edis', 100, 150, 50, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `profile_pic` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_group` int(10) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_email`, `profile_pic`, `user_password`, `user_group`, `date_added`) VALUES
(4, 'Emily', 'emily@gmail.com', 'cashier2.jpg', 'josh7933', 3, '2021-04-27 10:09:35'),
(5, 'James', 'jamesdigu@gmail.com', 'james.jpg', 'josh7933', 2, '2021-04-27 11:08:08'),
(6, 'tom', 'tom@gmail.com', '', '12345', 1, '2021-05-03 10:37:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `prescription_patient_fk` (`patient_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_medicine_fk` FOREIGN KEY (`medicine_id`) REFERENCES `stock` (`id`),
  ADD CONSTRAINT `prescription_patient_fk` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_category` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
