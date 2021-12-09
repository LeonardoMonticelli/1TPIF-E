CREATE TABLE Script(
   ScriptName VARCHAR(50),
   Path VARCHAR(50),
   Description VARCHAR(50),
   PRIMARY KEY(ScriptName)
);

CREATE TABLE SmartBox(
   HostName VARCHAR(16),
   Description VARCHAR(50),
   Location VARCHAR(50),
   PRIMARY KEY(HostName)
);

CREATE TABLE Users(
   UserNo INT,
   Name VARCHAR(50),
   FirstName VARCHAR(50),
   Technician VARCHAR(1),
   Email VARCHAR(50),
   Passwd VARCHAR(50),
   PRIMARY KEY(UserNo)
);

CREATE TABLE `Groups`(
   GroupNo INT,
   GroupName VARCHAR(20),
   Description VARCHAR(50),
   HostName VARCHAR(16) NOT NULL,
   PRIMARY KEY(GroupNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);

CREATE TABLE Pin(
   HostName VARCHAR(16),
   PinNo INT,
   Input INT,
   Designation VARCHAR(50),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);

CREATE TABLE `Events`(
   HostName VARCHAR(16),
   PinNo INT,
   EventCode VARCHAR(1),
   Description VARCHAR(50),
   FOREIGN KEY (HostName) REFERENCES Pin(HostName),
   FOREIGN KEY (PinNo) REFERENCES Pin(PinNo)
);

CREATE TABLE switch_execute(
   HostName VARCHAR(16),
   PinNo INT,
   EventCode VARCHAR(1),
   GroupNo INT,
   TargetFunctionCode VARCHAR(1) NOT NULL,
   Description VARCHAR(50),
   SequenceNo INT,
   WaitingDuration INT,
   UNIQUE(TargetFunctionCode),
   FOREIGN KEY (HostName) REFERENCES Events(HostName),
   FOREIGN KEY (PinNo) REFERENCES Events(PinNo),
   FOREIGN KEY (EventCode) REFERENCES Events(EventCode),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo)
);

CREATE TABLE `use`(
   GroupNo INT,
   ScriptName VARCHAR(50),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo),
   FOREIGN KEY(ScriptName) REFERENCES Script(ScriptName)
);

CREATE TABLE concern(
   GroupNo INT,
   HostName VARCHAR(16),
   PinNo INT,
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo),
   FOREIGN KEY(HostName) REFERENCES Pin(HostName),
   FOREIGN KEY(PinNo) REFERENCES Pin(PinNo)
);

CREATE TABLE manage(
   HostName VARCHAR(16),
   UserNo INT,
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName),
   FOREIGN KEY(UserNo) REFERENCES Users(UserNo)
);