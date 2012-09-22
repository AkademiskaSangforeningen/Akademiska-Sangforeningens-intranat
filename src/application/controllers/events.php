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
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
		
		// Arbitrary limit in use (50)
		$data['eventList'] = $this->event->get_closest_future_events(50);				
		$this->load->view($client . VIEW_CONTENT_EVENTS_LISTALL, $data);		
	}
	
	/**
	*	Used for editing a single event
	*/		
	function editSingle($eventId = NULL) {	
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));				
		
		$data = array();
    $data['eventItems'] = array();
		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
			$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), TRUE);
			$data['event'] 		= $this->event->getEvent($eventId);
			$data['eventId'] 	= $eventId;
			$data['eventItems'] = $this->eventitem->getEventItems($eventId);
		}
		
		//Load edit items, add them to $data-object

		$this->load->view($client . VIEW_CONTENT_EVENTS_EDITSINGLE, $data);
		
	}	
	
	/**
	*	Used for deleting a single event
	*/		
	function deleteSingle($eventId = NULL) {	
		$client = CLIENT_DESKTOP;
		
		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
			$this->event->deleteEvent($eventId);
		}
		
		$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
	}	
	
	/**
	*	Used for saving a single event
	*/	
	function saveSingle($eventId = NULL) {
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));					
		//Load module
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), TRUE);
		
		$itemRows = $this->_getEventItemRowNumbers();
		
		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_NAME,								lang(LANG_KEY_FIELD_NAME),					'trim|max_length[255]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_LOCATION, 						lang(LANG_KEY_FIELD_LOCATION),				'trim|max_length[255]|xss_clean');
    $this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PRICE, 						lang(LANG_KEY_FIELD_LOCATION),				'trim|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE,						lang(LANG_KEY_FIELD_STARTDATE), 			'trim|max_length[10]|required|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_HH,			lang(LANG_KEY_FIELD_STARTDATE), 			'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_MM,			lang(LANG_KEY_FIELD_STARTDATE), 			'trim|max_length[2]|is_natural');		
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE,							lang(LANG_KEY_FIELD_FINISHDATE),			'trim|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_HH,				lang(LANG_KEY_FIELD_FINISHDATE),			'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_MM,				lang(LANG_KEY_FIELD_FINISHDATE),			'trim|max_length[2]|is_natural');		
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE,				lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE), 	'trim|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH,	lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE), 	'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM,	lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE), 	'trim|max_length[2]|is_natural');				
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE,					lang(LANG_KEY_FIELD_PAYMENT_DUEDATE),		'trim|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH,		lang(LANG_KEY_FIELD_PAYMENT_DUEDATE), 		'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM,		lang(LANG_KEY_FIELD_PAYMENT_DUEDATE), 		'trim|max_length[2]|is_natural');				
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_DESCRIPTION, 						lang(LANG_KEY_FIELD_DESCRIPTION),			'trim|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE . '[]', 				lang(LANG_KEY_FIELD_PAYMENTTYPE),			'trim|xss_clean|is_natural');

		foreach ($itemRows as $rowNumber) {
			$this->form_validation->set_rules("EventItem_Caption" . $rowNumber, lang(LANG_KEY_FIELD_DESCRIPTION),			'trim|xss_clean');		
		}
		
		//If errors found, redraw the login form to the user
		if($this->form_validation->run() == FALSE) {
			$client = CLIENT_DESKTOP;
			$data['eventId'] = $eventId;
			$this->load->view($client . VIEW_CONTENT_EVENTS_EDITSINGLE, $data);
		} else {					
			$data = array(		
				DB_EVENT_NAME 					=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_NAME),
				DB_EVENT_LOCATION 				=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_LOCATION),
				DB_EVENT_PRICE => $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PRICE),
        DB_EVENT_STARTDATE 				=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE), 
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_HH), 
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_MM)),
				
        DB_EVENT_ENDDATE 				=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE), 
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_HH), 
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_MM)),
				DB_EVENT_REGISTRATIONDUEDATE 	=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE),
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH),
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM)),				
				DB_EVENT_PAYMENTDUEDATE 		=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE),
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH),
														$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM)),
				DB_EVENT_DESCRIPTION 			=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_DESCRIPTION),
				DB_EVENT_RESPONSIBLEID			=> $this->session->userdata(SESSION_PERSONID),
				DB_EVENT_PAYMENTTYPE			=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE))
			);									

			// Start a database transaction
			$this->db->trans_start();
				
			// Save the event
			$eventId = $this->event->saveEvent($data, $eventId);
			
			// Make an array of all event item IDs not to delete
			$eventItemIdsNotToDelete = array();
			
			//Go through all event items and save them
			foreach ($itemRows as $rowNumber) {			
				$data = array(
					DB_EVENTITEM_EVENTID		=> $eventId,
					DB_EVENTITEM_TYPE			=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_TYPE . $rowNumber),
					DB_EVENTITEM_CAPTION		=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_CAPTION . $rowNumber),
					DB_EVENTITEM_DESCRIPTION	=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_DESCRIPTION . $rowNumber),
					DB_EVENTITEM_AMOUNT			=> parseAmount($this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_AMOUNT . $rowNumber)),
					DB_EVENTITEM_MAXPCS			=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_MAXPCS . $rowNumber)
				);
				
				$eventItemId = $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_ID . $rowNumber);
				if ($eventItemId == "") {
					$eventItemId = NULL;
				}				
				$eventItemIdsNotToDelete[] = $this->eventitem->saveEventItem($data, $eventItemId);				
			}
			
			// Delete event items not saved
			$this->eventitem->deleteEventItems($eventId, $eventItemIdsNotToDelete);						
			
			// Commit the transaction
			$this->db->trans_complete();
			
			// Event inserted or updated
			$client = CLIENT_DESKTOP;
			$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
		}
	}
  
  function showEvent($eventId) {
    $this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
    $event = $this->event->getEvent($eventId);
    
    if($event){
      $data['event'] = $event;
      $this->load->view(CLIENT_DESKTOP . VIEW_GENERIC_HEADER);
      $this->load->view(CLIENT_DESKTOP . '/content/events/showevent', $data);
      $this->load->view(CLIENT_DESKTOP . VIEW_GENERIC_FOOTER);
    } else {
      show_error("Could not find event for id: '" . $eventId . "'");
    }
  }

	function _checkDateValid($date) {
		if ($date != "" && !isDateValid($date)) {
			$this->form_validation->set_message('_checkDateValid', "Fel datum din pucko: %s!");
			return false;		
		}
	}

	function _getEventItemRowNumbers() {
		$rowNumbers = array();
		$keys = array_keys($this->input->post());
		foreach($keys as $key) {
			if (preg_match('/(EventItem_Id)(\d)/i', $key, $matches)) {
				$rowNumbers[] = $matches[2];
			}
		}	
		
		return $rowNumbers;
	}
	
}

