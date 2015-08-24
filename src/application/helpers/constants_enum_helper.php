<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Enumerations
 *
 * @author André Brunnsberg
 *
*/

define('ENUM_VOICES',			'enum_voices');
define('ENUM_COUNTRIES',		'enum_countries');
define('ENUM_ENABLED',			'enum_enabled');
define('ENUM_PAYMENTTYPE',		'enum_paymenttype');
define('ENUM_SHOW_FOR_AVEC',	'enum_show_for_avec');

define('ENUM_PAYMENTTYPE_TRANSACTION', 	1);
define('ENUM_PAYMENTTYPE_CASH', 		2);
define('ENUM_PAYMENTTYPE_BANK_ACCOUNT',	4);
define('ENUM_PAYMENTTYPE_E_INVOICE',	8);

define('ENUM_VOICE_1T',	'1T');
define('ENUM_VOICE_2T',	'2T');
define('ENUM_VOICE_1B',	'1B');
define('ENUM_VOICE_2B',	'2B');
define('ENUM_VOICE_1S', '1S');
define('ENUM_VOICE_2S', '2S');
define('ENUM_VOICE_1A', '1A');
define('ENUM_VOICE_2A', '2A');
define('ENUM_VOICE_DR',	'Dr');

define('ENUM_SHOW_FOR_AVECS_ONLY',					2);
define('ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE',	3);

function getEnum($enum) {
	switch($enum) {
		case ENUM_VOICES:
			return array(
					ENUM_VOICE_1T	=> 	lang(LANG_KEY_ENUM_VOICE_1_TENOR),
					ENUM_VOICE_2T	=> 	lang(LANG_KEY_ENUM_VOICE_2_TENOR),
					ENUM_VOICE_1B	=> 	lang(LANG_KEY_ENUM_VOICE_1_BASS),
					ENUM_VOICE_2B	=>	lang(LANG_KEY_ENUM_VOICE_2_BASS),					
					ENUM_VOICE_1S	=>	lang(LANG_KEY_ENUM_VOICE_1_SOPRANO),
					ENUM_VOICE_2S	=>	lang(LANG_KEY_ENUM_VOICE_2_SOPRANO),
					ENUM_VOICE_1A	=>	lang(LANG_KEY_ENUM_VOICE_1_ALTO),
					ENUM_VOICE_2A	=>	lang(LANG_KEY_ENUM_VOICE_2_ALTO),
					ENUM_VOICE_DR	=> 	lang(LANG_KEY_ENUM_VOICE_CONDUCTOR)
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
					ENUM_PAYMENTTYPE_BANK_ACCOUNT	=> "Kontobetalning",
					ENUM_PAYMENTTYPE_E_INVOICE		=> "E-faktura"
				);
		case ENUM_SHOW_FOR_AVEC:
			return array(
					0											=> lang(LANG_KEY_ENUM_ENABLED_NO),
					ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE 	=> lang(LANG_KEY_ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE),
					1											=> lang(LANG_KEY_ENUM_ENABLED_YES),
					ENUM_SHOW_FOR_AVECS_ONLY					=> lang(LANG_KEY_ENUM_SHOW_FOR_AVECS_ONLY)
					
			);
		default:
			return;
	}
}

function getEnumValue($enum, $value) {
	$array = getEnum($enum);
	return (array_key_exists($value, $array) ? $array[$value] : NULL);
}