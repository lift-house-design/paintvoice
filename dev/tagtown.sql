-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: tagtown
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(10) unsigned NOT NULL DEFAULT '1',
  `tags` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (2,'New blog post','New blog post','2014-09-30 17:53:50',1,''),(3,'Filling the Void','Four aggressive, younger builders figure out how to make money in a still-weak housing market. \n\nIn 2009, the median age of a single-family home builder was 53 years old, according to an NAHB survey of its members. And a destabilizing recession hasn\'t helped housing replenish its ranks with fresh talent. But despite - or perhaps because of - market conditions, a generation of builders in their 30s and 40s is asserting itself with new ideas and energy.\n\nThe following profiles feature four such builders whose distinguishing characteristic is their willingness to try new things and shift gears when experiments didn\'t work as planned. These builders also rely more than their predecessors on systems and processes to monitor their financial and operational performance, as well as their customers\' preferences. To quote one of our subjects about his company\'s early success, \"Everything we\'ve been doing we\'re doing on purpose.\"\nGetting to Know You\n\nGary Hartogh, founder of Couture Homes, stops at nothing to deliver exactly what his clients are looking for. Recently, Hartogh even spent three days living with one client in the prospect\'s house in Chicago.\n\nHartogh, who in another life was one of South Africa\'s largest builder/developers - believes the Lifestyle Discovery Process is the foundation for achieving their larger ambition to licensing Couture as a brand. Couture is currently beta-testing its licensing concept with another builder, Orlando, Fla.-based Arturo Barcelona Homes, whose own ethnographic process is geared toward developing standard house plans.\n\nMeanwhile, Couture continues to refine and grow. It recently completed a 9,751-square-foot house in 165 days. This home was the first in Palm Beach County, Fla., to obtain green certification through the NAHB\'s National Green Building Standard. In addition, Couture recently signed an agreement for a seven-house community, its first.\n\nAnd in August, the company hired its first full-time architect. Couture has even employed architects from Canada and Italy in the past. The reason? Couture stops at nothing to keep Couture\'s designs fresh, and innovative.','2014-10-03 17:05:54',1,'');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bot_check`
--

DROP TABLE IF EXISTS `bot_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bot_check` (
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` char(42) NOT NULL,
  KEY `time` (`time`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bot_check`
--

LOCK TABLES `bot_check` WRITE;
/*!40000 ALTER TABLE `bot_check` DISABLE KEYS */;
INSERT INTO `bot_check` VALUES ('2014-04-30 15:48:06','0080533be4e7103078980f895d7883064a173e8f7a'),('2014-04-30 16:28:05','00960893f621a178f7cdc4a57d0d57f41da807fbc6');
/*!40000 ALTER TABLE `bot_check` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuration` (
  `name` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `example` varchar(100) NOT NULL,
  `help` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`),
  KEY `name_2` (`name`,`label`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuration`
--

LOCK TABLES `configuration` WRITE;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` VALUES ('contact_recipient','Contact Recipient Email','','bain@lifthousedesign.com','This is the email address that will received messages sent through the contact form.'),('ga_code','Google Analytics Code','','UA-000000-01','If you want to track your page views using Google Analytics, enter the provided code here.'),('google_site_verification','Allow Google Site Verification','No','No','Setting this field to \"Yes\" will allow Google to automatically verify your website (required for Google Webmaster Tools). It is important that you set this field back to \"No\" after your site has been verified or someone else may try to claim it!');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `type` enum('permanent','aside','page') NOT NULL DEFAULT 'page',
  `topbar` enum('Yes','No') NOT NULL DEFAULT 'No',
  `footer` enum('Yes','No') NOT NULL DEFAULT 'No',
  `title` varchar(500) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '',
  `weight` int(11) NOT NULL,
  `parent` varchar(50) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES ('contact','<h1>Contact</h1>','page','Yes','Yes','Contact','Contact',5,'0'),('gallery','<h1>Gallery</h1>','page','Yes','Yes','Gallery','Gallery',3,'0'),('homepage','<h1>TagTown</h1><p>Enter some homepage content here.</p>','aside','No','No','','',0,'0'),('news','<h1>News</h1>','page','Yes','Yes','News','News',4,'0');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text,
  `data` text,
  `type` enum('log','error') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_feed`
--

DROP TABLE IF EXISTS `news_feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_feed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(10) unsigned NOT NULL DEFAULT '1',
  `tags` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_feed`
--

LOCK TABLES `news_feed` WRITE;
/*!40000 ALTER TABLE `news_feed` DISABLE KEYS */;
INSERT INTO `news_feed` VALUES (3,'Filling The Void','<p>\nFour aggressive, younger builders figure out how to make money in a still-weak housing market. \n</p>\n<br />\n<p>\nIn 2009, the median age of a single-family home builder was 53 years old, according to an NAHB survey of its members. And a destabilizing recession hasn\'t helped housing replenish its ranks with fresh talent. But despite - or perhaps because of - market conditions, a generation of builders in their 30s and 40s is asserting itself with new ideas and energy.\n</p>\n<br />\n<p>\nThe following profiles feature four such builders whose distinguishing characteristic is their willingness to try new things and shift gears when experiments didn\'t work as planned. These builders also rely more than their predecessors on systems and processes to monitor their financial and operational performance, as well as their customers\' preferences. To quote one of our subjects about his company\'s early success, \"Everything we\'ve been doing we\'re doing on purpose.\"\nGetting to Know You\n</p>\n<br />\n<p>\nGary Hartogh, founder of Couture Homes, stops at nothing to deliver exactly what his clients are looking for. Recently, Hartogh even spent three days living with one client in the prospect\'s house in Chicago.\n</p>\n<br />\n<p>\nHartogh, who in another life was one of South Africa\'s largest builder/developers - believes the Lifestyle Discovery Process is the foundation for achieving their larger ambition to licensing Couture as a brand. Couture is currently beta-testing its licensing concept with another builder, Orlando, Fla.-based Arturo Barcelona Homes, whose own ethnographic process is geared toward developing standard house plans.\n</p>\n<br />\n<p>\nMeanwhile, Couture continues to refine and grow. It recently completed a 9,751-square-foot house in 165 days. This home was the first in Palm Beach County, Fla., to obtain green certification through the NAHB\'s National Green Building Standard. In addition, Couture recently signed an agreement for a seven-house community, its first.\n</p>\n<br />\n<p>\nAnd in August, the company hired its first full-time architect. Couture has even employed architects from Canada and Italy in the past. The reason? Couture stops at nothing to keep Couture\'s designs fresh, and innovative.\n</p>\n<br />','2014-10-03 19:10:09',1,'');
/*!40000 ALTER TABLE `news_feed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_media` (
  `label` varchar(30) NOT NULL,
  `value` varchar(100) NOT NULL DEFAULT '',
  `name` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media`
--

LOCK TABLES `social_media` WRITE;
/*!40000 ALTER TABLE `social_media` DISABLE KEYS */;
INSERT INTO `social_media` VALUES ('Facebook','','facebook'),('Google+','','googleplus'),('Instagram','','instagram'),('LinkedIn','','linkedin'),('Pinterest','','pinterest'),('Twitter','','twitter'),('YouTube','','youtube');
/*!40000 ALTER TABLE `social_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `phone_text_capable` tinyint(4) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirm_code` char(80) DEFAULT NULL,
  `role` enum('developer','administrator','manager','blogger','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'mike@lifthousedesign.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Mike','Beattie',NULL,0,'0000-00-00 00:00:00','2014-11-09 14:23:14','2014-11-09 14:23:14',NULL,'administrator'),(2,'tara@lifthousedesign.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Tara','Beattie',NULL,0,'0000-00-00 00:00:00','2014-10-06 01:57:47','2014-10-06 01:57:47',NULL,'administrator');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-10  7:59:51
