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
	
		if (!$this->userrights->hasRight(userrights::EVENTS_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}
		
		if (!ctype_digit($offset)) {
			$offset = 0;
		}		
	
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

		$data = array();
		$data['eventList'] 	= $eventList;
		$data['pagination']	= $this->pagination->create_links();
		
		$this->load->view($client . VIEW_CONTENT_EVENTS_LISTALL, $data);
	}
	
	function listSingleEventRegistrations($eventId, $offset = 0) {

		if (!ctype_digit($offset)) {
			$offset = 0;
		}
		
		// Don't use paging if data should be shown as CSV
		if ($this->input->get(HTTP_SHOWASCSV) == TRUE) {
			$offset = FALSE;
		}
	
		$this->load->model(MODEL_EVENT,	strtolower(MODEL_EVENT), TRUE);
		
		$event = $this->event->getEvent($eventId);
	
		if ($event->{DB_EVENT_CANUSERSVIEWREGISTRATIONS} == FALSE && !$this->userrights->hasRight(userrights::EVENTS_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}
	
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		$this->load->library('pagination');
		
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);		
				
		$personHasEventItems = array();
		foreach($this->eventitem->getPersonHasEventItems($eventId) as $key => $personHasEventItem) {			
			$personHasEventItems[$personHasEventItem->{DB_PERSONHASEVENTITEM_PERSONID}][$personHasEventItem->{DB_PERSONHASEVENTITEM_EVENTITEMID}] = array(
					DB_PERSONHASEVENTITEM_DESCRIPTION => $personHasEventItem->{DB_PERSONHASEVENTITEM_DESCRIPTION},
					DB_PERSONHASEVENTITEM_AMOUNT => $personHasEventItem->{DB_PERSONHASEVENTITEM_AMOUNT}
				);
		}
		
		$eventItemSums = array();
		foreach($this->eventitem->getEventItemSums($eventId) as $key => $eventItemSum) {
			$eventItemSums[$eventItemSum->{DB_PERSONHASEVENTITEM_EVENTITEMID}] = $eventItemSum->{DB_TOTALCOUNT};				
		}
		
		$voiceSums = array(ENUM_VOICE_1T => 0, ENUM_VOICE_2T => 0, ENUM_VOICE_1B => 0, ENUM_VOICE_2B => 0);
		foreach($this->event->getPersonVoiceSumsForEvent($eventId) as $voice) {
			$voiceSums[$voice->{DB_PERSON_VOICE}] = $voice->{DB_TOTALCOUNT};
		}
		
		$data = array();
		$data['eventId'] 				= $eventId;
		$data['personHasEventItems']	= $personHasEventItems;		
		$data['event'] 					= $event;
		$data['persons']				= $this->event->getPersonsForEvent($eventId, LIST_DEF_PAGING, $offset);
		$data['eventItems'] 			= $this->eventitem->getEventItems($eventId);
		$data['eventItemSums']			= $eventItemSums;
		$data['voiceSums']				= $voiceSums;
		
		$config['base_url'] 	= site_url() . CONTROLLER_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS . '/' . $eventId . '/';
		$config['total_rows']	= isset($data['persons'][0]->{DB_TOTALCOUNT}) ? $data['persons'][0]->{DB_TOTALCOUNT} : 0;
		$config['first_link'] 	= lang(LANG_KEY_BUTTON_PAGING_FIRST);
		$config['last_link'] 	= lang(LANG_KEY_BUTTON_PAGING_LAST);
		$config['anchor_class']	= 'class="button" ';
		$config['per_page'] 	= LIST_DEF_PAGING; 
		$config['uri_segment'] 	= 4;
		$this->pagination->initialize($config); 
		$data['pagination']	= $this->pagination->create_links();
		
		//Load parts
		$data['part_eventInfo']		= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT, $data, TRUE);		
				
		if ($this->input->get(HTTP_SHOWASCSV) == TRUE) {				
			// Overwrite with file download header
			header('Content-Description: File Transfer');
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename=event_' . $eventId . '.csv');
			header('Content-Transfer-Encoding: binary'); 
			
			// Open file pointer to standard output
			$fp = fopen('php://output', 'w');
			 
			// Add BOM to fix UTF-8 in Excel
			fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
			if ($fp) {
				$csv = $this->_buildCSVData($data['event'], $data['eventItems'], $data['persons'], $data['personHasEventItems']);
				foreach($csv as $singleLine) {
					fputcsv($fp, $singleLine, ';');
				}
			}
			 
			fclose($fp);
		} else {
			$this->load->view($client . VIEW_CONTENT_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS, $data);
		}
	}
	
	/**
	*	Function generates data in arrays for CSV-export
	*/	
	function _buildCSVData($event, $eventItems, $persons, $personHasEventItems) {
		$csv = array();
		
		$headerArray = array();
		$headerArray[] = 'Efternamn';
		$headerArray[] = 'Förnamn';
		$headerArray[] = 'E-post';
		$headerArray[] = 'Telefonnummer';
		if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) {
			$headerArray[] = lang(LANG_KEY_FIELD_ALLERGIES);
		}
		if ($event->{DB_EVENT_AVECALLOWED} == TRUE) {
			$headerArray[] = 'Avec';
		}
		$headerArray[] = 'Anmäld';
		$headerArray[] = '1T';
		$headerArray[] = '2T';
		$headerArray[] = '1B';
		$headerArray[] = '2B';
		$headerArray[] = 'Totalt';
		$headerArray[] = lang(LANG_KEY_FIELD_PAYMENTTYPE);
		
		foreach($eventItems as $key => $eventItem) {
			switch ($eventItem->{DB_EVENTITEM_TYPE}) {
				case EVENT_TYPE_RADIO:
				case EVENT_TYPE_CHECKBOX:					
					$caption = $eventItem->{DB_EVENTITEM_DESCRIPTION};
					
					if ($eventItem->{DB_EVENTITEM_AMOUNT} != 0) {
						$caption .= ' (' . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . ')';
					}
					$headerArray[] = $caption;
					break;
				case EVENT_TYPE_TEXTAREA:					
					$headerArray[] = $eventItem->{DB_EVENTITEM_CAPTION};
					break;
				default:
					break;
			}
		}
		
		$csv[] = $headerArray;				

		$previousPersonId = NULL;
		foreach($persons as $key => $person) {
			$singleLineArray = array();
			$singleLineArray[] = $person->{DB_PERSON_LASTNAME};
			$singleLineArray[] = $person->{DB_PERSON_FIRSTNAME};
			$singleLineArray[] = $person->{DB_PERSON_EMAIL};
			$singleLineArray[] = $person->{DB_PERSON_PHONE};
			if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) {
				$singleLineArray[] = $person->{DB_PERSON_ALLERGIES};
			}
			if ($event->{DB_EVENT_AVECALLOWED} == TRUE) {
				$singleLineArray[] = '';	// Avec
			}
			$singleLineArray[] = $person->{DB_PERSONHASEVENT_CREATED};
			$singleLineArray[] = $person->{DB_PERSON_VOICE} == ENUM_VOICE_1T ? '1' : '';
			$singleLineArray[] = $person->{DB_PERSON_VOICE} == ENUM_VOICE_2T ? '1' : '';
			$singleLineArray[] = $person->{DB_PERSON_VOICE} == ENUM_VOICE_1B ? '1' : '';
			$singleLineArray[] = $person->{DB_PERSON_VOICE} == ENUM_VOICE_2B ? '1' : '';
			$singleLineArray[] = ($person->{DB_TOTALSUM} + $person->{DB_CUSTOM_AVEC . DB_TOTALSUM});
			$singleLineArray[] = getEnumValue(ENUM_PAYMENTTYPE, $person->{DB_PERSONHASEVENT_PAYMENTTYPE});				
			foreach($eventItems as $key => $eventItem) {					
				if (isset($personHasEventItems[$person->{DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}])) {
					if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {								
						switch ($eventItem->{DB_EVENTITEM_TYPE}) {
							case EVENT_TYPE_RADIO:
							case EVENT_TYPE_CHECKBOX:
								$singleLineArray[] = '1';
								break;
							case EVENT_TYPE_TEXTAREA:
								$singleLineArray[] = $personHasEventItems[$person->{DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_DESCRIPTION];	
								break;
							default:
								break;
						}							
					} else {
						$singleLineArray[] = $personHasEventItems[$person->{DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_AMOUNT];	
					}																												
				} else {						
					$singleLineArray[] = '';
				}
			}
			$csv[] = $singleLineArray;
			
			if ($event->{DB_EVENT_AVECALLOWED} == TRUE && $person->{DB_CUSTOM_AVEC . DB_PERSON_ID} != NULL) {
				$singleLineArray = array();
				$singleLineArray[] = $person->{DB_CUSTOM_AVEC . DB_PERSON_LASTNAME};
				$singleLineArray[] = $person->{DB_CUSTOM_AVEC . DB_PERSON_FIRSTNAME};
				$singleLineArray[] = $person->{DB_CUSTOM_AVEC . DB_PERSON_EMAIL};
				$singleLineArray[] = $person->{DB_CUSTOM_AVEC . DB_PERSON_PHONE};				
				if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) {
					$singleLineArray[] = $person->{DB_CUSTOM_AVEC . DB_PERSON_ALLERGIES};
				}
				$singleLineArray[] = '1'; 	// Avec
				$singleLineArray[] = '';	// Anmäld
				$singleLineArray[] = '';	// 1T
				$singleLineArray[] = '';	// 2T
				$singleLineArray[] = '';	// 1B
				$singleLineArray[] = '';	// 2B
				$singleLineArray[] = '';	// Sum
				$singleLineArray[] = '';	// Payment type				
			
				foreach($eventItems as $key => $eventItem) {					
					if (isset($personHasEventItems[$person->{DB_CUSTOM_AVEC . DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}])) {
						if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {								
							switch ($eventItem->{DB_EVENTITEM_TYPE}) {
								case EVENT_TYPE_RADIO:
								case EVENT_TYPE_CHECKBOX:
									$singleLineArray[] = '1';
									break;
								case EVENT_TYPE_TEXTAREA:
									$singleLineArray[] = $personHasEventItems[$person->{DB_CUSTOM_AVEC . DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_DESCRIPTION];	
									break;
								default:
									break;
							}							
						} else {
							$singleLineArray[] = $personHasEventItems[$person->{DB_CUSTOM_AVEC . DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_AMOUNT];							
						}																												
					} else {
						$singleLineArray[] = '';
					}
				}
				$csv[] = $singleLineArray;
			}				
		}		
	
		return $csv;
	}

	/**
	*	Used for editing a single event
	*/
	function editSingle($eventId = NULL) {
	
		if (!$this->userrights->hasRight(userrights::EVENTS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}	
	
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
	
	/**
	*	Used for editing a single event registration directly or via the intranet-GUI
	*/	
	function editRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL, $internalRegistration = FALSE) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Check if the page should be loaded as a dialog
		$loadAsDialog 	= filter_var($this->input->get_post(HTTP_DIALOG), FILTER_VALIDATE_BOOLEAN);

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
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent, $internalRegistration) === FALSE) {
			return;
		}
		
		//Add parameters to view $data-object
		$data = array();	
		$data['eventId']				= $eventId;
		$data['personId'] 				= $personId;
		$data['hash'] 					= $hash;
		$data['dialog']					= $loadAsDialog;
		$data['internalRegistration']	= $internalRegistration;
		
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		$personAvecId	= isset($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID}) ? $personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} : NULL;
						
		/*	Load different dynamic parts of the page */
		//Event info
		$data_part_info_event = array();
		$data_part_info_event['eventId']	= $eventId;
		$data_part_info_event['event'] 		= $event;			
		$data['part_info_event'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT,	$data_part_info_event, TRUE);	
		
		//Person form
		$data_part_form_person = array();
		$data_part_form_person['person']		= $this->person->getPerson($personId);
		$data_part_form_person['fieldPrefix']	= '';
		$data_part_form_person['disableFields'] = $internalRegistration;
		$data_part_form_person['showFields']	= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_PHONE, DB_PERSON_ALLERGIES) 
														: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_PHONE, DB_PERSON_ALLERGIES);
		$data['part_form_person'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_person, TRUE);
			
		//Payment form
		$data_part_form_payment = array();
		$data_part_form_payment['personHasEvent'] = $personHasEvent;
		$data['part_form_payment'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PAYMENT, $data_part_form_payment, TRUE);

		//Event items form
		$part_form_eventItems = array();
		$part_form_eventItems['eventItems']				= $this->eventitem->getEventItems($eventId, $personId);
		$part_form_eventItems['currentIsAvec']			= FALSE;
		$part_form_eventItems['fieldPrefix']			= '';
		$part_form_eventItems['personId']				= $personId;
		$part_form_eventItems['internalRegistration']	= $internalRegistration;
		$part_form_eventItems['personHasEvent']			= $personHasEvent;
		$data['part_form_eventitems'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$part_form_eventItems, TRUE);		
		
		if ($event->{DB_EVENT_AVECALLOWED} == 1) {
			//Avec allowed form
			$data_part_form_avecAllowed = array();
			$data_part_form_avecAllowed['personHasEvent'] = $personHasEvent;
			$data['part_form_avecallowed'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_AVEC_ALLOWED,	$data_part_form_avecAllowed, TRUE);	

			//Person avec form
			$data_part_form_personAvec = array();
			$data_part_form_personAvec['updateRegistration']	= ($personId != NULL);
			$data_part_form_personAvec['person']				= $this->person->getPerson($personAvecId);
			$data_part_form_personAvec['fieldPrefix']			= DB_CUSTOM_AVEC . '_';
			$data_part_form_personAvec['disableFields']			= FALSE;
			$data_part_form_personAvec['showFields']			= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES) 
																		: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES);			
			$data['part_form_personAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_personAvec, TRUE);

			//Event items avec form
			$data_part_form_eventItemsAvec = array();
			$data_part_form_eventItemsAvec['eventItems'] 		= $this->eventitem->getEventItems($eventId, $personAvecId);
			$data_part_form_eventItemsAvec['currentIsAvec']		= TRUE;
			$data_part_form_eventItemsAvec['fieldPrefix']		= DB_CUSTOM_AVEC . '_';
			$data_part_form_eventItemsAvec['personId']			= $personId;
			$data_part_form_eventItemsAvec['personHasEvent']	= $personHasEvent;																					
			$data['part_form_eventitemsAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$data_part_form_eventItemsAvec, TRUE);		
		}					

		//Finally load the main views
		if ($loadAsDialog == FALSE) {
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		}
		$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER, $data);
		if ($loadAsDialog == FALSE) {
			$this->load->view($client . VIEW_GENERIC_FOOTER);
		}
	}

	function saveRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL, $internalRegistration = FALSE) {
		//Default to desktop client
		$client = CLIENT_DESKTOP;
		
		//Check if the page should be loaded as a dialog
		$loadAsDialog = filter_var($this->input->get_post(HTTP_DIALOG), FILTER_VALIDATE_BOOLEAN);		
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);					
		
		//Load models
		$this->load->model(MODEL_EVENT, 		strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, 	strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 		strtolower(MODEL_PERSON), 		TRUE);	
		$this->load->model(MODEL_TRANSACTION, 	strtolower(MODEL_TRANSACTION),	TRUE);	

		//Load event and person has event bind
		$event = $this->event->getEvent($eventId);
		$personHasEvent = $this->event->getPersonHasEvent($eventId, $personId);
		
		//Show error message and return if person has event bind is not found
		if ($this->_validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent, $internalRegistration) === FALSE) {
			return;
		}		

		$updateRegistration = ($personId != NULL);

		//Load the validation library
		$this->load->library('form_validation');

		//Validate the form
		if (!$internalRegistration) {
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),				'trim|max_length[50]|required|xss_clean');
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 				'trim|max_length[50]|required|xss_clean');
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES, 	lang(LANG_KEY_FIELD_ALLERGIES), 			'trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_PHONE, 		lang(LANG_KEY_FIELD_PHONE), 				'trim|max_length[50]|xss_clean');
		}
			
		$this->form_validation->set_rules(DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', 	DB_PERSONHASEVENTITEM_EVENTITEMID . '[]',	'trim|callback__checkGuidValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED, 	lang(LANG_KEY_FIELD_AVEC),					'trim|max_length[1]|xss_clean|numeric');
		
		//Only check payment type if it's required for the specific event
		if ($event->{DB_EVENT_PAYMENTTYPE} > 0) {
			$this->form_validation->set_rules(DB_TABLE_PERSONHASEVENT . '_' . DB_PERSONHASEVENT_PAYMENTTYPE, lang(LANG_KEY_FIELD_PAYMENTTYPE), 'required|trim|max_length[1]|xss_clean');
		}
		
		//Only validate the email if it's in the POST
		if (!$internalRegistration && $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL) !== FALSE) {
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL, 		lang(LANG_KEY_FIELD_EMAIL), 			'trim|max_length[50]|required|valid_email|xss_clean');
			$this->form_validation->set_rules(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL, 	lang(LANG_KEY_FIELD_EMAIL),					'callback__checkAlreadyRegistreredEmail['. $eventId . ']');
		}

		//Validate the avec data if user has selected an avec on the form
		if ($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED) == TRUE) {
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),			'trim|max_length[50]|required|xss_clean');
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 			'trim|max_length[50]|required|xss_clean');
			$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES, 	lang(LANG_KEY_FIELD_ALLERGIES), 		'trim|max_length[255]|xss_clean');
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

		//Check KK-sum for KK-payment for internal users
		if ($internalRegistration && $personId != NULL) {
			$personStatus = $this->person->getPerson($personId, array(DB_PERSON_STATUS));
			if ($personStatus->{DB_PERSON_STATUS} == PERSON_STATUS_INTERNAL) {					
				$this->form_validation->set_rules(DB_TABLE_PERSONHASEVENT . '_' . DB_PERSONHASEVENT_PAYMENTTYPE, lang(LANG_KEY_FIELD_PAYMENTTYPE), 'callback__checkEnoughTransactionAmount[' . $eventId . ',' . $personId . ']');
			}
		}
		
		//If errors found, redraw the login form to the user
		if($this->form_validation->run() === FALSE) {
			$client = CLIENT_DESKTOP;
			
			$data = array();
			$data['eventId']				= $eventId;
			$data['personId'] 				= $personId;
			$data['hash'] 					= $hash;			
			$data['dialog']					= $loadAsDialog;			
			$data['internalRegistration']	= $internalRegistration;
			
			/*	Load different dynamic parts of the page */
			//Event info
			$data_part_info_event = array();
			$data_part_info_event['eventId']	= $eventId;
			$data_part_info_event['event'] 		= $event;
			$data['part_info_event'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_INFO_EVENT,	$data_part_info_event, TRUE);	
			
			//Person form
			$data_part_form_person = array();
			$data_part_form_person['fieldPrefix']	= '';
			if ($internalRegistration) {
				$data_part_form_person['person']		= $this->person->getPerson($personId);							
			}
			$data_part_form_person['disableFields'] = $internalRegistration;
			$data_part_form_person['showFields']	= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_PHONE, DB_PERSON_ALLERGIES) 
															: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_EMAIL, DB_PERSON_PHONE, DB_PERSON_ALLERGIES);
			$data['part_form_person'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_person, TRUE);
				
			//Payment form
			$part_form_payment = array();
			$data['part_form_payment']		= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PAYMENT, array(), TRUE);
			
			//Event items form
			$part_form_eventItems = array();
			$part_form_eventItems['eventItems']				= $eventItems;
			$part_form_eventItems['currentIsAvec']			= FALSE;
			$part_form_eventItems['fieldPrefix']			= '';
			$part_form_eventItems['personId']				= $personId;
			$part_form_eventItems['internalRegistration']	= $internalRegistration;
			$part_form_eventItems['personHasEvent']			= TRUE;
			$data['part_form_eventitems']	= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$part_form_eventItems, TRUE);		
			
			if ($event->{DB_EVENT_AVECALLOWED} == 1) {
				//Avec allowed form
				$data_part_form_avecAllowed = array();
				$data_part_form_avecAllowed['personHasEvent'] = $personHasEvent;
				$data['part_form_avecallowed']	= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_AVEC_ALLOWED,	$data_part_form_avecAllowed, TRUE);	

				//Person avec form
				$data_part_form_personAvec = array();
				$data_part_form_personAvec['updateRegistration']	= ($personId != NULL);
				$data_part_form_personAvec['fieldPrefix']			= DB_CUSTOM_AVEC . '_';
				$data_part_form_personAvec['person']				= NULL;
				$data_part_form_personAvec['disableFields']			= FALSE;				
				$data_part_form_personAvec['showFields']			= ($personId != NULL) ? array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES) 
																			: array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME, DB_PERSON_ALLERGIES);		
				$data['part_form_personAvec'] = $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_PERSON, $data_part_form_personAvec, TRUE);

				//Event items avec form
				$data_part_form_eventItemsAvec = array();
				$data_part_form_eventItemsAvec['eventItems'] 		= $eventItems;
				$data_part_form_eventItemsAvec['currentIsAvec']		= TRUE;
				$data_part_form_eventItemsAvec['fieldPrefix']		= DB_CUSTOM_AVEC . '_';
				$data_part_form_eventItemsAvec['personId']			= $personId;
				$data_part_form_eventItemsAvec['personHasEvent']	= TRUE;
				$data['part_form_eventitemsAvec']	= $this->load->view($client . VIEW_CONTENT_EVENTS_PART_FORM_EVENTITEMS,	$data_part_form_eventItemsAvec, TRUE);		
			}			
			
			//Finally load the main views
			if ($loadAsDialog == FALSE) {
				$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			}
			$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER, $data);
			if ($loadAsDialog == FALSE) {
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

					//Don't save event items with empty (but not NULL) descriptions
					if ($eventItemDescription === '') {
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
						
			// Set payment type to NULL if FALSE (otherwise it ends up as 0 in database)
			$paymentType = $this->input->post(DB_TABLE_PERSONHASEVENT . '_' . DB_PERSONHASEVENT_PAYMENTTYPE);
			if ($paymentType === FALSE) {
				$paymentType = NULL;
			}			

			// Save the person has event-link including the avec (if given)
			$personHasEventData = array(
				DB_PERSONHASEVENT_AVECPERSONID	=> $avecId,
				DB_PERSONHASEVENT_PAYMENTTYPE 	=> $paymentType
			);
			$updateRegistration = $this->event->savePersonHasEvent($personHasEventData, $eventId, $personId);

			// If payment type is transaction, calculate sum and write it to Transaction-table
			if ($paymentType == ENUM_PAYMENTTYPE_TRANSACTION) {
				$this->transaction->savePersonHasEventTransaction($eventId, $personId);
			} 	else {
				$this->transaction->deletePersonHasEventTransaction($eventId, $personId);
			}

			//Calculate the hash if it isn't already calculated
			if ($hash == NULL) {
				$hash = md5($eventId . $this->config->item('encryption_key') . $personId);
			}

			// Commit the transaction
			$this->db->trans_complete();
			
			// Send an email to the person
			$this->_sendSaveRegisterConfirmMail($eventId, $personId, $updateRegistration);
			
			//Everything ok, redirect the user to the confirmation page (or show message directly if dialog)
			if ($loadAsDialog == FALSE) {
				redirect(CONTROLLER_EVENTS_CONFIRM_SAVE_REGISTER_DIRECTLY . '/' . $eventId . '/' . $personId . '/' . $hash . '/' . $updateRegistration, 'refresh');
			} else {
				$dataSucceeded = array();
				$dataSucceeded['closeFormDialog']	= $loadAsDialog;
				
				$event = $this->event->getEvent($eventId, array(DB_EVENT_NAME));
				$eventName = $event->{DB_EVENT_NAME};
				
				if ($personId != $this->session->userdata(SESSION_PERSONID)) {
					$person = $this->person->getPerson($personId, array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME));
					$personName = $person->{DB_PERSON_FIRSTNAME} . ' ' . $person->{DB_PERSON_LASTNAME};

					$messageSubject = ($updateRegistration) ? ($personName . 's anmälan till ' . $eventName . ' är nu uppdaterad') : ($personName . ' är nu anmäld till ' . $eventName);
					$dataSucceeded['header'] 	= $messageSubject;					
					$dataSucceeded['body'] 		= str_replace(PLACEHOLDER_PERSON, $personName, lang(LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED_ADMIN));
				} else {
					$messageSubject = ($updateRegistration) ? ('Din anmälan till ' . $eventName . ' är nu uppdaterad') : ('Du är nu anmäld till ' . $eventName);
					$dataSucceeded['header'] 	= $messageSubject;
					$dataSucceeded['body'] 		= lang(LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED);
				}
				
				$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $dataSucceeded);
			}
		}
	}

	function _sendSaveRegisterConfirmMail($eventId = NULL, $personId = NULL, $updateRegistration = FALSE) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL) {
			return;
		}

		$client = CLIENT_DESKTOP;

		//Load module
		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);

		$data = array();
		$data['eventId'] 			= $eventId;
		$data['personId'] 			= $personId;
		//The hash needs to be recalculated
		$data['hash']				= md5($eventId . $this->config->item('encryption_key') . $personId);
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
		
		$messageHTMLBody =	$this->load->view($client . VIEW_GENERIC_MAIL_HEADER, $data, TRUE);
		$messageHTMLBody .= $this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_SAVE_REGISTER_MAIL, $data, TRUE);
		$messageHTMLBody .= $this->load->view($client . VIEW_GENERIC_MAIL_FOOTER, $data, TRUE);		
		
		$messagePlainBody = $this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_SAVE_REGISTER_MAIL_PLAIN, $data, TRUE);
		
		$this->email->message($messageHTMLBody);
		$this->email->set_alt_message($messagePlainBody);
		$this->email->send();
	}

	function confirmSaveRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL, $updateRegistration = FALSE) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL || $hash == NULL) {
			return;
		}

		//Exit it the hash in the URL isn't correct
		if (md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		$client = CLIENT_DESKTOP;
		
		//Load module
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);		

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);		

		$event = $this->event->getEvent($eventId, array(DB_EVENT_NAME));
		$eventName = $event->{DB_EVENT_NAME};
		
		$data = array();
		$data['header']	= ($updateRegistration) ? ('Din anmälan till ' . $eventName . ' är nu uppdaterad') : ('Du är nu anmäld till ' . $eventName);
		$data['body']	= lang(LANG_KEY_BODY_EVENT_REGISTRATION_SUCCEEDED);
		
		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);		
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

		$data = array();
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
		
		//Check if the page should be loaded as a dialog
		$loadAsDialog = filter_var($this->input->get_post(HTTP_DIALOG), FILTER_VALIDATE_BOOLEAN);
		
		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);			
	
		//Load models
		$this->load->model(MODEL_EVENT, 		strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, 	strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 		strtolower(MODEL_PERSON), 		TRUE);
		$this->load->model(MODEL_TRANSACTION, 	strtolower(MODEL_TRANSACTION),	TRUE);	

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
		
		// Delete any transactions for the person and event
		$this->transaction->deletePersonHasEventTransaction($eventId, $personId);		

		// Delete the orphan avec
		if ($personAvecId != NULL) {
			$this->person->deletePerson($personAvecId);
		}
		
		// Commit the transaction
		$this->db->trans_complete();		
		
		// Send an email to the person
		$this->_sendCancelRegisterConfirmMail($eventId, $personId);		

		if ($loadAsDialog == FALSE) {
			redirect(CONTROLLER_EVENTS_CONFIRM_CANCEL_REGISTER_DIRECTLY . '/' . $eventId . '/' . $personId . '/' . $hash, 'refresh');		
		} else {
			$dataSucceeded = array();
			$dataSucceeded['closeFormDialog']	= $loadAsDialog;
			
			$event = $this->event->getEvent($eventId, array(DB_EVENT_NAME));
			$eventName = $event->{DB_EVENT_NAME};
			
			if ($personId != $this->session->userdata(SESSION_PERSONID)) {
				$person = $this->person->getPerson($personId, array(DB_PERSON_FIRSTNAME, DB_PERSON_LASTNAME));
				$personName = $person->{DB_PERSON_FIRSTNAME} . ' ' . $person->{DB_PERSON_LASTNAME};
				
				$dataSucceeded['header'] 	= $personName . 's anmälan till ' . $eventName . ' är nu annullerad';
				$dataSucceeded['body'] 		= str_replace(PLACEHOLDER_PERSON, $personName, lang(LANG_KEY_BODY_EVENT_YOU_CAN_REREGISTER_ADMIN));
			} else {
				$dataSucceeded['header'] 	= 'Din anmälan till ' . $eventName . ' är nu annullerad.';
				$dataSucceeded['body'] 		= lang(LANG_KEY_BODY_EVENT_YOU_CAN_REREGISTER);
			}
			
			$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $dataSucceeded);			
		}
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

		$data = array();
		$data['eventId'] 	= $eventId;
		$data['event'] 		= $this->event->getEvent($eventId);
		$data['person']		= $this->person->getPerson($personId);
		
		$messageSubject = 'Din anmälan till ' . $data['event']->{DB_EVENT_NAME} . ' är nu annullerad';
		$data['header'] = $messageSubject;

		$this->load->library('email');
		$this->email->from('anmalningar@akademen.com', 'Akademiska Sångföreningen');
		$this->email->to($data['person']->{DB_PERSON_EMAIL});
		$this->email->bcc('anmalningar@akademen.com');
		$this->email->subject($messageSubject);
		
		$messageHTMLBody =	$this->load->view($client . VIEW_GENERIC_MAIL_HEADER, $data, TRUE);
		$messageHTMLBody .= $this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_CANCEL_REGISTER_MAIL, $data, TRUE);
		$messageHTMLBody .= $this->load->view($client . VIEW_GENERIC_MAIL_FOOTER, $data, TRUE);
		
		$messagePlainBody = $this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_CANCEL_REGISTER_MAIL_PLAIN, $data, TRUE);
		
		$this->email->message($messageHTMLBody);
		$this->email->set_alt_message($messagePlainBody);
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

		$data = array();
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
	
		if (!$this->userrights->hasRight(userrights::EVENTS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}		
	
		$client = CLIENT_DESKTOP;

		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);			
			// Only delete events with zero registrations
			$event = $this->event->getEvent($eventId, array(DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT, DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT));
			if (($event->{DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT} + $event->{DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT}) == 0) {			
				// First delete the event's eventitems
				$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), TRUE);
				$this->eventitem->deleteEventItems($eventId, array());
				// Then delete the event
				$this->event->deleteEvent($eventId);
			}
		}

		$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
	}

	/**
	*	Used for saving a single event
	*/
	function saveSingle($eventId = NULL) {
	
		if (!$this->userrights->hasRight(userrights::EVENTS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}		
	
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		//Load module
		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), TRUE);

		$itemRows = $this->_getEventItemRowNumbers();

		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_NAME,								lang(LANG_KEY_FIELD_NAME),							'trim|max_length[255]|required|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_LOCATION, 						lang(LANG_KEY_FIELD_LOCATION),						'trim|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PRICE, 							lang(LANG_KEY_FIELD_LOCATION),						'trim|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE,						lang(LANG_KEY_FIELD_STARTDATE), 					'trim|max_length[10]|required|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_HH,			lang(LANG_KEY_FIELD_STARTDATE), 					'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_MM,			lang(LANG_KEY_FIELD_STARTDATE), 					'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE,							lang(LANG_KEY_FIELD_FINISHDATE),					'trim|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_HH,				lang(LANG_KEY_FIELD_FINISHDATE),					'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_MM,				lang(LANG_KEY_FIELD_FINISHDATE),					'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE,				lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE), 			'trim|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH,	lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE), 			'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM,	lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE), 			'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE,					lang(LANG_KEY_FIELD_PAYMENT_DUEDATE),				'trim|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH,		lang(LANG_KEY_FIELD_PAYMENT_DUEDATE), 				'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM,		lang(LANG_KEY_FIELD_PAYMENT_DUEDATE), 				'trim|max_length[2]|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_DESCRIPTION, 						lang(LANG_KEY_FIELD_DESCRIPTION),					'trim|xss_clean');		
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE . '[]', 				lang(LANG_KEY_FIELD_PAYMENTTYPE),					'trim|xss_clean|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT . '[]', 				lang(LANG_KEY_FIELD_PARTICIPANT),					'trim|xss_clean|is_natural');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED, 						lang(LANG_KEY_FIELD_PARTICIPANT),					'trim|xss_clean|numeric');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTINFO, 						lang(LANG_KEY_FIELD_PAYMENT_INFO),					'trim|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_CANUSERSVIEWREGISTRATIONS,		lang(LANG_KEY_FIELD_CAN_USERS_VIEW_REGISTRATIONS),	'trim|xss_clean|numeric');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_CANUSERSSETALLERGIES,				lang(LANG_KEY_FIELD_CAN_USERS_SET_ALLERGIES),		'trim|xss_clean|numeric');
		$this->form_validation->set_rules(DB_TABLE_EVENT . '_' . DB_EVENT_ISMAPSHOWN,						lang(LANG_KEY_FIELD_IS_MAP_SHOWN),					'trim|xss_clean|numeric');

		foreach ($itemRows as $rowNumber) {
			$this->form_validation->set_rules(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_CAPTION . $rowNumber, lang(LANG_KEY_FIELD_DESCRIPTION),			'trim|xss_clean');
		}

		//If errors found, redraw the login form to the user
		if($this->form_validation->run() === FALSE) {
			$client = CLIENT_DESKTOP;
			
			$data = array();			
			$data['eventId'] = $eventId;
			$this->load->view($client . VIEW_CONTENT_EVENTS_EDITSINGLE, $data);
		} else {
			$dataEvent = array(
				DB_EVENT_NAME 						=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_NAME),
				DB_EVENT_LOCATION 					=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_LOCATION),
				DB_EVENT_PRICE 						=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PRICE),
				DB_EVENT_STARTDATE 					=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_HH),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_STARTDATE . PREFIX_MM)),
				DB_EVENT_ENDDATE 					=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_HH),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ENDDATE . PREFIX_MM)),
				DB_EVENT_REGISTRATIONDUEDATE 		=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM)),
				DB_EVENT_PAYMENTDUEDATE 			=> formatDateODBC($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH),
															$this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM)),
				DB_EVENT_DESCRIPTION 				=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_DESCRIPTION),
				DB_EVENT_RESPONSIBLEID				=> $this->session->userdata(SESSION_PERSONID),
				DB_EVENT_PAYMENTTYPE				=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE) ? $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE) : array()),
				DB_EVENT_PARTICIPANT				=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT) ? $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT) : array()),
				DB_EVENT_AVECALLOWED				=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED),
				DB_EVENT_PAYMENTINFO 				=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTINFO),
				DB_EVENT_CANUSERSVIEWREGISTRATIONS	=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_CANUSERSVIEWREGISTRATIONS),
				DB_EVENT_CANUSERSSETALLERGIES		=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_CANUSERSSETALLERGIES),
				DB_EVENT_ISMAPSHOWN					=> $this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_ISMAPSHOWN)
			);

			// Start a database transaction
			$this->db->trans_start();

			// Save the event
			$eventId = $this->event->saveEvent($dataEvent, $eventId);

			// Make an array of all event item IDs not to delete
			$eventItemIdsNotToDelete = array();

			//Go through all event items and save them
			foreach ($itemRows as $rowNumber) {
				$dataEventItem = array(
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
				$eventItemIdsNotToDelete[] = $this->eventitem->saveEventItem($dataEventItem, $eventItemId);
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

	function _validateEditDirectlyVariables($client, $eventId, $personId, $hash, $event, $personHasEvent, $internalRegistration = FALSE) {
		//Return if the event in the URL isn't valid
		if ($eventId == NULL || !isGuidValid($eventId)) {
			return FALSE;
		}	
		
		//Exit if internal registration but no personId is found
		if ($internalRegistration && $personId == NULL) {
			return FALSE;
		}
		
		//Exit it the hash in the URL isn't correct
		if ($personId != NULL && md5($eventId . $this->config->item('encryption_key') . $personId . $internalRegistration) != $hash) {			
			return FALSE;
		}
		
		//Show error message and return if event is not found
		if ($event === FALSE) {
			$data = array();
			$data['header']	= lang(LANG_KEY_HEADER_EVENT_NOT_FOUND);
			$data['body']	= lang(LANG_KEY_BODY_EVENT_CHECK_CORRECT_ADDRESS);
			
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
			$this->load->view($client . VIEW_GENERIC_FOOTER);
			return FALSE;
		} else if ($event->{DB_EVENT_REGISTRATIONDUEDATE} != null && isDateInPast($event->{DB_EVENT_REGISTRATIONDUEDATE}, TRUE)
						&& !$this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) {
						
			$data = array();
			$data['header']	= lang(LANG_KEY_HEADER_EVENT_REGISTRATION_DUE_DATE_PASSED);
			$data['body']	= lang(LANG_KEY_BODY_EVENT_REGISTRATION_DUE_DATE_PASSED);
			
			$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
			$this->load->view($client . VIEW_GENERIC_BODY_MESSAGE, $data);
			$this->load->view($client . VIEW_GENERIC_FOOTER);
			return FALSE;					
		} else if ($personId != NULL && $personHasEvent === FALSE && $internalRegistration === FALSE) {
			$data = array();
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
	
	function _checkEnoughTransactionAmount($paymentType, $callbackParam) {
		$callbackParam 	= preg_split('/,/', $callbackParam);
		$eventId		= $callbackParam[0];
		$personId 		= $callbackParam[1];		
	
		if ($paymentType == ENUM_PAYMENTTYPE_TRANSACTION) {
			$eventItemsAmountTotal = 0;
			$eventItemIds = $this->input->post(DB_PERSONHASEVENTITEM_EVENTITEMID);
			if ($eventItemIds !== FALSE) {
				foreach ($eventItemIds as $eventItemId) {
					$eventItemAmount = $this->input->post($eventItemId . '_' . DB_PERSONHASEVENTITEM_AMOUNT, TRUE);
					if ($eventItemAmount === FALSE) {
						$eventItemAmount = 1;
					}

					//Don't save not-selected event items or event items with empty (but not NULL) descriptions
					if ($eventItemAmount == 0) {
						continue;
					}
					
					$eventItem = $this->eventitem->getEventItem($eventItemId);
					if ($eventItem !== FALSE) {
						$eventItemsAmountTotal += ($eventItemAmount * $eventItem->{DB_EVENTITEM_AMOUNT});
					}
				}
			}
			if ($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED) == TRUE) {
				$avecEventItemIds = $this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID);
				if ($avecEventItemIds !== FALSE) {
					foreach ($avecEventItemIds as $eventItemId) {
						$eventItemAmount = $this->input->post(DB_CUSTOM_AVEC . '_' . $eventItemId . '_' . DB_PERSONHASEVENTITEM_AMOUNT, TRUE);
						if ($eventItemAmount === FALSE) {
							$eventItemAmount = 1;
						}

						//Don't save not-selected event items or event items with empty (but not NULL) descriptions
						if ($eventItemAmount == 0) {
							continue;
						}
						
						$eventItem = $this->eventitem->getEventItem($eventItemId);
						if ($eventItem !== FALSE) {
							$eventItemsAmountTotal += ($eventItemAmount * $eventItem->{DB_EVENTITEM_AMOUNT});
						}
					}
				}			
			}
			
			$currentBalance = $this->transaction->getPersonCurrentBalance($personId, $eventId); 
		
			if ($eventItemsAmountTotal > $currentBalance) {		
				$this->form_validation->set_message('_checkEnoughTransactionAmount', 'Du har endast ' . formatCurrency($currentBalance) . ' på ditt kvartettkonto, behövs ' . formatCurrency($eventItemsAmountTotal));
				return FALSE;		
			} else {
				return TRUE;
			}
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
			if (preg_match('/(EventItem_Id)(\d{1,})/i', $key, $matches)) {
				$rowNumbers[] = $matches[2];
			}
		}
		return $rowNumbers;
	}
}
