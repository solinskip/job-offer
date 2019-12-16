-- -------------------------------------------------------------
-- TablePlus 2.12(282)
--
-- https://tableplus.com/
--
-- Database: job-offer
-- Generation Time: 2019-12-16 18:52:27.7320
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `responsibilities` text NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `employee_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `id_announcement` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `isRead` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_from` (`id_user_from`),
  KEY `id_user_to` (`id_user_to`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_user_from`) REFERENCES `user` (`id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`id_user_to`) REFERENCES `user` (`id`),
  CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`id_announcement`) REFERENCES `announcement` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `account_type` int(11) NOT NULL COMMENT '0: admin, 1: employer, 2: employee',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `logged_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `announcement` (`id`, `name`, `place`, `position`, `salary`, `responsibilities`, `description`, `active`, `created_at`, `created_by`) VALUES ('2', 'Programista PHP', 'Rzeszów, ul. Przemysłowa 14', 'Programista', '5000', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '2019-12-15 21:21:55', '4');
INSERT INTO `announcement` (`id`, `name`, `place`, `position`, `salary`, `responsibilities`, `description`, `active`, `created_at`, `created_by`) VALUES ('3', 'Magazynier', 'Warszawa', 'Magazynier', '2000', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '2019-12-16 01:32:08', '4');

INSERT INTO `employee_profile` (`id`, `id_user`, `name`, `surname`, `email`, `education`, `birth_date`, `courses`, `experience`, `information`, `phone`) VALUES ('2', '5', 'Janusz', 'Nowak', '234@wp.pl', 'Wykształcenie', '2019-12-20', 'Kursy', 'Doświadczenie', '', '2342342');

INSERT INTO `employer_profile` (`id`, `id_user`, `name`, `address`, `industry`, `phone`, `email`, `fax`, `information`) VALUES ('2', '4', 'Google', 'USA', 'Test', '234342342', 'wp@wp.pl', '234234234', 'Informacje');

INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `id_announcement`, `message`, `isRead`, `created_at`) VALUES ('1', '5', '4', '2', 'Treść wiadomości', '0', '2019-12-15 21:22:16');

INSERT INTO `user` (`id`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('3', 'admin', '0', '$2y$13$CnEh2Laz0uV21pfDsIvxMuVLS46xid9KL0MRTNGftxA8EvntoWMNS', '1576440771', '1576456479', '1586655279');
INSERT INTO `user` (`id`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('4', 'Pracodawca', '1', '$2y$13$1L3/nVE2xYR5lsne.VmttuJkMEN9Vc2dS99H1Vrm.QUj9.Q5Ddkxe', '1576441255', '1576456522', '1586655322');
INSERT INTO `user` (`id`, `username`, `account_type`, `password_hash`, `created_at`, `updated_at`, `logged_at`) VALUES ('5', 'Pracownik', '2', '$2y$13$NLDNyP7q9h.b2fxz0DdQQuBTf1Z6izt7nZtaP1orQpJ9GinrdkZX6', '1576441264', '1576456364', '1586655164');




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;