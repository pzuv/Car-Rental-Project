-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 07:15 PM
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
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `OfficeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`name`, `email`, `PASSWORD`, `OfficeID`) VALUES
('Admin', 'admin@me.com', '21232f297a57a5a743894a0e4a801fc3', 6);

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `Year` int(11) NOT NULL,
  `Status` enum('Active','Out of Service','Rented') NOT NULL DEFAULT 'Active',
  `Car_Modle` varchar(150) NOT NULL,
  `Car_plate` varchar(20) NOT NULL,
  `Car_type` enum('SUV','Sport','Sedan','Electric') NOT NULL,
  `Car_price` decimal(10,2) NOT NULL,
  `Car_detals` text NOT NULL,
  `Car_office` int(11) NOT NULL,
  `Car_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`Year`, `Status`, `Car_Modle`, `Car_plate`, `Car_type`, `Car_price`, `Car_detals`, `Car_office`, `Car_image`) VALUES
(2024, 'Active', 'MERCEDES EQS', 'AAA 1234', 'Electric', 1800.00, 'ELECTRIC CAR FROM MERCEDESsss ', 3, 'mercedes eqs.png'),
(2020, 'Active', 'TOYOTA FORTUNER', 'ABC 1234', 'SUV', 2000.00, 'toyota fortuner', 1, 'Fortuner.png'),
(2022, 'Active', 'PORSCHE TURBO S', 'BBB 1234', 'Sport', 4000.00, '911 TURBO S', 2, 'porsche 911turbo-s.png'),
(2022, 'Active', 'BMW 6 series', 'bmw 6', 'Sedan', 2499.00, 'BMW series 6 ', 1, 'bmw6.jpg'),
(2023, 'Active', 'TESLA MODEL X', 'ELE 1234', 'Electric', 1000.00, 'TESLA MODEL X', 1, 'tesla model x.png'),
(2000, 'Active', 'FERRARI F40', 'fer 1234', 'Sport', 6000.00, 'ferrari f40 ', 1, 'ferrari f40.png'),
(2022, 'Active', 'JAGUAR XF', 'JAG 1234', 'Sedan', 1600.00, 'JAGUAR XF MODEL 2022', 2, 'jaguarxf.jpg'),
(2025, 'Rented', 'LAMBORGINI TECNICA', 'OFF 1234', 'Sport', 4700.00, 'LAMBORGINI TECNICA', 1, 'LamborghiniHuracanTecnica.png'),
(2024, 'Active', 'PORSCHE CAYENNE ', 'POR 1234', 'SUV', 3000.00, 'PORSCHE CAYENNEE', 2, 'porsche cayenne.png'),
(2021, 'Active', 'PORSCHE GT3RS', 'RS 1234', 'Sport', 3000.00, 'PORSCHE 911 GT3R', 3, 'Porsche911GT3RS.png');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Name` varchar(255) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `Passport_number` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `Address` text NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Name`, `CustomerID`, `Passport_number`, `Email`, `age`, `Address`, `PhoneNumber`, `PASSWORD`) VALUES
('Abdalla', 1, 'A3330202', 'abdalla4@gmail.com', 21, 'Dammam', '96655276502', '25d55ad283aa400af464c76d713c07ad'),
('Abdalla', 2, 'P3201922', 'abdalla@gmail.com', 21, 'Cairo', '20109292922', '25d55ad283aa400af464c76d713c07ad');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `OfficeID` int(11) NOT NULL,
  `Location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`OfficeID`, `Location`) VALUES
(1, 'Egypt - Alexandria'),
(2, 'Egypt - Cairo'),
(3, 'Saudi Arabia - Riyadh'),
(4, 'Saudi Arabia - Dammam'),
(6, 'UK - London');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `rent_ID` int(11) NOT NULL,
  `PaymentDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Amount` decimal(10,2) NOT NULL,
  `PaymentMethod` enum('Credit Card','Cash','Canceled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `rent_ID`, `PaymentDate`, `Amount`, `PaymentMethod`) VALUES
(1, 1, '2024-12-29 00:30:39', 6000.00, 'Credit Card'),
(2, 2, '2024-12-29 00:47:53', 4000.00, 'Cash'),
(3, 3, '2024-12-29 16:16:51', 15000.00, 'Credit Card'),
(4, 4, '2024-12-29 21:40:13', 14100.00, 'Credit Card'),
(5, 5, '2024-12-29 23:00:21', 12000.00, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `rent_ID` int(11) NOT NULL,
  `office_ID` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `customer_ID` int(11) NOT NULL,
  `car_plate` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `Status` enum('Reserved','Picked Up','Returned','Cancelled','Confirmed') NOT NULL,
  `rent_created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`rent_ID`, `office_ID`, `pickup_date`, `return_date`, `customer_ID`, `car_plate`, `cost`, `Status`, `rent_created_at`) VALUES
(1, 1, '2024-12-30', '2025-01-01', 1, 'bmw 6', 6000.00, 'Cancelled', '2024-12-29 00:29:50'),
(2, 1, '2024-12-30', '2025-01-01', 1, 'ABC 1234', 4000.00, 'Returned', '2024-12-29 00:47:51'),
(3, 2, '2024-12-31', '2025-01-05', 1, 'POR 1234', 15000.00, 'Returned', '2024-12-29 16:16:22'),
(4, 1, '2024-12-30', '2025-01-02', 1, 'OFF 1234', 14100.00, 'Picked Up', '2024-12-29 21:39:50'),
(5, 2, '2024-12-30', '2025-01-02', 2, 'BBB 1234', 12000.00, 'Picked Up', '2024-12-29 23:00:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`OfficeID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`Car_plate`),
  ADD KEY `Car_office` (`Car_office`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`OfficeID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `rent_ID` (`rent_ID`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`rent_ID`),
  ADD KEY `customer_ID` (`customer_ID`),
  ADD KEY `car_plate` (`car_plate`),
  ADD KEY `office_ID` (`office_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `OfficeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `OfficeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `rent_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`OfficeID`) REFERENCES `offices` (`OfficeID`);

--
-- Constraints for table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`Car_office`) REFERENCES `offices` (`OfficeID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`rent_ID`) REFERENCES `rent` (`rent_ID`);

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`customer_ID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `rent_ibfk_2` FOREIGN KEY (`car_plate`) REFERENCES `car` (`Car_plate`),
  ADD CONSTRAINT `rent_ibfk_3` FOREIGN KEY (`office_ID`) REFERENCES `offices` (`OfficeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
