<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Transaction in database.
 *
 * @author André Brunnsberg
 *
*/
Class Transaction extends CI_Model {

	function savePersonHasEventTransaction($eventId, $personId) {
		if (!is_null($eventId) && !is_null($personId)) {

			$totalSum = 0;

			// Get sum
			$this->db->select('SUM(' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_AMOUNT . ' * ' . DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_AMOUNT .') AS ' . DB_TOTALSUM, FALSE);
			$this->db->from(DB_TABLE_PERSONHASEVENT);
			$this->db->join(DB_TABLE_EVENTITEM, DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_EVENTID, 'inner');
			$this->db->join(DB_TABLE_PERSONHASEVENTITEM, DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID . ' = ' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_ID, 'inner');
			$this->db->where(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_PERSONID
					. ' IN (' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ', ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_AVECPERSONID . ')', NULL, FALSE);
			$this->db->where_in(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID, $personId);
			$this->db->where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID, $personId);
			$this->db->where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID, $eventId);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$totalSum = $row[DB_TOTALSUM];
			}
			
			// Make the total sum negative
			$totalSum *= -1;

			// Check if an INSERT or an UPDATE should be made
			$this->db->select(DB_TRANSACTION_ID);
			$this->db->from(DB_TABLE_TRANSACTION);
			$this->db->where(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PERSONID, 	$personId);
			$this->db->where(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_EVENTID, 	$eventId);
			$query = $this->db->get();

			if ($query->num_rows() != 0) {
				$row = $query->row_array();
				$transactionId = $row[DB_TRANSACTION_ID];

				// UPDATE
				$this->db->set(DB_TRANSACTION_AMOUNT, 			$totalSum);
				$this->db->set(DB_TRANSACTION_TRANSACTIONDATE, 	'NOW()', FALSE);
				$this->db->set(DB_TRANSACTION_MODIFIED, 		'NOW()', FALSE);
				$this->db->set(DB_TRANSACTION_MODIFIEDBY, 		$personId);
				$this->db->where(DB_TRANSACTION_ID, 			$transactionId);
				$this->db->update(DB_TABLE_TRANSACTION, 		NULL);

				return $transactionId;
			} else {
				// INSERT
				$transactionId = substr(generateGuid(), 1, 36);
				$this->db->set(DB_TRANSACTION_ID, 				$transactionId);
				$this->db->set(DB_TRANSACTION_PERSONID, 		$personId);
				$this->db->set(DB_TRANSACTION_EVENTID, 			$eventId);
				$this->db->set(DB_TRANSACTION_AMOUNT, 			$totalSum);
				$this->db->set(DB_TRANSACTION_TRANSACTIONDATE, 	'NOW()', FALSE);
				$this->db->set(DB_TRANSACTION_CREATED, 			'NOW()', FALSE);
				$this->db->set(DB_TRANSACTION_CREATEDBY, 		$personId);
				$this->db->insert(DB_TABLE_TRANSACTION, 		NULL);

				return $transactionId;
			}
		}
	}

	function deletePersonHasEventTransaction($eventId, $personId) {
		if (!is_null($eventId) && !is_null($personId)) {
			$this->db->where(DB_TRANSACTION_PERSONID, 	$personId);
			$this->db->where(DB_TRANSACTION_EVENTID,	$eventId);
			$this->db->delete(DB_TABLE_TRANSACTION);
		}
	}

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

	function getPersonCurrentBalance($personId = NULL, $eventId = FALSE) {
		if (!$personId) {
			return 0;
		}

		$this->db->select('IFNULL(SUM(' . DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_AMOUNT . '), 0) AS ' . DB_TOTALSUM, FALSE);
		$this->db->from(DB_TABLE_TRANSACTION);
		$this->db->where(DB_TRANSACTION_PERSONID, $personId);
		if ($eventId !== FALSE) {
			$this->db->where_not_in(DB_TRANSACTION_EVENTID, array($eventId));
		}

		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$row = $query->row();
			echo $query->num_rows();
			return $row->{DB_TOTALSUM};
		} else {
			return 0;
		}
	}

	function getTransactionList($personId = NULL) {
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_ID);
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_TRANSACTIONDATE);
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_AMOUNT);
		$this->db->select(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_DESCRIPTION);
		$this->db->select(DB_TABLE_EVENT . '.' . DB_EVENT_NAME);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_FIRSTNAME);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_LASTNAME);
		$this->db->from(DB_TABLE_TRANSACTION);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PERSONID . '=' . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'inner');
		$this->db->join(DB_TABLE_EVENT, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_EVENTID . '=' . DB_TABLE_EVENT . '.' . DB_EVENT_ID, 'left');

		if($personId) {
			$this->db->where(DB_TABLE_PERSON . '.' . DB_PERSON_ID, $personId);
		}

		$this->db->order_by(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_TRANSACTIONDATE, "desc");

		$query = $this->db->get();
		return $query->result();
	}

	function getTransactionSum($personId = NULL) {
		$this->db->select_sum(DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_AMOUNT, DB_TOTALSUM);
		$this->db->from(DB_TABLE_TRANSACTION);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_TRANSACTION . '.' . DB_TRANSACTION_PERSONID . '=' . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'inner');

		if($personId) {
			$this->db->where(DB_TABLE_PERSON . '.' . DB_PERSON_ID, $personId);
		}

		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
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