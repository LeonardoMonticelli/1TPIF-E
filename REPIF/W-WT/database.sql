DROP DATABASE IF EXISTS WT;
create database WT;
use WT;

CREATE TABLE `users` (
  `UserNo` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) UNIQUE DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Technician` BOOLEAN DEFAULT 0,
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
  PRIMARY KEY (`HostName`)
);

INSERT INTO `smartboxes` (`HostName`, `Description`, `Location`) VALUES
('SB_1',    'Model A',    'Building 1, apartment 3'),
('SB_7',    'Model A',    'Building 7, apartment 2'),
('SB_3',    'Model B',    'Building 4, pet shop');

CREATE TABLE `manage`(
  `ManageId`int(11) NOT NULL AUTO_INCREMENT,
  `HostName` VARCHAR(16) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL,
  PRIMARY KEY (`ManageId`),
  KEY `UserNo`(`UserNo`),
  CONSTRAINT `manage_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `manage_ibfk_2` FOREIGN KEY(`UserNo`) REFERENCES `users` (`UserNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `manage` (`ManageId`,`HostName`, `UserNo`) VALUES
(1, 'SB_1', 1),
(2, 'SB_3', 1),
(3, 'SB_7', 1),
(4, 'SB_1', 2);

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
(1,    'CHIEF',    '',    'SB_7'),
(2,    'ALL',    'All lamps',    'SB_3'),
(3,    'ALL',    'All lamps',    'SB_1'),
(4,    'ROOM',    'Room light',    'SB_1'),
(5,    'CORRIDOR',    'Corridor light',    'SB_1'),
(6,    'ROOM2',    'Room light',    'SB_1'),
(7,    'AREA',    'Area light',    'SB_1'),
(8,    'TOILET',    'Toilet light',    'SB_1'),
(9,    'BATHROOM',    'bathroom light',    'SB_1'),
(10,    'ALARM',    'alarm bell',    'SB_1'),
(11,    'MOTOR',    'motor',    'SB_1'),
(12,    'ALL',    'All pins',    'SB_1')
;

CREATE TABLE `pins` (
  `PinId` int NOT NULL AUTO_INCREMENT,
  `PinNo` int NOT NULL,
  `HostName` varchar(16) DEFAULT NULL,
  `Input` int DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PinId`),
  KEY `PinNo`(`PinNo`),
  KEY `HostName` (`HostName`),
  CONSTRAINT `pin_ibfk_1` FOREIGN KEY (`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `pins` (`HostName`, `PinNo`, `Input`, `Designation`) VALUES 
('SB_1', 4, 1, 'GPIO4'),
('SB_1', 5, 1, 'GPIO5'),
('SB_1', 9, 1, 'GPIO9'),
('SB_1', 10, 1, 'GPIO10'),
('SB_1', 11, 1, 'GPIO11'),
('SB_1', 17, 1, 'GPIO17'),
('SB_1', 22, 1, 'GPIO22'),
('SB_1', 27, 1, 'GPIO27'),
('SB_1', 7, 0, 'GPIO7'),
('SB_1', 8, 0, 'GPIO8'),
('SB_1', 12, 0, 'GPIO12'),
('SB_1', 16, 0, 'GPIO16'),
('SB_1', 19, 0, 'GPIO19'),
('SB_1', 20, 0, 'GPIO20'),
('SB_1', 21, 0, 'GPIO21'),
('SB_1', 23, 0, 'GPIO23'),
('SB_1', 26, 0, 'GPIO26'),
('SB_3', 5, 1, 'GPIO7'),
('SB_3', 7, 0, 'GPIO5'),
('SB_7', 9, 1, 'GPIO11'),
('SB_7', 11, 0, 'GPIO9');

CREATE TABLE `scripts` (
  `ScriptId` int NOT NULL AUTO_INCREMENT,
  `ScriptName` varchar(50) DEFAULT NULL,
  `Path` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  KEY (`ScriptName`),
  PRIMARY KEY (`ScriptId`)
);

INSERT INTO `scripts` (`ScriptId`,`ScriptName`, `Path`, `Description`) VALUES
(1, 'DINGDONG',    '/home/pi/pif2122/data/esklingelt.sh',    'play bell'),
(3, 'strobo',    '/switch/strobo.sh',    'Make lamp flash quickly');

CREATE TABLE `use` (
  `UseId` int NOT NULL AUTO_INCREMENT,
  `ScriptName` varchar(50),
  `GroupNo` int(11),
  PRIMARY KEY (`UseId`),
  KEY `ScriptName` (`ScriptName`),
  KEY `GroupNo` (`GroupNo`),
  CONSTRAINT `use_ibfk_1` FOREIGN KEY (`ScriptName`) REFERENCES `scripts` (`ScriptName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `use_ibfk_2` FOREIGN KEY (`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `use` (`ScriptName`, `GroupNo`) VALUES
('DINGDONG', 10),
('strobo', 1);

CREATE TABLE `concern`(
  `ConcernId` int NOT NULL AUTO_INCREMENT,
  `GroupNo` int(11) DEFAULT NULL,
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  PRIMARY KEY (`ConcernId`),
  KEY `HostName`(`HostName`),
  KEY `PinNo`(`PinNo`),
  CONSTRAINT `concern_ibfk_1` FOREIGN KEY (`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `concern_ibfk_2` FOREIGN KEY (`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `concern_ibfk_3` FOREIGN KEY (`PinNo`) REFERENCES `pins` (`PinNo`)ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `concern` (`GroupNo`, `HostName`, `PinNo`) VALUES
(3,    'SB_1',    7),
(6,    'SB_1',    12),
(8,    'SB_1',    20),
(7,    'SB_1',    16),
(9,    'SB_1',    21),
(11,    'SB_1',    23),
(10,    'SB_1',    26),
(5,    'SB_1',    8);
-- only leds

CREATE TABLE `events`(
  `EventId` int NOT NULL AUTO_INCREMENT,
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  `EventCode` VARCHAR(1) NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  PRIMARY KEY(`EventId`),
  KEY `EventCode`(`EventCode`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `events_ibfk_2` FOREIGN KEY(`PinNo`) REFERENCES `pins` (`PinNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `events` (`HostName`, `PinNo`, `EventCode`, `Description`) VALUES
('SB_1',    5,    'K', 'Press switch briefly'),
('SB_1',    7,    'L', 'Long press touch field'),
('SB_3',    9,    'L', 'Long press touch field'),
('SB_7',    12,    'K', 'Touch field briefly');

CREATE TABLE `switchexecute` (
  `SwitchExecuteId` int NOT NULL AUTO_INCREMENT,
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  `EventCode` VARCHAR(1) NOT NULL,
  `GroupNo` int(11) DEFAULT NULL,
  `TargetFunctionCode` VARCHAR(1) DEFAULT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `SequenceNo` INT DEFAULT NULL,
  `WaitingDuration` INT DEFAULT NULL,
  PRIMARY KEY(`SwitchExecuteId`),
  CONSTRAINT `se_ibfk_1` FOREIGN KEY(`HostName`) REFERENCES `smartboxes` (`HostName`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `se_ibfk_2` FOREIGN KEY(`PinNo`) REFERENCES `pins` (`PinNo`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `se_ibfk_3` FOREIGN KEY(`EventCode`) REFERENCES `events` (`EventCode`) ON UPDATE CASCADE ON DELETE CASCADE,  
  CONSTRAINT `se_ibfk_4` FOREIGN KEY(`GroupNo`) REFERENCES `groups` (`GroupNo`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `switchexecute` (`HostName`, `PinNo`, `EventCode`, `GroupNo`, `TargetFunctionCode`, `Description`, `SequenceNo`, `WaitingDuration`) VALUES
  ('SB_1',    5,    'K', 6, 'U', 'Room2', NULL, NULL),
  ('SB_1',    9,    'K', 8, 'U', 'toilet', NULL, NULL),
  ('SB_1',    10,    'K', 7, 'U', 'area', NULL, NULL),
  ('SB_1',    11,    'K', 9, 'U', 'bathroom', NULL, NULL),
  ('SB_1',    17,    'K', 11, 'U', 'all', NULL, NULL),
  ('SB_1',    22,    'K', 4, 'U', 'room', NULL, NULL),
  ('SB_1',    22,    'L', 10, 'S', 'alarm', NULL, NULL),
  ('SB_1',    27,    'K', 5, 'U', 'corridor', NULL, NULL)
  ;
  -- only switches