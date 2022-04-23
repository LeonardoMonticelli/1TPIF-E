DROP DATABASE IF EXISTS WT;
create database WT;
use WT;

CREATE TABLE `user` (
  `UserNo` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Technician` BOOLEAN DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserNo`)
);

INSERT INTO `user` (`UserNo`, `UserName`, `FirstName`, `LastName`, `Technician`, `Email`, `Password`) VALUES
(1,    'admin',    'admin',    'adminson',    1,    'admin@admin.admin',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6'),
(2,    'user',    'user',    'userson',    0,    'user@user.user',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6');

CREATE TABLE `smartbox` (
  `HostName` varchar(16) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  PRIMARY KEY (`HostName`),
  KEY `UserNo` (`UserNo`),
  CONSTRAINT `smartbox_ibfk_1` FOREIGN KEY (`UserNo`) REFERENCES `user` (`UserNo`)
);

INSERT INTO `smartbox` (`HostName`, `Description`, `Location`, `UserNo`) VALUES
('SB_1',    'box 1',    'US',    1),
('SB_test',    'box 0',    'US',    1);

CREATE TABLE `group` (
  `GroupNo` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(20) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `HostName` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`GroupNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `group_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartbox` (`HostName`)
);

INSERT INTO `group` (`GroupNo`, `GroupName`, `Description`, `HostName`) VALUES
(1,    'group1',    '1st group',    'SB_1'),
(2,    'group2',    '2nd group',    'SB_1');

CREATE TABLE `pin` (
  `PinNo` int NOT NULL AUTO_INCREMENT,
  `HostName` varchar(16) DEFAULT NULL,
  `Input` int DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PinNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `pin_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartbox` (`HostName`)
);

INSERT INTO `pin` (`HostName`, `PinNo`, `Input`, `Designation`) VALUES 
('SB_test', 1, 1, 'GPIO1'),
('SB_1', 7, 1, 'GPIO2');

CREATE TABLE `script` (
  `ScriptName` varchar(50) NOT NULL,
  `Path` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ScriptName`)
);

INSERT INTO `script` (`ScriptName`, `Path`, `Description`) VALUES
('script1',    '/home/script1.sh',    'script 1'),
('script2',    '/home/script.sh',    'script2');

CREATE TABLE `smartboxaccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `HostName` varchar(16) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `HostName` (`HostName`),
  KEY `UserNo` (`UserNo`),
  CONSTRAINT `smartboxaccess_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartbox` (`HostName`),
  CONSTRAINT `smartboxaccess_ibfk_2` FOREIGN KEY (`UserNo`) REFERENCES `user` (`UserNo`)
);

INSERT INTO `smartboxaccess` (`id`, `HostName`, `UserNo`) VALUES
(1,    'SB_1',    1);

CREATE TABLE `use` (
  `GroupNo` int(11) DEFAULT NULL,
  `ScriptName` varchar(50) DEFAULT NULL,
  KEY `ScriptName` (`ScriptName`),
  KEY `GroupNo` (`GroupNo`),
  CONSTRAINT `use_ibfk_1` FOREIGN KEY (`ScriptName`) REFERENCES `script` (`ScriptName`),
  CONSTRAINT `use_ibfk_2` FOREIGN KEY (`GroupNo`) REFERENCES `group` (`GroupNo`)
);

INSERT INTO `use` (`GroupNo`, `ScriptName`) VALUES
(1,    'script1'),
(2,    'script2');