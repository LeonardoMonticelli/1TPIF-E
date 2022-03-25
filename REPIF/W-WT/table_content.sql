use WT;

INSERT INTO `Script` (ScriptName, `Path`, `Content`) VALUES (
    "TestScript",
    "/script/test.sh", 
    -- change the path so when saving the script, the name matches the one put on to save
    "A test script from the Example Dataset"
);

INSERT INTO SmartBox (HostName, `Description`, `Location`) VALUES (
    "1.monle399.local",
    "A SmartBox from the Example Dataset",
    "Virtual"
);

INSERT INTO Users (UserNo, UserName, FirstName, LastName, Technician, Email, `Password`) VALUES (
    1,
    "monle399",
    "Leonardo",
    "Monticelli",
    TRUE,
    "monle399@school.lu",
    "$2y$10$MrrHYVQY08WE3pKYSrZoDevCpqYh/B/WKZgy6MbO.H.V4Vk06bRRy"
);

INSERT INTO `Group` (GroupNo, GroupName, HostName) VALUES (
    1,
    "Test Group",
    "1.monle399.local"
);

INSERT INTO Pin (HostName, PinNo, Input, Designation) VALUES (
    "1.monle399.local",
    1,
    1,
    "Example Designation from Example Dataset"
);

INSERT INTO `Event` (HostName, PinNo, EventCode, `Description`) VALUES (
    "1.monle399.local",
    1,
    "a",
    "Test Example Event from the Example Dataset"
);

INSERT INTO switch_execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, `Description`, SequenceNo, WaitingDuration) VALUES (
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