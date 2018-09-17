
DROP TABLE IF EXISTS `banned`;
CREATE TABLE IF NOT EXISTS `banned` (
  `ban_name` varchar(255) NOT NULL,
  `banned` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ban_name`),
  UNIQUE KEY `name` (`ban_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cron_job`;
CREATE TABLE IF NOT EXISTS `cron_job` (
  `job` varchar(255) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`job`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `slug_2` (`slug`),
  KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;


DROP TABLE IF EXISTS `stream_group`;
CREATE TABLE IF NOT EXISTS `stream_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


DROP TABLE IF EXISTS `stream_list`;
CREATE TABLE IF NOT EXISTS `stream_list` (
  `name` varchar(255) NOT NULL,
  `display_name` text NOT NULL,
  `custom` tinyint(2) NOT NULL DEFAULT '0',
  `followers` int(10) NOT NULL,
  `views` int(10) NOT NULL,
  `status` text CHARACTER SET utf8 COLLATE utf8_hungarian_ci,
  `viewers` int(10) NOT NULL,
  `game` text,
  `large` text NOT NULL,
  `offline` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `stream_meta`;
CREATE TABLE IF NOT EXISTS `stream_meta` (
  `name` varchar(255) NOT NULL,
  `followers` int(10) NOT NULL,
  `views` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `month` int(2) NOT NULL,
  `week` int(2) NOT NULL,
  `day` int(10) NOT NULL,
  UNIQUE KEY `name` (`name`,`year`,`month`,`week`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `stream_update`;
CREATE TABLE IF NOT EXISTS `stream_update` (
  `name` varchar(255) NOT NULL,
  `online` tinyint(3) NOT NULL DEFAULT '0',
  `timecheck` int(10) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `name` (`name`,`online`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `stream_user`;
CREATE TABLE IF NOT EXISTS `stream_user` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL,
  `bio` text NOT NULL,
  `social` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;



INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', NULL, '$2y$08$Vkd89LiUfcV6/UGEO9udRu0jnXug6XG3uDi8fkiBD9e5T6WADtUIW', NULL, 'admin@admin.com', NULL, NULL, NULL, 'VHIbC3Xpfzs0lw1ygd9Cp.', 1452971941, 1452972194, 1, NULL, NULL, NULL, NULL);


CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;


INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);