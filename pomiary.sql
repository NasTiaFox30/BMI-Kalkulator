-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 16, 2024 at 04:55 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testowa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pomiary`
--

CREATE TABLE `pomiary` (
  `id_pomiaru` int(11) NOT NULL,
  `płeć` text DEFAULT NULL,
  `wiek` int(3) DEFAULT NULL,
  `waga` decimal(5,2) DEFAULT NULL,
  `wzrost` decimal(5,2) DEFAULT NULL,
  `data_pomiaru` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pomiary`
--

INSERT INTO `pomiary` (`id_pomiaru`, `płeć`, `wiek`, `waga`, `wzrost`, `data_pomiaru`) VALUES
(1, 'kobieta', 18, 55.60, 159.00, '2024-05-16 16:38:32'),
(2, 'mężczyzna', 23, 76.30, 171.00, '2024-05-16 16:38:53'),
(3, 'kobieta', 43, 61.00, 175.00, '2024-05-16 16:39:55'),
(4, 'kobieta', 24, 57.60, 153.00, '2024-05-16 16:53:14'),
(5, 'mężczyzna', 19, 86.00, 178.00, '2024-05-16 16:53:58'),
(6, 'kobieta', 20, 48.30, 161.00, '2024-05-16 16:54:27'),
(7, 'kobieta', 31, 47.30, 164.00, '2024-05-16 16:55:12');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pomiary`
--
ALTER TABLE `pomiary`
  ADD PRIMARY KEY (`id_pomiaru`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pomiary`
--
ALTER TABLE `pomiary`
  MODIFY `id_pomiaru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
