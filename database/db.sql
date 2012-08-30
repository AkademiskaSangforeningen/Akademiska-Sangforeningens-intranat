SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `PersonHasEvent`;
CREATE TABLE IF NOT EXISTS `PersonHasEvent` (
  `PersonId` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `EventId` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `TransactionId` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  `PaymentTypeId` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  `UnRegistered` tinyint(4) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Modified` datetime DEFAULT NULL,
  `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`PersonId`,`EventId`,`Status`),
  KEY `TransactionId` (`TransactionId`),
  KEY `EventId` (`EventId`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `ModifiedBy` (`ModifiedBy`),
  KEY `PersonId` (`PersonId`),
  KEY `PaymentTypeId` (`PaymentTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `EventHasPaymentType`;
CREATE TABLE IF NOT EXISTS `EventHasPaymentType` (
  `EventId` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `PaymentTypeId` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Modified` int(11) DEFAULT NULL,
  `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`EventId`,`PaymentTypeId`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `ModifiedBy` (`ModifiedBy`),
  KEY `PaymentTypeId` (`PaymentTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `Event`;
CREATE TABLE IF NOT EXISTS `Event` (
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
  PRIMARY KEY (`Id`),
  KEY `ModifiedBy` (`ModifiedBy`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `ResponsibleId` (`ResponsibleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `Transaction`;
CREATE TABLE IF NOT EXISTS `Transaction` (
  `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `PersonId` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `TransactionDate` datetime NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Description` varchar(256) COLLATE utf8_swedish_ci NOT NULL,
  `PaymentTypeId` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Modified` datetime DEFAULT NULL,
  `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `PersonId` (`PersonId`),
  KEY `PaymnentTypeId` (`PaymentTypeId`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `ModifiedBy` (`ModifiedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `PaymentType`;
CREATE TABLE IF NOT EXISTS `PaymentType` (
  `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Name` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Modified` datetime DEFAULT NULL,
  `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `ModifiedBy` (`ModifiedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `Person`;
CREATE TABLE IF NOT EXISTS `Person` (
  `Id` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `FirstName` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  `LastName` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  `Voice` char(2) COLLATE utf8_swedish_ci DEFAULT NULL,
  `Address` varchar(128) COLLATE utf8_swedish_ci DEFAULT NULL,
  `PostalCode` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  `City` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  `CountryId` char(2) COLLATE utf8_swedish_ci DEFAULT NULL,
  `Phone` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  `Email` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  `Allergies` varchar(256) COLLATE utf8_swedish_ci DEFAULT NULL,
  `Description` text COLLATE utf8_swedish_ci,
  `Status` tinyint(4) NOT NULL,
  `UserRights` integer unsigned NOT NULL DEFAULT 0,
  `Password` char(60) COLLATE utf8_swedish_ci NOT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Modified` datetime DEFAULT NULL,
  `ModifiedBy` char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `ModifiedBy` (`ModifiedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

INSERT INTO `Person` (`Id`, `FirstName`, `LastName`, `Voice`, `Address`, `PostalCode`, `City`, `CountryId`, `Phone`, `Email`, `Allergies`, `Description`, `Status`, `Password`, `Created`, `CreatedBy`, `Modified`, `ModifiedBy`) VALUES
('89fb6438-6aae-11e1-a06a-e81132589e91', 'Klaus', 'Lapela', '2B', 'Forums k�pcentrum', '12345', 'Helsingfors', 'fi', '+358-40-123456', 'intra@akademen.com', 'Finsk industriell cider', NULL, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO/FloPJU.AqDMvnUFlnFl6lTkv5uSlK2', '2012-03-10 14:42:47', '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO/FloPJU', NULL, NULL);



ALTER TABLE `Event`
  ADD CONSTRAINT `Event_ibfk_1` FOREIGN KEY (`ResponsibleId`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `Event_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `Event_ibfk_3` FOREIGN KEY (`ModifiedBy`) REFERENCES `Person` (`Id`);

ALTER TABLE `EventHasPaymentType`
  ADD CONSTRAINT `EventHasPaymentType_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`Id`),
  ADD CONSTRAINT `EventHasPaymentType_ibfk_2` FOREIGN KEY (`PaymentTypeId`) REFERENCES `PaymentType` (`Id`),
  ADD CONSTRAINT `EventHasPaymentType_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `EventHasPaymentType_ibfk_4` FOREIGN KEY (`ModifiedBy`) REFERENCES `Person` (`Id`);

ALTER TABLE `PaymentType`
  ADD CONSTRAINT `PaymentType_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `PaymentType_ibfk_2` FOREIGN KEY (`ModifiedBy`) REFERENCES `Person` (`Id`);

ALTER TABLE `Person`
  ADD CONSTRAINT `Person_ibfk_2` FOREIGN KEY (`ModifiedBy`) REFERENCES `Person` (`Id`);

ALTER TABLE `PersonHasEvent`
  ADD CONSTRAINT `PersonHasEvent_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_2` FOREIGN KEY (`PersonId`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_4` FOREIGN KEY (`ModifiedBy`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_5` FOREIGN KEY (`TransactionId`) REFERENCES `Transaction` (`Id`),
  ADD CONSTRAINT `PersonHasEvent_ibfk_6` FOREIGN KEY (`PaymentTypeId`) REFERENCES `PaymentType` (`Id`);

ALTER TABLE `Transaction`
  ADD CONSTRAINT `Transaction_ibfk_1` FOREIGN KEY (`PersonId`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `Transaction_ibfk_2` FOREIGN KEY (`PaymentTypeId`) REFERENCES `PaymentType` (`Id`),
  ADD CONSTRAINT `Transaction_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `Person` (`Id`),
  ADD CONSTRAINT `Transaction_ibfk_4` FOREIGN KEY (`ModifiedBy`) REFERENCES `Person` (`Id`);
