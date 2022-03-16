INSERT INTO Script (ScriptName, Path, Description) VALUES (
    "TestScript",
    "/tmp/test.sh",
    "A test script from the Example Dataset"
);

INSERT INTO SmartBox (HostName, Description, Location) VALUES (
    "1.monle399.local",
    "A SmartBox from the Example Dataset",
    "Virtual"
);

INSERT INTO Users (UserNo, Name, FirstName, Technician, Email, Passwd) VALUES (
    1,
    "Monticelli",
    "Leonardo",
    TRUE,
    "monle399@school.lu",
    "to_be_invalidated"
);

INSERT INTO Groups (GroupNo, GroupName, Description, HostName) VALUES (
    1,
    "Test Group",
    "Example group from Example Dataset",
    "1.monle399.local"
);

INSERT INTO Pin (HostName, PinNo, Input, Designation) VALUES (
    "1.monle399.local",
    1,
    1,
    "Example Designation from Example Dataset"
);

INSERT INTO Events (HostName, PinNo, EventCode, Description) VALUES (
    "1.monle399.local",
    1,
    "a",
    "Test Example Event from the Example Dataset"
);

INSERT INTO switch_execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, Description, SequenceNo, WaitingDuration) VALUES (
    "1.monle399.local",
    1,
    "a",
  	1,
    "b",
    "Test Example Switch Execute from Example Dataset",
    1,
    1
);

INSERT INTO `use` (GroupNo, ScriptName) VALUES (
    1,
    "TestScript"
);

INSERT INTO concern (GroupNo, HostName, PinNo) VALUES (
    1,
    "1.monle399.local",
    1
);

INSERT INTO manage (HostName, UserNo) VALUES (
    "1.monle399.local",
    1
)