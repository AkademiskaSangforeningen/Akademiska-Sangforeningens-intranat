<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Languages
 *
 * @author André Brunnsberg
 *
*/

//File name
define('LANG_FILE',									'Text');

//Languages
define('LANG_LANGUAGE_SV',							'sv');	

//Headers
define('LANG_KEY_HEADER_LOGIN',									'header_login');
define('LANG_KEY_HEADER_EVENT_REGISTRATION_SUCCEEDED',			'header_event_registration_succeeded');
define('LANG_KEY_HEADER_EVENT_REGISTRATION_CANCELLED',			'header_event_registration_cancelled');
define('LANG_KEY_HEADER_EVENT_NOT_FOUND',						'header_event_not_found');
define('LANG_KEY_HEADER_EVENT_REGISTRATION_NOT_FOUND',			'header_event_registration_not_found');
define('LANG_KEY_HEADER_EVENT_REGISTRATION_DUE_DATE_PASSED',	'header_event_due_date_passed');

//Buttons
define('LANG_KEY_BUTTON_LOG_IN',						'button_log_in');
define('LANG_KEY_BUTTON_LOGGING_IN',					'button_logging_in');
define('LANG_KEY_BUTTON_LOG_OUT',						'button_log_out');
define('LANG_KEY_BUTTON_CREATE_NEW_MEMBER',				'button_create_new_member');
define('LANG_KEY_BUTTON_EDIT_MEMBER',					'button_edit_member');
define('LANG_KEY_BUTTON_DELETE_MEMBER',					'button_delete_member');
define('LANG_KEY_BUTTON_CONFIRM',						'button_confirm');
define('LANG_KEY_BUTTON_SAVE',							'button_save');
define('LANG_KEY_BUTTON_OK',							'button_ok');
define('LANG_KEY_BUTTON_CANCEL',						'button_cancel');
define('LANG_KEY_BUTTON_CREATE_NEW_TRANSACTION',		'button_create_new_transaction');
define('LANG_KEY_BUTTON_EDIT_TRANSACTION',				'button_edit_transaction');
define('LANG_KEY_BUTTON_CREATE_NEW_EVENT',				'button_create_new_event');
define('LANG_KEY_BUTTON_EDIT_EVENT',					'button_edit_event');
define('LANG_KEY_BUTTON_DELETE_EVENT',					'button_delete_event');
define('LANG_KEY_BUTTON_VIEW_EVENT',					'button_view_event');
define('LANG_KEY_BUTTON_PAGING_FIRST',					'button_paging_first');
define('LANG_KEY_BUTTON_PAGING_LAST',					'button_paging_last');
define('LANG_KEY_BUTTON_EDIT_EVENT_REGISTRATION',		'button_edit_event_registration');
define('LANG_KEY_BUTTON_DELETE_EVENT_REGISTRATION',		'button_delete_event_registration');
define('LANG_KEY_BUTTON_CREATE_NEW_EVENT_REGISTRATION',	'button_create_new_event_registration');

