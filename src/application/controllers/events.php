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


	function editRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		$client = CLIENT_DESKTOP;

		//Exit if no eventId given
		if ($eventId == NULL) {
			return;
		}

		//Exit it the hash in the URL isn't correct
		if ($personId != NULL && md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		//Load languages. As we don't yet know the user's language, we default to swedish
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);

		//Load edit items, add them to $data-object
		$data = array();
		$data['eventItems'] = array();
		
		if (!is_null($eventId)) {
			$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
			$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);
			$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);

			$data['eventId'] 			= $eventId;
			$data['personId'] 			= $personId;
			$data['hash'] 				= $hash;
			$data['updateRegistration'] = ($personId != NULL);
			$data['event'] 				= $this->event->getEvent($eventId);
			$data['personHasEvent']		= $this->event->getPersonHasEvent($eventId, $personId);
			$data['eventItems'] 		= $this->eventitem->getEventItems($eventId, $personId);
			$data['person']				= $this->person->getPerson($personId);

			$personAvecId 			= isset($data['personHasEvent']->{DB_PERSONHASEVENT_AVECPERSONID}) ? $data['personHasEvent']->{DB_PERSONHASEVENT_AVECPERSONID} : NULL;
			$data['avecEventItems']	= $this->eventitem->getEventItems($eventId, $personAvecId);
			$data['personAvec'] 	= $this->person->getPerson($personAvecId);
		}

		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER_DIRECTLY, $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

	function saveRegisterDirectly($eventId, $personId = NULL, $hash = NULL) {
		//Exit it the hash in the URL isn't correct
		if ($personId != NULL && md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		$updateRegistration = ($personId != NULL);

		if (!is_null($eventId)) {
			//Load the validation library
			$this->load->library('form_validation');
			//Load languages
			$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);
			//Load module
			$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
			$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON),		TRUE);
			$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);

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
				$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_PERSON_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),			'trim|max_length[50]|required|xss_clean');
				$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_PERSON_LASTNAME, 	lang(LANG_KEY_FIELD_LASTNAME), 			'trim|max_length[50]|required|xss_clean');
				$this->form_validation->set_rules(DB_CUSTOM_AVEC . '_' . DB_PERSON_ALLERGIES, 	lang(LANG_KEY_FIELD_ALLERGIES), 		'trim|max_length[50]|xss_clean');
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
				$data['eventId'] 			= $eventId;
				$data['personId'] 			= $personId;
				$data['hash'] 				= $hash;
				$data['updateRegistration'] = ($personId != NULL);
				$data['event'] 				= $this->event->getEvent($eventId);
				$data['eventItems'] 		= $eventItems;
				$data['avecEventItems']		= $eventItems;

				$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
				$this->load->view($client . VIEW_CONTENT_EVENTS_EDIT_REGISTER_DIRECTLY, $data);
				$this->load->view($client . VIEW_GENERIC_FOOTER);
			} else {
				//Get personId if not set using the email address and save the person data
				if (!$updateRegistration) {
					$personId = $this->person->getPersonIdUsingEmail($this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL));
				}								
				
				$personData = array();				
				addToArrayIfNotFalse($personData, DB_PERSON_FIRSTNAME, 	$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_FIRSTNAME));
				addToArrayIfNotFalse($personData, DB_PERSON_LASTNAME, 	$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_LASTNAME));
				addToArrayIfNotFalse($personData, DB_PERSON_EMAIL, 		$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL));
				addToArrayIfNotFalse($personData, DB_PERSON_ALLERGIES, 	$this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_ALLERGIES));

				//Save the person, if a new person the GUID of the new person is returned
				$personId = $this->person->savePerson($personData, $personId, $personId);

				// Save all event items for the person
				$eventItemIds = $this->input->post(DB_PERSONHASEVENTITEM_EVENTITEMID);
				foreach ($eventItemIds as $eventItemId) {
					$eventItemAmount 		= $this->input->post($eventItemId . '_' . DB_PERSONHASEVENTITEM_AMOUNT, 		TRUE);
					$eventItemDescription 	= $this->input->post($eventItemId . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, 	TRUE);
					if ($eventItemAmount === FALSE) {
						$eventItemAmount = 1;
					}
					if ($eventItemDescription === FALSE) {
						$eventItemDescription = NULL;
					}

					//Save a single person event item link into the database
					$this->eventitem->savePersonHasEventItem($personId, $eventItemId, $eventItemAmount, $eventItemDescription, $personId);
				}
				// Delete orphan event items for the person
				$this->eventitem->deleteOrphanPersonHasEventItem($personId, $eventId, $eventItemIds);

				// Save the avec information (if given)
				$avecId = $this->event->getCurrentAvecForPersonHasEvent($personId, $eventId);
				if ($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED) == TRUE) {
				
					$avecData = array();
					addToArrayIfNotFalse($avecData, DB_PERSON_FIRSTNAME, 	$this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSON_FIRSTNAME));
					addToArrayIfNotFalse($avecData, DB_PERSON_LASTNAME, 	$this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSON_LASTNAME));
					addToArrayIfNotFalse($avecData, DB_PERSON_EMAIL, 		$this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSON_EMAIL));
					addToArrayIfNotFalse($avecData, DB_PERSON_ALLERGIES, 	$this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSON_ALLERGIES));

					//Save the avec, if a new avec the GUID of the new avec is returned
					$avecId = $this->person->savePerson($avecData, $avecId, $personId);

					// Save all event items for the avec
					$avecEventItemIds = $this->input->post(DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID);
					foreach ($avecEventItemIds as $eventItemId) {
						$eventItemAmount 		= $this->input->post(DB_CUSTOM_AVEC . '_' . $eventItemId . '_' . DB_PERSONHASEVENTITEM_AMOUNT, 		TRUE);
						$eventItemDescription	= $this->input->post(DB_CUSTOM_AVEC . '_' . $eventItemId . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, TRUE);
						if ($eventItemAmount === FALSE) {
							$eventItemAmount = 1;
						}
						if ($eventItemDescription === FALSE) {
							$eventItemDescription = NULL;
						}

						//Save a single avec event item link into the database
						$this->eventitem->savePersonHasEventItem($avecId, $eventItemId, $eventItemAmount, $eventItemDescription, $personId);
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

				// Send an email to the person
				$this->_sendConfirmMail($eventId, $personId, $hash, $updateRegistration);

				//Everything ok, redirect the user to the confirmation page
				redirect(CONTROLLER_EVENTS_CONFIRM_SAVE_REGISTER_DIRECTLY . '/' . $eventId . '/' . $personId . '/' . $hash, 'refresh');
			}
		}
	}

	function _sendConfirmMail($eventId = NULL, $personId = NULL, $hash = NULL, $updateRegistration = FALSE) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL || $hash == NULL) {
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
		$data['eventItems'] 		= $this->eventitem->getEventItems($eventId, $personId);
		$data['person']				= $this->person->getPerson($personId);

		$personAvecId = isset($data['personHasEvent']->{DB_PERSONHASEVENT_AVECPERSONID}) ? $data['personHasEvent']->{DB_PERSONHASEVENT_AVECPERSONID} : NULL;
		$data['avecEventItems']	= $this->eventitem->getEventItems($eventId, $personAvecId, TRUE);
		$data['personAvec'] 	= $this->person->getPerson($personAvecId);

		$this->load->library('email');
		$this->email->from('anmalningar@akademen.com', 'Akademiska Sångföreningen');
		$this->email->to($data['person']->{DB_PERSON_EMAIL});
		$this->email->bcc('anmalningar@akademen.com');
		if ($updateRegistration) {
			$this->email->subject('Din anmälan till ' . $data['event']->{DB_EVENT_NAME} . ' är nu uppdaterad');
		} else {
			$this->email->subject('Du är nu anmäld till ' . $data['event']->{DB_EVENT_NAME});
		}
		$this->email->message($this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_SAVE_REGISTER_MAIL, $data, TRUE));
		$this->email->send();
	}

	function confirmSaveRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
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

		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_SAVE_REGISTER_DIRECTLY);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

	function cancelRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL || $hash == NULL) {
			return;
		}

		//Exit it the hash in the URL isn't correct
		if (md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		$client = CLIENT_DESKTOP;

		$this->load->model(MODEL_EVENT, strtolower(MODEL_EVENT), TRUE);

		$data['eventId'] 	= $eventId;
		$data['personId']	= $personId;
		$data['hash']		= $hash;
		$data['event'] 		= $this->event->getEvent($eventId);

		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_CONTENT_EVENTS_CANCEL_REGISTER_DIRECTLY, $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

	function saveCancelRegisterDirectly($eventId = NULL, $personId = NULL, $hash = NULL) {
		//Exit if no eventId or personId is given
		if ($eventId == NULL || $personId == NULL || $hash == NULL) {
			return;
		}

		//Exit it the hash in the URL isn't correct
		if (md5($eventId . $this->config->item('encryption_key') . $personId) != $hash) {
			return;
		}

		$this->load->model(MODEL_EVENT, 	strtolower(MODEL_EVENT), 		TRUE);
		$this->load->model(MODEL_EVENTITEM, strtolower(MODEL_EVENTITEM), 	TRUE);
		$this->load->model(MODEL_PERSON, 	strtolower(MODEL_PERSON), 		TRUE);

		$personAvecId = $this->event->getCurrentAvecForPersonHasEvent($personId, $eventId);

		// Delete links between avec and event items
		if ($personAvecId != null) {
			$this->eventitem->deleteOrphanPersonHasEventItem($personAvecId, $eventId);
		}
		// Delete links between person and event items
		$this->eventitem->deleteOrphanPersonHasEventItem($personId, $eventId);

		// Delete link between person and event
		$this->event->deletePersonHasEvent($eventId, $personId);

		// Delete the orphan avec
		if ($personAvecId != null) {
			$this->person->deletePerson($personAvecId);
		}

		redirect(CONTROLLER_EVENTS_CONFIRM_CANCEL_REGISTER_DIRECTLY . '/' . $eventId . '/' . $personId . '/' . $hash, 'refresh');
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
		$data['eventId'] = $eventId;

		$this->load->view($client . VIEW_GENERIC_HEADER_NOTEXT);
		$this->load->view($client . VIEW_CONTENT_EVENTS_CONFIRM_CANCEL_REGISTER_DIRECTLY, $data);
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
				DB_EVENT_PAYMENTTYPE			=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PAYMENTTYPE)),
				DB_EVENT_PARTICIPANT			=> array_sum($this->input->post(DB_TABLE_EVENT . '_' . DB_EVENT_PARTICIPANT)),
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

	function _checkAlreadyRegistreredEmail($email, $eventId) {
		if($this->event->isEmailAlreadyRegisteredToEvent($email, $eventId)) {
			$this->form_validation->set_message('_checkAlreadyRegistreredEmail', 'En person med den angivna e-postadressen är redan anmäld till evenemanget, kontrollera din angivna e-postadress.<br/>Om du vill ändra på din anmälan, använd länken i det e-postmeddelande som skickades åt dig då du första gången anmälde dig.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _checkGuidValid($guid) {
		if ($guid != "" && !isGuidValid($guid)) {
			$this->form_validation->set_message('_checkGuidValid', "Fel guid din pucko: %s!");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _checkDateValid($date) {
		if ($date != "" && !isDateValid($date)) {
			$this->form_validation->set_message('_checkDateValid', "Fel datum din pucko: %s!");
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
