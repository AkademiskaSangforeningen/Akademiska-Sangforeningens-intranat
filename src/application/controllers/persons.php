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

		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		
		$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);

		$data['personList'] = $this->person->getPersonList();				
		
		$this->load->view($client . VIEW_CONTENT_PERSONS_LISTALL, $data);
	}

	/**
	*	Used for deleting a single event
	*/		
	function deleteSingle($personId = NULL) {	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;
		
		if (!is_null($personId)) {
			$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
			$this->person->deletePerson($personId);
		}
		
		$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
	}		
	
	/**
	*	Used for editing a person's own information
	*/		
	function editMyInformation() {
		//Set the personId to the one in user's session
		$personId = $this->session->userdata(SESSION_PERSONID);
		//And call the default edit function with a pre-defined controller
		$this->editSingle($personId, CONTROLLER_PERSONS_SAVE_MY_INFORMATION);
	}
	
	/**
	*	Used for saving a person's own information
	*/		
	function saveMyInformation() {
		//Set the personId to the one in user's session
		$personId = $this->session->userdata(SESSION_PERSONID);
		//And call the default save function with a pre-defined controller
		$this->saveSingle($personId, CONTROLLER_PERSONS_SAVE_MY_INFORMATION);
	}	
	
	/**
	*	Used for editing a single person
	*/		
	function editSingle($personId = NULL, $controller = NULL) {	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));				
		
		if (!is_null($personId)) {
			$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
			$data['person'] = $this->person->getPerson($personId);
			$data['personId'] = $personId;
		}
		$data['controller'] = !is_null($controller) ? $controller : CONTROLLER_PERSONS_SAVESINGLE;
		$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE, $data);
	}
	
	/**
	*	Used for saving a single person
	*/	
	function saveSingle($personId = NULL, $controller = NULL) {
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));			
		
		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),		'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 		'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL, 		lang(LANG_KEY_FIELD_EMAIL), 		'trim|max_length[50]|required|valid_email|xss_clean|callback_checkEmailNotDuplicate');
		if (is_null($personId)) {
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD,	lang(LANG_KEY_FIELD_PASSWORD), 	'trim|required|max_length[50]|xss_clean|callback__checkPassword');
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
			$data['personId'] = $personId;
			$data['controller'] = !is_null($controller) ? $controller : CONTROLLER_PERSONS_SAVESINGLE;			
			$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE, $data);
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
				$data[DB_PERSON_PASSWORD] = generateHash($this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD), $this->config->item('encryption_key'));
			}						
			
			//Load the person-model
			$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
			//save the person via the model
			$this->person->savePerson($data, $personId);
		
			//User inserted or updated
			$client = CLIENT_DESKTOP;
			$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
		}
	}
	
	function _checkVoiceInEnumList($voice) {
		if (!array_key_exists($voice, getEnum(ENUM_VOICES))) {
			$this->form_validation->set_message('_checkVoiceInEnumList', $voice);
			return false;
		}
	}
	
	function _checkCountryIdInEnumList($voice) {
		if (!array_key_exists($voice, getEnum(ENUM_COUNTRIES))) {
			$this->form_validation->set_message('_checkCountryIdInEnumList', $voice);
			return false;
		}
	}
	
	function _checkPassword($password) {
		$passwordRepeated = $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD . '_repeat');
		if (($password != "" || $passwordRepeated != "") && $password != $passwordRepeated) {
			$this->form_validation->set_message('_checkPassword', $password);
			return false;
		}
	}
}