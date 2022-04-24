DROP DATABASE IF EXISTS WT;
create database WT;
use WT;
-- -------------------------------------------------------

CREATE TABLE `box_group` (
  `Id` int(11) NOT NULL,
  `groupName` varchar(255) DEFAULT NULL,
  `groupDescription` varchar(255) DEFAULT NULL,
  `boxHostName` varchar(255) DEFAULT NULL
);

INSERT INTO `box_group` (`Id`, `groupName`, `groupDescription`, `boxHostName`) VALUES
(12, 'g1', 'g1', '192.168.178.72');

-- --------------------------------------------------------

CREATE TABLE `leds` (
  `Id` int(11) NOT NULL,
  `PinNo` int(11) DEFAULT NULL,
  `PinAction` varchar(255) DEFAULT NULL,
  `GroupId` int(11) DEFAULT NULL
);


INSERT INTO `leds` (`Id`, `PinNo`, `PinAction`, `GroupId`) VALUES
(9, 7, 'LEDTOGGLE', 12),
(10, 8, 'LEDTOGGLE', 12),
(11, 12, 'LEDTOGGLE', 12),
(12, 13, 'LEDTOGGLE', 12),
(13, 16, 'LEDTOGGLE', 12),
(14, 19, 'LEDTOGGLE', 12),
(15, 26, 'LEDTOGGLE', 12);

-- --------------------------------------------------------


CREATE TABLE `motor` (
  `Id` int(11) NOT NULL,
  `MotorAction` varchar(255) DEFAULT NULL,
  `GroupId` int(11) DEFAULT NULL
);

INSERT INTO `motor` (`Id`, `MotorAction`, `GroupId`) VALUES
(5, 'TOGGLE', 12);

-- --------------------------------------------------------

CREATE TABLE `script` (
  `Id` int(11) NOT NULL,
  `ScriptName` varchar(255) DEFAULT NULL,
  `ScriptDescription` varchar(255) DEFAULT NULL,
  `ScriptPath` varchar(255) DEFAULT NULL
);

INSERT INTO `script` (`Id`, `ScriptName`, `ScriptDescription`, `ScriptPath`) VALUES
(1, 'Bell', 'Run the bell', '/home/bell.sh');

-- --------------------------------------------------------

CREATE TABLE `script_access` (
  `Id` int(11) NOT NULL,
  `GroupId` int(11) DEFAULT NULL,
  `ScriptId` int(11) DEFAULT NULL
);

-- --------------------------------------------------------

CREATE TABLE `smartbox` (
  `HostName` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Location` varchar(3) DEFAULT NULL,
  `UserNo` int(11) DEFAULT NULL
);

INSERT INTO `smartbox` (`HostName`, `Description`, `Location`, `UserNo`) VALUES
('192.168.178.72', 'test', 'ea', 8);

-- --------------------------------------------------------

CREATE TABLE `switches` (
  `Id` int(11) NOT NULL,
  `PinNo` int(11) DEFAULT NULL,
  `GroupId` int(11) DEFAULT NULL,
  `HostName` varchar(255) DEFAULT NULL
);

INSERT INTO `switches` (`Id`, `PinNo`, `GroupId`, `HostName`) VALUES
(33, 4, 12, '192.168.178.72'),
(34, 5, 12, '192.168.178.72'),
(35, 9, 12, '192.168.178.72'),
(36, 10, 12, '192.168.178.72'),
(37, 11, 12, '192.168.178.72'),
(38, 17, 12, '192.168.178.72'),
(39, 22, 12, '192.168.178.72'),
(40, 27, 12, '192.168.178.72');

-- --------------------------------------------------------


CREATE TABLE `users` (
  `UserNo` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Technician` tinyint(1) NOT NULL DEFAULT 0,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
);


INSERT INTO `users` (`UserNo`, `UserName`, `FirstName`, `LastName`, `Technician`, `Email`, `Password`) VALUES
(1,    'admin',    'admin',    'adminson',    1,    'admin@admin.admin',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6'),
(2,    'user',    'user',    'userson',    0,    'user@user.user',    '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `box_group`
--
ALTER TABLE `box_group`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `box_group_ibfk_1` (`boxHostName`);

--
-- Indexes for table `leds`
--
ALTER TABLE `leds`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `leds_ibfk_1` (`GroupId`);

--
-- Indexes for table `motor`
--
ALTER TABLE `motor`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `GroupId` (`GroupId`);

--
-- Indexes for table `script`
--
ALTER TABLE `script`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `script_access`
--
ALTER TABLE `script_access`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `GroupId` (`GroupId`),
  ADD KEY `scriptId` (`scriptId`);

--
-- Indexes for table `smartbox`
--
ALTER TABLE `smartbox`
  ADD PRIMARY KEY (`HostName`),
  ADD KEY `smartbox_ibfk_1` (`userID`);

--
-- Indexes for table `switches`
--
ALTER TABLE `switches`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `GroupId` (`GroupId`),
  ADD KEY `hostname` (`hostname`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `box_group`
--
ALTER TABLE `box_group`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `leds`
--
ALTER TABLE `leds`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `motor`
--
ALTER TABLE `motor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `script`
--
ALTER TABLE `script`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `script_access`
--
ALTER TABLE `script_access`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `switches`
--
ALTER TABLE `switches`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `box_group`
--
ALTER TABLE `box_group`
  ADD CONSTRAINT `box_group_ibfk_1` FOREIGN KEY (`BoxHostName`) REFERENCES `smartbox` (`HostName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leds`
--
ALTER TABLE `leds`
  ADD CONSTRAINT `leds_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `box_group` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `motor`
--
ALTER TABLE `motor`
  ADD CONSTRAINT `motor_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `box_group` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `script_access`
--
ALTER TABLE `script_access`
  ADD CONSTRAINT `script_access_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `box_group` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `script_access_ibfk_2` FOREIGN KEY (`scriptId`) REFERENCES `script` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smartbox`
--
ALTER TABLE `smartbox`
  ADD CONSTRAINT `smartbox_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `switches`
--
ALTER TABLE `switches`
  ADD CONSTRAINT `switches_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `box_group` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `switches_ibfk_2` FOREIGN KEY (`hostname`) REFERENCES `smartbox` (`HostName`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
