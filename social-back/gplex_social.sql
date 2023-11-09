-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2023 at 09:56 AM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gplex_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `agent_id` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nick` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nick_sound` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` char(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `did` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language_1` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EN',
  `language_2` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language_3` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `telephone` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `birth_day` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `altid` char(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `seat_id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `login_pin` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `usertype` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `session_id` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `vcc_id` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `partition_id` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `var1` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `var2` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `skillout` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `browser_ip` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `browser_port` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `max_chat_session` decimal(2,0) NOT NULL DEFAULT '0',
  `chat_session_limit_with_call` decimal(1,0) NOT NULL DEFAULT '0',
  `always_recv_voice_call` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Keep a dedicated channel for voice call when used with non-voice calls',
  `supervisor_id` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `role_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `screen_logger` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ob_call` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `agent_group` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `login_status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_string` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `nick`, `nick_sound`, `name`, `did`, `language_1`, `language_2`, `language_3`, `telephone`, `email`, `birth_day`, `altid`, `seat_id`, `password`, `login_pin`, `usertype`, `active`, `session_id`, `vcc_id`, `partition_id`, `var1`, `var2`, `skillout`, `browser_ip`, `browser_port`, `max_chat_session`, `chat_session_limit_with_call`, `always_recv_voice_call`, `supervisor_id`, `role_id`, `screen_logger`, `ob_call`, `gender`, `agent_group`, `login_status`, `session_string`) VALUES
