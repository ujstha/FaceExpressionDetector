-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2017 at 12:56 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webcam`
--

-- --------------------------------------------------------

--
-- Table structure for table `snapshot`
--

CREATE TABLE IF NOT EXISTS `facedetect` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Image` varchar(2000) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `InputAge` Int(200) NOT NULL,
  `FaceId` varchar(2000) NOT NULL,
  `PupilLeftX` varchar(50) NOT NULL,
  `PupilLeftY` varchar(50) NOT NULL,
  `PupilRightX` varchar(50) NOT NULL,
  `PupilRightY` varchar(50) NOT NULL,
  `NoseTipX` varchar(50) NOT NULL,
  `NoseTipY` varchar(50) NOT NULL,
  `MouthLeftX` varchar(50) NOT NULL,
  `MouthLeftY` varchar(50) NOT NULL,
  `MouthRightX` varchar(50) NOT NULL,
  `MouthRightY` varchar(50) NOT NULL,
  `EyeBrowLeftOuterX` varchar(50) NOT NULL,
  `EyeBrowLeftOuterY` varchar(50) NOT NULL,
  `EyeBrowLeftInnerX` varchar(50) NOT NULL,
  `EyeBrowLeftInnerY` varchar(50) NOT NULL,
  `EyeLeftOuterX` varchar(50) NOT NULL,
  `EyeLeftOuterY` varchar(50) NOT NULL,
  `EyeLeftTopX` varchar(50) NOT NULL,
  `EyeLeftTopY` varchar(50) NOT NULL,
  `EyeLeftBottomX` varchar(50) NOT NULL,
  `EyeLeftBottomY` varchar(50) NOT NULL,
  `EyeLeftInnerX` varchar(50) NOT NULL,
  `EyeLeftInnerY` varchar(50) NOT NULL,
  `EyeBrowRightInnerX` varchar(50) NOT NULL,
  `EyeBrowRightInnerY` varchar(50) NOT NULL,
  `EyeBrowRightOuterX` varchar(50) NOT NULL,
  `EyeBrowRightOuterY` varchar(50) NOT NULL,
  `EyeRightInnerX` varchar(50) NOT NULL,
  `EyeRightInnerY` varchar(50) NOT NULL,
  `EyeRightTopX` varchar(50) NOT NULL,
  `EyeRightTopY` varchar(50) NOT NULL,
  `EyeRIghtbottomX` varchar(50) NOT NULL,
  `EyeRIghtbottomY` varchar(50) NOT NULL,
  `EyeRightOuterX` varchar(50) NOT NULL,
  `EyeRightOuterY` varchar(50) NOT NULL,
  `NoseRootLeftX` varchar(50) NOT NULL,
  `NoseRootLeftY` varchar(50) NOT NULL,
  `NoseRootRightX` varchar(50) NOT NULL,
  `NoseRootRightY` varchar(50) NOT NULL,
  `NoseLeftAlarTopX` varchar(50) NOT NULL,
  `NoseLeftAlarTopY` varchar(50) NOT NULL,
  `NoseRightAlarTopX` varchar(50) NOT NULL,
  `NoseRightAlarTopY` varchar(50) NOT NULL,
  `NoseLeftAlarOutTipX` varchar(50) NOT NULL,
  `NoseLeftAlarOutTipY` varchar(50) NOT NULL,
  `NoseRightAlarOutTipX` varchar(50) NOT NULL,
  `NoseRightAlarOutTipY` varchar(50) NOT NULL,
  `UpperLipTopX` varchar(50) NOT NULL,
  `UpperLipTopY` varchar(50) NOT NULL,
  `UpperLipBottomX` varchar(50) NOT NULL,
  `UpperLipBottomY` varchar(50) NOT NULL,
  `UnderLipTopX` varchar(50) NOT NULL,
  `UnderLipTopY` varchar(50) NOT NULL,
  `UnderLipBottomX` varchar(50) NOT NULL,
  `UnderLipBottomY` varchar(50) NOT NULL,
  `Smile` varchar(50) NOT NULL,
  `Pitch` varchar(50) NOT NULL,
  `Roll` varchar(50) NOT NULL,
  `Yaw` varchar(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Age` Int(200) NOT NULL,
  `Moustache` varchar(50) NOT NULL,
  `Beard` varchar(50) NOT NULL,
  `Sideburns` varchar(50) NOT NULL,
  `Glasses` varchar(50) NOT NULL,  
  `Anger` varchar(50) NOT NULL,
  `Contempt` varchar(50) NOT NULL,
  `Disgust` varchar(50) NOT NULL,
  `Fear` varchar(50) NOT NULL,
  `Happiness` varchar(50) NOT NULL,
  `Neutral` varchar(50) NOT NULL,
  `Sadness` varchar(50) NOT NULL,
  `Surprise` varchar(50) NOT NULL,
  `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`Id`)

 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
