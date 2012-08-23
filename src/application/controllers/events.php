<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for event signup form
 *
 * @author Emil Floman
 *
*/
class Events extends CI_Controller {

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
		
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
		
		// Arbitrary limit in use (50)
		$data['eventList'] = $this->event->get_closest_future_events(50);				
		
		//Load default event listing view	
		$this->load->view($client . VIEW_CONTENT_EVENTS_LISTALL, $data);		

	}
	
	/**
	*	Used for editing a single event
	*/		
	function editSingle($eventId = NULL) {	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));				
		
		$data = array();
		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
			$data['person'] = $this->person->getEvent($eventId);
			$data['eventId'] = $eventId;
		}

		$this->load->view($client . VIEW_CONTENT_EVENTS_EDITSINGLE, $data);
	}	
	
	/**
	*	Used for deleting a single event
	*/		
	function deleteSingle($eventId = NULL) {	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;
		
		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
			$this->person->deleteEvent($eventId);
		}
		
		$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
	}	
	
}