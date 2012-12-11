<?php
/**
 * Event model.
 *
 * @author André Brunnsberg
 */

// TODO: See if this actually works.
class EventItem extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

	function getEventItem($eventItemId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_EVENTITEM);	
		$this->db->where(DB_EVENTITEM_ID,	$eventItemId);		
		
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}			
	}
	
	function getEventItems($eventId, $personId = NULL, $onlyShowRegistered = FALSE) {
		$this->db->select(DB_TABLE_EVENTITEM . '.*');
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID . ' AS ' . DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID, FALSE);
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_DESCRIPTION . ' AS ' . DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION, FALSE);
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_AMOUNT . ' AS ' . DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT, FALSE);
		$this->db->from(DB_TABLE_EVENTITEM);	
		$this->db->join(DB_TABLE_PERSONHASEVENTITEM, DB_TABLE_EVENTITEM . "." . DB_EVENTITEM_ID . ' = ' . DB_TABLE_PERSONHASEVENTITEM . "." . DB_PERSONHASEVENTITEM_EVENTITEMID . ' AND ' .  DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_PERSONID . ' = \'' . $personId . '\'', 'left');
		$this->db->where(DB_EVENTITEM_EVENTID,	$eventId);
		if ($onlyShowRegistered	== TRUE) {
			$this->db->where(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_PERSONID, $personId);
		}
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_ROWORDER);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_TYPE);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_CAPTION);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_DESCRIPTION);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function getEventItemSums($eventId) {
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID);
		$this->db->select('SUM(' . DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_AMOUNT . ') AS ' . DB_TOTALCOUNT, FALSE);
		$this->db->from(DB_TABLE_EVENTITEM);	
		$this->db->join(DB_TABLE_PERSONHASEVENTITEM, DB_TABLE_EVENTITEM . "." . DB_EVENTITEM_ID . ' = ' . DB_TABLE_PERSONHASEVENTITEM . "." . DB_PERSONHASEVENTITEM_EVENTITEMID, 'inner');
		$this->db->where(DB_EVENTITEM_EVENTID,	$eventId);
		$this->db->group_by(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID);
		
		$query = $this->db->get();
		return $query->result();		
	}
	
	function getPersonHasEventItems($eventId) {			
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_PERSONID);
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID);
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_DESCRIPTION);
		$this->db->select(DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_AMOUNT);
		$this->db->from(DB_TABLE_EVENTITEM);	
		$this->db->join(DB_TABLE_PERSONHASEVENTITEM, DB_TABLE_EVENTITEM . "." . DB_EVENTITEM_ID . ' = ' . DB_TABLE_PERSONHASEVENTITEM . "." . DB_PERSONHASEVENTITEM_EVENTITEMID, 'inner');
		$this->db->where(DB_EVENTITEM_EVENTID,	$eventId);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_ROWORDER);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_TYPE);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_CAPTION);
		$this->db->order_by(DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_DESCRIPTION);
		
		$query = $this->db->get();
		return $query->result();		
	}

	/**
	* Function used for saving a single event list item
	*
	* @param string $eventItemId GUID of the event, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveEventItem($data, $eventItemId = NULL) {
		if (!is_null($eventItemId)) {
			$this->db->where(DB_EVENTITEM_ID, $eventItemId);
			$this->db->set(DB_EVENTITEM_MODIFIED, 'NOW()', FALSE);
			$this->db->set(DB_EVENTITEM_MODIFIEDBY, $this->session->userdata(SESSION_PERSONID));
			$this->db->update(DB_TABLE_EVENTITEM, $data);
		} else {
			$eventItemId = substr(generateGuid(), 1, 36);
			$data[DB_EVENTITEM_ID] = $eventItemId;
			$this->db->set(DB_EVENTITEM_CREATED, 'NOW()', FALSE);
			$this->db->set(DB_EVENTITEM_CREATEDBY, $this->session->userdata(SESSION_PERSONID));
			$this->db->insert(DB_TABLE_EVENTITEM, $data);
		}
		return $eventItemId;
	}

	function deleteEventItems($eventId, $eventItemIdsNotToDelete = array()) {
		$this->db->where(DB_EVENTITEM_EVENTID, $eventId);
		if (count($eventItemIdsNotToDelete) > 0) {
			$this->db->where_not_in(DB_EVENTITEM_ID, $eventItemIdsNotToDelete);
		}
		$this->db->delete(DB_TABLE_EVENTITEM);
	}

	/**
	* Function used for saving a single person event item bind. Return TRUE if an UPDATE is made.
	*/
	function savePersonHasEventItem($personId, $eventItemId, $amount, $description, $modifiedBy) {
		$this->db->select(DB_PERSONHASEVENTITEM_PERSONID);
		$this->db->from(DB_TABLE_PERSONHASEVENTITEM);
		$this->db->where(DB_PERSONHASEVENTITEM_PERSONID, $personId);
		$this->db->where(DB_PERSONHASEVENTITEM_EVENTITEMID, $eventItemId);
		$query = $this->db->get();

		if ($query->num_rows() != 0) {
			//UPDATE
			$this->db->where(DB_PERSONHASEVENTITEM_PERSONID, 	$personId);
			$this->db->where(DB_PERSONHASEVENTITEM_EVENTITEMID, $eventItemId);
			$this->db->set(DB_PERSONHASEVENTITEM_AMOUNT, 		$amount);
			$this->db->set(DB_PERSONHASEVENTITEM_DESCRIPTION, 	$description);
			$this->db->set(DB_PERSONHASEVENTITEM_MODIFIED, 		'NOW()', FALSE);
			$this->db->set(DB_PERSONHASEVENTITEM_MODIFIEDBY, 	$modifiedBy);
			$this->db->update(DB_TABLE_PERSONHASEVENTITEM);
			return TRUE;
		} else {
			//INSERT
			$this->db->set(DB_PERSONHASEVENTITEM_PERSONID, 		$personId);
			$this->db->set(DB_PERSONHASEVENTITEM_EVENTITEMID, 	$eventItemId);
			$this->db->set(DB_PERSONHASEVENTITEM_AMOUNT, 		$amount);
			$this->db->set(DB_PERSONHASEVENTITEM_DESCRIPTION, 	$description);
			$this->db->set(DB_PERSONHASEVENTITEM_CREATED, 		'NOW()', FALSE);
			$this->db->set(DB_PERSONHASEVENTITEM_CREATEDBY, 	$modifiedBy);
			$this->db->insert(DB_TABLE_PERSONHASEVENTITEM);
			return FALSE;
		}
	}

	function deleteOrphanPersonHasEventItem($personId, $eventId, $eventItemIds = NULL) {
		$this->db->select(DB_PERSONHASEVENTITEM_EVENTITEMID);
		$this->db->from(DB_TABLE_PERSONHASEVENTITEM);
		$this->db->join(DB_TABLE_EVENTITEM, DB_TABLE_PERSONHASEVENTITEM . "." . DB_PERSONHASEVENTITEM_EVENTITEMID . " = " . DB_TABLE_EVENTITEM . "." . DB_EVENTITEM_ID);
		$this->db->where(DB_TABLE_PERSONHASEVENTITEM . "." . DB_PERSONHASEVENTITEM_PERSONID, $personId);
		$this->db->where(DB_TABLE_EVENTITEM . "." . DB_EVENTITEM_EVENTID, $eventId);
		if ($eventItemIds != null) {
			$this->db->where_not_in(DB_TABLE_PERSONHASEVENTITEM . "." . DB_PERSONHASEVENTITEM_EVENTITEMID, $eventItemIds);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach($query->result_array() as $row){
				$this->db->where(DB_PERSONHASEVENTITEM_EVENTITEMID, $row[DB_PERSONHASEVENTITEM_EVENTITEMID]);
				$this->db->where(DB_PERSONHASEVENTITEM_PERSONID, $personId);
				$this->db->delete(DB_TABLE_PERSONHASEVENTITEM);
			}				
		}
	}
}