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
  
	function getEventItems($eventId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_EVENTITEM);
		$this->db->where(DB_EVENTITEM_EVENTID,	$eventId);
		$this->db->order_by(DB_EVENTITEM_TYPE);
		$this->db->order_by(DB_EVENTITEM_CAPTION);
		$this->db->order_by(DB_EVENTITEM_DESCRIPTION);
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
	
	function deleteEventItems($eventId, $eventItemIdsNotToDelete) {
		$this->db->where(DB_EVENTITEM_EVENTID, $eventId);
		$this->db->where_not_in(DB_EVENTITEM_ID, $eventItemIdsNotToDelete);
		$this->db->delete(DB_TABLE_EVENTITEM);
	}
}

?>