//Fields
define('LANG_KEY_FIELD_EMAIL',							'field_email');
define('LANG_KEY_FIELD_PASSWORD',						'field_password');
define('LANG_KEY_FIELD_PASSWORD_AGAIN',					'field_password_again');
define('LANG_KEY_FIELD_NAME',							'field_name');
define('LANG_KEY_FIELD_ACCESSRIGHTS',					'field_accessRights');
define('LANG_KEY_FIELD_FIRSTNAME',						'field_firstName');
define('LANG_KEY_FIELD_LASTNAME',						'field_lastName');
define('LANG_KEY_FIELD_VOICE',							'field_voice');
define('LANG_KEY_FIELD_ADDRESS',						'field_addess');
define('LANG_KEY_FIELD_POSTALCODE',						'field_postalCode');
define('LANG_KEY_FIELD_CITY',							'field_city');
define('LANG_KEY_FIELD_COUNTRYID',						'field_countryId');
define('LANG_KEY_FIELD_PHONE',							'field_phone');
define('LANG_KEY_FIELD_ALLERGIES',						'field_allergies');
define('LANG_KEY_FIELD_DESCRIPTION',					'field_description');
define('LANG_KEY_FIELD_STATUS',							'field_status');
define('LANG_KEY_FIELD_CREATED',						'field_created');
define('LANG_KEY_FIELD_CREATEDBY',						'field_createdBy');
define('LANG_KEY_FIELD_MODIFIED',						'field_modified');
define('LANG_KEY_FIELD_MODIFIEDBY',						'field_modifiedBy');
define('LANG_KEY_FIELD_DATE',							'field_date');
define('LANG_KEY_FIELD_STARTDATE',						'field_startDate');
define('LANG_KEY_FIELD_FINISHDATE',						'field_finishDate');
define('LANG_KEY_FIELD_PERSON',							'field_person');
define('LANG_KEY_FIELD_AMOUNT',							'field_amount');
define('LANG_KEY_FIELD_PAYMENTTYPE', 					'field_paymentType');
define('LANG_KEY_FIELD_EVENT',							'field_event');
define('LANG_KEY_FIELD_PRICE',							'field_price');
define('LANG_KEY_FIELD_LOCATION',						'field_location');
define('LANG_KEY_FIELD_ENROLLED',						'field_enrolled');			
define('LANG_KEY_FIELD_PAYMENT_DUEDATE',				'field_payment_duedate');
define('LANG_KEY_FIELD_ENROLLMENT_DUEDATE',				'field_enrollment_duedate');
define('LANG_KEY_FIELD_PARTICIPANT',					'field_participant');
define('LANG_KEY_FIELD_AVEC',							'field_avec');
define('LANG_KEY_FIELD_PAYMENT_INFO',					'field_payment_info');
define('LANG_KEY_FIELD_CAN_USERS_VIEW_REGISTRATIONS',	'field_can_users_view_registrations');

//Enumerations
define('LANG_KEY_ENUM_VOICE_1_TENOR',				'enum_voice_1st_tenor');
define('LANG_KEY_ENUM_VOICE_2_TENOR',				'enum_voice_2nd_tenor');
define('LANG_KEY_ENUM_VOICE_1_BASS',				'enum_voice_1st_bass');
define('LANG_KEY_ENUM_VOICE_2_BASS',				'enum_voice_2nd_bass');
define('LANG_KEY_ENUM_VOICE_CONDUCTOR',				'enum_voice_conductor');
define('LANG_KEY_ENUM_COUNTRY_FINLAND',				'enum_country_finland');
define('LANG_KEY_ENUM_COUNTRY_SWEDEN',				'enum_country_sweden');
define('LANG_KEY_ENUM_COUNTRY_OTHER',				'enum_country_other');
define('LANG_KEY_ENUM_ENABLED_NO',					'enum_enabled_no');
define('LANG_KEY_ENUM_ENABLED_YES',					'enum_enabled_yes');

//Error texts
define('LANG_KEY_ERROR_WRONG_CREDENTIALS',			'error_wrong_credentials');
define('LANG_KEY_ERROR_INVALID_DATE',				'error_invalid_date');
define('LANG_KEY_ERROR_INVALID_GUID',				'error_invalid_GUID');

//Misc
define('LANG_KEY_MISC_REQUIRED_FIELD',				'misc_required_field');

//Event registration
define('LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED',		'body_event_registration_succeeded');
define('LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED_ADMIN',	'body_event_registration_succeeded_admin');
define('LANG_KEY_BODY_EVENT_YOU_CAN_REREGISTER',			'body_event_registration_you_can_reregister');
define('LANG_KEY_BODY_EVENT_YOU_CAN_REREGISTER_ADMIN',		'body_event_registration_you_can_reregister_admin');
define('LANG_KEY_BODY_EVENT_CHECK_CORRECT_ADDRESS',			'body_event_check_correct_address');
define('LANG_KEY_BODY_EVENT_EMAIL_ALREADY_REGISTERED',		'body_event_email_already_registered');
define('LANG_KEY_BODY_EVENT_REGISTRATION_DUE_DATE_PASSED',	'body_event_registration_due_date_passed');
define('LANG_KEY_LINK_REREGISTER',							'link_reregister');