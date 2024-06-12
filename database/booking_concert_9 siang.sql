-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 05:52 AM
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
-- Database: `booking_concert`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `idAccount` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`idAccount`, `username`, `password`) VALUES
(1, 'Daka', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `concert`
--

CREATE TABLE `concert` (
  `idConcert` int(11) NOT NULL,
  `nameConcert` varchar(100) NOT NULL,
  `locProvConcert` varchar(100) NOT NULL,
  `dateConcert` date NOT NULL,
  `guestConcert` varchar(100) NOT NULL,
  `descConcert` text DEFAULT NULL,
  `locationConcert` varchar(100) NOT NULL,
  `imgConcert` varchar(255) DEFAULT NULL,
  `detailConcert` text NOT NULL,
  `idTicket` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concert`
--

INSERT INTO `concert` (`idConcert`, `nameConcert`, `locProvConcert`, `dateConcert`, `guestConcert`, `descConcert`, `locationConcert`, `imgConcert`, `detailConcert`, `idTicket`) VALUES
(1, 'Ekspektanika', 'Yogyakarta', '2024-06-17', 'Sheila on Seven', 'Sheila on 7 adalah grup musik rock alternatif Indonesia asal Yogyakarta. Didirikan oleh sekelompok pelajar SMA pada 6 Mei 1996, grup musik ini sekarang beranggotakan Akhdiyat Duta Modjo, Eross Candra, dan Adam Muhammad Subarkah.', 'Lapangan Mandala Krida, Yogyakarta', 's07.png', 's07.php', 1),
(2, 'Suara Manahan', 'Jawa Tengah', '2024-06-19', 'Guyon Waton', 'Guyon Waton merupakan grup musik dangdut dan Pop Jawa Indonesia yang berasal dari Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta. Guyon Waton terbentuk pada tahun 2015. Nama Guyon Waton berasal dari kata \"Guyon\" yang artinya bercanda dan \"Waton\" artinya asal, sehingga Guyon Waton artinya bercanda asal.', 'Stadion Manahan, Surakarta, Jawa Tengah', 'guyonwaton.png', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `idTicket` int(11) NOT NULL,
  `classTicket` varchar(50) NOT NULL,
  `priceTicket` int(11) NOT NULL,
  `soldTicket` int(11) DEFAULT 0,
  `stockTicket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`idTicket`, `classTicket`, `priceTicket`, `soldTicket`, `stockTicket`) VALUES
(1, 'VIP', 150000, 0, 50);

--
-- Triggers `ticket`
--
DELIMITER $$
CREATE TRIGGER `sold_ticket` BEFORE UPDATE ON `ticket` FOR EACH ROW BEGIN
    DECLARE sold_diff INT;

    -- Hitung selisih penjualan baru dan lama
    SET sold_diff = NEW.soldTicket - OLD.soldTicket;

    -- Hanya jika soldTicket bertambah
    IF sold_diff > 0 THEN
        -- Update stockTicket langsung pada baris yang akan diperbarui
        SET NEW.stockTicket = OLD.stockTicket - sold_diff;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `idTransaction` int(11) NOT NULL,
  `nameTransaction` varchar(50) NOT NULL,
  `telpTransaction` int(14) NOT NULL,
  `mailTransaction` varchar(50) NOT NULL,
  `idConcert` int(11) DEFAULT NULL,
  `idAccount` int(11) DEFAULT NULL,
  `idTicket` int(11) DEFAULT NULL,
  `qtyTransaction` int(2) NOT NULL,
  `statusTicket` char(10) NOT NULL DEFAULT 'Available',
  `transactionDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`idAccount`);

--
-- Indexes for table `concert`
--
ALTER TABLE `concert`
  ADD PRIMARY KEY (`idConcert`),
  ADD KEY `idTicket` (`idTicket`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`idTicket`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`idTransaction`),
  ADD KEY `idConcert` (`idConcert`),
  ADD KEY `idAccount` (`idAccount`),
  ADD KEY `idTicket` (`idTicket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `idAccount` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `concert`
--
ALTER TABLE `concert`
  MODIFY `idConcert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `idTicket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `idTransaction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `concert`
--
ALTER TABLE `concert`
  ADD CONSTRAINT `concert_ibfk_1` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`idConcert`) REFERENCES `concert` (`idConcert`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`idAccount`) REFERENCES `account` (`idAccount`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_expired_tickets` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-06-10 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE transactions t
    JOIN concert c ON t.idConcert = c.idConcert
    SET t.statusTicket = 'Expired'
    WHERE c.dateConcert <= DATE_ADD(NOW(), INTERVAL 2 DAY);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
