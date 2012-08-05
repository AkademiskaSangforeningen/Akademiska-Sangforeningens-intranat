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
	
	function listall() {
		$client = CLIENT_DESKTOP;
		$this->lang->load(LANG_FILE, $this->session->userdata(SESSION_LANG));
		
		$this->load->model(MODEL_TRANSACTION, strtolower(MODEL_TRANSACTION), TRUE);

    $personId = $this->session->userdata(SESSION_PERSONID);
		$data['transactionList'] = $this->transaction->getTransactionList($personId);				
		$data['transactionSum'] = $this->transaction->getTransactionSum($personId);
		
		$this->load->view($client . VIEW_CONTENT_TRANSACTIONS_LISTALL, $data);
	}
}