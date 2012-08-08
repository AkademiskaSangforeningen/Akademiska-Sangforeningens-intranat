<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table PaymentType in database.
 *
 * @author André Brunnsberg
 *
*/
Class PaymentType extends CI_Model {

	/**
	* Function used for loading all payment types as an array for dropdowns
	*
	* @return database result
	*/		
	function getPaymentTypeListAsArray($addEmpty = NULL) {
		$this->db->select(DB_PAYMENTTYPE_ID);
		$this->db->select(DB_PAYMENTTYPE_NAME);
		$this->db->from(DB_TABLE_PAYMENTTYPE);
		$this->db->order_by(DB_PAYMENTTYPE_NAME, "asc"); 

		$data = array();
		
		if ($addEmpty) {
			$data[''] = '-';
		}
		
		$query = $this->db->get();
		foreach($query->result_array() as $row){
            $data[$row[DB_PAYMENTTYPE_ID]] = $row[DB_PAYMENTTYPE_NAME];
    }
    return $data;
	}
}