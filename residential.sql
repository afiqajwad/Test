-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 15, 2023 at 08:16 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `residential`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `userid` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`userid`, `password`, `name`, `phone`, `email`) VALUES
(169886, 'admin1234', 'Hidayah Jusof', '0899182910', 'HidayahJusof@gmail.com'),
(244481, 'admin1234', 'Kamarul Adrul', '0145561010', 'kamaladrul28@gmail.com'),
(490250, 'admin1234', 'Zacky Zam', '0123456789', 'zackyker99@gmail.com'),
(799460, 'admin', 'admin', '123456789', 'admin@admin.admin');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `applicationid` int(11) NOT NULL,
  `matricno` varchar(50) NOT NULL,
  `collegeid` int(11) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` datetime NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Uncheck,\r\n1 = Accepted,\r\n2 = Rejected'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`applicationid`, `matricno`, `collegeid`, `checkin`, `checkout`, `remark`, `status`) VALUES
(3, 'B0136192', 3, '2023-01-06', '2023-03-08 00:00:00', 'Hellow ', 1),
(4, 'B0136192', 4, '2023-02-06', '2023-03-10 00:00:00', 'Hello', 1),
(5, 'B0136192', 11, '2023-03-15', '2023-03-15 00:00:00', 'Please let me in', 0);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `collegeid` int(11) NOT NULL,
  `collegename` varchar(50) NOT NULL,
  `block` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `roomnumber` int(11) NOT NULL,
  `roomstatus` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Unused,\r\n1 = Using',
  `capacity` int(11) NOT NULL DEFAULT 1,
  `manager` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`collegeid`, `collegename`, `block`, `unit`, `roomnumber`, `roomstatus`, `capacity`, `manager`) VALUES
(3, 'KKTDI', 'C', 'C-03-10', 10, 0, 1, 490250),
(4, 'KKTDI', 'C', 'C-03-11', 11, 0, 1, 490250),
(5, 'KKTDI', 'C', 'C-03-12', 12, 0, 1, 244481),
(11, 'KKTDI', 'D', 'D-10-20', 20, 0, 1, 169886),
(13, 'KKTF', 'B', 'C-03-12', 10, 0, 1, 169886),
(14, 'KKTF', 'A', 'A-19-10', 2, 0, 1, 244481);

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

CREATE TABLE `helpdesk` (
  `helpdeskid` int(11) NOT NULL,
  `matricno` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Unsolve,\r\n1 = Solved',
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helpdesk`
--

INSERT INTO `helpdesk` (`helpdeskid`, `matricno`, `comment`, `status`, `picture`) VALUES
(11, 'B0136192', 'Define the underlying principles that drive decisions and strategy for your design language a loss a day will keep you focus, and cloud native container based looks great,', 0, 'sample_broken_1.jpeg'),
(12, 'B0136192', 'for strategic fit, or 4-blocker, yet keep it lean, and high performance keywords. Product market fit', 1, 'sample_broken_2.jpeg'),
(13, 'B0136192', 'Tolong Repair Kerusi ni', 0, 'sampleimage_2.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `matricno` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `matricno`, `message`, `created_date`, `status`) VALUES
(3, 'B0136192', 'Your application status has been changed to Pending', '2023-03-13 04:31:17', 1),
(4, 'B0136192', 'Your application has been Approved', '2023-03-13 04:31:42', 1),
(5, 'B0136192', 'Your application has been Approved', '2023-03-14 02:36:35', NULL),
(6, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:31:10', NULL),
(7, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:31:27', NULL),
(8, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:31:39', NULL),
(9, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:31:42', NULL),
(10, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:31:48', NULL),
(11, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:31:51', NULL),
(12, 'B0136192', 'Your college issue has been updated!', '2023-03-14 03:36:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siteidentity`
--

CREATE TABLE `siteidentity` (
  `siteidentityid` int(11) NOT NULL,
  `websitename` varchar(255) NOT NULL,
  `websitedesc` varchar(255) NOT NULL,
  `websitelogo` varchar(255) NOT NULL,
  `websitefavicon` varchar(255) NOT NULL,
  `websitefooter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siteidentity`
--

INSERT INTO `siteidentity` (`siteidentityid`, `websitename`, `websitedesc`, `websitelogo`, `websitefavicon`, `websitefooter`) VALUES
(1, 'Default Name', 'A Website To Visit', 'default.png', 'default.png', 'Welcome To My Website');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `matricno` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icno` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `studieslevel` varchar(255) DEFAULT NULL,
  `faculty` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`matricno`, `password`, `name`, `icno`, `phonenumber`, `email`, `program`, `studieslevel`, `faculty`, `profile_picture`) VALUES
('B0136192', 'admin1234', 'Muhammad Faizal Bin Ayub', '810802105225', '0174207224', 'faizalayub29@gmail.com', 'Internet Technology', 'Degree', 'FTMK', 'motorhome logo_1dec22.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`applicationid`),
  ADD KEY `matricno` (`matricno`,`collegeid`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`collegeid`);

--
-- Indexes for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD PRIMARY KEY (`helpdeskid`),
  ADD KEY `matricno` (`matricno`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siteidentity`
--
ALTER TABLE `siteidentity`
  ADD PRIMARY KEY (`siteidentityid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`matricno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=961207;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `applicationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `collegeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `helpdeskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `siteidentity`
--
ALTER TABLE `siteidentity`
  MODIFY `siteidentityid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
