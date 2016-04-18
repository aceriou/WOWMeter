SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(45) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `ip` text NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_banned` int(1) NOT NULL DEFAULT '0',
  `oldusrname` text,
  `sig_url` text,
  `sig_bg` int(1) NOT NULL DEFAULT '1',
  `sig_font` int(1) NOT NULL DEFAULT '1',
  `usrname_color` varchar(6) NOT NULL DEFAULT 'ffffff',
  `text_color` varchar(6) NOT NULL DEFAULT 'ffffff',
  `bg_color` varchar(10) NOT NULL DEFAULT 'orange',
  `new_ip` text NOT NULL,
  `password_token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `wow`;
CREATE TABLE `wow` (
  `wow_id` int(45) NOT NULL AUTO_INCREMENT,
  `wow_to` int(45) NOT NULL,
  `wow_from` varchar(45) NOT NULL,
  `wow_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wow_ref` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`wow_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
