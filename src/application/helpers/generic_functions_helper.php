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