('1001', 'sweet', 'S300', 'Md Mohiuddin', '', 'BN', 'EN', '', '01714020393', 'mohiuddin@bpo.genuitysystems.com', '', '', '', '07e0075093fa9530e3cae63d4024f9cf855a48c0a0ba3479d3b1ebde64aa3e58', '85631', 'S', 'Y', '1001664440307', '', '', '4ad57e66', '64537', 'AC', '', '', 3, 3, '', '', '1662049108', 'Y', 'Y', '', '', NULL, ''),
('1002', 'Abir', 'A160', 'Tanzid Mohammad Abir', '', 'BN', 'EN', '', '01632830810', 'abir@bpo.genuitysystems.com', '', '', '', '39576558f2fa522fc76394e04bbffa2373fadf231e8c25bcfd71cde8c3f6ec2e', '67326', 'S', 'Y', '1002682572139', '', '', 'eea28bce', '', 'AA', '', '', 3, 3, '', '', '1662049108', 'Y', 'Y', '', '', NULL, ''),
('1004', 'NOC-Test', 'N232', 'NOC Test', '', 'BN', 'EN', '', '1914173843', 'abid.hasan@bpo.genuitysystems.com', '', '', '', 'b988f45a3618cd00652ed8967f7020da69a0b5667e89aabcbcae6b947c426e38', '98117', 'S', 'Y', '1004682586203', '', '', '', '', 'AA', '', '', 3, 3, '', '', '1530773743', 'Y', 'Y', '', '', NULL, ''),
('1016', 'Tuhin', 'T500', 'Tuhin Reza Sagar', '', 'BN', 'EN', '', '01792388908', 'tuhin@bpo.genuitysystems.com', '', '', '', 'f8da345836be1377daeb5d72a6363b4d6ca46f6e8797954536e5abce29eac484', '30128', 'S', 'Y', '1016668779696', '', '', '55721cba', '75968', '', '', '', 0, 0, '', '', '1662049108', 'Y', 'Y', '', '', NULL, ''),
('1017', 'Emran', 'E565', 'MD Emran Talukder', '', 'BN', 'EN', '', '01680394150', 'emran@bpo.genuitysystems.com', '', '', '', 'd4708af170ff3b8fd5ade26447a3e5c088d2a43b0b233448da8c5db3fc8a7c78', '98720', 'S', 'Y', '1017664427314', '', '', '66bc7e71', '32179', '', '', '', 0, 0, '', '', '1662049108', 'Y', 'Y', '', '', NULL, ''),
('1020', 'Sajjad', 'S230', 'Md. Sajjad Hossain', '', 'BN', 'EN', '', '01880162636', 'sajjad@bpo.genuitysystems.com', '', '', '', 'e1a5bf451afdc3ef60b2eac77d9be119f107d12147ffab2815de603f2debcc3c', '47827', 'A', 'Y', '1020664185008', '', '', '', '', '', '', '', 0, 0, '', '1003', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1023', 'Sadia', 'S300', 'Umme Sadia', '', 'BN', 'EN', '', '1715853817', 'umme.sadia@bpo.genuitysystems.com', '0829', '', '103', '2233152bc7f2f98cf033ba94dfc3bafac0564cf417389e59c443f3d4db43f69f', '81156', 'A', 'Y', '1023682826578', '', '', '6148a35a', '', 'AA', '192.168.70.20', '8284', 0, 0, '', '1005', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1024', 'Kulsum', 'K425', 'Kulsum Akhter', '', 'BN', 'EN', '', '1926023314', 'kulsum@bpo.genuitysystems.com', '0829', '', '104', 'ae453801bce5324e1ef2fc2dc3c02d618f47b472076286cda7a5a3422c6d9367', '29396', 'A', 'Y', '1024682819254', '', '', '726541e3', '', 'AA', '192.168.70.20', '39396', 0, 0, '', '1005', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1033', 'Lamia', 'L500', 'Lamia Rahman', '', 'BN', 'EN', '', '1670160801', 'lamia@bpo.genuitysystems.com', '0829', '', '', 'd920c3eaae6dc3b25d51b1d63952cb1a585fb857a1b129d8ddc14d1d7adcd2d0', '86978', 'A', 'N', '1033680839675', '', '', '', '', 'AA', '', '', 0, 0, '', '1004', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1036', 'Taslim', 'T245', 'Jubaer Taslim', '', 'BN', 'EN', '', '', '', '', '', '', '6ac903da992781d9900e6a57a25a602a1af3a9bcaf3064a3910e595780a4b407', '89446', 'A', 'N', '1036674464036', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1038', 'Sumaiya', 'S500', 'Sumaiya Akter', '', 'BN', 'EN', '', '', '', '', '', '', '82872f1b36d60ff455ef9a8867cb247b6e345025b1f9d5b530d06095b87625e7', '78057', 'A', 'Y', '1038682735865', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1669780047', 'Y', 'Y', '', '', NULL, ''),
('1041', 'Minhazul', 'M524', 'Minhazul Abedin', '', 'BN', 'EN', '', '', '', '', '', '', '021a1dac75ae5756ff463d5821a653a52cb1a3a760e2d2d52dfa047c58837814', '21398', 'A', 'N', '1041677062284', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1042', 'Amena', 'A550', 'Amena Khatun', '', 'BN', 'EN', '', '1777830481', '', '0907', '', '115', '6677242b732c2212f0c9a52ba93395cc9941cd56d0933a2d2da311e085268040', '69922', 'A', 'Y', '1042682819093', '', '', '638fd79c', '', 'AA', '192.168.70.20', '21563', 0, 0, '', '1001', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1043', 'Hridoy', 'H630', 'Md. Hridoy Mahmud', '', 'BN', 'EN', '', '', '', '0907', '', '116', '1e605fce253cf96b9825714381bc498d6375b3f765df9437aecae1d81be472be', '94689', 'A', 'Y', '1043682823514', '', '', '4e3db3b9', '', 'AA', '192.168.70.20', '27624', 0, 0, '', '1001', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('1048', 'Foujia', 'F200', 'Foujia Jaman', '', 'BN', 'EN', '', '', '', '0914', '', '', '58d3c57a00e3ba62de81bf88c51630acf945909779fa505e98ab4910152026ed', '85819', 'A', 'Y', '1048682740734', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1051', 'Arif', 'A610', 'Arif Raihan', '', 'BN', 'EN', '', '', '', '0914', '', '', '970fc472543c455a09b33015e89fbccab1b2e1a5eb3239a727d02397de30ec24', '42951', 'A', 'Y', '1051682312224', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1055', 'Sumaya', 'S500', 'Sumaya Mahmud', '', 'BN', 'EN', '', '', '', '0914', '', '', '5d0269f394220ff56089c4eb1c039f28ea9bcdae325e7a9b2b68718add30a1d7', '42727', 'A', 'N', '1055681610091', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1063', 'Yeasmin', 'Y255', 'Sanzida Yeasmin', '', 'BN', 'EN', '', '01309191709', '', '0921', '', '', '79789c1898a35d963d09ee16183b1df71cde57c6eec21c1a28adddc162a65882', '46650', 'A', 'N', '1063681610096', '', '', 'e5494d03', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1065', 'mostakem', 'M232', 'Mostakem Ahmed', '', 'BN', 'EN', '', '01748209520', '', '0921', '', '129', 'cb9776adb542ceac4efc6adbf43b9c52f12be6223f2745b5051acf6c54763f8b', '98553', 'A', 'Y', '1065682821852', '', '', '1329c72b', '', 'AA', '192.168.70.20', '42703', 0, 0, '', '1001', '1669780047', 'Y', 'N', '', '', NULL, ''),
('1076', 'Taleb', 'T410', 'Md. Abu Taleb', '', 'BN', 'EN', '', '1314668978', 'abu@bpo.genuitysystems.com', '0921', '', '', 'da2e95025e9b10dad0af4eb72c39d6eabd01e87d6d38283ee5f52f20b2f39cb5', '97670', 'S', 'Y', '1076681997390', '', '', '94a4a424', '', 'AA', '', '', 3, 3, '', '', '1662049108', 'Y', 'N', '', '', NULL, ''),
('1077', 'Sakib', 'S210', 'Nazmus Sakib Talha', '', 'BN', 'EN', '', '01673998031', 'sakib@bpo.genuitysystems.com', '0921', '', '', 'c409358b87693b14f0c29ab48975d77cd25e38c10b127178b2789bc6917c3b13', '54985', 'S', 'Y', '1077681888481', '', '', '855986df', '74037', 'AA', '', '', 3, 3, '', '', '1662049108', 'Y', 'N', '', '', NULL, ''),
('1079', 'Fatima', 'F350', 'Fatima Akter', '', 'BN', 'EN', '', '01934119463', 'fatima@bpo.genuitysystems.com', '1023', '', '', '7e8d36bf38445b3c856f1f1d08f72bec4779231ad0fef13eb4ada9bc7e0a5abd', '40752', 'S', 'Y', '1079682821963', '', '', '5e24e68b', '', 'AA', '', '', 3, 3, '', '1001', '1662049108', 'Y', 'N', '', '', NULL, ''),
('1080', 'Azad', 'A230', 'Dihan Azad', '', 'BN', 'EN', '', '01706015524', 'azad@bpo.genuitysystems.com', '1023', '', '', '8e5f871c3994ec24dd7755147c65347ab79a567504b2a858dd913fe6feb11ed0', '62221', 'A', 'Y', '1080682589650', '', '', '345882f1', '32741', 'AA', '', '', 0, 0, '', '1001', '1669780047', 'Y', 'Y', '', '', NULL, ''),
('1083', 'Mainul', 'M540', 'Md. Mainul Islam Hridoy', '', 'BN', 'EN', '', '01303042645', 'mainul@bpo.genuitysystems.com', '1023', '', '', '35949d0974d6c6fcfcc765ef5b2e9901642499a86aca73a13821e1898b5b28cf', '82524', 'A', 'N', '1083675154684', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1085', 'Rupak', 'R120', 'Ahsanul Islam Rupak', '', 'BN', 'EN', '', '01630929818', 'rupak@bpo.genuitysystems.com', '1023', '', '', 'c595eae17e15200b678ebd187b29f54af1b8e2aed7b6df4e658453c82da85f23', '46309', 'A', 'N', '1085680057715', '', '', '3e4d95dc', '', '', '', '', 0, 0, '', '1001', '1669780047', 'Y', 'Y', '', '', NULL, ''),
('1086', 'Ahmed', 'A530', 'Raju Ahmed', '', 'BN', 'EN', '', '01857279652', 'ahmed@bpo.genuitysystems.com', '1023', '', '', '414240e8c6b03987bd8c151da67b9a6d454ae62b4e9224d149801cc3f0705e40', '29602', 'A', 'Y', '1086682571719', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1090', 'Mim', 'M500', 'Sumaiya Mim', '', 'BN', 'EN', '', '01854020576', 'mim@bpo.genuitysystems.com', '1023', '', '102', '5ec5b057e17ce4be93d1c2b8c5930038005f395a6b580f08795cacc0f5421694', '99513', 'A', 'Y', '1090682822238', '', '', 'd52b93e2', '', 'AA', '192.168.70.20', '35589', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1091', 'Emon', 'E550', 'Md Emon Molla', '', 'BN', 'EN', '', '01768649315', 'emon@bpo.genuitysystems.com', '1023', '', '', '81d9a3dc6bbd144e618d0a0e843f6240af19e2ece0bf0e042986a5e856e4431c', '77873', 'A', 'N', '1091676277404', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1093', 'Asif', 'A210', 'Asif Hasan', '', 'BN', 'EN', '', '', 'asif@bpo.genuitysystems.com', '1109', '', '', 'dfc82de080510d9761bfe71bd861b19b0b0dd55d40f56ae99f1a728c54a845f0', '25099', 'A', 'N', '1093679223170', '', '', '2b405ac4', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1095', 'Saydul', 'S340', 'Md. Saydul Islam', '', 'BN', 'EN', '', '', 'saydul@bpo.genuitysystems.com', '1109', '', '122', 'fa07f42af3d62b7d1d8c08043094c6195e7e7af5baea3f267eab750209da48d3', '41359', 'A', 'Y', '1095682841347', '', '', 'be96da5b', '', 'AA', '192.168.70.20', '60634', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1101', 'Sharmin', 'S655', 'Adiba Sultana Sharmin', '', 'BN', 'EN', '', '1845439372', 'adiba@bpo.genuitysystems.com', '1218', '', '', '5c819a9f5aec7c39eb11c1ebd027be9a7df6fc239fe24c77d236b2af4924ede7', '93052', 'A', 'Y', '1101682744149', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1102', 'Halima', 'H450', 'Most. Halima Khatun', '', 'BN', 'EN', '', '1729889747', 'halima@bpo.genuitysystems.com', '1218', '', '', '97f5ede7b0f4adb90ca5bcc7d1d964b26af2244bab85a5d9b722aa169adc984b', '87440', 'A', 'Y', '1102682563682', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1104', 'Lubna', 'L150', 'Hafsa Islam Lubna', '', 'BN', 'EN', '', '1633926257', 'hafisa@bpo.genuitysystems.com', '1218', '', '', '0de50b7ecb038778e64dfa3800f7b4d51954318a7a7387e321c00716b4a879ef', '48186', 'A', 'N', '1104679367546', '', '', 'c2e0a465', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1105', 'Marwa', 'M600', 'Shayma Monir Marwa', '', 'BN', 'EN', '', '1863488033', 'marwa@bpo.genuitysystems.com', '1218', '', '', 'd2f69826dedbe6d8a53e166d2a925ecdd071864cefe96eda575057da01725cf1', '92090', 'A', 'N', '1105674265035', '', '', '', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1106', 'Roy', 'R000', 'Sukdev Roy', '', 'BN', 'EN', '', '1716991645', 'sukdev@bpo.genuitysystems.com', '1218', '', '', '0d6bd854504230c60b091dc4fb0326335a3f2d49cfa40c6cf66493c801615abd', '24953', 'A', 'Y', '1106682764900', '', '', '6fdc873f', '', 'AA', '', '', 0, 0, '', '1001', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1108', 'Riyad', 'R300', 'MD Riyad Hassan', '', 'BN', 'EN', '', '01797616607', 'riyad@bpo.genuitysystems.com', '0124', '', '112', '4e9bbaec1ba3b7eda2c56c189acacf5f74d31c50e344028d066b517216ce11af', '56677', 'A', 'Y', '1108682829689', '', '', 'eb9afa32', '', 'AA', '192.168.70.20', '51054', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1110', 'Akibuzzama', 'A212', 'Md. Akibuzzaman', '', 'BN', 'EN', '', '', 'akibuzzaman@bpo.genuitysystems.com', '0124', '', '', 'f1475ba5195feddd2dd9c6c19fe1e9d2da6a1a545f4b08fe34f8a979f6d08e4d', '61140', 'A', 'Y', '1110682566493', '', '', '', '', 'AB', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1111', 'Ahashanur', 'A256', 'Md Ahashanur Rahman Mahim', '', 'BN', 'EN', '', '01723288847', 'ahashanur@bpo.genuitysystems.com', '0124', '', '', '8bb337ac38ff08db8aaeb769f23877516f5d035c879bc1ff15cd84eb2c43a5a5', '47138', 'A', 'Y', '1111682394853', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1112', 'Fardin', 'F635', 'Mir Fardin', '', 'BN', 'EN', '', '01627209707', 'fardin@bpo.genuitysystems.com', '0124', '', '', '40e62e838b34cd67cefec4c7d34aafaa26ec79cd3ce91e47bfd8463e4cf60290', '75631', 'A', 'Y', '1112682739777', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1113', 'Munia', 'M500', 'Nusrat Jahan Munia', '', 'BN', 'EN', '', '0174880791', 'munia@bpo.genuitysystems.com', '0124', '', '106', '0426353b09d87caef4047b5a066c3ee6d22631881b9ffa68bbbca4be4bf5de58', '36310', 'A', 'Y', '1113682822551', '', '', 'fb9fe6a2', '', 'AA', '192.168.70.20', '19802', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1114', 'Diproami', 'D165', 'Diproami Majumder', '', 'BN', 'EN', '', '1779993794', 'diproami@bpo.genuitysystems.com', '0124', '', '109', '72622bb9cef6019ff70abe2ed20f5ab617b037c70b6509265849ca9de3bd259b', '81073', 'A', 'Y', '1114682826144', '', '', '812568d7', '', 'AA', '192.168.70.20', '20801', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1116', 'Tammim', 'T550', 'Tammim Rahman Rudro', '', 'BN', 'EN', '', '01994746465', 'tammim@bpo.genuitysystems.com', '0124', '', '', '5322d37c6fa2c4fe64ec1606d0afbb5cd8c63a816bc5cd0f015a0afa9d05589a', '45068', 'A', 'N', '1116675220297', '', '', '', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1117', 'Marzan', 'M625', 'Mubashirullah Marzan', '', 'BN', 'EN', '', '01615721922', 'marzan@bpo.genuitysystems.com', '0124', '', '', '890b111f97c5f8562ec5d34dea3809cfc2c35ee2db5fa1ae477d758870cd102c', '26665', 'A', 'N', '1117680838635', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1118', 'Rumpa', 'R510', 'Sadia Haque Rumpa', '', 'BN', 'EN', '', '01531718443', 'rumpa@bpo.genuitysystems.com', '0124', '', '108', 'a951570da12ece31f195b77396597c3d53e0612f347f7e08d29b8ce4bec90874', '59345', 'A', 'Y', '1118682819626', '', '', '2b73f5fb', '', 'AA', '192.168.70.20', '54392', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1119', 'Eti', 'E300', 'Mahmuda Akter Eti', '', 'BN', 'EN', '', '01638090268', 'eti@bpo.genuitysystems.com', '0124', '', '', '57f091372d8c70dda79cf61e42131670686d9fda0d622135857b64c2b807035d', '86567', 'A', 'N', '1119681271960', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1120', 'Jarin', 'J650', 'Sayeeda Chowdhury Jarin', '', 'BN', 'EN', '', '01642950098', 'jarin@bpo.genuitysystems.com', '0124', '', '113', 'bf94202c611cd6f8b0c26abd7c39e7d3e575dfac1462c502bf5b3e4862c13474', '25387', 'A', 'Y', '1120682829684', '', '', 'a7cc7cdb', '', 'AA', '192.168.70.20', '55524', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1122', 'Dilshad', 'D423', 'Tamanna Dilshad', '', 'BN', 'EN', '', '01919861329', 'dilshad@bpo.genuitysystems.com', '0124', '', '117', 'a36df78c585ad902f5a7317c72c15604ec463092275285a198b1f8d867568bcb', '92978', 'A', 'Y', '1122682829840', '', '', '4e5e2746', '', 'AA', '192.168.70.20', '42355', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1123', 'Pranto', 'P653', 'Aminul Islam Pranto', '', 'BN', 'EN', '', '', 'pranto@bpo.genuitysystems.com', '0226', '', '', '8279a3bd2d9b103bee72809ed13ec3c4dcac1592f6dabc214c189285d9e1ba13', '45770', 'A', 'N', '1123677814224', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1124', 'Muna', 'M500', 'Khairun Nahar', '', 'BN', 'EN', '', '', 'rootmuna@bpo.genuitysystems.com', '0226', '', '', '299e5e0cbfe96ecf6caaf5c8d01f8244c66df123b24a5f0fe5f158d6bd277c6b', '43616', 'A', 'N', '1124680665929', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1125', 'Meem', 'M500', 'Mehjebin Meem', '', 'BN', 'EN', '', '', 'meem@bpo.genuitysystems.com', '0226', '', '', '655b34d26773649ef483288364252ddbf4af087f86bb37d13325ef016a687787', '58431', 'A', 'N', '1125681265029', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1126', 'Kamal', 'K540', 'MD. Mostofa Kamal', '', 'BN', 'EN', '', '', 'kamal@bpo.genuitysystems.com', '0226', '', '', '9e34b855bb01d1773ef193fcc3b590f3e401b39a398b28f75171dcab16a66050', '38065', 'A', 'Y', '1126682754022', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1127', 'Zisan', 'Z250', 'Fardin Mushfik', '', 'BN', 'EN', '', '', 'zisan@bpo.genuitysystems.com', '0226', '', '', '3fa9a965b7208c981ee3a5236f1ef1d80994d2c0db6739d4c7b15bb405fa2eb0', '49625', 'A', 'Y', '1127682754772', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1128', 'Khairul', 'K640', 'Khairul Bari Tuhin', '', 'BN', 'EN', '', '', 'khairul@bpo.genuitysystems.com', '0226', '', '', '9ffd2a607c79303b29cc8448ac11415daf4204b896bf479ba2b5db64b21f219b', '16083', 'A', 'Y', '1128682757759', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1129', 'Tamim', 'T550', 'Rahmat Ullah Tamim', '', 'BN', 'EN', '', '', 'tamim@bpo.genuitysystems.com', '0226', '', '', '0874c3fdd650a489523a89d4e56e034a2962371e94adb9db302fed079d079070', '22957', 'A', 'Y', '1129682758025', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1130', 'Israt', 'I263', 'Israt Jahan', '', 'BN', 'EN', '', '', 'israt.jahan@bpo.genuitysystems.com', '0226', '', '', 'deda4e28a59a617d20166e634fb1158e7c4959ee9c0ecb1071ef23849cbfb114', '21982', 'A', 'N', '1130677814196', '', '', '', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1131', 'Uddin', 'U350', 'Md. Shehab Uddin', '', 'BN', 'EN', '', '', 'uddin@bpo.genuitysystems.com', '0226', '', '', 'f09e8feb272c4857f9204bf1f9a99950b7f6951684653aa4010ab274c5cfa392', '91047', 'A', 'Y', '1131682761243', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1132', 'Arifin', 'A615', 'Jawad Bin Arifin Khan', '', 'BN', 'EN', '', '', 'arifin@bpo.genuitysystems.com', '0226', '', '', 'bbb5a560d00275fc17622b1f9319627127f0a34f944314b24fae41fd14236a9b', '78968', 'A', 'Y', '1132682764953', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1133', 'Israk', 'I262', 'Md. Atik Israk', '', 'BN', 'EN', '', '', 'israk@bpo.genuitysystems.com', '0226', '', '', '685982ff65f8662fe77a468b963b7bbacb2e68faaf2139071fc32c566c2cb291', '88738', 'A', 'N', '1133677736770', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1134', 'Ador', 'A360', 'Md. Mujahid Hossain Ador', '', 'BN', 'EN', '', '1736995047', 'ador@bpo.genuitysystems.com', '0402', '', '120', 'a84b0beb9d21da0778240db626b49af19da23064aa2144de973ff63b866c98cd', '98283', 'A', 'Y', '1134682840615', '', '', '359b70b1', '', 'AA', '192.168.70.20', '4561', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1135', 'Mabia', 'M100', 'Mabia Jahan Jarin', '', 'BN', 'EN', '', '1830752899', 'mabia@bpo.genuitysystems.com', '0402', '', '107', 'cd2c475535ccc9a934b86c04d7a1d2551ff11eb7b59a95ff5e035dd9fb96e07b', '56062', 'A', 'Y', '1135682823785', '', '', '33870fc1', '', 'AA', '192.168.70.20', '21272', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1136', 'Any', 'A500', 'Ekramunnesa Any', '', 'BN', 'EN', '', '1784349585', 'any@bpo.genuitysystems.com', '0402', '', '105', 'b178126a257b2e28d4b8e57c8e991c6ceaa9411d740f5ce579976475f548694c', '50835', 'A', 'Y', '1136682826539', '', '', '0f0c7d51', '', 'AA', '192.168.70.20', '20270', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1137', 'Oyon', 'O500', 'Nurmohammad Oyon', '', 'BN', 'EN', '', '1980850398', 'oyon@bpo.genuitysystems.com', '0402', '', '111', '7cc587144af3f1fee5aa85960f7e1d67fe07c5ca67420e34e31cf7268f01414b', '18964', 'A', 'Y', '1137682829644', '', '', '13aafee8', '', 'AA', '192.168.70.20', '27067', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1138', 'Apu', 'A100', 'Rafiquzzaman Apu', '', 'BN', 'EN', '', '1871534977', 'apu@bpo.genuitysystems.com', '0402', '', '', '5ca0f68a2cfb47c05a6fac53da1f2411a95c378d3b18e64fcd9439bf9ddc2967', '91701', 'A', 'N', '1138680755512', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1139', 'R.Rahman', 'R550', 'Sakib R Rahman', '', 'BN', 'EN', '', '1737211564', 'r.rahman@bpo.genuitysystems.com', '0402', '', '', '293d8a25f25debcd8fcf17c100c3fcd87967155e94a2601c9df43464866ecef0', '33458', 'A', 'N', '1139680425261', '', '', 'f213b4d1', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1140', 'Hossen', 'H250', 'MD. Masud Hossen', '', 'BN', 'EN', '', '1313509002', 'hossen@bpo.genuitysystems.com', '0402', '', '', '7dac2a507fc5503fa2f3c4943d036260cdbd0c932830c1b1eec52ee24c03f3af', '74741', 'A', 'Y', '1140682656925', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1141', 'Afridi', 'A163', 'Afridi Khan Chowdhury', '', 'BN', 'EN', '', '1777004800', 'afridi@bpo.genuitysystems.com', '0402', '', '110', '25383af046705a34e88d8f034cd1e64b39bef467d41c981313fe6b99f870b47f', '84823', 'A', 'Y', '1141682826608', '', '', '284f2b34', '', 'AA', '192.168.70.20', '28789', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1142', 'Shifa', 'S100', 'MST. Anjuman Ara Shifa', '', 'BN', 'EN', '', '1721268217', 'shifa@bpo.genuitysystems.com', '0402', '', '', 'e2fa724d29c2b99ed613c77fecff3399c75eabb7a92d4b1c8779214e9b417e8d', '47103', 'A', 'N', '1142680503087', '', '', '2354c266', '62511', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1143', 'Mimi', 'M500', 'Afsana Mimi Hena', '', 'BN', 'EN', '', '1793735566', 'mimi@bpo.genuitysystems.com', '0402', '', '', 'f3e79e0aaeb8ebe285459a8db5f451871255a1847b30183ff2ca75ebc533b823', '73319', 'A', 'N', '1143680589614', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1144', 'Athoy', 'A300', 'Athoy Ranjon Das', '', 'BN', 'EN', '', '1793611611', 'athoy@bpo.genuitysystems.com', '0402', '', '125', '15f90915a2992b7a39d2af4ca4519b495209ff57db7d9904f295ead3dd5eb793', '58384', 'A', 'Y', '1144682841513', '', '', '69407dae', '', 'AA', '192.168.70.20', '35843', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1145', 'Istiak', 'I232', 'Istiak Islam', '', 'BN', 'EN', '', '1791748954', 'istiak@bpo.genuitysystems.com', '0402', '', '', 'cfa0de0df033a2836869506ea5d1d82096407b4dcc421662ece6c7bdda29d407', '38800', 'A', 'Y', '1145682757823', '', '', '', '', 'AA', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('1146', 'Selina', 'S450', 'Fatema Akter Selina', '', 'BN', 'EN', '', '1315635710', 'selina@bpo.genuitysystems.com', '0402', '', '', 'c37dffcd41ff349b8fa4b306e0c40e641490a7856b52926186841bbbc1b759ae', '10121', 'A', 'N', '1146681436730', '', '', '', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('2009', 'noctest', 'N232', 'gplexnoctest', '', 'BN', 'EN', '', '1721292194', 'nidhi@bpo.genuitysystems.com', '0829', '', '', '2b682aca274cdfffd98c852100e5abc57de0be2dabd30e24a31aeb822bbd152b', '14145', 'A', 'Y', '2009664786336', '', '', '0f57f538', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('2011', 'Nazma', 'N250', 'Nazma Sultana Bristy', '', 'BN', 'EN', '', '', '', '0907', '', '', 'fa534b2ad8bf7c6e5d8cca093d5666defb4b0350c686e2ef025f1e51fc0c2e4f', '62756', 'A', 'N', '2011677378767', '', '', '95907ddc', '', '', '', '', 0, 0, '', '1001', '1669780047', 'Y', 'Y', '', '', NULL, ''),
('2012', 'Robin', 'R150', 'Md Robin Chowdhury', '', 'BN', 'EN', '', '1521555817', 'robin@bpo.genuitysystems.com', '1030', '', '', '61deaf486a93bd748c8d729148ef5e7d76de11cb770849f0c63054a250a256c6', '56031', 'A', 'Y', '2012682759860', '', '', '3bb91653', '', 'AA', '', '', 0, 0, '', '', '1669780047', 'Y', 'Y', '', '', NULL, ''),
('2014', 'Rudra', 'R360', 'Rajib Al Rudra', '', 'BN', 'EN', '', '1977766989', 'rudra@bpo.genuitysystems.com', '1030', '', '', 'a1eb8b36205ff7e6b310969bb67e013c55b2e484fe965517b43e2b559ef3c48f', '83923', 'A', 'N', '2014675764496', '', '', '', '', '', '', '', 0, 0, '', '', '1669780047', 'Y', 'Y', '', '', NULL, ''),
('2015', 'Rahat', 'R300', 'MD Shahbaj Uddin Rahat', '', 'BN', 'EN', '', '1730477521', 'rahat@bpo.genuitysystems.com', '0402', '', '126', 'cf4de7cfbccb28e65a0eb625eec3bee03db7cf6c3524ed7f98be8035bdabc418', '41556', 'A', 'Y', '2015682821876', '', '', '40377c5c', '', 'AA', '192.168.70.20', '47494', 0, 0, '', '', '1669780047', 'Y', 'N', '', '', NULL, ''),
('2222', '', '', 'Demo 1', '', 'EN', '', '', '', '', '0814', '', '', 'c3d6c127f3c3f5e478a90ed3e973c9db57a35ad1a0293a0c9396f9829441743c', '45939', 'A', 'Y', '', '', '', '', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('5001', 'Shazia', 'S200', 'Shazia Afrin', '', 'BN', 'EN', '', '', '', '0328', '', '', '6980f677f430dfe0ce4d9cf07e529809824630101329016ecdb248aac18a2964', '63987', 'S', 'Y', '5001673003098', '', '', 'fe561d9f', '42989', '', '', '', 0, 0, '', '', '1594295212', 'Y', 'Y', '', '', NULL, ''),
('5004', 'Jannatul', 'J534', 'Jannatul Ferdaus', '', 'BN', 'EN', '', '', '', '0901', '', '', 'c77c2e2fac02153d216352b5870f3a31a1a13132fcc2a1c3ada7e125891fdcec', '38736', 'S', 'Y', '', '', '', '3fb45637', '41887', '', '', '', 0, 0, '', '', '1662049108', 'Y', 'Y', '', '', NULL, ''),
('5005', 'Abdullah', 'A134', 'Abdullah', '', 'BN', 'EN', '', '', '', '0901', '', '', '6209d1761f2213794dea5a27f8d43da3befd76a292c7571e6a2453c8d227844a', '26341', 'S', 'Y', '', '', '', '55dc5799', '', '', '', '', 0, 0, '', '', '1662049108', 'Y', 'Y', '', '', NULL, ''),
('6005', 'Agent 2', 'A253', 'Agent 2', '', 'EN', 'BN', '', '', '', '0328', '', '', '2e5fec7dfdebbf156dea0b40c9e4aa184f69ebd1520b3b9c1033eab16da6ecd3', '64419', 'A', 'Y', '', '', '', '109b8529', '', '', '', '', 0, 0, '', '5001', '1563795287', 'Y', 'Y', '', '', NULL, ''),
('6006', 'Agent 3', 'A253', 'Agent 3', '', 'EN', 'BN', '', '', '', '0327', '', '', '9f5a3a40c0ccff6c64df9ceba82f319db0d994d53686c6103c47ce2e82ec6ad1', '83334', 'A', 'Y', '6006649836831', '', '', '4854ddac', '87354', 'AB', '', '', 3, 3, '', '1002', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('6007', 'Afroza', 'A162', 'Rahima', '', 'BN', 'EN', '', '', '1003', '0330', '', '', 'f4ca9370669ba737dcc41473060f3da0b0e0fb3d8ff2b8889c54ccfbd3790ec8', '44593', 'A', 'Y', '', '', '', '', '', '', '', '', 0, 0, '', '1002', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('6008', '', '', 'Anika', '', 'EN', '', '', '', '', '0331', '', '', 'd8fe2990891b395a5b9ca0313876fa95ddb0800df8d59813eec88ff0e3c4f47c', '41930', 'A', 'Y', '', '', '', '', '', '', '', '', 0, 0, '', '1002', '1538388714', 'Y', 'Y', '', '', NULL, ''),
('8001', 'ShopUp-1', 'S110', 'ShopUp Governance', '', 'BN', 'EN', '', '', '', '', '', '', '4b997463b4a60acb69cd2ac63b86d36545337ab485b3fc2f765b645bf04412d0', '25694', 'P', 'Y', '', '', '', '6c0f4cb9', '', '', '', '', 0, 0, '', '', '1663146836', 'Y', 'N', '', '', NULL, ''),
('8501', 'Zinia', 'Z500', 'Zinia Shabnam', '', 'BN', 'EN', '', '1325072367', 'zinia@shopup.org', '0916', '', '', '20cc457ef3bbd5052e76f94f717fd2b4040efa7364c5ee5b9d3acc627cc3ff72', '75286', 'P', 'Y', '', '', '', 'bad14a38', '', '', '', '', 0, 0, '', '', '1663326143', 'Y', 'N', '', '', NULL, ''),
('8502', 'Maruf', 'M610', 'Md. Maruf Hasan', '', 'BN', 'EN', '', '1934451127', 'maruf.hasan@shopup.org', '0916', '', '', '9051c6eddacd7a14fd90d2f06f37acfc3da0b69e9bf9e797e960bf089cbe425e', '10900', 'P', 'Y', '', '', '', '08e81dd1', '', '', '', '', 0, 0, '', '', '1663326143', 'Y', 'N', '', '', NULL, ''),
('8551', 'Rashedul', 'R234', 'Md. Rashedul Islam', '', 'BN', 'EN', '', '1611060708', 'mdrashedul@shopup.org', '0916', '', '', '11caed793eb069882a66773f90f71e7ac993aaee20b71eb59c3c853797bc2664', '39718', 'P', 'Y', '', '', '', '3bf9e66e', '', '', '', '', 0, 0, '', '', '1663326172', 'Y', 'N', '', '', NULL, ''),
('8552', 'Moin', 'M500', 'Mohammad Moin Udden', '', 'BN', 'EN', '', '1321204721', 'moin.udden@shopup.org', '0916', '', '', 'ad9af0a6a4bdac61c0adae6d0cd06f15d1f63f9ec4a497a0ffb389ca9298f103', '16458', 'P', 'Y', '', '', '', '6e3b818d', '', '', '', '', 0, 0, '', '', '1663326172', 'Y', 'Y', '', '', NULL, ''),
('8553', 'Novera', 'N160', 'Novera Tasnuba Aura', '', 'BN', 'EN', '', '01796581246', 'novera.aura@shopup.org', '1002', '', '', '997b30061d8b30c4c95a9cb812119b6c150381eee2cae90e5fd81e815a84d6ad', '47190', 'P', 'Y', '', '', '', '8bdd27b2', '', '', '', '', 0, 0, '', '', '1663326172', 'Y', 'N', '', '', NULL, ''),
('8554', 'Faiyaz', 'F200', 'Naqib Muhammad Faiyaz', '', 'BN', 'EN', '', '01711086216', 'naqib@shopf.co', '1002', '', '', '7d736f54c65f8f8433cd3bba0c09b693325e68d9a6da82d85841f4459617bc68', '67319', 'P', 'Y', '', '', '', '07a980a5', '', '', '', '', 0, 0, '', '', '1663326172', 'Y', 'N', '', '', NULL, ''),
('8601', 'Sufi', 'S100', 'Mahmood Sufi', '', 'BN', 'EN', '', '1729209880', 'mahmood.sufi@shopup.org', '0916', '', '', 'ab2852cb931a878031caa620786f5d6d57c406b3ab0a3f6a8c8dcb3666cd5e68', '58830', 'S', 'Y', '', '', '', '31158ac9', '', '', '', '', 0, 0, '', '', '1663146836', 'Y', 'N', '', '', NULL, ''),
('9001', 'NOC', 'N200', 'gPlextest', '', 'BN', 'EN', '', '', '', '0405', '', '', 'cbb29c50b42eb503039e12849f492e6e78a6dbf4f8cc5dbd063c6e4ab0dc4122', '47970', 'A', 'Y', '9001681361613', '', '', '796234d6', '46389', '', '', '', 1, 1, '', '', '1530772919', 'N', 'Y', '', '', NULL, ''),
('9002', 'Dashboard', 'D216', 'gplexsuper', '', 'BN', 'EN', '', '', '', '0405', '', '', '8dc206138cb4dcfd436662ec148793ebcf9f5045107b130bf295331f4d83a57c', '25588', 'S', 'Y', '9002681124704', '', '', 'a3999d50', '', 'AC', '', '', 0, 0, '', '', '1530773743', 'Y', 'Y', '', '', NULL, ''),
('9003', 'vdtest1', 'V323', 'VDTEST-1', '', 'BN', 'BN', '', '', '', '0831', '', '', 'de3fe9ab12a7540f89c2addb74d9e811ed961b1956d7bc93302c29a1563c1175', '92811', 'A', 'Y', '9003677497986', '', '', '90471800', '41764', 'AC', '', '', 0, 0, '', '', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('9004', 'vdtest2', 'V323', 'VDTEST-2', '', 'BN', 'EN', '', '', '', '0915', '', '', '97fe1f4d75b724125e53ac694c6f701e10e91993d024741dd67697c970618787', '39381', 'A', 'Y', '9004682836890', '', '', '', '', '', '', '', 0, 0, '', '5004', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('9005', 'vdtest3', 'V323', 'VDTEST-3', '', 'BN', 'EN', '', '', '', '0916', '', '', 'bb2d88452fabbe3f08e2c24fe731fd4b386a7f8a4fa521752cb79d94806c79f6', '17419', 'A', 'Y', '', '', '', '07248a7c', '', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'N', '', '', NULL, ''),
('9006', 'vdtest4', 'V323', 'VDTEST-4', '', 'BN', 'EN', '', '', '', '0916', '', '', '8899c3c3914bade69337a5d7b5b5c31572d4bb09b95ba0ebde8d48b75131d10f', '71893', 'A', 'Y', '', '', '', 'ff717ec9', '64008', '', '', '', 0, 0, '', '', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('9007', 'vdtest5', 'V323', 'VDTEST-5', '', 'BN', 'EN', '', '', '', '0918', '', '', '7179d1b30e90d95768522f10089fea93751aa41626eff436ef19c6346c44e557', '55257', 'A', 'Y', '9007677591245', '', '', 'a65fa320', '23031', 'AC', '', '', 0, 0, '', '', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('9009', 'Dashboard', 'D216', 'Dashboard', '', 'EN', '', '', '', '', '1007', '', '', 'bfdf0e034244f68804ef57abdf039f61097cd4d3f6b80575dba04d480b3f821f', '93100', 'S', 'Y', '', '', '', '30219ed0', '', '', '', '', 0, 0, '', '', '1665487939', 'Y', 'N', '', '', NULL, ''),
('9019', 'gpnc', 'G152', 'gplexnoc', '', 'BN', 'EN', '', '', '', '0926', '', '', 'd8f3ed79d1896d460ce9560b22b212f303f73cefb2ba29d1ce11d46a2f2a5557', '26194', 'A', 'Y', '', '', '', 'ae615f80', '38598', '', '', '', 0, 0, '', '1003', '1530772919', 'Y', 'Y', '', '', NULL, ''),
('9020', 'US', '', 'VDI Test US', '', 'BN', 'EN', '', '', '', '', '', '', '3ede8e6553cb9b55aa7d841dc34c6b87ec4995784e4f30d8a867f1886f10b054', '', 'A', 'Y', '', '', '', '', '', '', '', '', 0, 0, '', '', '1530772919', '', '', '', '', NULL, ''),
('root', 'Root', '', 'Root', '', 'EN', '', '', '', '', '', '', '', '34f393511ba56256575e1f5c7bb12400a3ad4794ce1b905870edf20ae9dc0768', 'roott', 'R', 'Y', '', '', '', 'ab83f39f', '', '', '', '', 0, 0, '', '', '1530771846', '', '', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2023_09_18_043755_create_agents_table', 1),
(6, '2014_10_12_000000_create_users_table', 2),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(9, '0000_00_00_000000_create_websockets_statistics_entries_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '575cd640f0106d4a67be7c471bb70ebae8579eef0e7f8b6ff1f082db728c1ede', '[\"role:admin\"]', NULL, '2023-09-19 02:19:32', '2023-09-19 02:19:32'),
(2, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'cabcc7970711e5975eaf012f552c408fe6a5e80e8246be008314b7bc6cd40fe6', '[\"role:admin\"]', NULL, '2023-09-19 02:23:08', '2023-09-19 02:23:08'),
(3, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'be1e3a2654f1f775d09f97e95c16c3263d8a7ac680a336e1004bdc4589b298d8', '[\"role:admin\"]', NULL, '2023-09-19 02:27:12', '2023-09-19 02:27:12'),
(4, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'dc890ea7bb846887c3ca7def4da4255ec18eaeb932e029ad9a5fd332ff52f89c', '[\"role:admin\"]', NULL, '2023-09-19 03:12:57', '2023-09-19 03:12:57'),
(5, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'd4c7e44fb519332fa4592f1b8156de1597480fd7ca89c44b2a32649cfe87b5a8', '[\"role:admin\"]', NULL, '2023-09-19 04:03:33', '2023-09-19 04:03:33'),
(6, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'fbb696543d700705ad866acb452286f005856f62dd25b3d81ea691808d5f676e', '[\"role:admin\"]', NULL, '2023-09-19 04:24:01', '2023-09-19 04:24:01'),
(7, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '87b9c30ba05eebbc330023242c1b4d97ca6fe4f3d355bb010e427554118b9932', '[\"role:admin\"]', NULL, '2023-09-19 04:25:32', '2023-09-19 04:25:32'),
(8, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '8ec5d2c4f4b367c8965fe06f9ab198c3c22e4a5ddbe27589602b2d96451eef21', '[\"role:admin\"]', NULL, '2023-09-19 04:29:00', '2023-09-19 04:29:00'),
(9, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'b2016aa8c86c3d7840d7329a10fb203831ab3dc643324bbfc5770986294ea2b3', '[\"role:admin\"]', NULL, '2023-09-19 04:29:16', '2023-09-19 04:29:16'),
(10, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '5cda97b26ee9a836f18ae9aa452d952b158b81edff8839e738071d0d179ffeeb', '[\"role:admin\"]', NULL, '2023-09-19 04:30:30', '2023-09-19 04:30:30'),
(11, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'f11d64aeaa077b34107c9e0ef23bda2d983f115173922153f5944c0a2a513576', '[\"role:admin\"]', NULL, '2023-09-19 04:31:09', '2023-09-19 04:31:09'),
(12, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '1ed63e02ac946ef3a2bc7b056fb61127f86b953b14d1d75b7646469be5ecb816', '[\"role:admin\"]', NULL, '2023-09-19 05:26:16', '2023-09-19 05:26:16'),
(13, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'de96b579b1b15e9282cfa939cd87a5ac4d8cefd1c7452a146dae8fcab0cfbc5e', '[\"role:admin\"]', NULL, '2023-09-19 21:58:44', '2023-09-19 21:58:44'),
(14, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '1005be2b5e4f507e074b3e1069b5b78c35c9ada7a6fb1aad2f6481dcb44f9086', '[\"role:admin\"]', NULL, '2023-09-19 22:32:18', '2023-09-19 22:32:18'),
(15, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'e5fc84e04759c15859fef64a18a99342d869d22e3be013141f3acde69ef52318', '[\"role:admin\"]', NULL, '2023-09-19 22:36:02', '2023-09-19 22:36:02'),
(16, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '926ee76aa732738e97b36728ca3f7f53ff578e3a6376ff5a9f23396d4a20384b', '[\"role:admin\"]', NULL, '2023-09-19 22:37:09', '2023-09-19 22:37:09'),
(17, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '8186e02868766845ed8791d2c5523a73849ce3c0d125d972e61d6b0bc266ce66', '[\"role:admin\"]', NULL, '2023-09-19 23:02:26', '2023-09-19 23:02:26'),
(18, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'ddd3565d51af5b3b55466e83d0d5c03213038fce00e6f5cb5b4281600ac4cc09', '[\"role:admin\"]', NULL, '2023-09-19 23:30:51', '2023-09-19 23:30:51'),
(19, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '6fc697e174bee34f789476cbb3ec1895081c58fbba39e1e8e91d0f229e7927f6', '[\"role:admin\"]', NULL, '2023-09-19 23:33:27', '2023-09-19 23:33:27'),
(20, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'cb9e5f31cbac64c686f37c9980b955df9b89d987c906bc51d7afad07c1d48e99', '[\"role:admin\"]', NULL, '2023-09-19 23:57:04', '2023-09-19 23:57:04'),
(21, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '58e317150fc5c0baff9d85e47344b54ea7f51e267725f9a06e115eca668ae2f7', '[\"role:admin\"]', NULL, '2023-09-19 23:57:26', '2023-09-19 23:57:26'),
(22, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '89a74eb73f3698aa03e1d2db2ada1847e6afb5074be6f6a0846d02fde857bcbc', '[\"role:admin\"]', NULL, '2023-09-20 04:08:38', '2023-09-20 04:08:38'),
(23, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'dae883dcad9d218ecfa82441e172c5890ab58e4f06aa233e26a70e3a39fa3e01', '[\"role:admin\"]', NULL, '2023-09-20 05:31:28', '2023-09-20 05:31:28'),
(24, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '0048951ded8c309e85138af39122e622c866646b4e772d74729b91884ac02e83', '[\"role:admin\"]', NULL, '2023-09-21 00:12:39', '2023-09-21 00:12:39'),
(25, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'f879c7b31a3119ccf3b7c4e09688eefb0ebffa9c64efd52051dcc5b99a3975dc', '[\"role:admin\"]', '2023-10-05 00:30:30', '2023-09-21 00:12:58', '2023-10-05 00:30:30'),
(26, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '2c4bb6ce2f6caa51773ec052bd068259e7c45608c2b18ac5c558849ee5e62ebe', '[\"role:admin\"]', NULL, '2023-09-21 01:47:51', '2023-09-21 01:47:51'),
(27, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'a36a18924bd85b377f583c05803041ce089494a1624e58be9974788a51f8014c', '[\"role:admin\"]', NULL, '2023-09-21 05:33:48', '2023-09-21 05:33:48'),
(28, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '5990d5c13b6cb7e4bc9beded5721e44b907e77c2b5b0b47dc018d43cdf522121', '[\"role:admin\"]', NULL, '2023-09-23 22:06:33', '2023-09-23 22:06:33'),
(29, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'd509ad5423822400821e68f64057d71b89108815eb58cb394a8ec7ab58529970', '[\"role:admin\"]', NULL, '2023-09-23 22:08:33', '2023-09-23 22:08:33'),
(30, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '942e2b87582ccf232d464c69b3feed0072cd08802febf5fe761ef4f95f0cbbd2', '[\"role:admin\"]', NULL, '2023-09-23 22:29:23', '2023-09-23 22:29:23'),
(31, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '10639dc550bf4dc4725b159308f9e167c8a26002fb9dcd6973f093ccd3f1098f', '[\"role:admin\"]', NULL, '2023-09-23 22:36:03', '2023-09-23 22:36:03'),
(32, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '3cdfbf516cd962c6068a0edbf837cb4c807b8c33ee1a7bb69363df245fba19e0', '[\"role:admin\"]', NULL, '2023-09-24 00:51:06', '2023-09-24 00:51:06'),
(33, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '4a75906e59cf82b5dc1f65ad4dace91e79ffd5c99bcf754fed407e161c199f69', '[\"role:admin\"]', NULL, '2023-09-24 02:13:00', '2023-09-24 02:13:00'),
(34, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '3593e4059301956ab83a6b0f6269d079eb66b10dc9a16504bbf8d1df52f09993', '[\"role:admin\"]', NULL, '2023-09-24 02:59:20', '2023-09-24 02:59:20'),
(35, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '5c28851647d56fa74e6ba19cfff1c2b4c9e90d5a005f17ea72604dd7a33588fd', '[\"role:admin\"]', NULL, '2023-09-24 04:03:18', '2023-09-24 04:03:18'),
(36, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'cb9650d8def2f546185707ccbbfdb767cacc555ea08f84e7623f40e3c8ad4acd', '[\"role:admin\"]', NULL, '2023-09-24 04:04:19', '2023-09-24 04:04:19'),
(37, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'd9980b9b3252a3630bb569f571c1f761919efbee016c779aa89af2f7d858a05c', '[\"role:admin\"]', NULL, '2023-09-24 23:13:30', '2023-09-24 23:13:30'),
(38, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '730cb20c7806f578575c8baee45ff74a86a50da184f6d2b5367712f27ca679cc', '[\"role:admin\"]', NULL, '2023-09-25 00:11:38', '2023-09-25 00:11:38'),
(39, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'f1cbac572063480ce35f24d31ea4d00006d0cdc6415c4a65f2eb0403183529c1', '[\"role:admin\"]', NULL, '2023-09-25 21:49:40', '2023-09-25 21:49:40'),
(40, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'c723dfcadb55122c094918f2c38d93f20fc15b9c8dd77a6840469d280b132912', '[\"role:admin\"]', NULL, '2023-09-25 21:53:49', '2023-09-25 21:53:49'),
(41, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', 'c9e908154dbff07fa42ec755ee5cfce0c70defd6dab0ca895cbe5e403b098695', '[\"role:admin\"]', NULL, '2023-10-01 23:54:20', '2023-10-01 23:54:20'),
(42, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '0194b47a4c5d4b15578f6fd5a774611018eed40a465cbf3bc5768c5673e2c3be', '[\"role:admin\"]', NULL, '2023-10-02 21:31:43', '2023-10-02 21:31:43'),
(43, 'App\\Models\\User', 16831044666289, 'gplex-social-admin', '66eef228eef45e497b56a13e71be095671ba8492c352bcda922e2b4f8dd11216', '[\"role:admin\"]', NULL, '2023-10-03 23:06:00', '2023-10-03 23:06:00'),
(44, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'f07092b3b66fe8b889a3ab3edacd7410a488e6bbffa467bce96638cfc5418190', '[\"role:agent\"]', '2023-10-16 10:01:09', '2023-10-04 00:17:34', '2023-10-16 10:01:09'),
(45, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '0b24d5ff6d79a75c2ef2e6c594be557ce04b20e07658ee3ec1fc2440b91bba0a', '[\"role:agent\"]', NULL, '2023-10-04 22:39:08', '2023-10-04 22:39:08'),
(46, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '52f4d13bdac393d07692cedafb384604b0297f176501e2a511e50f309f5aa499', '[\"role:agent\"]', NULL, '2023-10-04 23:43:11', '2023-10-04 23:43:11'),
(47, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '2d582ce98e2f71ddb792ff7bfc3f3d818014c25eae44168ae22652f468f434ce', '[\"role:agent\"]', '2023-10-05 04:26:04', '2023-10-04 23:44:02', '2023-10-05 04:26:04'),
(48, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '3467d171d6739169e095ac69eda688905bb827859bbd9ebb8941f978b7705cf2', '[\"role:agent\"]', NULL, '2023-10-08 21:26:30', '2023-10-08 21:26:30'),
(49, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '95b12992ed494e737171ca16da28728a594dce952cb3e3f2b838ce5686aae8e8', '[\"role:agent\"]', '2023-10-09 04:30:09', '2023-10-08 23:02:09', '2023-10-09 04:30:09'),
(50, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'f16dbdbc474f868fb56ebce0313ff5c06120a5778a968401b47647641530a881', '[\"role:agent\"]', '2023-10-10 00:38:49', '2023-10-09 22:59:48', '2023-10-10 00:38:49'),
(51, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '4a3e79b183383c27bf0719e409f2327831845dce00666513a5c18b9eda802f13', '[\"role:agent\"]', '2023-10-10 03:07:23', '2023-10-10 00:39:09', '2023-10-10 03:07:23'),
(52, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'b13b27127a3b39498c7bc9c1006e89f42a03dc5a662be89617d23c581fe6118f', '[\"role:agent\"]', '2023-10-10 22:13:46', '2023-10-10 21:18:11', '2023-10-10 22:13:46'),
(53, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'cfe466d24db93e59a7f9f808b0981cb78da204666b26de1d65ebe2cd8f2b6ea1', '[\"role:agent\"]', '2023-10-11 04:19:32', '2023-10-10 23:21:00', '2023-10-11 04:19:32'),
(54, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '91a390e164819e5ff18251e6a0118f5e43d2da64ca7307a7d889b4454d4e7712', '[\"role:agent\"]', '2023-10-12 11:27:51', '2023-10-11 21:26:31', '2023-10-12 11:27:51'),
(55, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'b7535c0262cab3fe093c6688205276e1b646dced802ffcd38e7fbfd01a31a541', '[\"role:agent\"]', '2023-10-12 11:24:06', '2023-10-12 06:01:18', '2023-10-12 11:24:06'),
(56, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'd04252b1cad16d17f1a67b48b0d570e24cf2fa8e5c944f38a2a238d497acf69c', '[\"role:agent\"]', '2023-10-15 12:12:03', '2023-10-15 05:58:31', '2023-10-15 12:12:03'),
(57, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'af2a4aacb002a1d3fdbc001fa6328653456588475fa8dfc81abb680f21a84787', '[\"role:agent\"]', '2023-10-15 14:35:39', '2023-10-15 13:26:00', '2023-10-15 14:35:39'),
(58, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '4f7a60770cedf83019de1fd0cc7bd4cf700309f72acf85de81fa6b3a36f8d865', '[\"role:agent\"]', '2023-10-16 11:09:52', '2023-10-16 03:22:30', '2023-10-16 11:09:52'),
(59, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '1d07a2f667cd7ea962f6e179cc5f8b21e316c93c460321cd6c27c71d91a076f0', '[\"role:agent\"]', '2023-10-16 11:09:17', '2023-10-16 11:09:13', '2023-10-16 11:09:17'),
(60, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'aa70b7feb2129d0dd9595276c92fb368761622de6bf979be70538322ae6d4816', '[\"role:agent\"]', '2023-10-16 11:16:24', '2023-10-16 11:11:43', '2023-10-16 11:16:24'),
(61, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '8608621b0f513fc0cef34419e9ecf635c6f5fa303bef5cbc7954ba343bef2317', '[\"role:agent\"]', '2023-10-16 12:00:58', '2023-10-16 11:56:06', '2023-10-16 12:00:58'),
(62, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'cddc2ae6776e64bae386d0fa0e84a73f530740bb3bff9f61d9a31c31baaa5b67', '[\"role:agent\"]', '2023-10-17 06:12:12', '2023-10-17 03:39:42', '2023-10-17 06:12:12'),
(63, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '45d219d927a2c59c61fea74ea565f6d4d83bf313ce65a22f8cf170997caa9e52', '[\"role:agent\"]', '2023-10-18 09:53:52', '2023-10-18 04:25:18', '2023-10-18 09:53:52'),
(64, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '4b904c36aa2e486225397a460abe55e13217e8544902b2b16abfbd0820976281', '[\"role:agent\"]', '2023-10-19 11:33:41', '2023-10-19 03:39:45', '2023-10-19 11:33:41'),
(65, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '0b8ff025d625cccb754f28fa14aa3dbbd8e99e8b2092c5550a8579408626ead4', '[\"role:agent\"]', '2023-10-22 12:21:57', '2023-10-22 04:11:33', '2023-10-22 12:21:57'),
(66, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '743da6e65ad8b49f60f2bb6f727acbddbf15b499cc01e4b58d77896091d57321', '[\"role:agent\"]', '2023-10-23 10:56:46', '2023-10-23 05:43:41', '2023-10-23 10:56:46'),
(67, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '283968e7bd12dcc3ee828ac68cb0a2aa5d15df087cb331c2e910a84944aa48ef', '[\"role:agent\"]', '2023-10-25 10:44:21', '2023-10-25 03:27:15', '2023-10-25 10:44:21'),
(68, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'f3930576a14112a7750007cdafdee3930042d6d3c2af6d85787108abae6fcc22', '[\"role:agent\"]', '2023-10-26 11:25:25', '2023-10-26 04:18:23', '2023-10-26 11:25:25'),
(69, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '1014182a96672d9136c683f5951e8a0f88ba40a2176f8f6563e6f669d5141ddf', '[\"role:agent\"]', '2023-10-26 12:06:37', '2023-10-26 06:51:26', '2023-10-26 12:06:37'),
(70, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '1a19456485c7024b71e7d873b9ea6ab1e4955e3b31c4d30df02833ee5822aaee', '[\"role:agent\"]', '2023-10-29 03:44:11', '2023-10-29 03:44:08', '2023-10-29 03:44:11'),
(71, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'c06042ac02a18b101ca368e7eebfcd15360ab4c98df80eeee3dd7f3c182db1f5', '[\"role:agent\"]', '2023-10-29 05:17:37', '2023-10-29 03:47:56', '2023-10-29 05:17:37'),
(72, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'a418bd2bd1667872837652f7667f6be47cbdb733224d82d34893dcfb7c9ee9ff', '[\"role:agent\"]', '2023-10-29 11:25:17', '2023-10-29 05:21:04', '2023-10-29 11:25:17'),
(73, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '8a4199ba07a6182c429cf77d5a754869e05bbad0ba7825b9e0d6922577add2a6', '[\"role:agent\"]', '2023-10-29 12:20:36', '2023-10-29 09:26:20', '2023-10-29 12:20:36'),
(74, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'a34d32c1903d4cf3ba9d50808ac600bc9f781727d94d4373db2dece32b82d673', '[\"role:agent\"]', '2023-10-30 03:17:30', '2023-10-30 03:13:57', '2023-10-30 03:17:30'),
(75, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '0f018fe412f294fc4343af14177ddabe49299ac3b97996f742e0c01c43e51ca6', '[\"role:agent\"]', '2023-10-30 11:25:41', '2023-10-30 05:38:10', '2023-10-30 11:25:41'),
(76, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '1ffbfe12432402ed06d1659dc5ac9219d9348ad3fa0ba5c39cebfcd9515a0fdd', '[\"role:agent\"]', '2023-10-30 11:25:42', '2023-10-30 09:16:56', '2023-10-30 11:25:42'),
(77, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '8052b749e79f37ad898387289a78b13172d5f30ccb857fa9fdbe796458b54286', '[\"role:agent\"]', '2023-10-31 11:53:10', '2023-10-31 04:17:16', '2023-10-31 11:53:10'),
(78, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'b46b56c2d9a99f513aa17264081ae808bf4370de7a296882fa6a8194e5d0036a', '[\"role:agent\"]', '2023-10-31 09:17:57', '2023-10-31 06:34:21', '2023-10-31 09:17:57'),
(79, 'App\\Models\\Agent', 1001, 'gplex-social-agent', 'f3b1397fb9d17eda1764f0d32d15cb0ab4cd60582670b261578978701587ac12', '[\"role:agent\"]', '2023-11-01 05:46:12', '2023-11-01 03:27:40', '2023-11-01 05:46:12'),
(80, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '138d943abd63d7cb6278ab731007b1fda1cf36fad944258c7ebdbc306f6b8fe5', '[\"role:agent\"]', '2023-11-01 11:59:11', '2023-11-01 05:47:55', '2023-11-01 11:59:11'),
(81, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '73ea43c8fc5e931c60d253aa2a6dc0cf5882c94fe13278084560da995a31ff4e', '[\"role:agent\"]', '2023-11-02 08:44:03', '2023-11-02 04:22:23', '2023-11-02 08:44:03'),
(82, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '1b00a98328fdb5df49194c54aaa32dccd657e1e648893f9f1ca46b5d28bdb9f8', '[\"role:agent\"]', '2023-11-02 09:42:47', '2023-11-02 09:42:41', '2023-11-02 09:42:47'),
(83, 'App\\Models\\Agent', 1001, 'gplex-social-agent', '74da03cf874a9d94099b2a5dbae23ab1c45a48359fd7814685aadfdfaf1c4c7f', '[\"role:agent\"]', '2023-11-05 09:39:09', '2023-11-05 03:49:36', '2023-11-05 09:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `social_messages`
--

CREATE TABLE `social_messages` (
  `id` bigint NOT NULL,
  `channel_id` varchar(50) DEFAULT NULL,
  `page_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_id` char(50) DEFAULT NULL,
  `message_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `message_text` text,
  `reply_to` varchar(50) DEFAULT NULL,
  `reaction_to` varchar(50) DEFAULT NULL,
  `assign_agent` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `direction` varchar(50) DEFAULT NULL,
  `attachments` varchar(256) DEFAULT NULL,
  `session_id` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `read_status` tinyint NOT NULL DEFAULT '1',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `disposition_id` varchar(50) DEFAULT NULL,
  `disposition_by` char(10) DEFAULT NULL,
  `sms_state` enum('Queue','Assigned','Delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Queue',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `social_messages`
--

INSERT INTO `social_messages` (`id`, `channel_id`, `page_id`, `customer_id`, `message_id`, `message_text`, `reply_to`, `reaction_to`, `assign_agent`, `direction`, `attachments`, `session_id`, `read_status`, `start_time`, `end_time`, `disposition_id`, `disposition_by`, `sms_state`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', '278796022799015', '6114328811970451', 'm_aXmABJFokN-1Im9v7dvXR4yPj7RFMRr3sZf0vmH4mr__og0vhc6ii0lDMLPWDAZo66_cPyaBZqKLh-wpZIEI4w', 'hi', NULL, NULL, '1001', 'IN', '\"\"', '16991661058370849180', 0, '2023-11-05 12:35:05', NULL, NULL, NULL, 'Assigned', '2023-11-05 12:35:05', '2023-11-05 12:35:05'),
(2, 'Facebook', '278796022799015', '6114328811970451', 'm_aXmABJFokN-1Im9v7dvXR4yPj7RFMRr3sZf0vmH4mr__og0vhc6ii0lDMLPWDAZo66_cPyaBZqKLh-wpZIEI4w', 'Hello bangladesh', NULL, NULL, '1001', 'IN', '\"\"', '16991661058370849180', 0, '2023-11-05 12:35:29', NULL, NULL, NULL, 'Delivered', '2023-11-05 12:35:29', '2023-11-05 12:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User detail id.',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL COMMENT '0 => Inactive, 1 => Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
('16831044666289', 'root', '2023-05-03 00:45:03', '$2y$10$DXCK/5eFTaqWNVqeBFhtPuos8KjTeqF1si1KuNNlgkJZSmr5XwR9K', NULL, NULL, NULL, 'Ho2R4H9ri5', 1, NULL, '2033-05-10 00:45:03', '2023-05-03 00:45:03'),
('16831044666290', 'root3', '2023-05-03 00:45:03', '$2y$10$DXCK/5eFTaqWNVqeBFhtPuos8KjTeqF1si1KuNNlgkJZSmr5XwR9K', NULL, NULL, NULL, 'Ho2R4H9ri5', 1, NULL, '2023-05-03 00:45:03', '2023-05-03 00:45:03'),
('16831044666291', 'root1', '2023-05-03 00:45:03', '$2y$10$DXCK/5eFTaqWNVqeBFhtPuos8KjTeqF1si1KuNNlgkJZSmr5XwR9K', NULL, NULL, NULL, 'Ho2R4H9ri5', 1, NULL, '2023-05-03 00:45:03', '2023-05-03 00:45:03'),
('16831044666292', 'root2', '2023-05-03 00:45:03', '$2y$10$DXCK/5eFTaqWNVqeBFhtPuos8KjTeqF1si1KuNNlgkJZSmr5XwR9K', NULL, NULL, NULL, 'Ho2R4H9ri5', 1, NULL, '2023-05-03 00:45:03', '2023-05-03 00:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int NOT NULL,
  `websocket_message_count` int NOT NULL,
  `api_message_count` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `social_messages`
--
ALTER TABLE `social_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `social_messages`
--
ALTER TABLE `social_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
