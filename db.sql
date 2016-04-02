SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE `wow` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wow`;

CREATE TABLE `users` (
  `id` int(45) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `ip` text NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_banned` int(1) NOT NULL DEFAULT '0',
  `oldusrname` text,
  `sig_bg` int(1) NOT NULL DEFAULT '1',
  `sig_font` int(1) NOT NULL DEFAULT '1',
  `usrname_color` varchar(6) NOT NULL DEFAULT 'ffffff',
  `bg_color` varchar(10) NOT NULL DEFAULT 'orange',
  `new_ip` text NOT NULL,
  `password_token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `wow` (
  `wow_id` int(45) NOT NULL AUTO_INCREMENT,
  `wow_to` int(45) NOT NULL,
  `wow_from` varchar(45) NOT NULL,
  `wow_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wow_ref` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`wow_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `wow` (`wow_id`, `wow_to`, `wow_from`, `wow_date`, `wow_ref`) VALUES
(1, 1, '192.168.0.1', '2015-01-01 00:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
