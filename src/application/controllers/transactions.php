<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for login (and logout)
 *
 * @author André Brunnsberg
 *
*/
class Transactions extends CI_Controller {

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
		
		$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);

		$data['transactionList'] = $this->transaction->getTransactionList();				
		$data['transactionSum'] = $this->transaction->getTransactionSum();
		
		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_LISTALL, $data);
	}
	
	/**
	*	Used for editing a single transaction
	*/		
	function editSingle($transactionId = NULL) {	
		//Here we could define a different client type based on user agent-headers
		$client = CLIENT_DESKTOP;

		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));				
		
		if (!is_null($transactionId)) {
			$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);			
			$data['transaction'] = $this->transaction->getTransaction($transactionId);
			$data['transactionId'] = $transactionId;
		}

		$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
		$data['personList'] = $this->person->getPersonListAsArray(true);
		
		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_EDITSINGLE, $data);
	}
	
	/**
	*	Used for saving a single person
	*/	
	function saveSingle($transactionId = NULL) {
		//Load the validation library
		$this->load->library('form_validation');
		//Load languages
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));			
		
		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_TRANSACTIONDATE,	lang(LANG_KEY_FIELD_DATE),		'trim|max_length[10]|required|xss_clean|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_AMOUNT,			lang(LANG_KEY_FIELD_AMOUNT),	'trim|max_length[10]|required|xss_clean|numeric');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID, 		lang(LANG_KEY_FIELD_PERSON),	'trim|max_length[36]|required|xss_clean');								
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_DESCRIPTION, 		lang(LANG_KEY_FIELD_ALLERGIES),	'trim|max_length[255]|xss_clean');						

		//If errors found, redraw the login form to the user
		if($this->form_validation->run() == FALSE) {
			//Here we could define a different client type based on user agent-headers
			$client = CLIENT_DESKTOP;
			$data['transactionId'] = $transactionId;
		$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
		$data['personList'] = $this->person->getPersonListAsArray(true);						
			$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_EDITSINGLE, $data);
		} else {
			$data = array(			
				DB_TRANSACTION_TRANSACTIONDATE 	=> formatDateODBC($this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_TRANSACTIONDATE)),
				DB_TRANSACTION_AMOUNT 			=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_AMOUNT),
				DB_TRANSACTION_PERSONID 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID),
				DB_TRANSACTION_DESCRIPTION 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_DESCRIPTION)		
			);
			
			//Load the transaction-model
			$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);			
			//save the person via the model
			$this->transaction->saveTransaction($data, $transactionId);
		
			//User inserted or updated
			$client = CLIENT_DESKTOP;
			$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_SAVESINGLE_SUCCESS);
		}
	}
	
	function _checkDateValid($date) {
		if (!isDateValid($date)) {
			$this->form_validation->set_message('_checkDateValid', "Fel datum din pucko!");
			return false;		
		}
	}
}