DROP DATABASE IF EXISTS WT;
create database WT;
use WT;

SET NAMES utf8;
SET time_zone = '+02:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `GroupNo` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(20) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `HostName` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`GroupNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `group_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartbox` (`HostName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `group` (`GroupNo`, `GroupName`, `Description`, `HostName`) VALUES
(1,    'groupnum1',    'group 1',    'b1.project.gg'),
(3,    'Group 2',    'g2',    'b1.project.gg'),
(4,    'group 2',    'testing group',    'b1.project.gg');

DROP TABLE IF EXISTS `pin`;
CREATE TABLE `pin` (
  `PinNo` int NOT NULL AUTO_INCREMENT,
  `HostName` varchar(16) DEFAULT NULL,
  `Input` int DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PinNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `pin_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartbox` (`HostName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pin` (`HostName`, `PinNo`, `Input`, `Designation`)
VALUES ('SB_1',7, 1, 'GPIO4');

DROP TABLE IF EXISTS `script`;
CREATE TABLE `script` (
  `ScriptName` varchar(50) NOT NULL,
  `Path` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ScriptName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `script` (`ScriptName`, `Path`, `Description`) VALUES
('',    '',    ''),
('script1',    '/home/script1.sh',    'script 1'),
('script2',    '/home/script.sh',    'script2'),
('script3',    '/home/script3.sh',    'script 3');

DROP TABLE IF EXISTS `smartbox`;
CREATE TABLE `smartbox` (
  `HostName` varchar(16) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  PRIMARY KEY (`HostName`),
  KEY `UserNo` (`UserNo`),
  CONSTRAINT `smartbox_ibfk_1` FOREIGN KEY (`UserNo`) REFERENCES `user` (`UserNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `smartbox` (`HostName`, `Description`, `Location`, `UserNo`) VALUES
('SB_1',    'box 1',    'US',    NULL);

DROP TABLE IF EXISTS `smartboxaccess`;
CREATE TABLE `smartboxaccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `HostName` varchar(16) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `HostName` (`HostName`),
  KEY `UserNo` (`UserNo`),
  CONSTRAINT `smartboxaccess_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartbox` (`HostName`),
  CONSTRAINT `smartboxaccess_ibfk_2` FOREIGN KEY (`UserNo`) REFERENCES `user` (`UserNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `smartboxaccess` (`id`, `HostName`, `UserNo`) VALUES
(57,    'b1.project.gg',    2);

DROP TABLE IF EXISTS `use`;
CREATE TABLE `use` (
  `GroupNo` int(11) DEFAULT NULL,
  `ScriptName` varchar(50) DEFAULT NULL,
  KEY `ScriptName` (`ScriptName`),
  CONSTRAINT `use_ibfk_1` FOREIGN KEY (`ScriptName`) REFERENCES `script` (`ScriptName`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `use` (`GroupNo`, `ScriptName`) VALUES
(1,    'script1'),
(2,    'script2'),
(1,    'script2');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserNo` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Technician` BOOLEAN DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`UserNo`, `UserName`, `FirstName`, `LastName`, `Technician`, `Email`, `Password`) VALUES
(2,    'user',    'user a',    'user b',    0,    'user@user.user',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6'),
(3,    'admin',    'admin',    'admin',    1,    'admin@admin.admin',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6');