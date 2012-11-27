<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for event signup form
 *
 * @author André Brunnsberg
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

	function listAll($offset = 0) {
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
		$this->load->library('pagination');
		
		$eventList = $this->event->getAllEvents(LIST_DEF_PAGING, $offset);

		$config['base_url'] 	= site_url() . CONTROLLER_EVENTS_LISTALL . '/';
		$config['total_rows']	= $eventList[0]->{DB_TOTALCOUNT};
		$config['first_link'] 	= lang(LANG_KEY_BUTTON_PAGING_FIRST);
		$config['last_link'] 	= lang(LANG_KEY_BUTTON_PAGING_LAST);
		$config['anchor_class']	= 'class="button" ';
		$config['per_page'] 	= LIST_DEF_PAGING; 
		$this->pagination->initialize($config); 

		$data['eventList'] 	= $eventList;
		$data['pagination']	= $this->pagination->create_links();
		
		$this->load->view($client . VIEW_CONTENT_EVENTS_LISTALL, $data);
	}
	
	function listSingleEventRegistrations($eventId, $offset = 0) {
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		$this->load->library('pagination');

		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);		
				
		$personHasEventItems = array();
		foreach($this->eventitem->getPersonHasEventItems($eventId) as $key => $personHasEventItem) {
			$innerArray[$personHasEventItem->{DB_PERSONHASEVENTITEM_EVENTITEMID}] = array(
				DB_PERSONHASEVENTITEM_DESCRIPTION => $personHasEventItem->{DB_PERSONHASEVENTITEM_DESCRIPTION},
				DB_PERSONHASEVENTITEM_AMOUNT => $personHasEventItem->{DB_PERSONHASEVENTITEM_AMOUNT}
			);
			$personHasEventItems[$personHasEventItem->{DB_PERSONHASEVENTITEM_PERSONID}] = $innerArray;
		}
		
		$eventItemSums = array();
		foreach($this->eventitem->getEventItemSums($eventId) as $key => $eventItemSum) {
			$eventItemSums[$eventItemSum->{DB_PERSONHASEVENTITEM_EVENTITEMID}] = $eventItemSum->{DB_TOTALCOUNT};				
		}
		
		$data = array();
		$data['eventId'] 				= $eventId;
		$data['personHasEventItems']	= $personHasEventItems;		
		$data['event'] 					= $this->event->getEvent($eventId);
		$data['persons']				= $this->event->getPersonsForEvent($eventId, LIST_DEF_PAGING, $offset);
		$data['eventItems'] 			= $this->eventitem->getEventItems($eventId);
		$data['eventItemSums']			= $eventItemSums;	
		
		$config['base_url'] 	= site_url() . CONTROLLER_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS . '/' . $eventId . '/';
		$config['total_rows']	= $data['persons'][0]->{DB_TOTALCOUNT};
		$config['first_link'] 	= lang(LANG_KEY_BUTTON_PAGING_FIRST);
		$config['last_link'] 	= lang(LANG_KEY_BUTTON_PAGING_LAST);
		$config['anchor_class']	= 'class="button" ';
		$config['per_page'] 	= LIST_DEF_PAGING; 
		$config['uri_segment'] 	= 4;
		$this->pagination->initialize($config); 
		$data['pagination']	= $this->pagination->create_links();
		
		//Load parts
		$data['part_eventInfo']		= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT, $data, TRUE);		
				
		$this->load->view($client . VIEW_CONTENT_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS, $data);
	}

	/**
	*	Used for editing a single event
	*/
	function editSingle($eventId = NULL) {
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));

		//Load edit items, add them to $data-object
		$data = array();
		$data['eventItems'] = array();
		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
			$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);

			$data['eventId'] 	= $eventId;
			$data['event'] 		= $this->event->getEvent($eventId);			
			$data['eventItems'] = $this->eventitem->getEventItems($eventId, NULL);
		}
		$this->load->view($client . VIEW_CONTENT_EVENTS_EDITSINGLE, $data);
	}

	function editRegister($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);					
		
		//Load models
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);	

		//Load event and person has event bind
		$event = $this->event->getEvent($eventId);
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		
		//Show error message and return if person has event bind is not found
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent) === FALSE) {
			return;
		}
		
		//Add parameters to view $data-object
		$data = array();	
		$data['eventId']	= $eventId;
		$data['personId'] 	= $personId;
		$data['hash'] 		= $hash;
		$data['dialog']		= TRUE;
		
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		$personAvecId	= isset($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID}) ? $personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} : NULL;
						
		/*	Load different dynamic parts of the page */
		//Event info
		$data_part_info_event['eventId']	= $eventId;
		$data_part_info_event['event'] 		= $event;			
		$data['part_info_event'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT,	$data_part_info_event, TRUE);	
		
		//Person form
		if ($personId != $this->session->userdata(SESSION_PERSONID)) {		
			$data_part_form_person['person']		= $this->person->getPerson($personId);
			$data_part_form_person['fieldPrefix']	= '';
			$data_part_form_person['showFields']	= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_PHONE, DB_PERSON_ALLERGIES) 
															: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_PHONE, DB_PERSON_ALLERGIES);
			$data['part_form_person'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_person, TRUE);
		}
			
		//Payment form
		$data_part_form_payment['personHasEvent'] = $personHasEvent;
		$data['part_form_payment'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PAYMENT, $data_part_form_payment, TRUE);

		//Event items form
		$part_form_eventItems['eventItems']		= $this->eventitem->getEventItems($eventId, $personId);
		$part_form_eventItems['currentIsAvec']	= FALSE;
		$part_form_eventItems['fieldPrefix']	= '';
		$part_form_eventItems['personId']		= $personId;
		$data['part_form_eventitems'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$part_form_eventItems, TRUE);		
		
		if ($event->{DB_EVENT_AVECALLOWED} == 1) {
			//Avec allowed form
			$data_part_form_avecAllowed['personHasEvent'] = $personHasEvent;
			$data['part_form_avecallowed'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_AVEC_ALLOWED,	$data_part_form_avecAllowed, TRUE);	

			//Person avec form
			$data_part_form_personAvec['updateRegistration']	= ($personId != NULL);
			$data_part_form_personAvec['person']				= $this->person->getPerson($personAvecId);
			$data_part_form_personAvec['fieldPrefix']			= DB_CUSTOM_AVEC . '_';
			$data_part_form_personAvec['showFields']			= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES) 
																		: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_ALLERGIES);		
			$data['part_form_personAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_personAvec, TRUE);

			//Event items avec form
			$data_part_form_eventItemsAvec['eventItems'] 	= $this->eventitem->getEventItems($eventId, $personAvecId);
			$data_part_form_eventItemsAvec['currentIsAvec']	= TRUE;
			$data_part_form_eventItemsAvec['fieldPrefix']	= DB_CUSTOM_AVEC . '_';
			$data_part_form_eventItemsAvec['personId']		= $personId;
			$data['part_form_eventitemsAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$data_part_form_eventItemsAvec, TRUE);		
		}					

		//Finally load the main views
		$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER, $data);
	}	
	
	function editRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);					
		
		//Load models
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);	

		//Load event and person has event bind
		$event = $this->event->getEvent($eventId);
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		
		//Show error message and return if person has event bind is not found
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent) === FALSE) {
			return;
		}
		
		//Add parameters to view $data-object
		$data = array();	
		$data['eventId']	= $eventId;
		$data['personId'] 	= $personId;
		$data['hash'] 		= $hash;
		$data['dialog']		= FALSE;
		
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		$personAvecId	= isset($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID}) ? $personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} : NULL;
						
		/*	Load different dynamic parts of the page */
		//Event info
		$data_part_info_event['eventId']	= $eventId;
		$data_part_info_event['event'] 		= $event;			
		$data['part_info_event'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT,	$data_part_info_event, TRUE);	
		
		//Person form
		$data_part_form_person['person']		= $this->person->getPerson($personId);
		$data_part_form_person['fieldPrefix']	= '';
		$data_part_form_person['showFields']	= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_PHONE, DB_PERSON_ALLERGIES) 
														: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_PHONE, DB_PERSON_ALLERGIES);
		$data['part_form_person'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_person, TRUE);
		
		//Payment form
		$data_part_form_payment['personHasEvent'] = $personHasEvent;
		$data['part_form_payment'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PAYMENT, $data_part_form_payment, TRUE);

		//Event items form
		$part_form_eventItems['eventItems']		= $this->eventitem->getEventItems($eventId, $personId);
		$part_form_eventItems['currentIsAvec']	= FALSE;
		$part_form_eventItems['fieldPrefix']	= '';
		$part_form_eventItems['personId']		= $personId;
		$data['part_form_eventitems'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$part_form_eventItems, TRUE);		
		
		if ($event->{DB_EVENT_AVECALLOWED} == 1) {
			//Avec allowed form
			$data_part_form_avecAllowed['personHasEvent'] = $personHasEvent;
			$data['part_form_avecallowed'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_AVEC_ALLOWED,	$data_part_form_avecAllowed, TRUE);	

			//Person avec form
			$data_part_form_personAvec['updateRegistration']	= ($personId != NULL);
			$data_part_form_personAvec['person']				= $this->person->getPerson($personAvecId);
			$data_part_form_personAvec['fieldPrefix']			= DB_CUSTOM_AVEC . '_';
			$data_part_form_personAvec['showFields']			= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES) 
																		: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_ALLERGIES);		
			$data['part_form_personAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_personAvec, TRUE);

			//Event items avec form
			$data_part_form_eventItemsAvec['eventItems'] 	= $this->eventitem->getEventItems($eventId, $personAvecId);
			$data_part_form_eventItemsAvec['currentIsAvec']	= TRUE;
			$data_part_form_eventItemsAvec['fieldPrefix']	= DB_CUSTOM_AVEC . '_';
			$data_part_form_eventItemsAvec['personId']		= $personId;
			$data['part_form_eventitemsAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$data_part_form_eventItemsAvec, TRUE);		
		}					

		//Finally load the main views
		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER, $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

	function saveRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL, $dialog = FALSE) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);					
		
		//Load models
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);	

		//Load event and person has event bind
		$event = $this->event->getEvent($eventId);
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		
		//Show error message and return if person has event bind is not found
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent) === FALSE) {
			return;
		}		

		$updateRegistration = ($personId != NULL);

		//Load the validation library
		$this->load->library('form_validation');

		//Validate the form
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),				'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 				'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES, 	lang(LANG_KEY_FIELD_ALLERGIES), 			'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PHONE, 		lang(LANG_KEY_FIELD_PHONE), 				'trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', 	DB_PERSONHASEVENTITEM_EVENTITEMID . '[]',	'trim|callback__checkGuidValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED, 	lang(LANG_KEY_FIELD_AVEC),					'trim|max_length[1]|xss_clean|numeric');
		$this->form_validation->set_rules(DB_TABLE_PERSONHASEVENT . '_' . DB_PERSONHASEVENT_PAYMENTTYPE, lang(LANG_KEY_FIELD_PAYMENTTYPE), 'required|trim|max_length[1]|xss_clean');
		
		//Only validate the email if it's in the POST
		if ($this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL) !== FALSE) {
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL, 		lang(LANG_KEY_FIELD_EMAIL), 			'trim|max_length[50]|required|valid_email|xss_clean');
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL, 	lang(LANG_KEY_FIELD_EMAIL),					'callback__checkAlreadyRegistreredEmail['. $eventId . ']');
		}

		//Validate the avec data if user has selected an avec on the form
		if ($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED) == TRUE) {
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),			'trim|max_length[50]|required|xss_clean');
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 			'trim|max_length[50]|required|xss_clean');
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES, 	lang(LANG_KEY_FIELD_ALLERGIES), 		'trim|max_length[50]|xss_clean');
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]',	'trim|callback__checkGuidValid');
		}

		//Validate individual event items' special fields
		$eventItems = $this->eventitem->getEventItems($eventId, NULL);
		foreach($eventItems as $key => $eventItem) {
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, 	DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', 	'trim|max_length[8096]|xss_clean');
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, 		DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', 	'trim|numeric|xss_clean');
			$this->form_validation->set_rules($eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, 							DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', 							'trim|max_length[8096]|xss_clean');
			$this->form_validation->set_rules($eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, 								DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', 							'trim|numeric|xss_clean');
		}

		//If errors found, redraw the login form to the user
		if($this->form_validation->run() === FALSE) {
			$client = CLIENT_DESKTOP;
			$data = array();
			$data['eventId']	= $eventId;
			$data['personId'] 	= $personId;
			$data['hash'] 		= $hash;
			$data['dialog']		= $dialog;
			
			/*	Load different dynamic parts of the page */
			//Event info
			$data_part_info_event['eventId']	= $eventId;
			$data_part_info_event['event'] 		= $this->event->getEvent($eventId);			
			$data['part_info_event'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT,	$data_part_info_event, TRUE);	
			
			//Person form
			$data_part_form_person['fieldPrefix']	= '';
			$data_part_form_person['showFields']	= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_PHONE, DB_PERSON_ALLERGIES) 
															: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_PHONE, DB_PERSON_ALLERGIES);
			$data['part_form_person'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_person, TRUE);
			
			//Payment form
			$data['part_form_payment']		= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PAYMENT, array(), TRUE);
			
			//Event items form
			$part_form_eventItems['eventItems']		= $eventItems;
			$part_form_eventItems['currentIsAvec']	= FALSE;
			$part_form_eventItems['fieldPrefix']	= '';
			$part_form_eventItems['personId']		= $personId;
			$data['part_form_eventitems']	= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$part_form_eventItems, TRUE);		
			
			if ($event->{DB_EVENT_AVECALLOWED} == 1) {
				//Avec allowed form
				$data_part_form_avecAllowed['personHasEvent'] = $personHasEvent;
				$data['part_form_avecallowed']	= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_AVEC_ALLOWED,	$data_part_form_avecAllowed, TRUE);	

				//Person avec form
				$data_part_form_personAvec['updateRegistration']	= ($personId != NULL);
				$data_part_form_personAvec['fieldPrefix']			= DB_CUSTOM_AVEC . '_';
				$data_part_form_personAvec['showFields']			= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES) 
																			: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_ALLERGIES);		
				$data['part_form_personAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_personAvec, TRUE);

				//Event items avec form
				$data_part_form_eventItemsAvec['eventItems'] 	= $eventItems;
				$data_part_form_eventItemsAvec['currentIsAvec']	= TRUE;
				$data_part_form_eventItemsAvec['fieldPrefix']	= DB_CUSTOM_AVEC . '_';
				$data_part_form_eventItemsAvec['personId']		= $personId;
				$data['part_form_eventitemsAvec']	= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$data_part_form_eventItemsAvec, TRUE);		
			}			
			
			//Finally load the main views
			if ($dialog == FALSE) {
				$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			}
			$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER, $data);
			if ($dialog == FALSE) {
				$this->load->view($client . VIEW_GENERIC_FOOTER);
			}
			
		} else {		
			// Start a database transaction
			$this->db->trans_start();		
		
			//Get personId if not set using the email address and save the person data
			if (!$updateRegistration) {
				$personId = $this->person->getPersonIdUsingEmail($this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL));
			}								
			
			$personData = array();				
			addToArrayIfNotFalse($personData, DB_PERSON_FIRSTNAME, 	$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME));
			addToArrayIfNotFalse($personData, DB_PERSON_LASTNAME, 	$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME));
			addToArrayIfNotFalse($personData, DB_PERSON_EMAIL, 		$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL));
			addToArrayIfNotFalse($personData, DB_PERSON_ALLERGIES, 	$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES));
			addToArrayIfNotFalse($personData, DB_PERSON_PHONE, 		$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_PHONE));

			//Save the person, if a new person the GUID of the new person is returned
			$personId = $this->person->savePerson($personData, $personId, $personId);

			// Save all event items for the person
			$eventItemIds = $this->input->post(DB_PERSONHASEVENTITEM_EVENTITEMID);
			if ($eventItemIds !== FALSE) {
				foreach ($eventItemIds as $eventItemId) {
					$eventItemAmount 		= $this->input->post($eventItemId . '_' . DB_PERSONHASEVENTITEM_AMOUNT, 		TRUE);
					$eventItemDescription 	= $this->input->post($eventItemId . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, 	TRUE);
					if ($eventItemAmount === FALSE) {
						$eventItemAmount = 1;
					}
					if ($eventItemDescription === FALSE) {
						$eventItemDescription = NULL;
					}

					//Don't save not-selected event items or event items with empty (but not NULL) descriptions
					if ($eventItemAmount == 0 || $eventItemDescription === '') {
						continue;
					}

					//Save a single person event item link into the database
					$this->eventitem->savePersonHasEventItem($personId, $eventItemId, $eventItemAmount, $eventItemDescription, $personId);
				}
			}
			// Delete orphan event items for the person
			$this->eventitem->deleteOrphanPersonHasEventItem($personId, $eventId, $eventItemIds);

			// Save the avec information (if given)
			$avecId = $this->event->getCurrentAvecForPersonHasEvent($personId, $eventId);
			if ($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED) == TRUE) {
			
				$avecData = array();
				addToArrayIfNotFalse($avecData, DB_PERSON_FIRSTNAME, 	$this->input->post(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME));
				addToArrayIfNotFalse($avecData, DB_PERSON_LASTNAME, 	$this->input->post(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME));
				addToArrayIfNotFalse($avecData, DB_PERSON_EMAIL, 		$this->input->post(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL));
				addToArrayIfNotFalse($avecData, DB_PERSON_ALLERGIES, 	$this->input->post(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES));

				//Save the avec, if a new avec the GUID of the new avec is returned
				$avecId = $this->person->savePerson($avecData, $avecId, $personId);

				// Save all event items for the avec
				$avecEventItemIds = $this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID);
				if ($avecEventItemIds !== FALSE) {
					foreach ($avecEventItemIds as $eventItemId) {
						$eventItemAmount 		= $this->input->post(DB_CUSTOM_AVEC . '_' . $eventItemId . '_' . DB_PERSONHASEVENTITEM_AMOUNT, 		TRUE);
						$eventItemDescription	= $this->input->post(DB_CUSTOM_AVEC . '_' . $eventItemId . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, TRUE);
						if ($eventItemAmount === FALSE) {
							$eventItemAmount = 1;
						}
						if ($eventItemDescription === FALSE) {
							$eventItemDescription = NULL;
						}
						
						//Don't save not-selected event items or event items with empty (but not NULL) descriptions
						if ($eventItemAmount == 0 || $eventItemDescription === '') {
							continue;
						}					

						//Save a single avec event item link into the database
						$this->eventitem->savePersonHasEventItem($avecId, $eventItemId, $eventItemAmount, $eventItemDescription, $personId);
					}
				}					
				// Delete orphan event items for the avec
				$this->eventitem->deleteOrphanPersonHasEventItem($avecId, $eventId, $avecEventItemIds);
				
			} else if ($avecId != NULL) {
				// Delete orphan event items for the avec
				$this->eventitem->deleteOrphanPersonHasEventItem($avecId, $eventId, null);
				// Delete the old avec
				$this->person->deletePerson($avecId);
				$avecId = NULL;
			}

			// Save the person has event-link including the avec (if given)
			$personHasEventData = array(
				DB_PERSONHASEVENT_AVECPERSONID	=> $avecId,
				DB_PERSONHASEVENT_PAYMENTTYPE 	=> $this->input->post(DB_TABLE_PERSONHASEVENT . '_' . DB_PERSONHASEVENT_PAYMENTTYPE)
			);
			$this->event->savePersonHasEvent($personHasEventData, $eventId, $personId);

			//Calculate the hash if it isn't already calculated
			if ($hash == NULL) {
				$hash = md5($eventId . $this->config->item('encryption_key') . $personId);
			}

			// Commit the transaction
			$this->db->trans_complete();
			
			// Send an email to the person
			$this->_sendSaveRegisterConfirmMail($eventId, $personId, $hash, $updateRegistration);

			//Everything ok, redirect the user to the confirmation page (or show message directly if dialog)
			if ($dialog == FALSE) {
				redirect(CONTROLLER_EVENTS_CONFIRM_SAVE_REGISTER_DIRECTLY . '/' . $eventId . '/' . $personId . '/' . $hash . '/' . $dialog, 'refresh');
			} else {
				$dataSucceeded['body'] 				= lang(LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED);
				$dataSucceeded['closeFormDialog']	= $dialog;
				$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $dataSucceeded);
			}
		}
	}

	function _sendSaveRegisterConfirmMail($eventId = NULL, $personId = NULL, $hash = NULL, $updateRegistration = FALSE) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL) {
			return;
		}

		$client = CLIENT_DESKTOP;

		//Load module
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);

		$data['eventId'] 			= $eventId;
		$data['personId'] 			= $personId;
		$data['hash']				= $hash;
		$data['updateRegistration']	= $updateRegistration;
		$data['event'] 				= $this->event->getEvent($eventId);
		$data['personHasEvent']		= $this->event->getPersonHasEvent($eventId, $personId, TRUE);
		$data['eventItems'] 		= $this->eventitem->getEventItems($eventId, $personId, TRUE);
		$data['person']				= $this->person->getPerson($personId);

		$personAvecId = isset($data['personHasEvent']->{DB_PERSONHASEVENT_AVECPERSONID}) ? $data['personHasEvent']->{DB_PERSONHASEVENT_AVECPERSONID} : NULL;
		$data['avecEventItems']	= $this->eventitem->getEventItems($eventId, $personAvecId, TRUE);
		$data['personAvec'] 	= $this->person->getPerson($personAvecId);		
		
		$messageSubject = ($updateRegistration) ? ('Din anmälan till ' . $data['event']->{DB_EVENT_NAME} . ' är nu uppdaterad') : ('Du är nu anmäld till ' . $data['event']->{DB_EVENT_NAME});
		$data['header'] = $messageSubject;

		$this->load->library('email');
		$this->email->from('anmalningar@akademen.com', 'Akademiska Sångföreningen');
		$this->email->to($data['person']->{DB_PERSON_EMAIL});
		$this->email->bcc('anmalningar@akademen.com');
		$this->email->subject($messageSubject);
		
		$messageBody =	$this->load->view($client . VIEW_GENERIC_MAIL_HEADER, $data, TRUE);
		$messageBody .= $this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_SAVE_REGISTER_MAIL, $data, TRUE);
		$messageBody .= $this->load->view($client . VIEW_GENERIC_MAIL_FOOTER, $data, TRUE);		
		
		$this->email->message($messageBody);
		$this->email->send();
	}

	function confirmSaveRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL, $dialog = FALSE) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL || $hash == NULL) {
			return;
		}

		//Exit it the hash in the URL isn't correct
		if (md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);		
		
		$data['header']	= lang(LANG_KEY_HEADER_LOGIN);
		$data['body']	= lang(LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED);
		
		if ($dialog == FALSE) {
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		}
		$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
		if ($dialog == FALSE) {
			$this->load->view($client . VIEW_GENERIC_FOOTER);		
		}
	}

	function cancelRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);			
	
		//Load models
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);		

		//Load event and person has event bind
		$event = $this->event->getEvent($eventId);							
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		
		//Show error message and return if person has event bind is not found
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent) === FALSE) {
			return;
		}

		$data['eventId'] 	= $eventId;
		$data['personId']	= $personId;
		$data['hash']		= $hash;
		$data['event'] 		= $this->event->getEvent($eventId);

		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_CONTENT_EVENTS_CANCEL_REGISTER_DIRECTLY, $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

	function saveCancelRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);			
	
		//Load models
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);

		//Load event and person has event bind
		$event = $this->event->getEvent($eventId);							
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
	
		//Show error message and return if person has event bind is not found
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent) === FALSE) {
			return;
		}	

		$personAvecId = $this->event->getCurrentAvecForPersonHasEvent($personId, $eventId);

		// Start a database transaction
		$this->db->trans_start();		
		
		// Delete links between avec and event items
		if ($personAvecId != NULL) {
			$this->eventitem->deleteOrphanPersonHasEventItem($personAvecId, $eventId);
		}
		// Delete links between person and event items
		$this->eventitem->deleteOrphanPersonHasEventItem($personId, $eventId);

		// Delete link between person and event
		$this->event->deletePersonHasEvent($eventId, $personId);
		
		// Commit the transaction
		$this->db->trans_complete();		

		// Delete the orphan avec
		if ($personAvecId != NULL) {
			$this->person->deletePerson($personAvecId);
		}
		
		// Send an email to the person
		$this->_sendCancelRegisterConfirmMail($eventId, $personId);		

		redirect(CONTROLLER_EVENTS_CONFIRM_CANCEL_REGISTER_DIRECTLY . '/' . $eventId . '/' . $personId . '/' . $hash, 'refresh');
	}

	function _sendCancelRegisterConfirmMail($eventId = NULL, $personId = NULL) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL) {
			return;
		}

		$client = CLIENT_DESKTOP;

		//Load module
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);

		$data['eventId'] 			= $eventId;
		$data['event'] 				= $this->event->getEvent($eventId);
		$data['person']				= $this->person->getPerson($personId);
		
		$messageSubject = 'Din anmälan till ' . $data['event']->{DB_EVENT_NAME} . ' är nu annulerad';
		$data['header'] = $messageSubject;

		$this->load->library('email');
		$this->email->from('anmalningar@akademen.com', 'Akademiska Sångföreningen');
		$this->email->to($data['person']->{DB_PERSON_EMAIL});
		$this->email->bcc('anmalningar@akademen.com');
		$this->email->subject($messageSubject);
		
		$messageBody =	$this->load->view($client . VIEW_GENERIC_MAIL_HEADER, $data, TRUE);
		$messageBody .= $this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_CANCEL_REGISTER_MAIL, $data, TRUE);
		$messageBody .= $this->load->view($client . VIEW_GENERIC_MAIL_FOOTER, $data, TRUE);		
		
		$this->email->message($messageBody);
		$this->email->send();
	}	
	
	function confirmCancelRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL || $hash == NULL) {
			return;
		}

		//Exit it the hash in the URL isn't correct
		if (md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		$client = CLIENT_DESKTOP;

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);

		$data['header']	= lang(LANG_KEY_HEADER_EVENT_REGISTRATION_CANCELLED);
		$data['body']	= lang(LANG_KEY_BODY_EVENT_YOU_CAN_REREGISTER);
		
		$links[site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $eventId] = lang(LANG_KEY_LINK_REREGISTER);
		$data['links']	= $links;
		
		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
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
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PRICE, 							lang(LANG_KEY_FIELD_LOCATION),				'trim|max_length[255]|xss_clean');
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
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT . '[]', 				lang(LANG_KEY_FIELD_PARTICIPANT),			'trim|xss_clean|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED, 						lang(LANG_KEY_FIELD_PARTICIPANT),			'trim|xss_clean|numeric');

		foreach ($itemRows as $rowNumber) {
			$this->form_validation->set_rules(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_CAPTION . $rowNumber, lang(LANG_KEY_FIELD_DESCRIPTION),			'trim|xss_clean');
		}

		//If errors found, redraw the login form to the user
		if($this->form_validation->run() === FALSE) {
			$client = CLIENT_DESKTOP;
			$data['eventId'] = $eventId;
			$this->load->view($client . VIEW_CONTENT_EVENTS_EDITSINGLE, $data);
		} else {
			$data = array(
				DB_EVENT_NAME 					=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_NAME),
				DB_EVENT_LOCATION 				=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_LOCATION),
				DB_EVENT_PRICE 					=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PRICE),
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
				DB_EVENT_PAYMENTTYPE			=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE) ? $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE) : array()),
				DB_EVENT_PARTICIPANT			=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT) ? $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT) : array()),
				DB_EVENT_AVECALLOWED			=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED)
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
					DB_EVENTITEM_MAXPCS			=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_MAXPCS . $rowNumber),
					DB_EVENTITEM_PRESELECTED	=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_PRESELECTED . $rowNumber),
					DB_EVENTITEM_SHOWFORAVEC	=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_SHOWFORAVEC . $rowNumber),
					DB_EVENTITEM_ROWORDER		=> $this->input->post(DB_TABLE_EVENTITEM . '_' . DB_EVENTITEM_ROWORDER . $rowNumber)
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

	function _validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent) {
		//Return if the event in the URL isn't valid
		if ($eventId == NULL || !isGuidValid($eventId)) {
			return FALSE;
		}	
		
		//Exit it the hash in the URL isn't correct
		if ($personId != NULL && md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return FALSE;
		}	
		
		//Show error message and return if event is not found
		if ($event === FALSE) {
			$data['header']	= lang(LANG_KEY_HEADER_EVENT_NOT_FOUND);
			$data['body']	= lang(LANG_KEY_BODY_EVENT_CHECK_CORRECT_ADDRESS);
			
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
			$this->load->view($client . VIEW_GENERIC_FOOTER);
			return FALSE;
		} else if ($event->{DB_EVENT_REGISTRATIONDUEDATE} != null && isDateInPast($event->{DB_EVENT_REGISTRATIONDUEDATE}, TRUE)) {
			$data['header']	= lang(LANG_KEY_HEADER_EVENT_REGISTRATION_DUE_DATE_PASSED);
			$data['body']	= lang(LANG_KEY_BODY_EVENT_REGISTRATION_DUE_DATE_PASSED);
			
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
			$this->load->view($client . VIEW_GENERIC_FOOTER);
			return FALSE;					
		} else if ($personId != NULL && $personHasEvent === FALSE) {
			$data['header']	= lang(LANG_KEY_HEADER_EVENT_REGISTRATION_NOT_FOUND);
			$data['body']	= lang(LANG_KEY_BODY_EVENT_CHECK_CORRECT_ADDRESS);
			
			$links[site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $eventId] = lang(LANG_KEY_LINK_REREGISTER);
			$data['links']	= $links;
			
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
			$this->load->view($client . VIEW_GENERIC_FOOTER);
			return FALSE;
		} else {
			return TRUE;
		}		
	}	
	
	function _checkAlreadyRegistreredEmail($email, $eventId) {
		if($this->event->isEmailAlreadyRegisteredToEvent($email, $eventId)) {
			$this->form_validation->set_message('_checkAlreadyRegistreredEmail', lang(LANG_KEY_BODY_EVENT_EMAIL_ALREADY_REGISTERED));
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _checkGuidValid($guid) {
		if ($guid != "" && !isGuidValid($guid)) {
			$this->form_validation->set_message('_checkGuidValid', lang(LANG_KEY_ERROR_INVALID_GUID) . '%s');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _checkDateValid($date) {
		if ($date != "" && !isDateValid($date)) {
			$this->form_validation->set_message('_checkDateValid', lang(LANG_KEY_ERROR_INVALID_DATE) . '%s');
			return FALSE;
		} else {
			return TRUE;
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
