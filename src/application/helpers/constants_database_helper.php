<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Database constants
 *
 * @author André Brunnsberg
 *
*/

//Table Event
define('DB_TABLE_EVENT',					'Event');
define('DB_EVENT_ID,',						'Id');
define('DB_EVENT_NAME',						'Name');
define('DB_EVENT_STARTDATE',				'StartDate');
define('DB_EVENT_ENDDATE',					'EndDate');
define('DB_EVENT_REGISTRATIONDUEDATE',		'RegistrationDueDate');
define('DB_EVENT_PAYMENTDUEDATE',			'PaymentDueDate');
define('DB_EVENT_DESCRIPTION',				'Description');
define('DB_EVENT_PRICE',					'Price');
define('DB_EVENT_LOCATION',					'Location');
define('DB_EVENT_ISATCLUB',					'IsAtClub');
define('DB_EVENT_TYPE',						'Type');
define('DB_EVENT_ISEXTERNAL',				'IsExternal');
define('DB_EVENT_RESPONSIBLEID',			'ResponsibleId');
define('DB_EVENT_CREATED',					'Created');
define('DB_EVENT_CREATEDBY',				'CreatedBy');
define('DB_EVENT_MODIFIED',					'Modified');
define('DB_EVENT_MODIFIEDBY',				'ModifiedBy');

//Table PaymentType
define('TABLE_PAYMENTTYPE',					'PaymentType');
define('DB_PAYMENTTYPE_ID',					'Id');
define('DB_PAYMENTTYPE_NAME',				'Name');
define('DB_PAYMENTTYPE_CREATED',			'Created');
define('DB_PAYMENTTYPE_CREATEDBY',			'CreatedBy');
define('DB_PAYMENTTYPE_MODIFIED',			'Modified');
define('DB_PAYMENTTYPE_MODIFIEDBY',			'ModifiedBy');

//Table Person
define('DB_TABLE_PERSON',					'Person');
define('DB_PERSON_ID',						'Id');
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
define('DB_TABLE_PERSONHASEVENT',			'PersonHasEvent');
define('DB_PERSONHASEVENT_PERSONID',		'PersonId');
define('DB_PERSONHASEVENT_EVENTID',			'EventId');
define('DB_PERSONHASEVENT_STATUS',			'Status');
define('DB_PERSONHASEVENT_TRANSACTIONID',	'TransactionId');
define('DB_PERSONHASEVENT_PAYMENTTYPEID',	'PaymentTypeId');
define('DB_PERSONHASEVENT_UNREGISTERED',	'Unregistered');
define('DB_PERSONHASEVENT_CREATED',			'Created');
define('DB_PERSONHASEVENT_CREATEDBY',		'CreatedBy');
define('DB_PERSONHASEVENT_MODIFIED',		'Modified');
define('DB_PERSONHASEVENT_MODIFIEDBY',		'ModifiedBy');

//Table Transaction
define('DB_TABLE_TRANSACTION',				'Transaction');
define('DB_TRANSACTION_ID',					'Id');
define('DB_TRANSACTION_PERSONID',			'PersonId');
define('DB_TRANSACTION_TRANSACTIONDATE',	'TransactionDate');
define('DB_TRANSACTION_AMOUNT',				'Amount');
define('DB_TRANSACTION_DESCRIPTION',		'Description');
define('DB_TRANSACTION_PAYMENTTYPEID',		'PaymentTypeId');
define('DB_TRANSACTION_CREATED',			'Created');
define('DB_TRANSACTION_CREATEDBY',			'CreatedBy');
define('DB_TRANSACTION_MODIFIED',			'Modified');
define('DB_TRANSACTION_MODIFIEDBY',			'ModifiedBy');