-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.17 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.1.0.4903
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para anexmailing
CREATE DATABASE IF NOT EXISTS `anexmailing` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `anexmailing`;


-- Volcando estructura para tabla anexmailing.am_mailing
CREATE TABLE IF NOT EXISTS `am_mailing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `relation` varchar(50) NOT NULL DEFAULT '',
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla anexmailing.am_mailing: ~144,265 rows (aproximadamente)
/*!40000 ALTER TABLE `am_mailing` DISABLE KEYS */;
/*!40000 ALTER TABLE `am_mailing` ENABLE KEYS */;



-- En un comienzo se pensó trabajar con usuarios registrados en la BD, por ahora no hace falta esto porque el sistema no es muy complejo pero dejamos el script para un futuro.
-- De todos modos la autenticación mediante base de datos esta deshabilitada

-- Volcando estructura para tabla anexmailing.am_user
/*CREATE TABLE IF NOT EXISTS `am_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `nickname` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;*/

-- Volcando datos para la tabla anexmailing.am_user: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `am_user` DISABLE KEYS */;
/*INSERT INTO `am_user` (`id`, `name`, `nickname`, `email`, `password`, `last_login`, `created_at`, `updated_at`, `is_active`) VALUES
	(1, 'eduardo', 'erodriguez', 'demo@anexmailing.com', '$2y$10$hRm2Q4YqeeC6jltYwOKh8eLfsv4zwSkoteAp6Ew9/o/sYmLtOU4vi', '2016-08-10 23:36:23', '2016-07-31 12:20:43', '2016-07-31 12:20:44', 1);*/
/*!40000 ALTER TABLE `am_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
