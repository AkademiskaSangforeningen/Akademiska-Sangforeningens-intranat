<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transactions extends CI_Controller {

	function __construct() {
		parent::__construct();	
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function index() {
		redirect(CONTROLLER_MY_PAGE, 'refresh');
	}
	
	function listall($offset = 0) {
	
		if (!$this->userrights->hasRight(userrights::TRANSACTIONS_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}
		
		if (!ctype_digit($offset)) {
			$offset = 0;
		}			
	
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		
		$this->load->model(MODEL_TRANSACTION, 	strtolower(MODEL_TRANSACTION),	TRUE);
		$this->load->model(MODEL_PERSON, 		strtolower(MODEL_PERSON), 		TRUE);
		$this->load->library('pagination');

		$personId = $this->input->get(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, TRUE);
		$wildCardSearch = $this->input->get(HTTP_WILDCARDSEARCH, TRUE);
		
		$data = array();
		$data['personId'] = $personId;
		$data['wildCardSearch'] = $wildCardSearch;
		$data['persons'] = $this->person->getPersonListAsArray(TRUE);		
		$data['transactionList'] = $this->transaction->getTransactionList($personId, $wildCardSearch, LIST_DEF_PAGING, $offset);
		$data['transactionSum'] = $this->transaction->getTransactionSum($personId);
		
		$config['base_url'] 	= site_url() . CONTROLLER_TRANSACTIONS_LISTALL . '/';
		$config['total_rows']	= ($data['transactionList']) ? $data['transactionList'][0]->{DB_TOTALCOUNT} : 0;
		$config['first_link'] 	= lang(LANG_KEY_BUTTON_PAGING_FIRST);
		$config['last_link'] 	= lang(LANG_KEY_BUTTON_PAGING_LAST);
		$config['anchor_class']	= 'class="button" ';
		$config['per_page'] 	= LIST_DEF_PAGING; 
		$this->pagination->initialize($config); 				
		$data['pagination']	= $this->pagination->create_links();
		
		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_LISTALL, $data);
	}
	
	/**
	*	Used for deleting a single manually created transaction
	*/		
	function deleteSingle($transactionId = NULL) {
	
		if (!$this->userrights->hasRight(userrights::TRANSACTIONS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}
	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;
		
		if (!is_null($transactionId)) {
			$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);
			$this->transaction->deleteManualTransaction($transactionId);
		}
		
		$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
	}
	
	/**
	*	Used for editing a single manual transaction
	*/		
	function editSingle($transactionId = NULL) {
	
		if (!$this->userrights->hasRight(userrights::TRANSACTIONS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}
	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		
		//Load models
		$this->load->model(MODEL_TRANSACTION, 	strtolower(MODEL_TRANSACTION), 	TRUE);
		$this->load->model(MODEL_PERSON, 		strtolower(MODEL_PERSON), 		TRUE);

		$data = array();
		
		if (!is_null($transactionId)) {			
			$data['transaction'] = $this->transaction->getTransaction($transactionId);
			$data['transactionId'] = $transactionId;
		}
		
		$data['persons'] = $this->person->getPersonListAsArray(TRUE);

		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_EDITSINGLE, $data);
	}
	
	/**
	*	Used for saving a single transaction
	*/	
	function saveSingle($transactionId = NULL) {
	
		if (!$this->userrights->hasRight(userrights::TRANSACTIONS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) {
			show_error(NULL, 403);
		}	
	
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));			
		//Load models
		$this->load->model(MODEL_TRANSACTION, 	strtolower(MODEL_TRANSACTION), 	TRUE);
		$this->load->model(MODEL_PERSON, 		strtolower(MODEL_PERSON), 		TRUE);
		
		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_DESCRIPTION,		lang(LANG_KEY_FIELD_DESCRIPTION), 	'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_AMOUNT, 			lang(LANG_KEY_FIELD_AMOUNT), 		'trim|required|max_length[10]|numeric|xss_clean');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_TRANSACTIONDATE,	lang(LANG_KEY_FIELD_DATE),			'trim|required|max_length[10]|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID,			lang(LANG_KEY_FIELD_PERSON),		'trim|required|callback__checkGuidValid');

		//If errors found, redraw the form to the user
		if($this->form_validation->run() == FALSE) {
			//Here we could define a different client type based on user agent-headers
			$client = CLIENT_DESKTOP;
			$data['transactionId'] = $transactionId;
			$data['persons'] = $this->person->getPersonListAsArray(TRUE);
			$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_EDITSINGLE, $data);
		} else {
			$data = array(			
				DB_TRANSACTION_DESCRIPTION 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_DESCRIPTION),
				DB_TRANSACTION_AMOUNT 			=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_AMOUNT),
				DB_TRANSACTION_TRANSACTIONDATE	=> formatDateODBC($this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_TRANSACTIONDATE)),
				DB_TRANSACTION_PERSONID 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID)
			);		

			//save the person via the model
			$this->transaction->saveTransaction($data, $transactionId, $this->session->userdata(SESSION_PERSONID));
		
			//User inserted or updated
			$client = CLIENT_DESKTOP;
			$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
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
}