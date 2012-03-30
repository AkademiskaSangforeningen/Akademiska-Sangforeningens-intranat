<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for login (and logout)
 *
 * @author André Brunnsberg
 *
*/
class Persons extends CI_Controller {

	function __construct() {
		parent::__construct();	
		
		//Set headers to always load data dynamically
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	/**
	*	Default function for controller	
	*/
	function index() {
		redirect(CONTROLLER_MY_PAGE, 'refresh');
	}
	
	function listAll() {
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);
		
		$this->load->model(DB_TABLE_PERSON, 'person', TRUE);

		$data['personList'] = $this->person->getPersonList();				
		
		$this->load->view($client . VIEW_CONTENT_PERSONS_LISTALL, $data);
	}

	/**
	*	Used for editing a single person
	*/		
	function editSingle($personId = NULL) {
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);		
		
		if (!is_null($personId)) {
			$this->load->model(DB_TABLE_PERSON, 'person', TRUE);
			$data['person'] = $this->person->getPerson($personId);
			$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE, $data);
		} else {
			//$data['person'] = new stdClass();
			$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE);
		}
	}
	
	/**
	*	Used for saving a single person
	*/	
	function saveSingle($personId = NULL) {
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);			
		
		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),		'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 		'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL, 		lang(LANG_KEY_FIELD_EMAIL), 		'trim|max_length[50]|required|valid_email|xss_clean|callback_checkEmailNotDuplicate');
		if (is_null($personId)) {
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD,	lang(LANG_KEY_FIELD_PASSWORD), 	'trim||required|max_length[50]|xss_clean|callback__checkPassword');
		} else {
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD,	lang(LANG_KEY_FIELD_PASSWORD), 	'trim|max_length[50]|xss_clean|callback__checkPassword');
		}		
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_VOICE, 		lang(LANG_KEY_FIELD_VOICE), 		'trim|exact_length[2]|required|xss_clean|callback__checkVoiceInEnumList');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES, 	lang(LANG_KEY_FIELD_ALLERGIES), 	'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PHONE, 		lang(LANG_KEY_FIELD_PHONE), 		'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_ADDRESS, 	lang(LANG_KEY_FIELD_ADDRESS), 		'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_POSTALCODE, lang(LANG_KEY_FIELD_POSTALCODE), 	'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_CITY, 		lang(LANG_KEY_FIELD_CITY), 			'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_COUNTRYID, 	lang(LANG_KEY_FIELD_COUNTRYID), 	'trim|exact_length[2]|xss_clean|callback__checkCountryIdInEnumList');

		//If errors found, redraw the login form to the user
		if($this->form_validation->run() == FALSE) {
			//Here we could define a different client type based on user agent-headers
			$client = CLIENT_DESKTOP;		
			$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE);
		} else {
			$data = array(			
				DB_PERSON_FIRSTNAME 	=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME),
				DB_PERSON_LASTNAME 		=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME),
				DB_PERSON_EMAIL 		=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL),
				DB_PERSON_VOICE 		=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_VOICE),
				DB_PERSON_ALLERGIES 	=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES),
				DB_PERSON_PHONE 		=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_PHONE),
				DB_PERSON_ADDRESS 		=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_ADDRESS),
				DB_PERSON_POSTALCODE	=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_POSTALCODE),
				DB_PERSON_CITY 			=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_CITY),
				DB_PERSON_COUNTRYID		=> $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_COUNTRYID)				
			);
			
			//Only include the password if it has been given.
			//For new users it's a required field.
			if ($this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD) != "") {
				$data[DB_PERSON_PASSWORD] = $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD);
			}						
			
			//Load the person-model
			$this->load->model(DB_TABLE_PERSON, 'person', TRUE);			
			//save the person via the model
			$this->person->savePerson($data, $personId);
		
			//User inserted or updated
			$client = CLIENT_DESKTOP;
			$this->load->view($client . VIEW_CONTENT_PERSONS_SAVESINGLE_SUCCESS);
		}
	}
	
	function _checkVoiceInEnumList($voice) {
		if (!array_key_exists($voice, getEnum(ENUM_VOICES))) {
			$this->form_validation->set_message('_checkVoiceInEnumList', $voice);
			return false;
		}
	}
	
	function checkCountryIdInEnumList($voice) {
		if (!array_key_exists($voice, getEnum(ENUM_COUNTRIES))) {
			$this->form_validation->set_message('checkCountryIdInEnumList', $voice);
			return false;
		}
	}
	
	function _checkPassword($password) {
		//TODO: function should check if len($password) > 0 and
		//		compare it with the password_again found in the post
		return true;
	}
}