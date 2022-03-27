drop database WT;
create database WT;
use WT;

CREATE TABLE `User` (
  UserNo INT NOT NULL AUTO_INCREMENT, 
  Name varchar(50), 
  FirstName varchar(50), 
  LastName varchar(50), 
  Technician BOOLEAN, 
  Email varchar(50), 
  Passowrd varchar(255),
  PRIMARY KEY (UserNo)
);

CREATE TABLE `SmartBox` (
  HostName varchar(16), 
  Description varchar(50), 
  Location varchar(50),
  UserNo int,
  FOREIGN KEY (UserNo) REFERENCES User(UserNo),
  PRIMARY KEY (HostName)
);

CREATE TABLE `SmartBoxAccess` (
  id INT NOT NULL AUTO_INCREMENT, 
  HostName varchar(16), 
  UserNo int,
  FOREIGN KEY (HostName) REFERENCES SmartBox(HostName),
  FOREIGN KEY (UserNo) REFERENCES User(UserNo),
  PRIMARY KEY (id)
);

CREATE TABLE Pin(
   PinNo INT not null AUTO_INCREMENT unique,
   HostName VARCHAR(50),
   Input INT NOT NULL,
   Designation VARCHAR(50) NOT NULL,
   PRIMARY KEY(PinNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName) ON DELETE CASCADE
);

CREATE TABLE `Script` (
  `ScriptName` varchar(50), 
  `Path` varchar(50),
  `Description` varchar(50),
  PRIMARY KEY (ScriptName)
);

CREATE TABLE `use` (
  `GroupNo` int,
  `ScriptName` varchar(50),
  FOREIGN KEY (ScriptName) REFERENCES Script(ScriptName) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `Groups` (
  GroupNo int NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(20),
  `Description` varchar(50),
  `HostName` varchar(16),
  FOREIGN KEY (HostName) REFERENCES SmartBox(HostName),
  PRIMARY KEY (GroupNo)
);