<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for login (and logout)
 *
 * @author André Brunnsberg
 *
*/
class Login extends CI_Controller {

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
	
		if ($this->session->userdata(SESSION_LOGGEDIN) == true) {
			redirect(CONTROLLER_MY_PAGE, 'refresh');
		}
	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);
		
		//Load default login view
		$this->load->view($client . VIEW_GENERIC_HEADER);
		$this->load->view($client . VIEW_CONTENT_LOGIN_FORM);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

	/**
	*	Used for authenticating a single user through form
	*/	
	function authenticate() {
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);
		
		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL,		lang(LANG_KEY_FIELD_EMAIL),		'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PASSWORD, 	lang(LANG_KEY_FIELD_PASSWORD), 	'trim|required|xss_clean|callback__authenticateInDatabase');

		//If errors found, redraw the login form to the user
		if($this->form_validation->run() == FALSE) {
			//Here we could define a different client type based on user agent-headers
			$client = CLIENT_DESKTOP;		
			$this->load->view($client . VIEW_GENERIC_HEADER);
			$this->load->view($client . VIEW_CONTENT_LOGIN_FORM);
			$this->load->view($client . VIEW_GENERIC_FOOTER);
		} else {
			//Otherwise it's green light and the user can be redirected to the internal dashboard
			redirect(CONTROLLER_MY_PAGE, 'refresh');
		}
	}
	
	/**
	*	Used for loging out a user
	*/		
	function logout() {
		//First we destroy the session
	   	$this->session->sess_destroy();
		//And then we direct the user back to the login page
		redirect(CONTROLLER_LOGIN, 'refresh');		
	}
	
	/**
	*	Private function called as callback from authenticate().
	*	Checks if the given username and password is found in the database.
	* @param	string	$password password, comes directly from the form_validator
	* @return 	boolean if user found, return true otherwise false		
	*/			
	function _authenticateInDatabase($password) {
		//Load the model Person with database access
		$this->load->model(DB_TABLE_PERSON, 'person', TRUE);
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);		
	
		//Get the username
		$username = $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL);		
		//Calculate the hash for the password
		$password = $this->_generateHash($password);
	
		//Call the model and check if the user can login with the given credentials
		$row = $this->person->canUserLogin($username, $password);				
		if ($row) {
			//Set the session variables and return true
			$this->session->set_userdata(SESSION_LOGGEDIN, 		true);
			$this->session->set_userdata(SESSION_PERSONID, 		$row->Id);			
			$this->session->set_userdata(SESSION_ACCESSRIGHT,	$row->AccessRight);			
			return true;
		} else {
			//Set and error message and return false
			$this->form_validation->set_message('_authenticateInDatabase', lang(LANG_KEY_ERROR_WRONG_CREDENTIALS));
			return false;
		}
	}

	/**
	*	Private function for generating hashes for a string
	*	The hash is a bcrypt hash with the salt based on the encryption_key also used for session cookies
	* @param	string	$stringToHash The string to calculate a hash on
	* @return 	string Return the calculated hash
	*/	
	function _generateHash($stringToHash) {
		//First get the encryption key in a base64-encoding (to remove false characters) 
		$encryptionKey = base64_encode($this->config->item('encryption_key'));
		//Calculate a 22-char salt
		$salt = substr(str_replace('+', '.', $encryptionKey), 0, 22);
		// Return the hash
		// 2a is the bcrypt algorithm selector, see http://php.net/crypt
		// 10 is the workload factor (around 300ms on a Core i5 machine)
		return crypt($stringToHash, '$2a$10$' . $salt);				
	}
}