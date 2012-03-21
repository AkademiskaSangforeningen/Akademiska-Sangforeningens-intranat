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
		$this->load->helper('constants_enum');
		
		$this->load->model(DB_TABLE_PERSON, 'person', TRUE);

		$data['personList'] = $this->person->getPersonList();				
		
		$this->load->view($client . VIEW_CONTENT_PERSONS_LISTALL, $data);
	}
	
	function editSingle($personId = NULL) {
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);		
		$this->load->helper('constants_enum');				
		
		if (!is_null($personId)) {
			$this->load->model(DB_TABLE_PERSON, 'person', TRUE);
			$data['person'] = $this->person->getPerson($personId);
			$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE, $data);
		} else {
			$this->load->view($client . VIEW_CONTENT_PERSONS_EDITSINGLE);
		}
	}
}