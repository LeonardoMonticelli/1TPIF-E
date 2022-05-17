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
(3,    'GARAGE',    'Garage door',    'SB_1'),
(4,    'FLUR',    'Corridor lamps',    'SB_1');

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
('SB_1', 5, 1, 'GPIO05'),
('SB_1', 11, 1, 'GPIO11'),
('SB_1', 9, 1, 'GPIO09'),
('SB_1', 10, 1, 'GPIO10'),
('SB_1', 4, 1, 'GPIO04'),
('SB_1', 22, 1, 'GPIO22'),
('SB_1', 27, 1, 'GPIO27'),
('SB_1', 7, 0, 'GPIO07'),
('SB_1', 8, 0, 'GPIO08'),
('SB_1', 12, 0, 'GPIO12'),
('SB_1', 16, 0, 'GPIO16'),
('SB_1', 19, 0, 'GPIO19'),
('SB_1', 20, 0, 'GPIO20'),
('SB_1', 21, 0, 'GPIO21'),
('SB_1', 23, 0, 'GPIO23'),
('SB_3', 5, 1, 'GPIO07'),
('SB_3', 7, 0, 'GPIO05'),
('SB_7', 9, 1, 'GPIO11'),
('SB_7', 11, 0, 'GPIO09');

CREATE TABLE `scripts` (
  `ScriptId` int NOT NULL AUTO_INCREMENT,
  `ScriptName` varchar(50) DEFAULT NULL,
  `Path` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  KEY (`ScriptName`),
  PRIMARY KEY (`ScriptId`)
);

INSERT INTO `scripts` (`ScriptId`,`ScriptName`, `Path`, `Description`) VALUES
(1, 'dimmer',    '/switch/dimmer.sh',    'Dim lamp'),
(2, 'bell',    '/sound/bell.sh',    'Play ringtone'),
(3, 'strobo',    '/switch/strobo.sh',    'Make lamp flash quickly');

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
(2,    'bell'),
(3,    'strobo');

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

INSERT INTO `concern` (`ConcernId`, `GroupNo`, `HostName`, `PinNo`) VALUES
(1, 1,    'SB_7',    7),
(2, 3,    'SB_1',    19);
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
('SB_1',    7,    'K', 'Press switch briefly'),
('SB_3',    7,    'L', 'Long press touch field'),
('SB_7',    12,    'K', 'Touch field briefly');

CREATE TABLE `switchexecute` (
  `SwitchExecuteId` int NOT NULL AUTO_INCREMENT,
  `HostName` VARCHAR(16) DEFAULT NULL,
  `PinNo` int DEFAULT NULL,
  `EventCode` VARCHAR(1) NOT NULL,
  `GroupNo` int(11) DEFAULT NULL,
  `TargetFunctionCode` VARCHAR(1) NOT NULL,
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
  ('SB_1',    5,    'K', 3, 'E', 'Switch on alarm', 2, 5),
  ('SB_1',    11,    'L', 1, 'U', 'Switch light in the bathroom',NULL, NULL),
  ('SB_1',    9,    'K', 1, 'A', 'Close a window', 1, NULL);
  -- only switches