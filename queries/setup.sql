--
-- Setup Ambrogio
--
-- Version 1.0.0
--

-- --------------------------------------------------------

SET TIME_ZONE = "+00:00";
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------

--
-- Table structure for table `ambrogio__chats`
--

CREATE TABLE IF NOT EXISTS `ambrogio__chats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telegram_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `telegram_id` (`telegram_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ambrogio__hooks`
--

CREATE TABLE IF NOT EXISTS `ambrogio__hooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `chat_title` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `request` text COLLATE utf8_unicode_ci NOT NULL,
  `response` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `chat_id` (`chat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
