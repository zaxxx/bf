SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+01:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_posted` datetime NOT NULL,
  `lft` int(8) unsigned NOT NULL,
  `rgt` int(8) unsigned NOT NULL,
  `depth` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;