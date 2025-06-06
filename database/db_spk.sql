-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2025 at 07:49 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spk`
--

-- --------------------------------------------------------

--
-- Table structure for table `aspect`
--

CREATE TABLE `aspect` (
  `id` int(11) NOT NULL,
  `code_aspect` varchar(7) NOT NULL,
  `name` varchar(100) NOT NULL,
  `persentase` decimal(3,2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aspect`
--

INSERT INTO `aspect` (`id`, `code_aspect`, `name`, `persentase`, `created_on`, `updated_on`) VALUES
(9, 'ASP0001', 'Kehadiran', '0.20', '2025-04-25 07:46:49', '2025-04-29 18:05:36'),
(11, 'ASP0002', 'Profile Karyawan', '0.20', '2025-05-10 05:47:29', '0000-00-00 00:00:00'),
(12, 'ASP0003', 'Sikap Kerja', '0.30', '2025-05-10 05:47:46', '0000-00-00 00:00:00'),
(13, 'ASP0004', 'Kemampuan', '0.30', '2025-05-10 05:47:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(11) NOT NULL,
  `code_criteria` varchar(7) NOT NULL,
  `aspect_id` int(11) NOT NULL,
  `factor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `persentase` decimal(3,2) NOT NULL,
  `target` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `code_criteria`, `aspect_id`, `factor_id`, `name`, `persentase`, `target`, `created_on`, `updated_on`) VALUES
(4, 'CRI0001', 9, 1, 'Absensi', '0.60', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'CRI0002', 9, 2, 'Keterlambatan', '0.40', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'CRI0003', 11, 1, 'Jabatan', '0.60', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'CRI0004', 11, 2, 'Lama Masa Kerja', '0.40', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'CRI0005', 12, 1, 'Kerjasama', '0.35', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'CRI0006', 12, 1, 'Inisiatif', '0.25', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'CRI0007', 12, 2, 'Kendali Diri', '0.40', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'CRI0008', 13, 1, 'Problem Solving', '0.25', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'CRI0009', 13, 1, 'Tanggung Jawab', '0.35', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'CRI0010', 13, 2, 'Kemampuan Adaptasi', '0.40', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `name`, `created_on`, `updated_on`) VALUES
(3, 'Study Space', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Techno Coffe', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Cafe 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Cafe 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Cafe 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Cafe 3', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Technolife', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'HRD', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `position_id` int(11) NOT NULL,
  `sub_divisi` varchar(50) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `fullname`, `address`, `no_telp`, `position_id`, `sub_divisi`, `start_date`, `end_date`, `created_on`, `updated_on`) VALUES
(1, 1, 'Super Admin', '', '', 0, NULL, '0000-00-00', '0000-00-00', '2025-02-06 00:00:00', '2025-02-06 00:00:00'),
(2, 2, 'Afip', 'cipasir', '0987654098765', 0, NULL, '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 8, 'nerva', 'cipasir', '0987654098765', 1, 'Kitchen', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '2025-05-28 14:41:18'),
(9, 9, 'Salma', 'cicalengka', '0897687657', 4, 'Kitchen', '0000-00-00', '0000-00-00', '2025-05-10 06:41:14', '2025-05-28 14:41:08'),
(10, 10, 'Rifa', 'Tanjungsari', '08564362819', 3, 'Layanan', '0000-00-00', '0000-00-00', '2025-05-10 06:41:54', '2025-05-28 14:40:57'),
(11, 11, 'Gilang', 'Garut', '087543212345', 2, 'Layanan', '0000-00-00', '0000-00-00', '2025-05-10 06:42:45', '2025-05-28 14:40:46'),
(12, 12, 'Tina', 'Cipasir', '08564371819', 5, 'Umum', '0000-00-00', '0000-00-00', '2025-05-10 06:43:21', '2025-05-28 14:38:17'),
(13, 13, 'Raihan', 'jatinangor', '08564372891', 7, NULL, '0000-00-00', '0000-00-00', '2025-05-10 06:44:55', '0000-00-00 00:00:00'),
(14, 14, 'Yuda', 'Cikijing', '09876567898', 5, 'Umum', '0000-00-00', '0000-00-00', '2025-05-28 14:42:11', '0000-00-00 00:00:00'),
(15, 15, 'Dian Herdiana', 'cibiru', '08976521134', 8, 'HRD', '0000-00-00', '0000-00-00', '2025-05-28 14:46:24', '2025-05-29 15:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `employee_division`
--

CREATE TABLE `employee_division` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_division`
--

INSERT INTO `employee_division` (`id`, `employee_id`, `division_id`, `created_on`, `updated_on`) VALUES
(8, 13, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 12, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 11, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 10, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 9, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 8, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 14, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 15, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `factor`
--

CREATE TABLE `factor` (
  `id` int(11) NOT NULL,
  `code_factor` varchar(7) NOT NULL,
  `name` varchar(100) NOT NULL,
  `persentase` decimal(3,2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factor`
--

INSERT INTO `factor` (`id`, `code_factor`, `name`, `persentase`, `created_on`, `updated_on`) VALUES
(1, 'FAC0001', 'Core', '0.00', '2025-04-25 07:44:14', '2025-04-29 18:06:27'),
(2, 'FAC0002', 'Secondary', '0.00', '2025-04-29 18:06:39', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level_position` varchar(15) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `level_position`, `created_on`, `updated_on`) VALUES
(1, 'Head Chef', 'senior_staff', '2025-04-30 04:38:20', '2025-05-29 15:54:13'),
(2, 'Waitress', 'staff', '2025-05-10 05:43:58', '2025-05-29 15:47:56'),
(3, 'Cashier', 'staff', '2025-05-10 05:44:04', '2025-05-29 15:54:21'),
(4, 'Cook Helper', 'staff', '2025-05-10 05:44:09', '2025-05-29 15:54:29'),
(5, 'Supervisor', 'managerial', '2025-05-10 05:44:18', '2025-05-29 15:54:36'),
(6, 'Admin', NULL, '2025-05-10 05:56:37', '0000-00-00 00:00:00'),
(7, 'Operator', NULL, '2025-05-10 05:56:44', '0000-00-00 00:00:00'),
(8, 'HRD', 'hrd', '2025-05-28 14:43:06', '2025-05-29 15:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `code_question` varchar(7) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `code_question`, `criteria_id`, `name`, `created_on`, `updated_on`) VALUES
(3, 'QST0001', 9, 'Apakah rekan Anda mudah diajak bekerja sama dalam menyelesaikan tugas bersama?', '2025-05-10 09:27:34', '0000-00-00 00:00:00'),
(4, 'QST0002', 9, 'Apakah rekan Anda bersedia membantu rekan kerja lain tanpa diminta?', '2025-05-10 09:28:00', '0000-00-00 00:00:00'),
(5, 'QST0003', 9, 'Apakah rekan Anda mampu berkomunikasi dengan baik dalam tim?', '2025-05-10 09:28:12', '0000-00-00 00:00:00'),
(6, 'QST0004', 9, 'Apakah rekan Anda menghargai pendapat orang lain saat berdiskusi?', '2025-05-10 09:28:24', '0000-00-00 00:00:00'),
(7, 'QST0005', 9, 'Apakah rekan Anda turut berkontribusi aktif saat bekerja dalam kelompok?', '2025-05-10 09:28:38', '0000-00-00 00:00:00'),
(8, 'QST0006', 10, 'Apakah rekan Anda mampu mengambil tindakan tanpa menunggu perintah atasan?', '2025-05-10 09:28:58', '0000-00-00 00:00:00'),
(9, 'QST0007', 10, 'Apakah rekan Anda mencari solusi ketika menghadapi masalah dalam pekerjaan?', '2025-05-10 09:29:13', '0000-00-00 00:00:00'),
(10, 'QST0008', 10, 'Apakah rekan Anda menunjukkan antusiasme dalam mencari cara baru untuk meningkatkan hasil kerja?', '2025-05-10 09:29:27', '0000-00-00 00:00:00'),
(11, 'QST0009', 10, 'Apakah rekan Anda sering memberikan ide atau saran yang membangun di tempat kerja?', '2025-05-10 09:29:40', '2025-05-28 14:49:56'),
(12, 'QST0010', 10, 'Apakah rekan Anda menunjukkan keinginan untuk belajar dan berkembang secara mandiri?', '2025-05-10 09:29:51', '2025-05-28 14:50:06'),
(13, 'QST0011', 11, 'Apakah rekan Anda mampu tetap tenang ketika menghadapi tekanan pekerjaan?', '2025-05-10 09:30:29', '0000-00-00 00:00:00'),
(14, 'QST0012', 11, 'Apakah rekan Anda tidak mudah marah saat menghadapi situasi sulit?', '2025-05-10 09:30:39', '0000-00-00 00:00:00'),
(15, 'QST0013', 11, 'Apakah rekan Anda mampu menyelesaikan konflik secara profesional?', '2025-05-10 09:30:50', '0000-00-00 00:00:00'),
(16, 'QST0014', 11, 'Apakah rekan Anda menjaga sikap dan tutur kata dalam situasi kerja yang menegangkan?', '2025-05-10 09:31:01', '0000-00-00 00:00:00'),
(17, 'QST0015', 11, 'Apakah rekan Anda tetap fokus dan tidak mudah terdistraksi oleh hal-hal pribadi saat bekerja?', '2025-05-10 09:31:12', '0000-00-00 00:00:00'),
(18, 'QST0016', 12, 'Apakah karyawan mampu menemukan solusi yang efektif saat menghadapi masalah kerja?', '2025-05-10 09:32:53', '0000-00-00 00:00:00'),
(19, 'QST0017', 12, 'Apakah karyawan dapat menganalisis penyebab utama dari suatu permasalahan?', '2025-05-10 09:33:04', '0000-00-00 00:00:00'),
(20, 'QST0018', 12, 'Apakah karyawan menunjukkan kreativitas dalam menyelesaikan permasalahan?', '2025-05-10 09:33:14', '0000-00-00 00:00:00'),
(21, 'QST0019', 12, 'Apakah karyawan mengambil keputusan dengan tepat dan cepat saat dibutuhkan?', '2025-05-10 09:33:27', '0000-00-00 00:00:00'),
(22, 'QST0020', 12, 'Apakah karyawan mampu menangani masalah tanpa selalu bergantung pada atasan?', '2025-05-10 09:34:16', '0000-00-00 00:00:00'),
(23, 'QST0021', 13, 'Apakah karyawan menyelesaikan pekerjaan sesuai dengan tenggat waktu yang ditentukan?', '2025-05-10 09:39:07', '0000-00-00 00:00:00'),
(24, 'QST0022', 13, 'Apakah karyawan konsisten dalam menjalankan tugas tanpa pengawasan langsung?', '2025-05-10 09:39:19', '0000-00-00 00:00:00'),
(25, 'QST0023', 13, 'Apakah karyawan dapat diandalkan untuk menyelesaikan tugas penting?', '2025-05-10 09:39:33', '0000-00-00 00:00:00'),
(26, 'QST0024', 13, 'Apakah karyawan menunjukkan kepedulian terhadap hasil kerjanya?', '2025-05-10 09:39:44', '0000-00-00 00:00:00'),
(27, 'QST0025', 13, 'Apakah karyawan mengakui kesalahan dan berusaha memperbaikinya ketika terjadi?', '2025-05-10 09:39:56', '0000-00-00 00:00:00'),
(28, 'QST0026', 14, 'Apakah karyawan mampu menyesuaikan diri dengan perubahan sistem atau kebijakan kerja?', '2025-05-10 09:40:34', '0000-00-00 00:00:00'),
(29, 'QST0027', 14, 'Apakah karyawan tetap produktif meskipun kondisi kerja berubah?', '2025-05-10 09:40:50', '0000-00-00 00:00:00'),
(30, 'QST0028', 14, 'Apakah karyawan cepat belajar saat diberikan tugas atau peran baru?', '2025-05-10 09:41:05', '0000-00-00 00:00:00'),
(31, 'QST0029', 14, 'Apakah karyawan mampu bekerja sama dengan tim baru atau dalam lingkungan kerja yang berbeda?', '2025-05-10 09:41:20', '0000-00-00 00:00:00'),
(32, 'QST0030', 14, 'Apakah karyawan menunjukkan sikap positif terhadap perubahan?', '2025-05-10 09:41:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `questioner`
--

CREATE TABLE `questioner` (
  `id` int(11) NOT NULL,
  `code_questioner` varchar(7) NOT NULL,
  `deadline` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questioner`
--

INSERT INTO `questioner` (`id`, `code_questioner`, `deadline`, `status`, `created_on`) VALUES
(1, 'QUE0001', '2025-06-20 17:00:00', 1, '2025-06-06 07:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `questioner_answers`
--

CREATE TABLE `questioner_answers` (
  `id` int(11) NOT NULL,
  `questioner_id` int(11) NOT NULL,
  `evaluator_id` int(11) NOT NULL,
  `evaluatee_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questioner_answers`
--

INSERT INTO `questioner_answers` (`id`, `questioner_id`, `evaluator_id`, `evaluatee_id`, `question_id`, `nilai`, `created_on`) VALUES
(16, 1, 9, 8, 3, 1, '2025-06-06 17:44:50'),
(17, 1, 9, 8, 4, 1, '2025-06-06 17:44:50'),
(18, 1, 9, 8, 5, 1, '2025-06-06 17:44:50'),
(19, 1, 9, 8, 6, 1, '2025-06-06 17:44:50'),
(20, 1, 9, 8, 7, 1, '2025-06-06 17:44:50'),
(21, 1, 9, 8, 8, 2, '2025-06-06 17:44:50'),
(22, 1, 9, 8, 9, 2, '2025-06-06 17:44:50'),
(23, 1, 9, 8, 10, 2, '2025-06-06 17:44:50'),
(24, 1, 9, 8, 11, 2, '2025-06-06 17:44:50'),
(25, 1, 9, 8, 12, 2, '2025-06-06 17:44:50'),
(26, 1, 9, 8, 13, 3, '2025-06-06 17:44:50'),
(27, 1, 9, 8, 14, 3, '2025-06-06 17:44:50'),
(28, 1, 9, 8, 15, 3, '2025-06-06 17:44:50'),
(29, 1, 9, 8, 16, 3, '2025-06-06 17:44:50'),
(30, 1, 9, 8, 17, 3, '2025-06-06 17:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `questioner_status`
--

CREATE TABLE `questioner_status` (
  `id` int(11) NOT NULL,
  `questioner_id` int(11) NOT NULL,
  `evaluator_id` int(11) NOT NULL,
  `evaluatee_id` int(11) NOT NULL,
  `type` enum('peer','supervisor') NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `created_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questioner_status`
--

INSERT INTO `questioner_status` (`id`, `questioner_id`, `evaluator_id`, `evaluatee_id`, `type`, `status`, `created_on`) VALUES
(2, 1, 9, 8, 'peer', 'completed', '2025-06-06 12:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_on`, `updated_on`) VALUES
(1, 'Admin', '2025-02-06 00:00:00', '2025-02-06 00:00:00'),
(2, 'User', '2025-02-07 08:38:00', '2025-02-07 08:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_criteria`
--

CREATE TABLE `sub_criteria` (
  `id` int(11) NOT NULL,
  `code_sub_criteria` varchar(8) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_criteria`
--

INSERT INTO `sub_criteria` (`id`, `code_sub_criteria`, `criteria_id`, `name`, `value`, `created_on`, `updated_on`) VALUES
(4, 'ASP0001', 4, '&lt;2 kali tidak hadir', 5, '2025-05-10 06:24:14', '0000-00-00 00:00:00'),
(5, 'ASP0002', 4, '3-4 kali tidak hadir', 4, '2025-05-10 06:24:31', '0000-00-00 00:00:00'),
(6, 'ASP0003', 4, '5-6 kali tidak hadir', 3, '2025-05-10 06:24:53', '0000-00-00 00:00:00'),
(7, 'ASP0004', 4, '7-8 kali tidak hadir', 2, '2025-05-10 06:25:11', '0000-00-00 00:00:00'),
(8, 'ASP0005', 4, '>8 kali tidak hadir ', 1, '2025-05-10 06:25:30', '0000-00-00 00:00:00'),
(9, 'ASP0006', 5, '&lt;2 Kali terlambat', 5, '2025-05-10 06:26:04', '0000-00-00 00:00:00'),
(10, 'ASP0007', 5, '3-4 kali terlambat', 4, '2025-05-10 06:26:25', '0000-00-00 00:00:00'),
(11, 'ASP0008', 5, '5-6 kali tidak hadir', 3, '2025-05-10 06:26:44', '0000-00-00 00:00:00'),
(12, 'ASP0009', 5, '7-8 kali terlambat', 2, '2025-05-10 06:27:05', '0000-00-00 00:00:00'),
(13, 'ASP0010', 5, '>8 kali terlambat', 1, '2025-05-10 06:29:59', '0000-00-00 00:00:00'),
(14, 'ASP0011', 7, 'Staff Managerial', 3, '2025-05-10 06:30:14', '0000-00-00 00:00:00'),
(15, 'ASP0012', 7, 'Staff Senior', 2, '2025-05-10 06:30:26', '0000-00-00 00:00:00'),
(16, 'ASP0013', 7, 'Staff', 1, '2025-05-10 06:30:49', '0000-00-00 00:00:00'),
(17, 'ASP0014', 8, '>2 Tahun', 3, '2025-05-10 06:32:10', '0000-00-00 00:00:00'),
(18, 'ASP0015', 8, '>1 Tahun - 2 Tahun', 2, '2025-05-10 06:32:29', '0000-00-00 00:00:00'),
(19, 'ASP0016', 8, '&lt;1 Tahun - 1 Tahun', 1, '2025-05-10 06:32:50', '0000-00-00 00:00:00'),
(20, 'ASP0017', 9, '>68', 3, '2025-05-10 06:33:22', '0000-00-00 00:00:00'),
(21, 'ASP0018', 9, '49-67', 2, '2025-05-10 06:33:36', '0000-00-00 00:00:00'),
(22, 'ASP0019', 9, '&lt;48', 1, '2025-05-10 06:33:48', '0000-00-00 00:00:00'),
(23, 'ASP0020', 10, '>68', 3, '2025-05-10 06:34:03', '0000-00-00 00:00:00'),
(24, 'ASP0021', 10, '49-67', 2, '2025-05-10 06:34:31', '0000-00-00 00:00:00'),
(25, 'ASP0022', 10, '&lt;48', 1, '2025-05-10 06:34:53', '0000-00-00 00:00:00'),
(26, 'ASP0023', 11, '>68', 3, '2025-05-10 06:35:08', '0000-00-00 00:00:00'),
(27, 'ASP0024', 11, '49-67', 2, '2025-05-10 06:35:17', '0000-00-00 00:00:00'),
(28, 'ASP0025', 11, '&lt;48', 1, '2025-05-10 06:35:28', '0000-00-00 00:00:00'),
(29, 'ASP0026', 12, '>20', 3, '2025-05-10 06:35:49', '0000-00-00 00:00:00'),
(30, 'ASP0027', 12, '11-19', 2, '2025-05-10 06:36:04', '0000-00-00 00:00:00'),
(31, 'ASP0028', 12, '&lt;10', 1, '2025-05-10 06:36:16', '0000-00-00 00:00:00'),
(32, 'ASP0029', 13, '>20', 3, '2025-05-10 06:36:29', '0000-00-00 00:00:00'),
(34, 'ASP0030', 13, '11-19', 2, '2025-05-10 06:37:28', '0000-00-00 00:00:00'),
(35, 'ASP0031', 13, '&lt;10', 1, '2025-05-10 06:37:42', '0000-00-00 00:00:00'),
(36, 'ASP0032', 14, '>20', 3, '2025-05-10 06:37:55', '0000-00-00 00:00:00'),
(37, 'ASP0033', 14, '11-19', 2, '2025-05-10 06:38:12', '0000-00-00 00:00:00'),
(38, 'ASP0034', 14, '&lt;10', 1, '2025-05-10 06:40:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `code_user` varchar(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `code_user`, `email`, `password`, `role_id`, `status`, `avatar`, `created_on`, `updated_on`) VALUES
(1, 'USR0001', 'admin@gmail.com', '1234', 1, 1, '', '2025-02-06 00:00:00', '2025-02-06 00:00:00'),
(8, 'USR0003', 'nerva@gmail.com', '1235', 2, 1, '/dist/img/avatar4.png', '0000-00-00 00:00:00', '2025-05-28 14:41:18'),
(9, 'USR0004', 'salma@gmail.com', '1234', 2, 1, '/dist/img/avatar4.png', '2025-05-10 06:41:14', '2025-05-28 14:41:08'),
(10, 'USR0005', 'Rifa@gmail.com', '1237', 2, 1, '/dist/img/avatar4.png', '2025-05-10 06:41:54', '2025-05-28 14:40:57'),
(11, 'USR0006', 'gilang@gmail.com', '1238', 2, 1, '/dist/img/avatar4.png', '2025-05-10 06:42:45', '2025-05-28 14:40:46'),
(12, 'USR0007', 'tina@gmail.com', '1239', 2, 1, '/dist/img/avatar4.png', '2025-05-10 06:43:21', '2025-05-28 14:38:17'),
(13, 'USR0008', 'raihan@gmail.com', '12310', 2, 1, '/dist/img/avatar4.png', '2025-05-10 06:44:55', '0000-00-00 00:00:00'),
(14, 'USR0009', 'yuda@gmail.com', '1232', 2, 1, '/dist/img/avatar4.png', '2025-05-28 14:42:11', '0000-00-00 00:00:00'),
(15, 'USR0010', 'dian@gmail.com', '1231', 2, 1, '/dist/img/avatar4.png', '2025-05-28 14:46:24', '2025-05-29 15:20:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aspect`
--
ALTER TABLE `aspect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_division`
--
ALTER TABLE `employee_division`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_division` (`employee_id`);

--
-- Indexes for table `factor`
--
ALTER TABLE `factor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questioner`
--
ALTER TABLE `questioner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questioner_answers`
--
ALTER TABLE `questioner_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questioner_id` (`questioner_id`);

--
-- Indexes for table `questioner_status`
--
ALTER TABLE `questioner_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_evaluation` (`evaluator_id`,`evaluatee_id`,`type`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_criteria`
--
ALTER TABLE `sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aspect`
--
ALTER TABLE `aspect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employee_division`
--
ALTER TABLE `employee_division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `factor`
--
ALTER TABLE `factor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `questioner`
--
ALTER TABLE `questioner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questioner_answers`
--
ALTER TABLE `questioner_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `questioner_status`
--
ALTER TABLE `questioner_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_criteria`
--
ALTER TABLE `sub_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questioner_answers`
--
ALTER TABLE `questioner_answers`
  ADD CONSTRAINT `questioner_answers_ibfk_1` FOREIGN KEY (`questioner_id`) REFERENCES `questioner` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
