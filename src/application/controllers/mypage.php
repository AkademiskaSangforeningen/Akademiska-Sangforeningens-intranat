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
		$this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);	

		$this->load->view($client . VIEW_GENERIC_HEADER);
		$this->load->view($client . VIEW_GENERIC_HEADER_NAVITABS);
		$this->load->view($client . VIEW_CONTENT_MYPAGE_DASHBOARD);
		$this->load->view($client . VIEW_GENERIC_FOOTER);				
		
	}
}