<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Database constants
 *
 * @author André Brunnsberg
 *
*/

//Table Event
define('DB_TABLE_EVENT',						'event');
define('DB_EVENT_ID',							'Id');
define('DB_EVENT_NAME',							'Name');
define('DB_EVENT_STARTDATE',					'StartDate');
define('DB_EVENT_ENDDATE',						'EndDate');
define('DB_EVENT_REGISTRATIONDUEDATE',			'RegistrationDueDate');
define('DB_EVENT_PAYMENTDUEDATE',				'PaymentDueDate');
define('DB_EVENT_DESCRIPTION',					'Description');
define('DB_EVENT_PRICE',						'Price');
define('DB_EVENT_LOCATION',						'Location');
define('DB_EVENT_ISATCLUB',						'IsAtClub');
define('DB_EVENT_TYPE',							'Type');
define('DB_EVENT_ISEXTERNAL',					'IsExternal');
define('DB_EVENT_RESPONSIBLEID',				'ResponsibleId');
define('DB_EVENT_CREATED',						'Created');
define('DB_EVENT_CREATEDBY',					'CreatedBy');
define('DB_EVENT_MODIFIED',						'Modified');
define('DB_EVENT_MODIFIEDBY',					'ModifiedBy');
define('DB_EVENT_PAYMENTTYPE',					'PaymentType');
define('DB_EVENT_PARTICIPANT',					'Participant');
define('DB_EVENT_AVECALLOWED',					'AvecAllowed');
define('DB_EVENT_PAYMENTINFO',					'PaymentInfo');
define('DB_EVENT_CANUSERSVIEWREGISTRATIONS',	'CanUsersViewRegistrations');

//Table EventItem
define('DB_TABLE_EVENTITEM',				'eventitem');
define('DB_EVENTITEM_ID',					'Id');
define('DB_EVENTITEM_EVENTID',				'EventId');
define('DB_EVENTITEM_TYPE',					'Type');
define('DB_EVENTITEM_CAPTION',				'Caption');
define('DB_EVENTITEM_DESCRIPTION',			'Description');
define('DB_EVENTITEM_AMOUNT',				'Amount');
define('DB_EVENTITEM_MAXPCS',				'MaxPcs');
define('DB_EVENTITEM_PRESELECTED',			'PreSelected');
define('DB_EVENTITEM_SHOWFORAVEC',			'ShowForAvec');
define('DB_EVENTITEM_ROWORDER',				'RowOrder');
define('DB_EVENTITEM_CREATED',				'Created');
define('DB_EVENTITEM_CREATEDBY',			'CreatedBy');
define('DB_EVENTITEM_MODIFIED',				'Modified');
define('DB_EVENTITEM_MODIFIEDBY',			'ModifiedBy');

//Table Person
define('DB_TABLE_PERSON',					'person');
define('DB_PERSON_ID',						'Id');
define('DB_PERSON_USERRIGHTS',				'UserRights');
define('DB_PERSON_FIRSTNAME',				'FirstName');
define('DB_PERSON_LASTNAME',				'LastName');
define('DB_PERSON_VOICE',					'Voice');
define('DB_PERSON_ADDRESS',					'Address');
define('DB_PERSON_POSTALCODE',				'PostalCode');
define('DB_PERSON_CITY',					'City');
define('DB_PERSON_COUNTRYID',				'CountryId');
define('DB_PERSON_PHONE',					'Phone');
define('DB_PERSON_EMAIL',					'Email');
define('DB_PERSON_ALLERGIES',				'Allergies');
define('DB_PERSON_DESCRIPTION',				'Description');
define('DB_PERSON_STATUS',					'Status');
define('DB_PERSON_PASSWORD',				'Password');
define('DB_PERSON_CREATED',					'Created');
define('DB_PERSON_CREATEDBY',				'CreatedBy');
define('DB_PERSON_MODIFIED',				'Modified');
define('DB_PERSON_MODIFIEDBY',				'ModifiedBy');

//Table PersonHasEvent
define('DB_TABLE_PERSONHASEVENT',			'personhasevent');
define('DB_PERSONHASEVENT_PERSONID',		'PersonId');
define('DB_PERSONHASEVENT_EVENTID',			'EventId');
define('DB_PERSONHASEVENT_STATUS',			'Status');
define('DB_PERSONHASEVENT_TRANSACTIONID',	'TransactionId');
define('DB_PERSONHASEVENT_PAYMENTTYPE',		'PaymentType');
define('DB_PERSONHASEVENT_UNREGISTERED',	'Unregistered');
define('DB_PERSONHASEVENT_AVECPERSONID',	'AvecPersonId');
define('DB_PERSONHASEVENT_CREATED',			'Created');
define('DB_PERSONHASEVENT_CREATEDBY',		'CreatedBy');
define('DB_PERSONHASEVENT_MODIFIED',		'Modified');
define('DB_PERSONHASEVENT_MODIFIEDBY',		'ModifiedBy');

//Table PersonHasEventItem
define('DB_TABLE_PERSONHASEVENTITEM',		'personhaseventitem');
define('DB_PERSONHASEVENTITEM_PERSONID',	'PersonId');
define('DB_PERSONHASEVENTITEM_EVENTITEMID',	'EventItemId');
define('DB_PERSONHASEVENTITEM_AMOUNT',		'Amount');
define('DB_PERSONHASEVENTITEM_DESCRIPTION',	'Description');
define('DB_PERSONHASEVENTITEM_CREATED',		'Created');
define('DB_PERSONHASEVENTITEM_CREATEDBY',	'CreatedBy');
define('DB_PERSONHASEVENTITEM_MODIFIED',	'Modified');
define('DB_PERSONHASEVENTITEM_MODIFIEDBY',	'ModifiedBy');

//Table Transaction
define('DB_TABLE_TRANSACTION',				'transaction');
define('DB_TRANSACTION_ID',					'Id');
define('DB_TRANSACTION_PERSONID',			'PersonId');
define('DB_TRANSACTION_TRANSACTIONDATE',	'TransactionDate');
define('DB_TRANSACTION_EVENTID',			'EventId');
define('DB_TRANSACTION_AMOUNT',				'Amount');
define('DB_TRANSACTION_DESCRIPTION',		'Description');
define('DB_TRANSACTION_CREATED',			'Created');
define('DB_TRANSACTION_CREATEDBY',			'CreatedBy');
define('DB_TRANSACTION_MODIFIED',			'Modified');
define('DB_TRANSACTION_MODIFIEDBY',			'ModifiedBy');

//Temporary tables, views and columns
define('DB_CUSTOM_AVEC',					'Avec');
define('DB_TOTALCOUNT',						'TotalCount');
define('DB_TOTALSUM',						'TotalSum');