<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Person in database.
 *
 * @author André Brunnsberg
 *
*/
Class Person extends CI_Model {

	/**
	* Function used for checking login in database
	*
	* @param string $email email of user
	* @param string $password password of user
	* @return false if check fails, otherwise returns database result
	*/
	function canUserLogin($email, $password) {
		$this->db->select(DB_PERSON_ID . ', ' . DB_PERSON_EMAIL);
		$this->db->from(DB_TABLE_PERSON);
		$this->db->where(DB_PERSON_EMAIL, 		$email);
		$this->db->where(DB_PERSON_PASSWORD, 	$password);
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
  
  function findAllBalances() {
    $this->db->select("*, 0.0 as TotalBalance", FALSE);
    
    $query = $this->db->get(DB_TABLE_PERSON);
    return $query->result_array();
  }
}