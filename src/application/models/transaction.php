<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Transaction in database.
 *
 * @author André Brunnsberg
 *
*/
Class Transaction extends CI_Model {

	/**
	* Function used for loading a single transaction
	*
	* @param string $transactionId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/	
	function getTransaction($transactionId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_TRANSACTION);
		$this->db->where(DB_TRANSACTION_ID,	$transactionId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}		
	}
	
	function getTransactionList($personId = NULL) {
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_ID);
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_TRANSACTIONDATE);
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_AMOUNT);
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_DESCRIPTION);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_FIRSTNAME);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_LASTNAME);
		$this->db->select(DB_TABLE_PAYMENTTYPE . '.' . DB_PAYMENTTYPE_NAME);
		$this->db->from(DB_TABLE_TRANSACTION);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PERSONID . '=' . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'inner');		
		$this->db->join(DB_TABLE_PAYMENTTYPE, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PAYMENTTYPEID . '=' . DB_TABLE_PAYMENTTYPE . '.' . DB_PAYMENTTYPE_ID, 'left');		
		
		if($personId)
			$this->db->where(DB_TABLE_PERSON . '.' . DB_PERSON_ID, $personId);
		
		$this->db->order_by(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_TRANSACTIONDATE, "asc"); 

		$query = $this->db->get();
		return $query->result();	
	}

	function getTransactionSum($personId = NULL) {
		$this->db->select_sum(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_AMOUNT, DB_TRANSACTION_AMOUNT);
		$this->db->from(DB_TABLE_TRANSACTION);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PERSONID . '=' . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'inner');		
		$this->db->join(DB_TABLE_PAYMENTTYPE, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PAYMENTTYPEID . '=' . DB_TABLE_PAYMENTTYPE . '.' . DB_PAYMENTTYPE_ID, 'left');			
		
		if($personId)
			$this->db->where(DB_TABLE_PERSON . '.' . DB_PERSON_ID, $personId);

		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}						
	}	

	/**
	* Function used for saving a single transaction
	*
	* @param string $transactionId GUID of the transaction, if NULL an INSERT is made, otherwise UPDATE
	*/		
	function saveTransaction($data, $transactionId = NULL) {	
		if (!is_null($transactionId)) {
			$this->db->where(DB_TRANSACTION_ID, $transactionId);
			$this->db->set(DB_TRANSACTION_MODIFIED, 'NOW()', FALSE);
			$this->db->set(DB_TRANSACTION_MODIFIEDBY, $this->session->userdata(SESSION_PERSONID));						
			$this->db->update(DB_TABLE_TRANSACTION, $data);			
		} else {
			$data[DB_TRANSACTION_ID] = substr(generateGuid(), 1, 36);
			$this->db->set(DB_TRANSACTION_CREATED, 'NOW()', FALSE);
			$this->db->set(DB_TRANSACTION_CREATEDBY, $this->session->userdata(SESSION_PERSONID));			
			$this->db->insert(DB_TABLE_TRANSACTION, $data);
		}	
	}
}