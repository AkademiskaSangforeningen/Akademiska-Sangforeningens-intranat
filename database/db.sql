SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS ci_sessions;
CREATE TABLE IF NOT EXISTS  `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(45) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);

DROP TABLE IF EXISTS event;
CREATE TABLE IF NOT EXISTS `event` (
  Id char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Name` varchar(256) COLLATE utf8_swedish_ci NOT NULL,
  StartDate datetime NOT NULL,
  EndDate datetime DEFAULT NULL,
  RegistrationDueDate datetime DEFAULT NULL,
  PaymentDueDate datetime DEFAULT NULL,
  Description text COLLATE utf8_swedish_ci,
  Price decimal(10,2) NOT NULL,
  Location varchar(256) COLLATE utf8_swedish_ci NOT NULL,
  IsAtClub tinyint(4) NOT NULL,
  `Type` tinyint(4) NOT NULL,
  IsExternal tinyint(4) NOT NULL,
  ResponsibleId char(36) COLLATE utf8_swedish_ci NOT NULL,
  Created datetime NOT NULL,
  CreatedBy char(36) COLLATE utf8_swedish_ci NOT NULL,
  Modified datetime DEFAULT NULL,
  ModifiedBy char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PaymentType tinyint(4) DEFAULT NULL,
  Participant tinyint(4) DEFAULT NULL,
  AvecAllowed tinyint(4) DEFAULT NULL,
  PaymentInfo text COLLATE utf8_swedish_ci,
  CanUsersViewRegistrations tinyint(4) DEFAULT NULL,
  CanUsersSetAllergies tinyint(4) DEFAULT NULL,
  IsMapShown tinyint(4) DEFAULT NULL,
  PRIMARY KEY (Id),
  KEY ModifiedBy (ModifiedBy),
  KEY CreatedBy (CreatedBy),
  KEY ResponsibleId (ResponsibleId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS eventitem;
CREATE TABLE IF NOT EXISTS eventitem (
  Id char(36) COLLATE utf8_swedish_ci NOT NULL,
  EventId char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Type` tinyint(4) NOT NULL,
  Caption varchar(256) COLLATE utf8_swedish_ci NOT NULL,
  Description text COLLATE utf8_swedish_ci,
  Amount decimal(10,2) DEFAULT NULL,
  MaxPcs tinyint(4) DEFAULT NULL,
  PreSelected tinyint(4) DEFAULT NULL,
  ShowForAvec tinyint(4) DEFAULT NULL,
  RowOrder tinyint(4) DEFAULT NULL,
  Created datetime NOT NULL,
  CreatedBy char(36) COLLATE utf8_swedish_ci NOT NULL,
  Modified datetime DEFAULT NULL,
  ModifiedBy char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (Id),
  KEY EventId (EventId),
  KEY ModifiedBy (ModifiedBy),
  KEY CreatedBy (CreatedBy)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS person;
CREATE TABLE IF NOT EXISTS person (
  Id char(36) COLLATE utf8_swedish_ci NOT NULL,
  FirstName varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  LastName varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  Voice char(2) COLLATE utf8_swedish_ci DEFAULT NULL,
  Joined varchar(5) COLLATE utf8_swedish_ci DEFAULT NULL,
  Address varchar(128) COLLATE utf8_swedish_ci DEFAULT NULL,
  PostalCode varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  City varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  CountryId char(2) COLLATE utf8_swedish_ci DEFAULT NULL,
  Phone varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  Email varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  Allergies varchar(256) COLLATE utf8_swedish_ci DEFAULT NULL,
  Description text COLLATE utf8_swedish_ci,
  `Status` tinyint(4) NOT NULL,
  UserRights int(10) unsigned NOT NULL DEFAULT '0',
  `Password` char(60) COLLATE utf8_swedish_ci NOT NULL,
  Created datetime NOT NULL,
  CreatedBy char(36) COLLATE utf8_swedish_ci NOT NULL,
  Modified datetime DEFAULT NULL,
  ModifiedBy char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (Id),
  UNIQUE KEY Email (Email),
  KEY CreatedBy (CreatedBy),
  KEY ModifiedBy (ModifiedBy)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

INSERT INTO person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, `Status`, UserRights, `Password`, Created, CreatedBy, Modified, ModifiedBy) VALUES
('89fb6438-6aae-11e1-a06a-e81132589e91', 'Klaus', 'Lapela', '2B', 'Forums köpcentrum', '12345', 'Helsingfors', 'fi', '+358-40-123456', 'intra@akademen.com', 'Finsk industriell cider', NULL, 0, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO/FloPJU.AqDMvnUFlnFl6lTkv5uSlK2', '2012-03-10 14:42:47', '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO/FloPJU', NULL, NULL),

DROP TABLE IF EXISTS personhasevent;
CREATE TABLE IF NOT EXISTS personhasevent (
  PersonId char(36) COLLATE utf8_swedish_ci NOT NULL,
  EventId char(36) COLLATE utf8_swedish_ci NOT NULL,
  `Status` tinyint(4) NOT NULL,
  PaymentType tinyint(4) DEFAULT NULL,
  UnRegistered tinyint(4) DEFAULT NULL,
  AvecPersonId char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  Created datetime NOT NULL,
  CreatedBy char(36) COLLATE utf8_swedish_ci NOT NULL,
  Modified datetime DEFAULT NULL,
  ModifiedBy char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (PersonId,EventId),
  KEY EventId (EventId),
  KEY CreatedBy (CreatedBy),
  KEY ModifiedBy (ModifiedBy),
  KEY PersonId (PersonId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS personhaseventitem;
CREATE TABLE IF NOT EXISTS personhaseventitem (
  PersonId char(36) COLLATE utf8_swedish_ci NOT NULL,
  EventItemId char(36) COLLATE utf8_swedish_ci NOT NULL,
  Amount tinyint(4) NOT NULL,
  Description text COLLATE utf8_swedish_ci,
  Created datetime NOT NULL,
  CreatedBy char(36) COLLATE utf8_swedish_ci NOT NULL,
  Modified datetime DEFAULT NULL,
  ModifiedBy char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (PersonId,EventItemId),
  KEY EventItemId (EventItemId),
  KEY CreatedBy (CreatedBy),
  KEY ModifiedBy (ModifiedBy),
  KEY PersonId (PersonId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  Id char(36) COLLATE utf8_swedish_ci NOT NULL,
  PersonId char(36) COLLATE utf8_swedish_ci NOT NULL,
  TransactionId char(36) COLLATE utf8_swedish_ci DEFAULT NULL,  
  TransactionDate datetime NOT NULL,
  Amount decimal(10,2) NOT NULL,
  Description varchar(256) COLLATE utf8_swedish_ci NOT NULL,
  Created datetime NOT NULL,
  CreatedBy char(36) COLLATE utf8_swedish_ci NOT NULL,
  Modified datetime DEFAULT NULL,
  ModifiedBy char(36) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (Id),
  UNIQUE KEY `PersonId_EventId` (`PersonId`,`EventId`),
  KEY CreatedBy (CreatedBy),
  KEY ModifiedBy (ModifiedBy)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;


ALTER TABLE `event`
  ADD CONSTRAINT Event_ibfk_1 FOREIGN KEY (ResponsibleId) REFERENCES person (Id),
  ADD CONSTRAINT Event_ibfk_2 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT Event_ibfk_3 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);

ALTER TABLE `eventhaspaymenttype`
  ADD CONSTRAINT EventHasPaymentType_ibfk_1 FOREIGN KEY (EventId) REFERENCES event (Id),
  ADD CONSTRAINT EventHasPaymentType_ibfk_2 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT EventHasPaymentType_ibfk_3 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);

ALTER TABLE `eventitem`
  ADD CONSTRAINT EventItem_ibfk_1 FOREIGN KEY (EventId) REFERENCES event (Id),
  ADD CONSTRAINT EventItem_ibfk_2 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT EventItem_ibfk_3 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);

ALTER TABLE `paymenttype`
  ADD CONSTRAINT PaymentType_ibfk_1 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT PaymentType_ibfk_2 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);

ALTER TABLE `person`
  ADD CONSTRAINT Person_ibfk_2 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);

ALTER TABLE `personhasevent`
  ADD CONSTRAINT PersonHasEvent_ibfk_1 FOREIGN KEY (EventId) REFERENCES event (Id),
  ADD CONSTRAINT PersonHasEvent_ibfk_2 FOREIGN KEY (PersonId) REFERENCES person (Id),
  ADD CONSTRAINT PersonHasEvent_ibfk_3 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT PersonHasEvent_ibfk_4 FOREIGN KEY (ModifiedBy) REFERENCES person (Id)  

ALTER TABLE `personhaseventitem`
  ADD CONSTRAINT PersonHasEventItem_ibfk_1 FOREIGN KEY (EventItemId) REFERENCES eventitem (Id),
  ADD CONSTRAINT PersonHasEventItem_ibfk_2 FOREIGN KEY (PersonId) REFERENCES person (Id),
  ADD CONSTRAINT PersonHasEventItem_ibfk_3 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT PersonHasEventItem_ibfk_4 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);

ALTER TABLE `transaction`
  ADD CONSTRAINT Transaction_ibfk_1 FOREIGN KEY (PersonId) REFERENCES person (Id),
  ADD CONSTRAINT Transaction_ibfk_2 FOREIGN KEY (TransactionId) REFERENCES transaction (Id),
  ADD CONSTRAINT Transaction_ibfk_3 FOREIGN KEY (CreatedBy) REFERENCES person (Id),
  ADD CONSTRAINT Transaction_ibfk_4 FOREIGN KEY (ModifiedBy) REFERENCES person (Id);