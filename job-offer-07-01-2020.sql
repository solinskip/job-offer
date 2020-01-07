-- -------------------------------------------------------------
-- TablePlus 2.12(282)
--
-- https://tableplus.com/
--
-- Database: job-offer
-- Generation Time: 2020-01-07 18:59:15.9630
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `announcement`;
CREATE TABLE `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `responsibilities` text NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `employee_profile`;
CREATE TABLE `employee_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `index_number` int(11) DEFAULT NULL,
  `symbol_of_year` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `education` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `courses` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `information` text DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `employee_profile_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `employer_profile`;
CREATE TABLE `employer_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fax` int(11) DEFAULT NULL,
  `information` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `employer_profile_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `guardian_profile`;
CREATE TABLE `guardian_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `guardian_profile_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `internship`;
CREATE TABLE `internship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) NOT NULL,
  `id_employer` int(11) NOT NULL,
  `id_guardian` int(11) DEFAULT NULL,
  `id_announcement` int(11) NOT NULL,
  `id_messages` int(11) NOT NULL,
  `accepted` int(11) NOT NULL DEFAULT 0,
  `isSent` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_employee` (`id_employee`),
  KEY `id_employer` (`id_employer`),
  KEY `id_announcement` (`id_announcement`),
  KEY `id_guardian` (`id_guardian`),
  KEY `id_messages` (`id_messages`),
  CONSTRAINT `internship_ibfk_3` FOREIGN KEY (`id_employee`) REFERENCES `user` (`id`),
  CONSTRAINT `internship_ibfk_4` FOREIGN KEY (`id_employer`) REFERENCES `user` (`id`),
  CONSTRAINT `internship_ibfk_5` FOREIGN KEY (`id_announcement`) REFERENCES `announcement` (`id`) ON DELETE CASCADE,
  CONSTRAINT `internship_ibfk_6` FOREIGN KEY (`id_guardian`) REFERENCES `user` (`id`),
  CONSTRAINT `internship_ibfk_7` FOREIGN KEY (`id_messages`) REFERENCES `messages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `internship_diary`;
CREATE TABLE `internship_diary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_internship` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `working_hours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_internship` (`id_internship`),
  CONSTRAINT `internship_diary_ibfk_1` FOREIGN KEY (`id_internship`) REFERENCES `internship` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `id_announcement` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `isRead` int(11) NOT NULL DEFAULT 0,
  `internshipRequest` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_from` (`id_user_from`),
  KEY `id_user_to` (`id_user_to`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_user_from`) REFERENCES `user` (`id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`id_user_to`) REFERENCES `user` (`id`),
  CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`id_announcement`) REFERENCES `announcement` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_employer` int(11) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `account_type` int(11) NOT NULL COMMENT '0: admin, 1: employer, 2: employee',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `logged_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_employer` (`id_employer`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_employer`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `announcement` (`id`, `name`, `place`, `position`, `salary`, `responsibilities`, `description`, `active`, `start_date`, `end_date`, `created_at`, `created_by`) VALUES ('2', 'Programista PHP', 'Rzeszów, ul. Przemysłowa 14', 'Programista', '5000', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '2019-12-01', '2019-12-31', '2019-12-15 21:21:55', '4');
INSERT INTO `announcement` (`id`, `name`, `place`, `position`, `salary`, `responsibilities`, `description`, `active`, `start_date`, `end_date`, `created_at`, `created_by`) VALUES ('3', 'Magazynier', 'Warszawa', 'Magazynier', '2000', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '2019-10-01', '2020-01-31', '2019-12-16 01:32:08', '4');

