-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 22, 2026 at 05:37 AM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 8.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blocknotsa2_uttarabank_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_point` enum('Branches','AD Branches') NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `type` enum('branch','sub_branch','atm','agent') NOT NULL DEFAULT 'branch',
  `branch` varchar(191) DEFAULT NULL,
  `address` varchar(191) NOT NULL,
  `district` varchar(191) DEFAULT NULL,
  `upazila` varchar(191) DEFAULT NULL,
  `dhaka_branch` tinyint(1) NOT NULL DEFAULT 0,
  `division` varchar(191) DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `map` longtext DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `fax` varchar(191) DEFAULT NULL,
  `image` bigint(20) UNSIGNED DEFAULT NULL,
  `opening_hours` varchar(191) DEFAULT NULL,
  `dates` varchar(191) DEFAULT NULL,
  `date_opening` date DEFAULT NULL,
  `locker` tinyint(1) NOT NULL DEFAULT 0,
  `gstatus` varchar(191) DEFAULT NULL,
  `routing_no` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `branch_point`, `name`, `slug`, `type`, `branch`, `address`, `district`, `upazila`, `dhaka_branch`, `division`, `latitude`, `longitude`, `map`, `email`, `phone`, `mobile`, `fax`, `image`, `opening_hours`, `dates`, `date_opening`, `locker`, `gstatus`, `routing_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Branches', 'Mongla Branch, Uttara Bank PLC', 'uttara-bank-plc', 'branch', 'Mongla Branch', '54/1, Sk. Abdul Hai Sarak, Mongla Main Road, Mongla, Bagerhat-9350', 'Bagerhut', NULL, 0, 'Khulna', 0.0000000, 0.0000000, NULL, 'mongla.manager@uttarabank-bd.com', '(04658)73383, 01991144397', '(04658)73383, 01991144397', NULL, NULL, NULL, NULL, NULL, 1, '1', '250010945', 1, '2026-04-14 05:14:56', '2026-04-14 05:16:37'),
