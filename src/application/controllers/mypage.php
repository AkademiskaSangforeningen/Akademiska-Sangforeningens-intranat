<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for login (and logout)
 *
 * @author André Brunnsberg
 *
*/
class MyPage extends CI_Controller {

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
	
		if ($this->session->userdata(SESSION_LOGGEDIN) == false) {
			redirect(CONTROLLER_LOGIN_LOGOUT, 'refresh');
		}

		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));	

		$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
		$personId = $this->session->userdata(SESSION_PERSONID);
		$person = $this->person->getPerson($personId);
	
		$data['isTransactionAdmin'] = $this->userrights->canAdministrate('transactions', $person->UserRights);
		
    //Load upcoming events. 
    //TODO: Show if user is already registered to an event
    $this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
    $data['events'] = $this->event->get_closest_future_events();
    
		$this->load->view($client . VIEW_GENERIC_HEADER);
		$this->load->view($client . VIEW_GENERIC_HEADER_NAVITABS, $data);
		$this->load->view($client . VIEW_CONTENT_MYPAGE_DASHBOARD);
		$this->load->view($client . VIEW_GENERIC_FOOTER);					
	}
	
	function listUpcomingEvents() {
		if ($this->session->userdata(SESSION_LOGGEDIN) == false) {
			return;
		}

		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));			
		// Load event model
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);		
		$personId = $this->session->userdata(SESSION_PERSONID);
		
		$data['eventList'] = $this->event->getUpcomingEventsForPerson($personId);				
		
		//Load default event listing view	
		$this->load->view($client . VIEW_CONTENT_EVENTS_MY_UPCOMING, $data);		
	}
}