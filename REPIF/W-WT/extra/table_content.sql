use WT;

INSERT INTO SmartBox (HostName, `Description`, `Location`)
VALUES ('SB_1','ModelA','Building1-apartment3');

INSERT INTO SmartBox (HostName, `Description`, `Location`)
VALUES ('SB_7','ModelA','Building7-apartment2');

INSERT INTO SmartBox (HostName, `Description`, `Location`)
VALUES ('SB_23','ModelB','Building4-petshop');

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES ('SB_1',7, 1, 'GPIO4'); 

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES ('SB_2',11, 1, 'GPIO17');

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES ('SB_7',33, 0, 'GPIO13');

INSERT INTO Pin (HostName, PinNo, Input, Designation)
VALUES ('SB_23','35', 0, 'GPIO19');

INSERT INTO Groups (GroupNo, GroupName, `Description`, HostName)
VALUES (1,'CHIEF','Lamps in the kitchen', 'SB_7'); 

INSERT INTO Groups (GroupNo, GroupName, `Description`, HostName)
VALUES (3,'ALL','All lamps', 'SB_23'); 

INSERT INTO Groups (GroupNo, GroupName, `Description`, HostName)
VALUES (11,'GARAGE','Garage door', 'SB_1');

INSERT INTO Groups (GroupNo, GroupName, `Description`, HostName)
VALUES (13,'FLUR','Hallway lamps', 'SB_2');

INSERT INTO SmartBoxAccess (GroupNo, HostName, PinNo)
VALUES (11,'SB_1', 7); 

INSERT INTO SmartBoxAccess (GroupNo, HostName, PinNo)
VALUES (13,'SB_2', 11); 

INSERT INTO SmartBoxAccess (GroupNo, HostName, PinNo)
VALUES (1,'SB_7', 33); 

INSERT INTO SmartBoxAccess (GroupNo, HostName, PinNo)
VALUES (3,'SB_23', 35); 

INSERT INTO Script (ScriptName, `Path`, `Description`)
VALUES ('Dimmer','/Switch/Dimmer.sh', 'Dim lamp');

INSERT INTO Script (ScriptName, `Path`, `Description`)
VALUES ('Bell','/Sound/bell.sh', 'Play ringtone');

INSERT INTO Script (ScriptName, `Path`, `Description`)
VALUES ('Strobo','/Switch/Strobo.sh', 'Make lamp flash quickly');

INSERT INTO `Use` (GroupNo, ScriptName)
VALUES ( 1,'Dimmer');

INSERT INTO `Use` (GroupNo, ScriptName)
VALUES ( 3,'Bell');

INSERT INTO `Use` (GroupNo, ScriptName)
VALUES ( 11,'Strobo');

INSERT INTO Events (HostName, PinNo, EventCode, `Description`)
VALUES ( 'SB_1',7, 'K', 'Press light switch briefly');

INSERT INTO Events (HostName, PinNo, EventCode, `Description`)
VALUES ( 'SB_1',11, 'L', 'Long press touch field'); 

INSERT INTO Events (HostName, PinNo, EventCode, `Description`)
VALUES ( 'SB_7',33, 'K', 'Touch field briefly'); 

INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, `Description`, SequenceNo, WaitingDuration)
VALUES ( 'SB_1',11, 'L', 11, 'E', 'Switch on alarm', 2, 5);

INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, `Description`, SequenceNo, WaitingDuration)
VALUES ( 'SB_7',33, 'K', 1, 'U', 'Switch light in the bathroom',0,0); 

INSERT INTO Switch_Execute (HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, `Description`, SequenceNo, WaitingDuration)
VALUES ( 'SB_1',7, 'K', 13, 'A', 'Close window', 1,0); 

INSERT INTO Users (UserNo, UserName, FullName, Technician, Email, `Password`, HostName)
VALUES ( 3 , 'AT', 'Anna Theis', 1, 'a.theis@bt.lu','$2y$10$nY2wDz6pZJSf2tRbDSEz7eB87fGrE35vMFF1eIFRSXihnh2H5vyW2', 'SB_1');

INSERT INTO Users (UserNo, UserName, FullName, Technician, Email, `Password`, HostName)
VALUES ( 7 , 'JS', 'Jean Schmit', 0, 'jean@jmail.com', '$2y$10$nY2wDz6pZJSf2tRbDSEz7eB87fGrE35vMFF1eIFRSXihnh2H5vyW2', 'SB_23');

INSERT INTO Users (UserNo, UserName, FullName, Technician, Email, `Password`, HostName)
VALUES ( 11, 'CF', 'Claude Fellens', 0, 'claude@fellens.lu', '$2y$10$nY2wDz6pZJSf2tRbDSEz7eB87fGrE35vMFF1eIFRSXihnh2H5vyW2', 'SB_7');