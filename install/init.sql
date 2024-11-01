
CREATE TABLE IF NOT EXISTS `wp_wb_sst_broken_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) UNSIGNED DEFAULT '0',
  `check_date` datetime DEFAULT NULL,
  `code` varchar(32) DEFAULT NULL,
  `memo` text,
  `url` varchar(512) DEFAULT NULL,
  `url_md5` varchar(32) DEFAULT NULL,
  `url_type` varchar(32) DEFAULT NULL,
  `url_text` text,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `check_date` (`check_date`),
  KEY `url_md5` (`url_md5`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB ;

-- row split --

CREATE TABLE IF NOT EXISTS `wp_wb_sst_redirection_url` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` mediumtext  NOT NULL,
  `match_url` varchar(2000)  DEFAULT NULL,
  `match_data` text ,
  `regex` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `position` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_access` datetime DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `action_type` varchar(20)  NOT NULL,
  `action_code` int(11) UNSIGNED NOT NULL,
  `action_data` mediumtext ,
  `match_type` varchar(20)  NOT NULL,
  `title` text ,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB ;
