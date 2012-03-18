<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for quartet accounts
 *
 * @author Markus Virtanen
 *
*/
class QuartetAccount extends CI_Controller {

	function __construct() {
		parent::__construct();	

		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}

	function index() {
		$client = CLIENT_DESKTOP;
    $this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);
    
    $this->load->model(DB_TABLE_PERSON, 'person', TRUE);
		$data['persons'] = $this->person->findAllBalances();
    
		$this->load->view($client . VIEW_GENERIC_HEADER);
    $this->load->view($client . "/content/kk/kk_admin_list", $data);
		$this->load->view($client . VIEW_GENERIC_FOOTER);
	}

}