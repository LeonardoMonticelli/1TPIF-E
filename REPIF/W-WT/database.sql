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
('SB_1',    'Model A',    'Building 1, apartment 3',    2),
('SB_7',    'Model A',    'Building 7, apartment 2',    1),
('SB_3',    'Model B',    'Building 4, pet shop',    1);

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
(1,    'CHIEF',    'Lamps in the kitchen',    'SB_7'),
(3,    'ALL',    'All lamps',    'SB_3'),
(11,    'GARAGE',    'Garage door',    'SB_1'),
(13,    'FLUR',    'Hallway lamps',    'SB_1');

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
('SB_1', 7, 1, 'GPIO4'),
('SB_1', 11, 1, 'GPIO17'),
('SB_7', 33, 0, 'GPIO13'),
('SB_3', 35, 0, 'GPIO19');

CREATE TABLE `scripts` (
  `ScriptName` varchar(50) NOT NULL,
  `Path` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ScriptName`)
);

INSERT INTO `scripts` (`ScriptName`, `Path`, `Description`) VALUES
('dimmer',    '/switch/dimmer.sh',    'Dim lamp'),
('bell',    '/sound/bell.sh',    'Play ringtone'),
('strobo',    '/switch/strobo.sh',    'Make lamp flash quickly');

CREATE TABLE `use` (
  `GroupNo` int(11) DEFAULT NULL,
  `ScriptName` varchar(50) DEFAULT NULL,
  KEY `ScriptName` (`ScriptName`),
  KEY `GroupNo` (`GroupNo`),
  CONSTRAINT `use_ibfk_1` FOREIGN KEY (`ScriptName`) REFERENCES `scripts` (`ScriptName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `use_ibfk_2` FOREIGN KEY (`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `use` (`GroupNo`, `ScriptName`) VALUES
(1,    'dimmer'),
(3,    'bell'),
(11,    'strobo');

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

INSERT INTO `concern` (`GroupNo`, `HostName`, `PinNo`) VALUES
(11,    'SB_7',    33),
(3,    'SB_3',    35);

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

INSERT INTO `events` (`HostName`, `PinNo`, `EventCode`, `Description`) VALUES
('SB_1',    7,    'K', 'Press light switch briefly'),
('SB_3',    11,    'L', 'Long press touch field'),
('SB_7',    33,    'K', 'Touch field briefly');

CREATE TABLE `switch_execute` (
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  `EventCode` VARCHAR(1) NOT NULL,
  `GroupNo` int(11) DEFAULT NULL,
  `TargetFunctionCode` VARCHAR(1) NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `SequenceNo` INT DEFAULT NULL,
  `WaitingDuration` INT DEFAULT NULL,
  CONSTRAINT `se_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `se_ibfk_2` FOREIGN KEY(`PinNo`) REFERENCES `pins` (`PinNo`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `se_ibfk_3` FOREIGN KEY(`EventCode`) REFERENCES `events` (`EventCode`) ON UPDATE CASCADE ON DELETE CASCADE,  
  CONSTRAINT `se_ibfk_4` FOREIGN KEY(`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `switch_execute` (`HostName`, `PinNo`, `EventCode`, `GroupNo`, `TargetFunctionCode`, `Description`, `SequenceNo`, `WaitingDuration`) VALUES
  ('SB_1',    11,    'K', 13, 'E', 'Switch on alarm', 2, 5),
  ('SB_3',    33,    'L', 3, 'U', 'Switch light in the bathroom',NULL, NULL),
  ('SB_1',    7,    'K', 11, 'A', 'Close a window', 1, NULL);