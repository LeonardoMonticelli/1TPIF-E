DROP DATABASE IF EXISTS WT2;
create database WT2;
use WT2;

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