INSERT INTO `employee_profile` (`id`, `id_user`, `index_number`, `symbol_of_year`, `name`, `surname`, `email`, `education`, `birth_date`, `courses`, `experience`, `information`, `phone`) VALUES ('2', '5', '234', 'WS/W1', 'Janusz', 'Nowak', '234@wp.pl', 'Wykształcenie', '2019-12-20', 'Kursy', 'Doświadczenie', '', '2342342');
INSERT INTO `employee_profile` (`id`, `id_user`, `index_number`, `symbol_of_year`, `name`, `surname`, `email`, `education`, `birth_date`, `courses`, `experience`, `information`, `phone`) VALUES ('3', '13', NULL, NULL, 'Marek', 'Kowalski', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO `employer_profile` (`id`, `id_user`, `name`, `address`, `industry`, `phone`, `email`, `fax`, `information`) VALUES ('2', '4', 'Google', 'USA', 'Test', '234342342', 'wp@wp.pl', '234234234', 'Informacje');
INSERT INTO `employer_profile` (`id`, `id_user`, `name`, `address`, `industry`, `phone`, `email`, `fax`, `information`) VALUES ('3', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO `guardian_profile` (`id`, `id_user`, `name`, `surname`, `email`, `phone`) VALUES ('3', '11', 'Marek', 'Konrad', 'w@wp.pl', '24');
INSERT INTO `guardian_profile` (`id`, `id_user`, `name`, `surname`, `email`, `phone`) VALUES ('5', '14', NULL, NULL, NULL, NULL);

INSERT INTO `internship` (`id`, `id_employee`, `id_employer`, `id_guardian`, `id_announcement`, `id_messages`, `accepted`, `isSent`) VALUES ('5', '5', '4', '14', '2', '16', '1', '0');
INSERT INTO `internship` (`id`, `id_employee`, `id_employer`, `id_guardian`, `id_announcement`, `id_messages`, `accepted`, `isSent`) VALUES ('6', '13', '4', '11', '2', '18', '0', '0');
INSERT INTO `internship` (`id`, `id_employee`, `id_employer`, `id_guardian`, `id_announcement`, `id_messages`, `accepted`, `isSent`) VALUES ('7', '5', '4', '11', '3', '19', '1', '1');

INSERT INTO `internship_diary` (`id`, `id_internship`, `date`, `description`, `working_hours`) VALUES ('1', '5', '2020-01-02', 'Opis 3', '9');
INSERT INTO `internship_diary` (`id`, `id_internship`, `date`, `description`, `working_hours`) VALUES ('3', '5', '2020-01-30', 'PHP', '4');
INSERT INTO `internship_diary` (`id`, `id_internship`, `date`, `description`, `working_hours`) VALUES ('5', '7', '2020-01-30', 'Test Magazynier', '8');
INSERT INTO `internship_diary` (`id`, `id_internship`, `date`, `description`, `working_hours`) VALUES ('6', '5', '2020-02-06', 'PHP1', '3');

INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `id_announcement`, `message`, `isRead`, `internshipRequest`, `created_at`) VALUES ('14', '13', '4', '2', 'Z stażem', '1', '1', '2020-01-02 19:36:01');
INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `id_announcement`, `message`, `isRead`, `internshipRequest`, `created_at`) VALUES ('15', '5', '4', '2', 'Staż', '0', '1', '2020-01-02 22:32:00');
INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `id_announcement`, `message`, `isRead`, `internshipRequest`, `created_at`) VALUES ('16', '5', '4', '2', 'Test', '1', '1', '2020-01-02 23:33:40');
INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `id_announcement`, `message`, `isRead`, `internshipRequest`, `created_at`) VALUES ('18', '13', '4', '2', 'Staż', '1', '1', '2020-01-04 14:29:06');
INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `id_announcement`, `message`, `isRead`, `internshipRequest`, `created_at`) VALUES ('19', '5', '4', '3', 'v', '1', '1', '2020-01-04 17:11:00');

INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('3', NULL, 'admin', '0', '$2y$13$CnEh2Laz0uV21pfDsIvxMuVLS46xid9KL0MRTNGftxA8EvntoWMNS', '1576440771', '1576624733', '1591964333');
INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('4', NULL, 'Pracodawca', '1', '$2y$13$1L3/nVE2xYR5lsne.VmttuJkMEN9Vc2dS99H1Vrm.QUj9.Q5Ddkxe', '1576441255', '1578418291', '1593585091');
INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('5', NULL, 'Pracownik', '2', '$2y$13$NLDNyP7q9h.b2fxz0DdQQuBTf1Z6izt7nZtaP1orQpJ9GinrdkZX6', '1576441264', '1578418301', '1593585101');
INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('6', NULL, 'TestPracodawca', '1', '$2y$13$eTsLcaVIVyPwpmnJ/dGNdODvbdV6HpeApV4v7cZweNBte9COBZXfK', '1577708231', '1577708243', '1623460643');
INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('11', '4', 'Opiekun Pracodawcy', '3', '$2y$13$GXOOFVwkriR0CghCKZ.n4.PcuXye/3UUMer15RteqAdQlAPJ7ysBi', '1577710424', '1578418313', '1593585113');
INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('13', NULL, 'Pracownik1', '2', '$2y$13$8KERvrb0OaXRJwORm26NrexLBvbzuEui2hdCeRGMkcPkJEw4EZD6.', '1577987477', '1578340119', '1591001319');
INSERT INTO `user` (`id`, `id_employer`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('14', '4', 'Opiekun Pracodawcy 2', '3', '$2y$13$PLMK1a3Tne7c2sIjyIoS/.YrcajB7WFya6smT.6NqnlpBC5bTMaFC', '1578154333', '1578154333', NULL);




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;