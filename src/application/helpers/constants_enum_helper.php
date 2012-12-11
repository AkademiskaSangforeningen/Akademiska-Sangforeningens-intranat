<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Enumerations
 *
 * @author André Brunnsberg
 *
*/

define('ENUM_VOICES',		'enum_voices');
define('ENUM_COUNTRIES',	'enum_countries');
define('ENUM_ENABLED',		'enum_enabled');
define('ENUM_PAYMENTTYPE',	'enum_paymenttype');

define('ENUM_PAYMENTTYPE_TRANSACTION', 	1);
define('ENUM_PAYMENTTYPE_CASH', 		2);
define('ENUM_PAYMENTTYPE_BANK_ACCOUNT',	4);


function getEnum($enum) {
	switch($enum) {
		case ENUM_VOICES:
			return array(
					'1T'  	=> 	lang(LANG_KEY_ENUM_VOICE_1_TENOR),
					'2T'  	=> 	lang(LANG_KEY_ENUM_VOICE_2_TENOR),
					'1B'  	=> 	lang(LANG_KEY_ENUM_VOICE_1_BASS),
					'2B'	=>	lang(LANG_KEY_ENUM_VOICE_2_BASS),
					'Dr'	=> 	lang(LANG_KEY_ENUM_VOICE_CONDUCTOR)
				);	
		case ENUM_COUNTRIES:
			return array(
					'fi'  	=> 	lang(LANG_KEY_ENUM_COUNTRY_FINLAND),
					'sv'  	=> 	lang(LANG_KEY_ENUM_COUNTRY_SWEDEN),
					'nn'  	=> 	lang(LANG_KEY_ENUM_COUNTRY_OTHER)
				);	
		case ENUM_ENABLED:
			return array(
					0		=> lang(LANG_KEY_ENUM_ENABLED_NO),
					1		=> lang(LANG_KEY_ENUM_ENABLED_YES)
				);
		case ENUM_PAYMENTTYPE:
			return array(
					ENUM_PAYMENTTYPE_TRANSACTION	=> "Kvartettkonto",
					ENUM_PAYMENTTYPE_CASH			=> "Kontant vid evenemanget",
					ENUM_PAYMENTTYPE_BANK_ACCOUNT	=> "Kontobetalning"
				);		
		default:
			return;
	}
}

function getEnumValue($enum, $value) {
	$array = getEnum($enum);
	return $array[$value];
}