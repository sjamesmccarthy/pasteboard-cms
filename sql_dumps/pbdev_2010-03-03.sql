# Sequel Pro dump
# Version 1630
# http://code.google.com/p/sequel-pro
#
# Host: pasteboard.org (MySQL 5.0.85-community)
# Database: pbdev
# Generation Time: 2010-03-03 13:07:53 -0800
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table pb_app_registry
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_app_registry`;

CREATE TABLE `pb_app_registry` (
  `app_id` int(11) NOT NULL auto_increment,
  `app_name` varchar(255) NOT NULL,
  `app_group` int(2) NOT NULL default '0',
  `app_state` int(1) NOT NULL default '1',
  PRIMARY KEY  (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `pb_app_registry` WRITE;
/*!40000 ALTER TABLE `pb_app_registry` DISABLE KEYS */;
INSERT INTO `pb_app_registry` (`app_id`,`app_name`,`app_group`,`app_state`)
VALUES
	(1,'page',0,1);

/*!40000 ALTER TABLE `pb_app_registry` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_keywords`;

CREATE TABLE `pb_keywords` (
  `keywords_id` int(10) NOT NULL auto_increment,
  `keywords_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`keywords_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='taxonomy dictionary';



# Dump of table pb_keywords_taxonomy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_keywords_taxonomy`;

CREATE TABLE `pb_keywords_taxonomy` (
  `fk_keywords_id` int(10) NOT NULL,
  `fk_page_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='taxonomy dictionary';



# Dump of table pb_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_page`;

CREATE TABLE `pb_page` (
  `page_id` int(10) NOT NULL auto_increment,
  `fk_user_id` int(10) NOT NULL,
  `page_slug` varchar(255) default NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `page_meta_description` varchar(255) default NULL,
  `page_meta_keywords` varchar(255) default NULL,
  `page_meta_robots` varchar(255) default NULL,
  `page_meta_cache_control` varchar(255) default NULL,
  `page_meta_expires` datetime default NULL,
  `page_template` varchar(255) NOT NULL,
  `page_created` datetime NOT NULL,
  `page_modified` datetime NOT NULL,
  `page_password` varchar(64) default NULL,
  `page_status` int(1) NOT NULL default '0',
  `page_type` enum('404','MAINTENANCE','FRONT','STANDARD') NOT NULL default 'STANDARD',
  `page_lock` int(1) NOT NULL default '0',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='stores content';

LOCK TABLES `pb_page` WRITE;
/*!40000 ALTER TABLE `pb_page` DISABLE KEYS */;
INSERT INTO `pb_page` (`page_id`,`fk_user_id`,`page_slug`,`page_title`,`page_content`,`page_meta_description`,`page_meta_keywords`,`page_meta_robots`,`page_meta_cache_control`,`page_meta_expires`,`page_template`,`page_created`,`page_modified`,`page_password`,`page_status`,`page_type`,`page_lock`)
VALUES
	(1,1,'dev-example-page','Dev Example Page','<br />Welcome to the home or front page. This paragraph is being displayed from database content.','homepage desc.','home, page, cms','no-follow','no-cache','2010-03-01 12:12:34','index','2009-01-04 13:50:23','2009-01-04 13:50:23',NULL,1,'FRONT',0),
	(2,1,'dvr-review','DVR Review','<p>kismet |kizmit; -met|<br />\nnoun<br />\ndestiny; fate : what chance did I stand against kismet?</br />\nORIGIN early 19th cent.: from Turkish, from Arabic kismat division, portion, lot,\' from kasama \'to divide.\'\n</p>',NULL,NULL,NULL,NULL,NULL,'page','2009-01-07 10:30:00','2009-01-07 14:30:45','0',1,'STANDARD',0),
	(3,1,'MAINTENANCE','MAINTENANCE','<p>\nDarn the luck! The site is currently undergoing some maintenance right now. Please check back again soon.\n</p>',NULL,NULL,NULL,NULL,NULL,'page','2009-02-04 13:10:00','2009-02-04 13:10:00','0',1,'MAINTENANCE',0),
	(4,1,'PAGE-NOT-FOUND','404 PAGE NOT FOUND','<p>\nHow EXCITING! You have discovered something new, but we don\'t know what it is you are looking for. Try again.\n</p>',NULL,NULL,NULL,NULL,NULL,'page','2009-02-04 13:10:00','2009-02-04 13:10:00','0',1,'404',0);

/*!40000 ALTER TABLE `pb_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_page_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_page_history`;

CREATE TABLE `pb_page_history` (
  `page_history_id` int(10) NOT NULL auto_increment,
  `fk_user_id` int(10) NOT NULL,
  `page_history_slug` varchar(255) default NULL,
  `page_history_title` varchar(255) NOT NULL,
  `page_history_content` longtext NOT NULL,
  `page_history_meta_description` varchar(255) default NULL,
  `page_history_meta_keywords` varchar(255) default NULL,
  `page_history_meta_robots` varchar(255) default NULL,
  `page_history_meta_pragma` varchar(255) default NULL,
  `page_history_meta_expires` datetime default NULL,
  `page_history_template` varchar(255) NOT NULL,
  `page_history_created` datetime NOT NULL,
  `page_history_modified` datetime NOT NULL,
  `page_history_password` varchar(64) default NULL,
  `page_history_status` int(1) NOT NULL default '0',
  `page_history_type` enum('404','MAINTENANCE','FRONT','STANDARD') NOT NULL default 'STANDARD',
  `page_history_lock` int(1) NOT NULL default '0',
  PRIMARY KEY  (`page_history_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='stores content';

LOCK TABLES `pb_page_history` WRITE;
/*!40000 ALTER TABLE `pb_page_history` DISABLE KEYS */;
INSERT INTO `pb_page_history` (`page_history_id`,`fk_user_id`,`page_history_slug`,`page_history_title`,`page_history_content`,`page_history_meta_description`,`page_history_meta_keywords`,`page_history_meta_robots`,`page_history_meta_pragma`,`page_history_meta_expires`,`page_history_template`,`page_history_created`,`page_history_modified`,`page_history_password`,`page_history_status`,`page_history_type`,`page_history_lock`)
VALUES
	(1,1,'dev-example-page','Dev Example Page','Hellow dev.world',NULL,NULL,NULL,NULL,NULL,'home','2009-01-04 13:50:23','2009-01-04 13:50:23',NULL,1,'STANDARD',0);

/*!40000 ALTER TABLE `pb_page_history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_page_history_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_page_history_meta`;

CREATE TABLE `pb_page_history_meta` (
  `page_history_meta_id` int(10) NOT NULL auto_increment,
  `fk_page_history_id` int(10) NOT NULL,
  `page_history_meta_key` varchar(255) NOT NULL,
  `page_history_meta_value` longtext NOT NULL,
  `page_history_meta_active` int(1) NOT NULL,
  PRIMARY KEY  (`page_history_meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='history_meta data for backup';



# Dump of table pb_page_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_page_meta`;

CREATE TABLE `pb_page_meta` (
  `page_meta_id` int(10) NOT NULL auto_increment,
  `fk_page_id` int(10) NOT NULL,
  `page_meta_key` varchar(255) NOT NULL,
  `page_meta_value` longtext NOT NULL,
  `page_meta_active` int(1) NOT NULL default '0',
  PRIMARY KEY  (`page_meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='meta data for pages';



# Dump of table pb_pages_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_pages_history`;

CREATE TABLE `pb_pages_history` (
  `page_history_id` int(10) NOT NULL auto_increment,
  `fk_user_id` int(10) NOT NULL,
  `page_history_slug` varchar(255) default NULL,
  `page_history_title` varchar(255) NOT NULL,
  `page_history_content` longtext NOT NULL,
  `page_history_meta_description` varchar(255) default NULL,
  `page_history_meta_keywords` varchar(255) default NULL,
  `page_history_meta_robots` varchar(255) default NULL,
  `page_history_meta_pragma` varchar(255) default NULL,
  `page_history_meta_expires` datetime default NULL,
  `page_history_template` varchar(255) NOT NULL,
  `page_history_created` datetime NOT NULL,
  `page_history_modified` datetime NOT NULL,
  `page_history_password` varchar(64) default NULL,
  `page_history_status` int(1) NOT NULL default '0',
  `page_history_type` enum('404','MAINTENANCE','FRONT','STANDARD') NOT NULL default 'STANDARD',
  `page_history_lock` int(1) NOT NULL default '0',
  PRIMARY KEY  (`page_history_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='stores content';

LOCK TABLES `pb_pages_history` WRITE;
/*!40000 ALTER TABLE `pb_pages_history` DISABLE KEYS */;
INSERT INTO `pb_pages_history` (`page_history_id`,`fk_user_id`,`page_history_slug`,`page_history_title`,`page_history_content`,`page_history_meta_description`,`page_history_meta_keywords`,`page_history_meta_robots`,`page_history_meta_pragma`,`page_history_meta_expires`,`page_history_template`,`page_history_created`,`page_history_modified`,`page_history_password`,`page_history_status`,`page_history_type`,`page_history_lock`)
VALUES
	(1,1,'dev-example-page','Dev Example Page','Hellow dev.world',NULL,NULL,NULL,NULL,NULL,'home','2009-01-04 13:50:23','2009-01-04 13:50:23',NULL,1,'STANDARD',0);

/*!40000 ALTER TABLE `pb_pages_history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_user`;

CREATE TABLE `pb_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `fk_group_id` varchar(255) NOT NULL,
  `user_login` varchar(32) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `user_activation_key` varchar(64) NOT NULL,
  `user_registered` datetime NOT NULL,
  `user_hint` varchar(255) NOT NULL,
  `user_hint_answer` longtext NOT NULL,
  `user_status` int(1) NOT NULL,
  `user_last_login` datetime NOT NULL,
  `user_created` datetime NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='list of all users regardless of role';

LOCK TABLES `pb_user` WRITE;
/*!40000 ALTER TABLE `pb_user` DISABLE KEYS */;
INSERT INTO `pb_user` (`user_id`,`fk_group_id`,`user_login`,`user_password`,`user_email`,`user_first_name`,`user_last_name`,`user_activation_key`,`user_registered`,`user_hint`,`user_hint_answer`,`user_status`,`user_last_login`,`user_created`)
VALUES
	(1,'9','james','my4girl$','james.mccarthy@gmail.com','James','McCarthy','0000','0000-00-00 00:00:00','0','0\n',1,'2009-01-04 13:50:23','2009-01-04 13:50:23');

/*!40000 ALTER TABLE `pb_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_user_group`;

CREATE TABLE `pb_user_group` (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(255) NOT NULL,
  `group_r` int(1) NOT NULL,
  `group_w` int(1) NOT NULL,
  `group_e` int(1) NOT NULL,
  `grouo_p` int(1) NOT NULL,
  `group_b` int(1) NOT NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

LOCK TABLES `pb_user_group` WRITE;
/*!40000 ALTER TABLE `pb_user_group` DISABLE KEYS */;
INSERT INTO `pb_user_group` (`group_id`,`group_name`,`group_r`,`group_w`,`group_e`,`grouo_p`,`group_b`)
VALUES
	(1,'member',1,0,0,0,0),
	(2,'subscriber',1,0,0,0,0),
	(3,'writer',1,0,0,0,0),
	(4,'editor',1,1,1,0,0),
	(5,'publisher',1,0,0,1,0),
	(6,'sales',1,1,1,0,0),
	(7,'marketing',1,0,0,0,0),
	(8,'admin',1,1,1,1,0),
	(9,'budda',1,1,1,1,1);

/*!40000 ALTER TABLE `pb_user_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_user_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_user_meta`;

CREATE TABLE `pb_user_meta` (
  `users_meta_id` int(10) NOT NULL auto_increment,
  `fk_user_id` int(10) NOT NULL,
  `users_meta_key` varchar(255) NOT NULL,
  `users_meta_value` longtext NOT NULL,
  `users_meta_active` int(1) NOT NULL,
  PRIMARY KEY  (`users_meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='meta data for users';



# Dump of table pb_user_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_user_roles`;

CREATE TABLE `pb_user_roles` (
  `roles_id` int(10) NOT NULL auto_increment,
  `fk_user_id` int(10) NOT NULL,
  `user_roles_r` int(1) NOT NULL,
  `user_roles_w` int(1) NOT NULL,
  `user_roles_x` int(1) NOT NULL,
  `user_roles_b` int(1) NOT NULL,
  PRIMARY KEY  (`roles_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='roles and permissions for users';

LOCK TABLES `pb_user_roles` WRITE;
/*!40000 ALTER TABLE `pb_user_roles` DISABLE KEYS */;
INSERT INTO `pb_user_roles` (`roles_id`,`fk_user_id`,`user_roles_r`,`user_roles_w`,`user_roles_x`,`user_roles_b`)
VALUES
	(1,1,1,1,1,1);

/*!40000 ALTER TABLE `pb_user_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pb_user_session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pb_user_session`;

CREATE TABLE `pb_user_session` (
  `user_session_id` int(10) NOT NULL auto_increment,
  `fk_user_id` int(10) NOT NULL,
  `user_hostname` varchar(255) NOT NULL,
  `user_time_login` datetime NOT NULL,
  `user_ip` varchar(50) NOT NULL,
  PRIMARY KEY  (`user_session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='stores session data';






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
