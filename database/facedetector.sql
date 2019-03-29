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
  `Age` Int(200) NOT NULL,
  `Sex` varchar(50) NOT NULL,
  `NoseRootLeft` varchar(50) NOT NULL,
  `NoseRootRight` varchar(50) NOT NULL,
  `EyeBrowRightOuter` varchar(50) NOT NULL,
  `EyeBrowRightInner` varchar(50) NOT NULL,
  `EyeRightTop` varchar(50) NOT NULL,
  `PupilRight` varchar(50) NOT NULL,
  `EyeRightOuter` varchar(50) NOT NULL,
  `EyeRIghtbottom` varchar(50) NOT NULL,
  `EyeRightInner` varchar(50) NOT NULL,
  `NoseRightAlarTop` varchar(50) NOT NULL,
  `NoseRightAlarOutTip` varchar(50) NOT NULL,
  `MouthRight` varchar(50) NOT NULL,
  `UnderLipTop` varchar(50) NOT NULL,
  `UnderLipBottom` varchar(50) NOT NULL,
  `EyeBrowLeftOuter` varchar(50) NOT NULL,
  `EyeBrowLeftInner` varchar(50) NOT NULL,
  `EyeLeftTop` varchar(50) NOT NULL,
  `PupilLeft` varchar(50) NOT NULL,
  `EyeLeftOuter` varchar(50) NOT NULL,
  `EyeLeftBottom` varchar(50) NOT NULL,
  `EyeLeftInner` varchar(50) NOT NULL,
  `NoseTip` varchar(50) NOT NULL,
  `NoseLeftAlarTop` varchar(50) NOT NULL,
  `NoseLeftAlarOutTip` varchar(50) NOT NULL,
  `UpperLipTop` varchar(50) NOT NULL,
  `UpperLipBottom` varchar(50) NOT NULL,
  `MouthLeft` varchar(50) NOT NULL,
  `Fear` varchar(50) NOT NULL,
  `Anger` varchar(50) NOT NULL,
  `Sadness` varchar(50) NOT NULL,
  `Joy` varchar(50) NOT NULL,
  `Disgust` varchar(50) NOT NULL,
  `Surprise` varchar(50) NOT NULL,

  PRIMARY KEY (`Id`)

 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
