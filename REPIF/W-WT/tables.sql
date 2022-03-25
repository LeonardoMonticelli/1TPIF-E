drop database WT;
create database WT;
use WT;

CREATE TABLE Script(
   ScriptName VARCHAR(50) NOT NULL,
   `Path` VARCHAR(50) NOT NULL,
   `Description` VARCHAR(500) NOT NULL,
   PRIMARY KEY(ScriptName)
);

CREATE TABLE SmartBox(
   `HostName` VARCHAR(50) NOT NULL,
   `Description` VARCHAR(50) NOT NULL,
   `Location` VARCHAR(50) NOT NULL,
   PRIMARY KEY(HostName)
);

CREATE TABLE Users(
   UserNo INT not null AUTO_INCREMENT,
   UserName VARCHAR(50) NOT NULL,
   FullName VARCHAR(50) NOT NULL,
   Technician BOOLEAN,
   Email VARCHAR(50) NOT NULL ,
   `Password` VARCHAR(255) NOT NULL,
   HostName VARCHAR(50),
   PRIMARY KEY(UserNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName) ON DELETE CASCADE
);

CREATE TABLE `Groups`(
   GroupNo INT not null AUTO_INCREMENT,
   GroupName VARCHAR(20) NOT NULL,
   `Description` VARCHAR(50) NOT NULL,
   HostName VARCHAR(50),
   PRIMARY KEY(GroupNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName) ON DELETE CASCADE
);

CREATE TABLE Pin(
   PinNo INT not null AUTO_INCREMENT,
   HostName VARCHAR(50),
   Input INT NOT NULL,
   Designation VARCHAR(50) NOT NULL,
   PRIMARY KEY(PinNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName) ON DELETE CASCADE
);

CREATE TABLE `Events`(
   PinNo INT,
   HostName VARCHAR(50),
   EventCode VARCHAR(1) NOT NULL,
   `Description` VARCHAR(50) NOT NULL,
   PRIMARY KEY(PinNo),
   FOREIGN KEY(PinNo) REFERENCES Pin(PinNo) ON DELETE CASCADE,
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostN ame) ON DELETE CASCADE
);

CREATE TABLE `Switch_Execute`(
   ExecId INT NOT NULL AUTO_INCREMENT,
   HostName VARCHAR(50),
   PinNo INT,
   EventCode VARCHAR(1),
   GroupNo INT,
   TargetFunctionCode VARCHAR(1) NOT NULL,
   `Description` VARCHAR(50) NOT NULL,
   SequenceNo INT NOT NULL,
   WaitingDuration INT NOT NULL,
   PRIMARY KEY(ExecId),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName) ON DELETE CASCADE,
   FOREIGN KEY(PinNo) REFERENCES Pin(PinNo) ON DELETE CASCADE,
   FOREIGN KEY(EventCode) REFERENCES `Events`(EventCode) ON DELETE CASCADE,
   FOREIGN KEY(GroupNo) REFERENCES `Groups`(GroupNo) ON DELETE CASCADE
);

CREATE TABLE `Use`(
   useid INT NOT NULL AUTO_INCREMENT,
   GroupNo INT,
   ScriptName VARCHAR(50),
   PRIMARY KEY(useid),
   FOREIGN KEY(GroupNo) REFERENCES `Groups`(GroupNo) ON DELETE CASCADE,
   FOREIGN KEY(ScriptName) REFERENCES Script(ScriptName) ON DELETE CASCADE
);

CREATE TABLE Concern(
   ConcernId INT NOT NULL AUTO_INCREMENT,
   GroupNo INT,
   HostName VARCHAR(50),
   PinNo INT,
   PRIMARY KEY(ConcernId),
   FOREIGN KEY(GroupNo) REFERENCES `Groups`(GroupNo) ON DELETE CASCADE,
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName) ON DELETE CASCADE,
   FOREIGN KEY(PinNo) REFERENCES Pin(PinNo) ON DELETE CASCADE
);