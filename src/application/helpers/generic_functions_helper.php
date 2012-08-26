<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Generic functions, can be used by all controllers
 *
 * @author André Brunnsberg
 *
*/

	/**
	*	Private function for generating hashes for a string
	*	The hash is a bcrypt hash with the salt based on the encryption_key also used for session cookies
	* @param	string	$stringToHash The string to calculate a hash on
	* @return 	string Return the calculated hash
	*/	
	function generateHash($stringToHash, $encryptionKey) {
		//First get the encryption key in a base64-encoding (to remove false characters) 
		$encryptionKey = base64_encode($encryptionKey);
		//Calculate a 22-char salt
		$salt = substr(str_replace('+', '.', $encryptionKey), 0, 22);
		// Return the hash
		// 2a is the bcrypt algorithm selector, see http://php.net/crypt
		// 10 is the workload factor (around 300ms on a Core i5 machine)
		return crypt($stringToHash, '$2a$10$' . $salt);				
	}
	

	/**
	*	Private function for generating a unique guid
	*	The function falls back to com_create_guid if available (only on Windows platform)
	* @return 	string a GUID e.g. {E9804D0B-8478-88FD-0140-7EA5FDAC5154}
	*/		
	function generateGuid(){
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)// "{"
					.substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12)
					.chr(125);// "}"
			return $uuid;
		}
	}

	/**
	*	Private function for validating dates using RegEx for the format dd.mm.yyyy.
	*	If the RegEx returns true the date is also checked to be calendar-valid (e.g. 29.2.2011 is not valid)
	* @return 	true or false
	*/		
	function isDateValid($date) {
		if (preg_match ("/^(0[1-9]|[12][0-9]|3[01]|[1-9])\.(0[1-9]|1[012]|[1-9])\.(\d{4})$/", $date, $parts)) {
			if(checkdate($parts[2],$parts[1],$parts[3])) {
				return true;
			} else {
				return false;
			}
        } else {
			return false;
		}
	}
	
	function extractHoursFromDate($date) {
		if (is_null($date) || $date == "") {
			return null;
		}
		$timeStamp = strtotime($date);
		$parsedDate = getdate($timeStamp);
		
		if (($parsedDate["hours"] != 0 || $parsedDate["minutes"] != 0)) {
			return $parsedDate["hours"];
		} else {
			return null;
		}
	}
	
	function extractMinutesFromDate($date) {
		if (is_null($date) || $date == "") {
			return null;
		}
		$timeStamp = strtotime($date);
		$parsedDate = getdate($timeStamp);
		if (($parsedDate["hours"] != 0 || $parsedDate["minutes"] != 0)) {
			return $parsedDate["minutes"];
		} else {
			return null;
		}
	}	
	
	function formatDateGerman($date, $includeTime = true) {
		if (is_null($date) || $date == "") {
			return "";
		}

		$timeStamp = strtotime($date);
		$parsedDate = getdate($timeStamp);
		if ($includeTime && ($parsedDate["hours"] != 0 || $parsedDate["minutes"] != 0)) {
			return date('d.m.Y H:i', $timeStamp);
		} else {
			return date('d.m.Y', $timeStamp);
		}			
	}
	
	function formatDateODBC($date, $hours = 0, $minutes = 0) {
		if (is_null($date) || $date == "") {
			return null;
		}		
		if (is_null($hours) || $hours == "") {
			$hours = 0;
		}
		if (is_null($minutes) || $minutes == "") {
			$minutes = 0;
		}
		
		return date('Y-m-d H:i', strtotime($date . " " . $hours . ":" . $minutes));
	}	
	
	function formatCurrency($value) {
		return '€' . number_format($value, 2, ",", "");
	}