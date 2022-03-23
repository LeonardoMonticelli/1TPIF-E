drop database WT;
create database WT;
use WT;

CREATE TABLE `Script` (
  `ScriptName` varchar(50),
  `Path` varchar(50),
  `Content` varchar(500),
  PRIMARY KEY (ScriptName)
);

CREATE TABLE `SmartBox` (
  HostName varchar(16),
  `Description` varchar(50),
  `Location` varchar(50),
  PRIMARY KEY (HostName)
);

CREATE TABLE `Users` (
  UserNo INT NOT NULL AUTO_INCREMENT,
  UserName varchar(50),
  FirstName varchar(50),
  LastName varchar(50),
  Technician BOOL,
  Email varchar(50),
  `Password` varchar(200),
  PRIMARY KEY (UserNo)
);

CREATE TABLE `Group` (
  GroupNo INT NOT NULL AUTO_INCREMENT,
  GroupName varchar(20),
  HostName VARCHAR(16) NOT NULL,
  PRIMARY KEY (GroupNo),
  FOREIGN KEY (HostName) REFERENCES SmartBox (HostName)
);

CREATE TABLE `Pin` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `HostName` varchar(16) NOT NULL,
  `PinNo` INT,
  `Input` INT,
  `Designation` varchar(50),
  PRIMARY KEY (id),
  FOREIGN KEY (HostName) REFERENCES SmartBox (HostName),
  CONSTRAINT PIN_PINNO_UQ UNIQUE (PinNo)
);

CREATE TABLE `Event` (
  EventID INT NOT NULL AUTO_INCREMENT,
  HostName varchar(16),
  PinNo INT,
  EventCode CHAR(1),
  `Description` varchar(50),
  PRIMARY KEY (EventID),
  FOREIGN KEY (HostName) REFERENCES Pin (HostName),
  FOREIGN KEY (PinNo) REFERENCES Pin (PinNo),
  CONSTRAINT EVENT_EVENTCODE_UQ UNIQUE (EventCode)
);

CREATE TABLE switch_execute(
  ExecID INT NOT NULL AUTO_INCREMENT,
  HostName VARCHAR(16),
  PinNo INT,
  EventCode VARCHAR(1),
  GroupNo INT,
  TargetFunctionCode VARCHAR(1) NOT NULL,
  `Description` VARCHAR(50),
  SequenceNo INT,
  WaitingDuration INT,
  PRIMARY KEY (ExecID),
  FOREIGN KEY (HostName) REFERENCES SmartBox(HostName),
  FOREIGN KEY (PinNo) REFERENCES Pin(PinNo),
  FOREIGN KEY (EventCode) REFERENCES `Event`(EventCode)
);

CREATE TABLE `use` (
   GroupNo INT,
   ScriptName VARCHAR(50),
   PRIMARY KEY (GroupNo),
   FOREIGN KEY (GroupNo) REFERENCES `Group`(GroupNo),
   FOREIGN KEY (ScriptName) REFERENCES Script(ScriptName)
);

CREATE TABLE concern(
   GroupNo INT,
   HostName VARCHAR(16),
   PinNo INT,
   PRIMARY KEY(GroupNo),
   FOREIGN KEY (GroupNo) REFERENCES `Group`(GroupNo),
   FOREIGN KEY (HostName) REFERENCES SmartBox(HostName),
   FOREIGN KEY (PinNo) REFERENCES Pin(PinNo)
);

CREATE TABLE manage(
   HostName VARCHAR(16),
   UserNo INT,
   PRIMARY KEY(HostName),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName),
   FOREIGN KEY(UserNo) REFERENCES Users(UserNo)
);