(2, 'Branches', 'Bagerhat Branch, Uttara Bank PLC', 'bagerhat-branch-uttara-bank-plc', 'branch', 'Bagerhat Branch', '158, Main Road, Ward No. 05, Bagerhat-9300', 'Bagerhut', NULL, 0, 'Khulna', 0.0000000, 0.0000000, NULL, 'bagerhat.manager@uttarabank-bd.com', '(0468)62440, 01991144386', '(0468)62440, 01991144386', NULL, NULL, NULL, NULL, NULL, 1, '1', '250010079', 1, '2026-04-14 05:23:30', '2026-04-14 05:23:30'),
(3, 'Branches', 'Barguna Branch, Uttara Bank PLC', 'barguna-branch-uttara-bank-plc', 'branch', 'Barguna Branch', 'Advocate Ansar Plaza (1st Floor), Nazrul Islam Road, Barguna Sadar, Barguna-8700', 'Barguna', NULL, 0, 'Barishal', 0.0000000, 0.0000000, NULL, 'barguna.manager@uttarabank-bd.com', '(0448)62376, 01991144417', '(0448)62376, 01991144417', NULL, NULL, NULL, NULL, NULL, 1, '1', '250040131', 1, '2026-04-14 05:25:20', '2026-04-14 05:25:20'),
(4, 'AD Branches', 'Barishal Branch, Uttara Bank PLC', 'barishal-branch-uttara-bank-plc', 'branch', 'Barishal Branch', 'Aryya Laxmi Bhaban, 99, Sadar Road, Ward No.17, Barishal City Corporation, Kotwali, Barishal-8200', 'Barishal', NULL, 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3680.6265467428843!2d90.36834361496196!3d22.704942185114795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x744931aefde41a19!2sUttara+Bank+Limited%2C+Borisal+Br!5e0!3m2!1sen!2s!4v1461837233663\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'barishal.manager@uttarabank-bd.com', '(0431)64175, (0431)64407, 01991144416', '(0431)64175, (0431)64407, 01991144416', NULL, NULL, NULL, NULL, NULL, 1, '1', '250060287', 1, '2026-04-14 05:27:17', '2026-04-14 05:29:41'),
(5, 'Branches', 'Barishal Branch, Uttara Bank PLC', 'Barishal Branch', 'branch', 'Chawk Bazar (BAR) Branch', 'Jonaki Shopping Complex (1st floor). Ward-09, Chawkbazar, Kotwali, Barishal-8200', 'Barishal', NULL, 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d460.0800608532703!2d90.37368485852357!3d22.704423542190973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375534079aaed0ad%3A0xbda1cc0937bfb661!2z4KaJ4Kak4KeN4Kak4Kaw4Ka-IOCmrOCnjeCmr-CmvuCmguCmlSDgprLgpr_gpq7gpr_gpp_gp4fgpqE!5e0!3m2!1sen!2sbd!4v1633933855146!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'chawkbzrbar.manager@uttarabank-bd.com', '(0431)64502, (0431)64096, 01991144420', '(0431)64502, (0431)64096, 01991144420', NULL, NULL, NULL, NULL, NULL, 1, '1', '250060708', 1, '2026-04-20 16:42:21', '2026-04-20 16:42:21'),
(6, 'Branches', 'Tajumuddin Branch, Uttara Bank PLC', 'Tajumuddin Branch', 'branch', 'Tajumuddin Branch', 'Ahmed Bhaban, 1st Floor, Hat Shashigonj Bazar, Tajumuddin, Bhola-8350', 'Bhola', 'Tazumuddin', 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1844.1423355760921!2d90.85241771736773!3d22.418308832735633!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x26295b15c6c8738a!2sUttara%20Bank%20Limited%2C%20Tajumuddin%20Branch!5e0!3m2!1sen!2sbd!4v1580281119712!5m2!1sen!2sbd\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"></iframe>', 'tajumuddin.manager@uttarabank-bd.com', '(04927)56019, 01991144434', '(04927)56019, 01991144434', NULL, NULL, NULL, NULL, NULL, 1, '1', '250091001', 1, '2026-04-20 16:45:57', '2026-04-20 16:45:57'),
(7, 'Branches', 'Lalmohan Branch, Uttara Bank PLC', 'Lalmohan Branch', 'branch', 'Lalmohan Branch', 'Mia Plaza (1st Floor), 878-879, Sadar Road, Ward-06, Lalmohon Pourosova, Bhola', 'Bhola', 'Lalmohan', 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3690.3592980900567!2d90.73303121498911!3d22.340058285302977!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ab24a27020ebc7%3A0xfa32314cec010943!2sUttara%20Bank%20Limited%2C%20Lalmohan%20Branch!5e0!3m2!1sen!2sbd!4v1629199800323!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'lalmohon.manager@uttarabank-bd.com', '(04925)75625, 01991144427', '(04925)75625, 01991144427', NULL, NULL, NULL, NULL, NULL, 1, '1', '250090707', 1, '2026-04-20 16:47:28', '2026-04-20 16:47:28'),
(8, 'Branches', 'Charfashion Branch, Uttara Bank PLC', 'Charfashion Branch', 'branch', 'Charfashion Branch', '145, Thana Road, Ward no: 04,  Charfashion Pourasava, Charfashion-8340, Bhola', 'Bhola', 'Char Fasson', 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3694.4410588246856!2d90.75986941495263!3d22.185338585383445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ab1779ce650329%3A0x7fa125d238746145!2sUttara%20Bank%20Limited%2C%20Charfashion%20Branch!5e0!3m2!1sen!2sbd!4v1629203656522!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'charfashion.manager@uttarabank-bd.com', '(04923)74074 (04923)74075 01991144419', '(04923)74074 (04923)74075 01991144419', NULL, NULL, NULL, NULL, NULL, 1, '1', '250090228', 1, '2026-04-20 16:48:49', '2026-04-20 16:48:49'),
(9, 'Branches', 'Daulatkhan Branch, Uttara Bank PLC', 'Daulatkhan Branch', 'branch', 'Daulatkhan Branch', '51/1, Tarek Jamil Tower, Ward-03, Sadar Road, Uttar Matha Bus Stand, Daulatkhan Pourashava, Bhola-8310', 'Bhola', 'Daulatkhan', 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3683.4300260869513!2d90.74456921496011!3d22.6004114851685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ab2d5a54eb4425%3A0xf35f65c7f2b1d7fb!2sUttara+Bank+Limited%2C+Daulatkhan+Branch!5e0!3m2!1sen!2s!4v1495517869222\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'daulatkhan.manager@uttarabank-bd.com', '(04924)56110, 01991144421', '(04924)56110, 01991144421', NULL, NULL, NULL, NULL, NULL, 1, '1', '250090378', 1, '2026-04-20 16:50:48', '2026-04-20 16:50:48'),
(10, 'Branches', 'Bhola Branch, Uttara Bank PLC', 'Bhola Branch', 'branch', 'Bhola Branch', 'K, Jahan Shopping Complex, Sadar Road, Bhola-8300', 'Bhola', 'Bhola Sadar', 0, 'Barishal', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3681.172390772715!2d90.64271461496159!3d22.684625585125243!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3754d4494a58497b%3A0x1a8ae0d7550409c!2sUttara+Bank+Limited%2C+Bhola+Branch!5e0!3m2!1sen!2s!4v1495024349941\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'bhola.manager@uttarabank-bd.com', '(0491)61387, (0491)61480, 01991144418', '(0491)61387, (0491)61480, 01991144418', NULL, NULL, NULL, NULL, NULL, 1, '1', '250090107', 1, '2026-04-20 16:52:22', '2026-04-20 16:52:22'),
(11, 'AD Branches', 'Bogura Branch, Uttara Bank PLC', 'Bogura Branch', 'branch', 'Bogura Branch', 'Habib Mansion (1st floor), Kabi Nazrul Islam Road, Bogura-5800', 'Bagura', NULL, 0, 'Rajshahi', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3620.4272150529805!2d89.37095491500261!3d24.849254484059163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fc54e477604437%3A0x1ecfe815210fffb0!2sUttara%20Bank%20Limited%2C%20Bogura%20Branch!5e0!3m2!1sen!2sbd!4v1629335853259!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'bogura.manager@uttarabank-bd.com', '(051)66228, (051)78439, (051)66376, 01991144356', '(051)66228, (051)78439, (051)66376, 01991144356', NULL, NULL, NULL, NULL, NULL, 1, '1', '250100376', 1, '2026-04-20 16:53:56', '2026-04-20 16:53:56'),
(12, 'Branches', 'Dharkhar Branch, Uttara Bank PLC', 'Dharkhar Branch', 'branch', 'Dharkhar Branch', 'Nizam Uddin Market (1st Floor), Tantor Bazar, Akhaura, Brahmanbaria-3452', 'Brahmanbaria', 'Akhaura', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.805901297436!2d91.15204101498279!3d23.825500184552517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9ca634b00958fa58!2sUttara+Bank+Limited%2C+Br!5e0!3m2!1sen!2s!4v1461842816910\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'dharkhar.manager@uttarabank-bd.com', '01991144312', '01991144312', NULL, NULL, NULL, NULL, NULL, 1, '1', '250120730', 1, '2026-04-20 16:55:41', '2026-04-20 16:55:41'),
(13, 'Branches', 'Gopinathpur Branch', 'Gopinathpur Branch', 'branch', 'Gopinathpur Branch', 'Gopinathpur Bazar, P.O- Gopinathpur, P.S- Kasba, Brahmanbaria-3464', 'Brahmanbaria', 'Kasba', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.7549645935974!2d91.17293111498216!3d23.79173848456901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe7d7da96e248047a!2sUttara+Bank+Limited%2C+Gopinathpur+Br!5e0!3m2!1sen!2s!4v1462252017049\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'gopinathpur.manager@uttarabank-bd.com', '01991144314', '01991144314', NULL, NULL, NULL, NULL, NULL, 1, '1', '250120822', 1, '2026-04-20 16:56:49', '2026-04-20 16:56:49'),
(14, 'Branches', 'Brahmanbaria Branch, Uttara Bank PLC', 'Brahmanbaria Branch', 'branch', 'Brahmanbaria Branch', '1324, Ahmed Manshion (1st Floor), Sarok Bazar, Brahmanbaria -3400', 'Brahmanbaria', 'Brahmanbaria Sadar', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1822.9845207819187!2d91.10974207216134!3d23.96153485587306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375405bfb99039ef%3A0x6da8209d96ae689a!2sUttara%20Bank%20Limited%2C%20Brahmanbaria%20Branch!5e0!3m2!1sen!2sbd!4v1688616241464!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'brahmanbaria.manager@uttarabank-bd.com', '(0851)58673, (0851)57633, 01991144305', '(0851)58673, (0851)57633, 01991144305', NULL, NULL, NULL, NULL, NULL, 1, '1', '250120435', 1, '2026-04-20 16:58:46', '2026-04-20 16:58:46'),
(15, 'Branches', 'Chandpur Branch, Uttara Bank PLC', 'Chandpur Branch', 'branch', 'Chandpur Branch', '50/50, Akhand Market, Cumilla Road, Chandpur 3600', 'Chandpur', 'Chandpur Sadar', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d916.623629706877!2d90.65338065640415!3d23.225085189378618!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4cc789b664d5397c!2sUttara%20Bank%20Limited%2C%20Chandpur%20Branch!5e0!3m2!1sen!2sus!4v1580290810663!5m2!1sen!2sus\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"></iframe>', 'chandpur.manager@uttarabank-bd.com', '02334487227, 01991144307', '02334487227, 01991144307', NULL, NULL, NULL, NULL, NULL, 1, '1', '250130317', 1, '2026-04-20 17:00:20', '2026-04-20 17:00:20'),
(16, 'Branches', 'Chapainawabgonj Branch, Uttara Bank PLC', 'Chapainawabgonj Branch', 'branch', 'Chapainawabgonj Branch', 'House No. 04, Ward No. 02, Puraton Bazar, Madrasha Road, Chapainawabgonj-6300', 'Chapainawabganj', 'Chapainawabganj Sadar', 0, 'Rajshahi', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1827.4880151020484!2d90.97148469740013!3d23.641029442144177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3754693801000001%3A0x7dbb3725b2419934!2sUttara+Bank+Limited%2C+Companigonj+Br+(Comilla)!5e0!3m2!1sen!2s!4v1495514474660\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'chapainawabgonj.manager@uttarabank-bd.com', '02588892758, 01991144337', '02588892758, 01991144337', NULL, NULL, NULL, NULL, NULL, 1, '1', '250700255', 1, '2026-04-20 17:01:40', '2026-04-20 17:01:40'),
(17, 'Branches', 'Kansat Branch, Uttara Bank PLC', 'Kansat Branch', 'branch', 'Kansat Branch', 'Kansat Gopalnagar Eidgah Market, Kansat, Shibgonj, Chapainawabgonj', 'Chapainawabganj', 'Chapainawabganj Sadar', 0, 'Rajshahi', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3623.99945197642!2d88.16821751500021!3d24.726899084117072!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9af554c47dc96ac4!2sUttara+Bank+Limited%2C+Kansat+Branch!5e0!3m2!1sen!2s!4v1462364145618\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'kansat.manager@uttarabank-bd.com', '01991144339', '01991144339', NULL, NULL, NULL, NULL, NULL, 1, '1', '250700521', 1, '2026-04-20 17:03:00', '2026-04-20 17:03:00'),
(18, 'Branches', 'Bandartila Branch, Uttara Bank PLC', 'Bandartila Branch', 'branch', 'Bandartila Branch', '319/344, Jamal Shopping Centre(1st floor), PO-Sailors Colony, PS-EPZ (Old Bandar), Chattogram-4218', 'Chattogram', NULL, 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.7950147570646!2d91.78230341495443!3d22.285753485331167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30acdefaf3a24b83%3A0x598a629030a04473!2sUttara!5e0!3m2!1sen!2s!4v1495012675274\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'bandertilla.manager@uttarabank-bd.com', '(031)740975, 01991144267', '(031)740975, 01991144267', NULL, NULL, NULL, NULL, NULL, 1, '1', '250150942', 1, '2026-04-20 17:04:50', '2026-04-20 17:04:50'),
(19, 'Branches', 'Chaktai Branch, Uttara Bank PLC', 'Chaktai Branch', 'branch', 'Chaktai Branch', '19, New Chaktai, Chalpatti, Chattogram-4000', 'Chattogram', NULL, 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3690.5143665215533!2d91.84574561495533!3d22.33419898530603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ad274896c74f79%3A0x7680916dd10195ae!2sUttara+Bank+Limited!5e0!3m2!1sen!2s!4v1495087817779\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'chaktai.manager@uttarabank-bd.com', '02333368719, 02333355899, 01991144269', '02333368719, 02333355899, 01991144269', NULL, NULL, NULL, NULL, NULL, 1, '1', '250151754', 1, '2026-04-20 17:09:28', '2026-04-20 17:09:28'),
(20, 'AD Branches', 'Laldighi Branch, Uttara Bank PLC', 'Laldighi Branch', 'branch', 'Laldighi Branch', 'K.S.R City Center, J.M Sen Avenue, Kotowali, Chattogram', 'Chattogram', 'Kotwali', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3690.413924331113!2d91.83512351495536!3d22.337994385303986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfb2e8664e5109d12!2sUttara+Bank+Limited%2C!5e0!3m2!1sen!2s!4v1462365376999\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'laldighictg.manager@uttarabank-bd.com', '01991144276', '01991144276', NULL, NULL, NULL, NULL, NULL, 1, '1', '250154519', 1, '2026-04-20 17:11:12', '2026-04-20 17:11:12'),
(21, 'Branches', 'Halishahar Branch, Uttara Bank PLC', 'Halishahar Branch', 'branch', 'Halishahar Branch', 'Tamizur Rahman Plaza (1st Floor), Naya Bazar Mor, Halishahar Road, Pahartali, Chattogram 4202', 'Chattogram', 'Pahartali', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d922.5829757618568!2d91.78777340589805!3d22.34109326238938!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb0b59b953743f2cb!2sUttara%20Bank%20Limited%2C%20Halishahar%20Branch!5e0!3m2!1sen!2sbd!4v1580297321751!5m2!1sen!2sbd\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"></iframe>', 'halishahar.manager@uttarabank-bd.com', '(031)727204, 01991144272', '(031)727204, 01991144272', NULL, NULL, NULL, NULL, NULL, 1, '1', '250153165', 1, '2026-04-20 17:12:24', '2026-04-20 17:12:24'),
(22, 'Branches', 'Baraiyarhat Branch, Uttara Bank PLC', 'Baraiyarhat Branch', 'branch', 'Baraiyarhat Branch', '47 Hawa Bhaban, Baraiyarhat Pourashova, Jorarganj, Mirsharai,  Chattogram-4326', 'Chattogram', 'Mirsharai', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1837.774620775096!2d91.53261555815314!3d22.893103967193376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375338b3db8b252d%3A0x6d08dff5a94c380e!2sUttara%20Bank%20Limited!5e0!3m2!1sen!2sus!4v1581815523034!5m2!1sen!2sus\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"></iframe>', 'baraiyarhat.manager@uttarabank-bd.com', '01991144268', '01991144268', NULL, NULL, NULL, NULL, NULL, 1, '1', '250150292', 1, '2026-04-20 17:13:49', '2026-04-20 17:13:49'),
(23, 'Branches', 'Reazuddin Bazar Branch, Uttara Bank PLC', 'Reazuddin Bazar Branch', 'branch', 'Reazuddin Bazar Branch', 'Karnophuli Tower', 'Chattogram', 'Karnaphuli', 0, 'Chattogram', 0.0000000, 0.0000000, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d922.616842627808!2d91.8305136145626!3d22.33597489548682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x6125b641a86fcdb2!2sUttara+Bank+Limited!5e0!3m2!1sen!2sbd!4v1462264975051\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 'reazuddinbzr.manager@uttarabank-bd.com', '(031)613307, 01991144282', '(031)613307, 01991144282', NULL, NULL, NULL, NULL, NULL, 1, '1', '250156520', 1, '2026-04-20 17:14:52', '2026-04-20 17:14:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_slug_unique` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
