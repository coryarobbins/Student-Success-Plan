-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: ssp
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Current Database: `ssp`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ssp` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ssp`;

--
-- Table structure for table `additionalresources`
--

DROP TABLE IF EXISTS `additionalresources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additionalresources` (
  `essentialCourseTitle` varchar(500) DEFAULT NULL,
  `essentialCourseLink` varchar(500) DEFAULT NULL,
  `vocationalTitle` varchar(500) DEFAULT NULL,
  `vocationalLink` varchar(500) DEFAULT NULL,
  `careerExplorationTitle` varchar(500) DEFAULT NULL,
  `careerExplorationLink` varchar(500) DEFAULT NULL,
  `collegeTitle` varchar(500) DEFAULT NULL,
  `collegeLink` varchar(500) DEFAULT NULL,
  `armedServicesTitle` varchar(500) DEFAULT NULL,
  `armedServicesLink` varchar(500) DEFAULT NULL,
  `employmentTitle` varchar(500) DEFAULT NULL,
  `employmentLink` varchar(500) DEFAULT NULL,
  `certificationTitle` varchar(500) DEFAULT NULL,
  `certificationLinks` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `careerreadiness`
--

DROP TABLE IF EXISTS `careerreadiness`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `careerreadiness` (
  `college1` varchar(200) DEFAULT NULL,
  `college2` varchar(200) DEFAULT NULL,
  `college3` varchar(200) DEFAULT NULL,
  `armedServicesBranch` varchar(200) DEFAULT NULL,
  `vocationTrade` varchar(200) DEFAULT NULL,
  `employmentIndustry` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `certificationgoals`
--

DROP TABLE IF EXISTS `certificationgoals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificationgoals` (
  `certGoal1` varchar(200) DEFAULT NULL,
  `certGoal2` varchar(200) DEFAULT NULL,
  `certGoal3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `certificationsList`
--

DROP TABLE IF EXISTS `certificationsList`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificationsList` (
  `certification` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `certificationsearned`
--

DROP TABLE IF EXISTS `certificationsearned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificationsearned` (
  `certsEarned1` varchar(200) DEFAULT NULL,
  `certsEarned2` varchar(200) DEFAULT NULL,
  `certsEarned3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `collegeobjectiveslist`
--

DROP TABLE IF EXISTS `collegeobjectiveslist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collegeobjectiveslist` (
  `objective` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `creditcalcs`
--

DROP TABLE IF EXISTS `creditcalcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creditcalcs` (
  `eighthHS` int(10) unsigned DEFAULT NULL,
  `totalHS` int(10) unsigned DEFAULT NULL,
  `totalCollege` int(10) unsigned DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designations` (
  `gt` int(11) DEFAULT NULL,
  `504` int(11) DEFAULT NULL,
  `iep` int(11) DEFAULT NULL,
  `ell` int(11) DEFAULT NULL,
  `speechServices` int(11) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eighthcourselist`
--

DROP TABLE IF EXISTS `eighthcourselist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eighthcourselist` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `technology` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `activity` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eighthcourses`
--

DROP TABLE IF EXISTS `eighthcourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eighthcourses` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `technology` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `activity` varchar(60) DEFAULT 'Rotation',
  `other` varchar(900) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eighthinterventions`
--

DROP TABLE IF EXISTS `eighthinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eighthinterventions` (
  `intervention1` varchar(200) DEFAULT NULL,
  `intervention2` varchar(200) DEFAULT NULL,
  `intervention3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eighthresume`
--

DROP TABLE IF EXISTS `eighthresume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eighthresume` (
  `activity1` varchar(200) DEFAULT NULL,
  `activity2` varchar(200) DEFAULT NULL,
  `honors1` varchar(200) DEFAULT NULL,
  `honors2` varchar(200) DEFAULT NULL,
  `gpaSem1` varchar(200) DEFAULT NULL,
  `gpaSem2` varchar(200) DEFAULT NULL,
  `cumulativeGpa` varchar(200) DEFAULT NULL,
  `communityService1` varchar(200) DEFAULT NULL,
  `communityService2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eighthscores`
--

DROP TABLE IF EXISTS `eighthscores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eighthscores` (
  `aspireEnglish` int(10) unsigned DEFAULT NULL,
  `aspireReading` int(10) unsigned DEFAULT NULL,
  `aspireScience` int(10) unsigned DEFAULT NULL,
  `aspireMath` int(10) unsigned DEFAULT NULL,
  `mapLanguage` int(10) unsigned DEFAULT NULL,
  `mapReading` int(10) unsigned DEFAULT NULL,
  `mapScience` int(10) unsigned DEFAULT NULL,
  `mapMath` int(10) unsigned DEFAULT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eleventhcourselist`
--

DROP TABLE IF EXISTS `eleventhcourselist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleventhcourselist` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eleventhcourses`
--

DROP TABLE IF EXISTS `eleventhcourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleventhcourses` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL,
  `other` varchar(60) DEFAULT NULL,
  `courseRetakes` varchar(60) DEFAULT NULL,
  `credits` varchar(60) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eleventhinterventions`
--

DROP TABLE IF EXISTS `eleventhinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleventhinterventions` (
  `intervention1` varchar(200) DEFAULT NULL,
  `intervention2` varchar(200) DEFAULT NULL,
  `intervention3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eleventhresume`
--

DROP TABLE IF EXISTS `eleventhresume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleventhresume` (
  `activity1` varchar(200) DEFAULT NULL,
  `activity2` varchar(200) DEFAULT NULL,
  `honors1` varchar(200) DEFAULT NULL,
  `honors2` varchar(200) DEFAULT NULL,
  `gpaSem1` varchar(200) DEFAULT NULL,
  `gpaSem2` varchar(200) DEFAULT NULL,
  `cumulativeGpa` varchar(200) DEFAULT NULL,
  `classRank` varchar(200) DEFAULT NULL,
  `communityService1` varchar(200) DEFAULT NULL,
  `communityService2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eleventhscores`
--

DROP TABLE IF EXISTS `eleventhscores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleventhscores` (
  `mapLanguage` int(10) unsigned DEFAULT NULL,
  `mapReading` int(10) unsigned DEFAULT NULL,
  `mapScience` int(10) unsigned DEFAULT NULL,
  `mapMath` int(10) unsigned DEFAULT NULL,
  `actEnglish` int(10) unsigned DEFAULT NULL,
  `actReading` int(10) unsigned DEFAULT NULL,
  `actScience` int(10) unsigned DEFAULT NULL,
  `actMath` int(10) unsigned DEFAULT NULL,
  `actComposite` int(10) unsigned DEFAULT NULL,
  `asvab` int(10) unsigned DEFAULT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eleventhsupporting`
--

DROP TABLE IF EXISTS `eleventhsupporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eleventhsupporting` (
  `supportingCourse1` varchar(200) DEFAULT NULL,
  `supportingCourse2` varchar(200) DEFAULT NULL,
  `supportingCourse3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `goalplanning`
--

DROP TABLE IF EXISTS `goalplanning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goalplanning` (
  `collegeObjective` varchar(200) DEFAULT NULL,
  `vocationalObjective` varchar(200) DEFAULT NULL,
  `careerObjective` varchar(200) DEFAULT NULL,
  `strongestArea` varchar(600) DEFAULT NULL,
  `weakestArea` varchar(600) DEFAULT NULL,
  `improvementGoal` varchar(600) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gradrequirements`
--

DROP TABLE IF EXISTS `gradrequirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gradrequirements` (
  `subject` varchar(60) DEFAULT NULL,
  `credits` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `interventionlist`
--

DROP TABLE IF EXISTS `interventionlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interventionlist` (
  `seventh` varchar(60) DEFAULT NULL,
  `eighth` varchar(60) DEFAULT NULL,
  `nineth` varchar(60) DEFAULT NULL,
  `tenth` varchar(60) DEFAULT NULL,
  `eleventh` varchar(60) DEFAULT NULL,
  `twelfth` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mentor`
--

DROP TABLE IF EXISTS `mentor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mentor` (
  `name` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` enum('MENTOR','MSADMIN','HSADMIN','DISTRICTADMIN') NOT NULL DEFAULT 'MENTOR',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ninethcourselist`
--

DROP TABLE IF EXISTS `ninethcourselist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninethcourselist` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `health` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ninethcourses`
--

DROP TABLE IF EXISTS `ninethcourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninethcourses` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `health` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL,
  `other` varchar(60) DEFAULT NULL,
  `credits` varchar(60) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ninethinterventions`
--

DROP TABLE IF EXISTS `ninethinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninethinterventions` (
  `intervention1` varchar(200) DEFAULT NULL,
  `intervention2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ninethresume`
--

DROP TABLE IF EXISTS `ninethresume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninethresume` (
  `activity1` varchar(200) DEFAULT NULL,
  `activity2` varchar(200) DEFAULT NULL,
  `honors1` varchar(200) DEFAULT NULL,
  `honors2` varchar(200) DEFAULT NULL,
  `gpaSem1` varchar(200) DEFAULT NULL,
  `gpaSem2` varchar(200) DEFAULT NULL,
  `cumulativeGpa` varchar(200) DEFAULT NULL,
  `classRank` varchar(200) DEFAULT NULL,
  `communityService1` varchar(200) DEFAULT NULL,
  `communityService2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ninethscores`
--

DROP TABLE IF EXISTS `ninethscores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninethscores` (
  `aspireEnglish` int(10) unsigned DEFAULT NULL,
  `aspireReading` int(10) unsigned DEFAULT NULL,
  `aspireScience` int(10) unsigned DEFAULT NULL,
  `aspireMath` int(10) unsigned DEFAULT NULL,
  `mapLanguage` int(10) unsigned DEFAULT NULL,
  `mapReading` int(10) unsigned DEFAULT NULL,
  `mapScience` int(10) unsigned DEFAULT NULL,
  `mapMath` int(10) unsigned DEFAULT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ninethsupporting`
--

DROP TABLE IF EXISTS `ninethsupporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninethsupporting` (
  `supportingCourse1` varchar(200) DEFAULT NULL,
  `supportingCourse2` varchar(200) DEFAULT NULL,
  `supportingCourse3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `isActive` enum('NO','YES','MENTOR') DEFAULT 'NO',
  `startTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isLocked` enum('NO','YES') DEFAULT 'NO',
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seventhcourselist`
--

DROP TABLE IF EXISTS `seventhcourselist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seventhcourselist` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `technology` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `activity` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seventhcourses`
--

DROP TABLE IF EXISTS `seventhcourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seventhcourses` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `technology` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `activity` varchar(60) DEFAULT 'Rotation',
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seventhinterventions`
--

DROP TABLE IF EXISTS `seventhinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seventhinterventions` (
  `intervention1` varchar(200) DEFAULT NULL,
  `intervention2` varchar(200) DEFAULT NULL,
  `intervention3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seventhresume`
--

DROP TABLE IF EXISTS `seventhresume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seventhresume` (
  `activity1` varchar(200) DEFAULT NULL,
  `activity2` varchar(200) DEFAULT NULL,
  `honors1` varchar(200) DEFAULT NULL,
  `honors2` varchar(200) DEFAULT NULL,
  `communityService1` varchar(200) DEFAULT NULL,
  `communityService2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seventhscores`
--

DROP TABLE IF EXISTS `seventhscores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seventhscores` (
  `aspireEnglish` int(10) unsigned DEFAULT NULL,
  `aspireReading` int(10) unsigned DEFAULT NULL,
  `aspireScience` int(10) unsigned DEFAULT NULL,
  `aspireMath` int(10) unsigned DEFAULT NULL,
  `mapLanguage` int(10) unsigned DEFAULT NULL,
  `mapReading` int(10) unsigned DEFAULT NULL,
  `mapScience` int(10) unsigned DEFAULT NULL,
  `mapMath` int(10) unsigned DEFAULT NULL,
  `dukeTip` int(10) unsigned DEFAULT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `mentor` varchar(50) NOT NULL,
  `class_of` int(11) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `local_id` bigint(20) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenthcourselist`
--

DROP TABLE IF EXISTS `tenthcourselist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenthcourselist` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenthcourses`
--

DROP TABLE IF EXISTS `tenthcourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenthcourses` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL,
  `other` varchar(60) DEFAULT NULL,
  `courseRetakes` varchar(60) DEFAULT NULL,
  `credits` varchar(60) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenthinterventions`
--

DROP TABLE IF EXISTS `tenthinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenthinterventions` (
  `intervention1` varchar(200) DEFAULT NULL,
  `intervention2` varchar(200) DEFAULT NULL,
  `intervention3` varchar(200) DEFAULT NULL,
  `intervention4` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenthresume`
--

DROP TABLE IF EXISTS `tenthresume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenthresume` (
  `activity1` varchar(200) DEFAULT NULL,
  `activity2` varchar(200) DEFAULT NULL,
  `honors1` varchar(200) DEFAULT NULL,
  `honors2` varchar(200) DEFAULT NULL,
  `gpaSem1` varchar(200) DEFAULT NULL,
  `gpaSem2` varchar(200) DEFAULT NULL,
  `cumulativeGpa` varchar(200) DEFAULT NULL,
  `classRank` varchar(200) DEFAULT NULL,
  `communityService1` varchar(200) DEFAULT NULL,
  `communityService2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenthscores`
--

DROP TABLE IF EXISTS `tenthscores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenthscores` (
  `aspireEnglish` int(10) unsigned DEFAULT NULL,
  `aspireReading` int(10) unsigned DEFAULT NULL,
  `aspireScience` int(10) unsigned DEFAULT NULL,
  `aspireMath` int(10) unsigned DEFAULT NULL,
  `mapLanguage` int(10) unsigned DEFAULT NULL,
  `mapReading` int(10) unsigned DEFAULT NULL,
  `mapScience` int(10) unsigned DEFAULT NULL,
  `mapMath` int(10) unsigned DEFAULT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenthsupporting`
--

DROP TABLE IF EXISTS `tenthsupporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenthsupporting` (
  `supportingCourse1` varchar(200) DEFAULT NULL,
  `supportingCourse2` varchar(200) DEFAULT NULL,
  `supportingCourse3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `twelfthcourselist`
--

DROP TABLE IF EXISTS `twelfthcourselist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twelfthcourselist` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `twelfthcourses`
--

DROP TABLE IF EXISTS `twelfthcourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twelfthcourses` (
  `english` varchar(60) DEFAULT NULL,
  `math` varchar(60) DEFAULT NULL,
  `science` varchar(60) DEFAULT NULL,
  `socialStudies` varchar(60) DEFAULT NULL,
  `electiveOne` varchar(60) DEFAULT NULL,
  `electiveTwo` varchar(60) DEFAULT NULL,
  `electiveThree` varchar(60) DEFAULT NULL,
  `electiveFour` varchar(60) DEFAULT NULL,
  `other` varchar(60) DEFAULT NULL,
  `courseRetakes` varchar(60) DEFAULT NULL,
  `credits` varchar(60) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `twelfthinterventions`
--

DROP TABLE IF EXISTS `twelfthinterventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twelfthinterventions` (
  `intervention1` varchar(200) DEFAULT NULL,
  `intervention2` varchar(200) DEFAULT NULL,
  `intervention3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `twelfthresume`
--

DROP TABLE IF EXISTS `twelfthresume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twelfthresume` (
  `activity1` varchar(200) DEFAULT NULL,
  `activity2` varchar(200) DEFAULT NULL,
  `honors1` varchar(200) DEFAULT NULL,
  `honors2` varchar(200) DEFAULT NULL,
  `gpaSem1` varchar(200) DEFAULT NULL,
  `gpaSem2` varchar(200) DEFAULT NULL,
  `cumulativeGpa` varchar(200) DEFAULT NULL,
  `classRank` varchar(200) DEFAULT NULL,
  `communityService1` varchar(200) DEFAULT NULL,
  `communityService2` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `twelfthscores`
--

DROP TABLE IF EXISTS `twelfthscores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twelfthscores` (
  `actEnglish` int(10) unsigned DEFAULT NULL,
  `actReading` int(10) unsigned DEFAULT NULL,
  `actScience` int(10) unsigned DEFAULT NULL,
  `actMath` int(10) unsigned DEFAULT NULL,
  `actComposite` int(10) unsigned DEFAULT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `twelfthsupporting`
--

DROP TABLE IF EXISTS `twelfthsupporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twelfthsupporting` (
  `supportingCourse1` varchar(200) DEFAULT NULL,
  `supportingCourse2` varchar(200) DEFAULT NULL,
  `supportingCourse3` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vocationalobjectiveslist`
--

DROP TABLE IF EXISTS `vocationalobjectiveslist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vocationalobjectiveslist` (
  `objective` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vocationalplan`
--

DROP TABLE IF EXISTS `vocationalplan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vocationalplan` (
  `vocationPlan` varchar(200) DEFAULT NULL,
  `careerFocus` varchar(200) DEFAULT NULL,
  `local_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-21  1:54:53
