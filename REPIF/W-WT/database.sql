DROP DATABASE IF EXISTS WT;
create database WT;
use WT;

CREATE TABLE `users` (
  `UserNo` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) UNIQUE DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Technician` BOOLEAN DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserNo`)
);

INSERT INTO `users` (`UserNo`, `UserName`, `FirstName`, `LastName`, `Technician`, `Email`, `Password`) VALUES
(1,    'admin',    'admin',    'adminson',    1,    'admin@admin.admin',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6'),
(2,    'user',    'user',    'userson',    0,    'user@user.user',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6');

CREATE TABLE `smartboxes` (
  `HostName` varchar(16) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  PRIMARY KEY (`HostName`),
  KEY `UserNo` (`UserNo`),
  CONSTRAINT `smartbox_ibfk_1` FOREIGN KEY (`UserNo`) REFERENCES `users` (`UserNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `smartboxes` (`HostName`, `Description`, `Location`, `UserNo`) VALUES
('SB_1',    'box 1',    'US',    2),
('SB_test',    'box 0',    'US',    1);

CREATE TABLE `groups` (
  `GroupNo` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(20) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `HostName` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`GroupNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `group_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `groups` (`GroupNo`, `GroupName`, `Description`, `HostName`) VALUES
(1,    'group1',    '1st group',    'SB_1'),
(2,    'group2',    '2nd group',    'SB_1');

CREATE TABLE `pins` (
  `PinNo` int NOT NULL AUTO_INCREMENT,
  `HostName` varchar(16) DEFAULT NULL,
  `Input` int DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PinNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `pin_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `pins` (`HostName`, `PinNo`, `Input`, `Designation`) VALUES 
('SB_test', 1, 1, 'GPIO1'),
('SB_1', 7, 1, 'GPIO2');

CREATE TABLE `scripts` (
  `ScriptName` varchar(50) NOT NULL,
  `Path` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ScriptName`)
);

INSERT INTO `scripts` (`ScriptName`, `Path`, `Description`) VALUES
('script1',    '/home/script1.sh',    'script 1'),
('script2',    '/home/script.sh',    'script2');

CREATE TABLE `use` (
  `GroupNo` int(11) DEFAULT NULL,
  `ScriptName` varchar(50) DEFAULT NULL,
  KEY `ScriptName` (`ScriptName`),
  KEY `GroupNo` (`GroupNo`),
  CONSTRAINT `use_ibfk_1` FOREIGN KEY (`ScriptName`) REFERENCES `scripts` (`ScriptName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `use_ibfk_2` FOREIGN KEY (`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `use` (`GroupNo`, `ScriptName`) VALUES
(1,    'script1'),
(2,    'script2');

CREATE TABLE `concern`(
  `GroupNo` int(11) DEFAULT NULL,
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  KEY `HostName`(`HostName`),
  KEY `PinNo`(`PinNo`),
  CONSTRAINT `concern_ibfk_1` FOREIGN KEY (`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `concern_ibfk_2` FOREIGN KEY (`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `concern_ibfk_3` FOREIGN KEY (`PinNo`) REFERENCES `pins` (`PinNo`)ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `manage`(
  `HostName` VARCHAR(16) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  KEY `UserNo`(`UserNo`),
  CONSTRAINT `manage_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `manage_ibfk_2` FOREIGN KEY(`UserNo`) REFERENCES `users` (`UserNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `events`(
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  `EventCode` VARCHAR(1) NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  KEY `EventCode`(`EventCode`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `events_ibfk_2` FOREIGN KEY(`PinNo`) REFERENCES `pins` (`PinNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `switch_execute` (
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  `EventCode` VARCHAR(1) NOT NULL,
  `GroupNo` int(11) DEFAULT NULL,
  `TargetFunctionCode` VARCHAR(1) NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `SequenceNo` INT NOT NULL,
  `WaitingDuration` INT,
  CONSTRAINT `se_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `se_ibfk_2` FOREIGN KEY(`PinNo`) REFERENCES `pins` (`PinNo`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `se_ibfk_3` FOREIGN KEY(`EventCode`) REFERENCES `events` (`EventCode`) ON UPDATE CASCADE ON DELETE CASCADE,  
  CONSTRAINT `se_ibfk_4` FOREIGN KEY(`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

