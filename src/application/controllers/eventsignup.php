<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for event signup form
 *
 * @author Emil Floman
 *
*/
class Eventsignup extends CI_Controller {

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
		$data['futureEventList'] = $this->event->get_closest_future_events(50);				
		
		//Load default event listing view	
		$this->load->view($client . VIEW_CONTENT_EVENTSIGNUP_LISTEVENTS, $data);

		

	}
	
	function signup($eventId) {
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));				
		
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
		
		$data['eventData'] = $this->event->getEvent($eventId);
		$data['eventId'] = $eventId;		
		//Load default eventsignup view	
		$this->load->view($client . VIEW_CONTENT_EVENTSIGNUP_SIGNUPFORM, $data);
	
	}
	
	function getevent ($EventId) {
		// gets all event data, outputs an array
	}
	
}