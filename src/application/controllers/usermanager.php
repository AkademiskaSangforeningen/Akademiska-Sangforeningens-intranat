<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for managing/listing users.
 *
 * @author Simon Cederqvist
 *
 */
class Usermanager extends CI_Controller {
  
  function __construct() {
    parent::__construct();	
    
    //Set headers to always load data dynamically
    header('Content-type: text/html; charset=utf-8');		
    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    header("Expires: 0");
  }
  
  /**
   * Default: prints a list of users, with their data in columns.
   */
  function index() {
    // 
    //Here we could define a different client type based on user agent-headers
    $client = CLIENT_DESKTOP;
    
    //Load languages. As we don't yet know the user's language, we default to swedish
    $this->lang->load(LANG_FILE, LANG_LANGUAGE_SV);
    
    //Load default listusers view
    $this->load->view($client . VIEW_GENERIC_HEADER);
    $this->load->view($client . VIEW_CONTENT_USERMANAGER_LISTUSERS);
    $this->load->view($client . VIEW_GENERIC_FOOTER);
  }
  
  
  function delete ($what) {    
    $this->load->view($client . VIEW_GENERIC_HEADER);
    //    $this->load->view($client . VIEW_CONTENT_MASSEDITOR_DELETE);
    $this->load->view($client . VIEW_GENERIC_FOOTER);    
  }
  
  function get_all_users($order = "DESC")
  {
    if($order!="DESC") $order = "ASC"; // Just to be safe, when I still don't know how this framework works.
    return $this->db->query("SELECT * FROM Person ORDER BY LastName,FirstName ?", array($order));
  }
  
  function get_all_admins($order = "DESC")
  {
    if($order!="DESC") $order = "ASC"; // Just to be safe, when I still don't know how this framework works.
    return $this->db->query("SELECT * FROM Person WHERE Status=".STATUS_ADMIN." ORDER BY LastName,FirstName ?", array($order));
    
  }
}