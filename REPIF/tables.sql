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

CREATE TABLE Groups(
   GroupNo SMALLINT,
   GroupName VARCHAR(20),
   Description VARCHAR(50),
   HostName VARCHAR(16) NOT NULL,
   PRIMARY KEY(GroupNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);

CREATE TABLE Pin(
   HostName VARCHAR(16),
   PinNo SMALLINT,
   Input SMALLINT,
   Designation VARCHAR(50),
   PRIMARY KEY(HostName, PinNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName)
);

CREATE TABLE Events(
   HostName VARCHAR(16),
   PinNo SMALLINT,
   EventCode VARCHAR(1),
   Description VARCHAR(50),
   PRIMARY KEY(HostName, PinNo, EventCode),
   FOREIGN KEY(HostName, PinNo) REFERENCES Pin(HostName, PinNo)
);

CREATE TABLE switch_execute(
   HostName VARCHAR(16),
   PinNo SMALLINT,
   EventCode VARCHAR(1),
   GroupNo SMALLINT,
   TargetFunctionCode VARCHAR(1) NOT NULL,
   Description VARCHAR(50),
   SequenceNo INT,
   WaitingDuration INT,
   PRIMARY KEY(HostName, PinNo, EventCode, GroupNo),
   UNIQUE(TargetFunctionCode),
   FOREIGN KEY(HostName, PinNo, EventCode) REFERENCES Events(HostName, PinNo, EventCode),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo)
);

CREATE TABLE `use`(
   GroupNo SMALLINT,
   ScriptName VARCHAR(50),
   PRIMARY KEY(GroupNo, ScriptName),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo),
   FOREIGN KEY(ScriptName) REFERENCES Script(ScriptName)
);

CREATE TABLE concern(
   GroupNo SMALLINT,
   HostName VARCHAR(16),
   PinNo SMALLINT,
   PRIMARY KEY(GroupNo, HostName, PinNo),
   FOREIGN KEY(GroupNo) REFERENCES Groups(GroupNo),
   FOREIGN KEY(HostName, PinNo) REFERENCES Pin(HostName, PinNo)
);

CREATE TABLE manage(
   HostName VARCHAR(16),
   UserNo INT,
   PRIMARY KEY(HostName, UserNo),
   FOREIGN KEY(HostName) REFERENCES SmartBox(HostName),
   FOREIGN KEY(UserNo) REFERENCES Users(UserNo)
);