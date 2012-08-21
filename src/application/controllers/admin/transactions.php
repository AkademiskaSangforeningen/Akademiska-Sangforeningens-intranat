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
	
	function listAll() {
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		
		$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);

		$data['transactionList'] = $this->transaction->getTransactionList();				
		
		$client = CLIENT_DESKTOP;

		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_ADMIN_LISTALL, $data);
	}
		
	function editSingle($transactionId = NULL) {	
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));				
		
		if (!is_null($transactionId)) {
			$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);			
			$data['transaction'] = $this->transaction->getTransaction($transactionId);
			$data['transactionId'] = $transactionId;
		}

		$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
		$data['personList'] = $this->person->getPersonListAsArray(true);
		
		$this->load->model(MODEL_PAYMENTTYPE, strtolower(MODEL_PAYMENTTYPE), TRUE);
		$data['paymentTypeList'] = $this->paymenttype->getPaymentTypeListAsArray();	

		$client = CLIENT_DESKTOP;
		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_ADMIN_EDITSINGLE, $data);
	}
	
	function saveSingle($transactionId = NULL) {
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));			
		//Load the validation library
		$this->load->library('form_validation');

		//Validate the fields
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_TRANSACTIONDATE,	lang(LANG_KEY_FIELD_DATE),		'trim|max_length[10]|required|xss_clean|callback__checkDateValid');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_AMOUNT,			lang(LANG_KEY_FIELD_AMOUNT),	'trim|max_length[10]|required|xss_clean|numeric');
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID, 		lang(LANG_KEY_FIELD_PERSON),	'trim|max_length[36]|required|xss_clean');								
		$this->form_validation->set_rules(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_DESCRIPTION, 		lang(LANG_KEY_FIELD_ALLERGIES),	'trim|max_length[255]|xss_clean');						

		if($this->form_validation->run() == FALSE) {
			$data['transactionId'] = $transactionId;
			$this->load->model(MODEL_PERSON, strtolower(MODEL_PERSON), TRUE);
			$data['personList'] = $this->person->getPersonListAsArray(true);
			$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_ADMIN_EDITSINGLE, $data);
		} else {
			$data = array(			
				DB_TRANSACTION_TRANSACTIONDATE 	=> formatDateODBC($this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_TRANSACTIONDATE)),
				DB_TRANSACTION_AMOUNT 			=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_AMOUNT),
				DB_TRANSACTION_PERSONID 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID),
				DB_TRANSACTION_DESCRIPTION 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_DESCRIPTION),
				DB_TRANSACTION_PAYMENTTYPEID 		=> $this->input->post(DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PAYMENTTYPEID)
			);

			$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);			
			$this->transaction->saveTransaction($data, $transactionId);
			$this->load->view($client . VIEW_GENERIC_DIALOG_CLOSE_AND_RELOAD_PARENT);
		}
	}
	
	function _checkDateValid($date) {
		if (!isDateValid($date)) {
			$this->form_validation->set_message('_checkDateValid', "Fel datum din pucko!");
			return false;		
		}
	}
}