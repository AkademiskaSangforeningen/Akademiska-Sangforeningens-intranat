<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserRights {
	const FULL_ACCESS_RIGHTS			= 1;
	
	const TRANSACTIONS_VIEW				= 2;
	const TRANSACTIONS_EDIT				= 4;
	const TRANSACTIONS_DELETE			= 8;
	
	const USERS_VIEW					= 16;
	const USERS_EDIT					= 32;
	const USERS_EDIT_ACCESS_RIGHTS		= 64;
	const USERS_DELETE					= 128;
	
	const EVENTS_VIEW					= 256;
	const EVENTS_EDIT					= 512;
	const EVENTS_DELETE					= 1024;
	const EVENTS_EDIT_REGISTRATION		= 2048;
	const EVENTS_DELETE_REGISTRATION	= 4096;			
	
	function hasRight($right, $userRight) {
		return (($right & $userRight) == $right) || ((self::FULL_ACCESS_RIGHTS & $userRight) == self::FULL_ACCESS_RIGHTS);
	}
}
