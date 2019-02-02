<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generic constants
 *
 * @author André Brunnsberg
 *
*/

//Client
define('CLIENT_DESKTOP',					'desktop');
define('CLIENT_MOBILE',						'mobile');

//HTTP params
define('HTTP_DIALOG',						'dialog');
define('HTTP_SHOWASCSV',					'showascsv');
define('HTTP_WILDCARDSEARCH', 				'wildcardsearch');

//Placeholders
define('PLACEHOLDER_PERSON',				'[person]');

//Session
define('SESSION_LOGGEDIN',					'LoggedIn');
define('SESSION_PERSONID',					'PersonId');
define('SESSION_LANG',						'Lang');
define('SESSION_NAME',						'Name');
define('SESSION_EMAIL',						'Email');
define('SESSION_ACCESSRIGHT',				'AccessRight');

define('PREFIX_HH',							'_hh');
define('PREFIX_MM',							'_mm');

//Event types
define('EVENT_TYPE_RADIO',					1);
define('EVENT_TYPE_CHECKBOX',				2);
define('EVENT_TYPE_TEXTAREA',				3);

//Person statuses
define('PERSON_STATUS_EXTERNAL',			0);
define('PERSON_STATUS_INTERNAL',			10);

//List views
define('LIST_DEF_PAGING',					100);
define('LIST_DEF_PAGING_MINI_LIST',			10);