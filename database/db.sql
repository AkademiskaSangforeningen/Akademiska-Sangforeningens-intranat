SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS ci_sessions;
CREATE TABLE `ci_sessions` (
                             `session_id` varchar(40) COLLATE utf8_swedish_ci NOT NULL DEFAULT '0',
                             `ip_address` varchar(45) COLLATE utf8_swedish_ci NOT NULL DEFAULT '0',
                             `user_agent` varchar(120) COLLATE utf8_swedish_ci NOT NULL,
                             `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
                             `user_data` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

CREATE TABLE `event` (
                       `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
                       `Name` varchar(256) COLLATE utf8_swedish_ci NOT NULL,
                       `StartDate` datetime NOT NULL,
                       `EndDate` datetime DEFAULT NULL,
                       `RegistrationDueDate` datetime DEFAULT NULL,
                       `PaymentDueDate` datetime DEFAULT NULL,
                       `Description` text COLLATE utf8_swedish_ci,
                       `Price` decimal(10,2) NOT NULL,
                       `Location` varchar(256) COLLATE utf8_swedish_ci NOT NULL,
                       `IsAtClub` tinyint(4) NOT NULL,
                       `Type` tinyint(4) NOT NULL,
                       `IsExternal` tinyint(4) NOT NULL,
                       `ResponsibleId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                       `Created` datetime NOT NULL,
                       `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
                       `Modified` datetime DEFAULT NULL,
                       `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
                       `PaymentType` tinyint(4) DEFAULT NULL,
                       `Participant` tinyint(4) DEFAULT NULL,
                       `AvecAllowed` tinyint(4) DEFAULT NULL,
                       `PaymentInfo` text COLLATE utf8_swedish_ci,
                       `CanUsersViewRegistrations` tinyint(4) DEFAULT NULL,
                       `CanUsersSetAllergies` tinyint(4) DEFAULT NULL,
                       `IsMapShown` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS eventitem;
CREATE TABLE `eventitem` (
                           `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
                           `EventId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                           `Type` tinyint(4) NOT NULL,
                           `Caption` varchar(256) COLLATE utf8_swedish_ci NOT NULL,
                           `Description` text COLLATE utf8_swedish_ci,
                           `Amount` decimal(10,2) DEFAULT NULL,
                           `MaxPcs` tinyint(4) DEFAULT NULL,
                           `PreSelected` tinyint(4) DEFAULT NULL,
                           `ShowForAvec` tinyint(4) DEFAULT NULL,
                           `RowOrder` tinyint(4) DEFAULT NULL,
                           `Created` datetime NOT NULL,
                           `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
                           `Modified` datetime DEFAULT NULL,
                           `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS person;
CREATE TABLE `person` (
                        `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
                        `FirstName` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
                        `LastName` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
                        `Voice` char(2) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `Joined` varchar(5) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `Address` varchar(128) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `PostalCode` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `City` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `CountryId` char(2) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `Phone` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `Email` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `Allergies` varchar(256) COLLATE utf8_swedish_ci DEFAULT NULL,
                        `Description` text COLLATE utf8_swedish_ci,
                        `Status` tinyint(4) NOT NULL,
                        `UserRights` int(10) UNSIGNED NOT NULL DEFAULT '0',
                        `Password` char(60) COLLATE utf8_swedish_ci NOT NULL,
                        `Created` datetime NOT NULL,
                        `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
                        `Modified` datetime DEFAULT NULL,
                        `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS personhasevent;
CREATE TABLE `personhasevent` (
                                `PersonId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                                `EventId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                                `Status` tinyint(4) NOT NULL,
                                `PaymentType` tinyint(4) DEFAULT NULL,
                                `UnRegistered` tinyint(4) DEFAULT NULL,
                                `AvecPersonId` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
                                `Created` datetime NOT NULL,
                                `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
                                `Modified` datetime DEFAULT NULL,
                                `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS personhaseventitem;
CREATE TABLE `personhasevent` (
                                `PersonId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                                `EventId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                                `Status` tinyint(4) NOT NULL,
                                `PaymentType` tinyint(4) DEFAULT NULL,
                                `UnRegistered` tinyint(4) DEFAULT NULL,
                                `AvecPersonId` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
                                `Created` datetime NOT NULL,
                                `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
                                `Modified` datetime DEFAULT NULL,
                                `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
                             `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
                             `PersonId` char(36) COLLATE utf8_swedish_ci NOT NULL,
                             `EventId` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
                             `TransactionDate` datetime NOT NULL,
                             `Amount` decimal(10,2) NOT NULL,
                             `Description` varchar(256) COLLATE utf8_swedish_ci NOT NULL,
                             `Created` datetime NOT NULL,
                             `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
                             `Modified` datetime DEFAULT NULL,
                             `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

ALTER TABLE `event`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ModifiedBy` (`ModifiedBy`),
  ADD KEY `CreatedBy` (`CreatedBy`),
  ADD KEY `ResponsibleId` (`ResponsibleId`);

ALTER TABLE `eventitem`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `EventId` (`EventId`),
  ADD KEY `ModifiedBy` (`ModifiedBy`),
  ADD KEY `CreatedBy` (`CreatedBy`);

ALTER TABLE `person`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `CreatedBy` (`CreatedBy`),
  ADD KEY `ModifiedBy` (`ModifiedBy`),
  ADD KEY `Status` (`Status`);

ALTER TABLE `personhasevent`
  ADD PRIMARY KEY (`PersonId`,`EventId`),
  ADD KEY `EventId` (`EventId`),
  ADD KEY `CreatedBy` (`CreatedBy`),
  ADD KEY `ModifiedBy` (`ModifiedBy`),
  ADD KEY `PersonId` (`PersonId`);

ALTER TABLE `personhaseventitem`
  ADD PRIMARY KEY (`PersonId`,`EventItemId`),
  ADD KEY `EventItemId` (`EventItemId`),
  ADD KEY `CreatedBy` (`CreatedBy`),
  ADD KEY `ModifiedBy` (`ModifiedBy`),
  ADD KEY `PersonId` (`PersonId`);

ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `PersonId` (`PersonId`),
  ADD KEY `CreatedBy` (`CreatedBy`),
  ADD KEY `ModifiedBy` (`ModifiedBy`),
  ADD KEY `EventId` (`EventId`);

ALTER TABLE `event`
  ADD CONSTRAINT `Event_ibfk_1` FOREIGN KEY (`ResponsibleId`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `Event_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `Event_ibfk_3` FOREIGN KEY (`ModifiedBy`) REFERENCES `person` (`Id`);

ALTER TABLE `eventitem`
  ADD CONSTRAINT `EventItem_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `event` (`Id`),
  ADD CONSTRAINT `EventItem_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `EventItem_ibfk_3` FOREIGN KEY (`ModifiedBy`) REFERENCES `person` (`Id`);

ALTER TABLE `person`
  ADD CONSTRAINT `Person_ibfk_2` FOREIGN KEY (`ModifiedBy`) REFERENCES `person` (`Id`);

ALTER TABLE `personhasevent`
  ADD CONSTRAINT `PersonHasEvent_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `event` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_2` FOREIGN KEY (`PersonId`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_4` FOREIGN KEY (`ModifiedBy`) REFERENCES `person` (`Id`);

ALTER TABLE `personhaseventitem`
  ADD CONSTRAINT `PersonHasEventItem_ibfk_1` FOREIGN KEY (`EventItemId`) REFERENCES `eventitem` (`Id`),
  ADD CONSTRAINT `PersonHasEventItem_ibfk_2` FOREIGN KEY (`PersonId`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `PersonHasEventItem_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `PersonHasEventItem_ibfk_4` FOREIGN KEY (`ModifiedBy`) REFERENCES `person` (`Id`);

ALTER TABLE `transaction`
  ADD CONSTRAINT `Transaction_ibfk_1` FOREIGN KEY (`PersonId`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `Transaction_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `person` (`Id`),
  ADD CONSTRAINT `Transaction_ibfk_3` FOREIGN KEY (`ModifiedBy`) REFERENCES `person` (`Id`);
COMMIT;
