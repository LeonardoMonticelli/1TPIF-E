INSERT INTO `Script` (ScriptName, Path, Description) VALUES ("Example", "/tmp/ex.sh", "Demo");

INSERT INTO `SmartBox` (HostName, Description, Location) VALUEs ("1.monle399.host", "Demo", "Virtual");

INSERT INTO `User` (Name, FirstName, LastName, Technician, Email, Passwd) VALUES ("Test", "Test1", "Test2", False, "test@example.com", NULL);

INSERT INTO `Group` (GroupName, HostName) VALUES ("TestGroup", "1.monle399.host");

INSERT INTO `Pin` (HostName, PinNo, Input, Designation) VALUES ("1.monle399.host", 1, 1, "Test");

INSERT INTO `Event` (HostName, PinNo, EventCode, Description) VALUES ("1.monle399.host", 1, "A", "Test");

INSERT INTO `switch_execute` (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, Description, SequenceNo, WaitingDuration) VALUES ("1.monle399.host", 1, "A", 1, "A", "Test", 1, 0);

INSERT INTO `use` (GroupNo, ScriptName) VALUES (1, "Example");

INSERT INTO `concern` (GroupNo, HostName, PinNo) VALUES (1, "1.monle399.host", 1);

INSERT INTO `manage` (HostName, UserNo) VALUES ("1.monle399.host", 1);
