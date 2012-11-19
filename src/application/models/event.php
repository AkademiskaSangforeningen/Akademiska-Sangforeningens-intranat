<?php
/**
 * Event model.
 * 
 * @author Simon Cederqvist
 */

// TODO: See if this actually works.
class Event extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //May be called without limit to get all future events.
    //NOTE: Uses StartDate, so does not return ongoing events!
    function get_closest_future_events($limit = NULL)
    {
        // TODO: Make StartDate a bit smarter, so you can see 'Today' events even
        // if the event has no time, which would mean it would be equal to midnight,
        // and would not be shown in the morning of the same day.
        $query = $this->db->query('SELECT * FROM event WHERE StartDate>='.time().
                                  ' ORDER BY StartDate ASC'.
                                  ($limit ? ' LIMIT '.$this->db->escape($limit) : '')
								  );
        return $query->result();
    }
	
	function getEvent($eventId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_EVENT);
		$this->db->where(DB_EVENT_ID,	$eventId);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}		
	}
	
	/**
	* Function used for saving a single event
	*
	* @param string $eventId GUID of the event, if NULL an INSERT is made, otherwise UPDATE
	*/		
	function saveEvent($data, $eventId = NULL) {	
		if (!is_null($eventId)) {
			$this->db->where(DB_EVENT_ID, $eventId);
			$this->db->set(DB_EVENT_MODIFIED, 'NOW()', FALSE);
			$this->db->set(DB_EVENT_MODIFIEDBY, $this->session->userdata(SESSION_PERSONID));						
			$this->db->update(DB_TABLE_EVENT, $data);			
		} else {
			$eventId = substr(generateGuid(), 1, 36);
			$data[DB_EVENT_ID] = $eventId;
			$this->db->set(DB_EVENT_CREATED, 'NOW()', FALSE);
			$this->db->set(DB_EVENT_CREATEDBY, $this->session->userdata(SESSION_PERSONID));			
			$this->db->insert(DB_TABLE_EVENT, $data);
		}
		return $eventId;
	}	
	
	function getPersonHasEvent($eventId = NULL, $personId = NULL) {
		if ($eventId == NULL || $personId == NULL) {
			return FALSE;
		}

		$this->db->select('*');			
		$this->db->from(DB_TABLE_PERSONHASEVENT);
		$this->db->where(DB_PERSONHASEVENT_EVENTID, $eventId);
		$this->db->where(DB_PERSONHASEVENT_PERSONID, $personId);						
		$query = $this->db->get();		

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}				
	}
	
	/**
	* Function used for saving a single event
	*
	* @param string $eventId GUID of the event, if NULL an INSERT is made, otherwise UPDATE
	*/		
	function savePersonHasEvent($data, $eventId, $personId) {	
		if (!is_null($eventId) && !is_null($personId)) {
			$this->db->select(DB_PERSONHASEVENT_EVENTID);			
			$this->db->from(DB_TABLE_PERSONHASEVENT);
			$this->db->where(DB_PERSONHASEVENT_EVENTID, $eventId);
			$this->db->where(DB_PERSONHASEVENT_PERSONID, $personId);						
			$query = $this->db->get();

			if ($query->num_rows() != 0) {
				//UPDATE
				$this->db->set(DB_PERSONHASEVENT_MODIFIED, 'NOW()', FALSE);
				$this->db->set(DB_PERSONHASEVENT_MODIFIEDBY, $personId);
			
				$this->db->where(DB_PERSONHASEVENT_EVENTID, $eventId);
				$this->db->where(DB_PERSONHASEVENT_PERSONID, $personId);
				$this->db->update(DB_TABLE_PERSONHASEVENT, $data);
			} else {
				//INSERT
				$this->db->set(DB_PERSONHASEVENT_CREATED, 'NOW()', FALSE);
				$this->db->set(DB_PERSONHASEVENT_CREATEDBY, $personId);			
				$this->db->set(DB_PERSONHASEVENT_EVENTID, $eventId);
				$this->db->set(DB_PERSONHASEVENT_PERSONID, $personId);
				$this->db->insert(DB_TABLE_PERSONHASEVENT, $data);
			}
		}
	}
	
	function deletePersonHasEvent($eventId, $personId) {
		if (!is_null($eventId) && !is_null($personId)) {
			$this->db->where(DB_PERSONHASEVENT_EVENTID, $eventId);
			$this->db->where(DB_PERSONHASEVENT_PERSONID, $personId);
			$this->db->delete(DB_TABLE_PERSONHASEVENT);			
		}
	}	

	/**
	* Function used for getting the current avec for a person in an event bind
	*/		
	function getCurrentAvecForPersonHasEvent($personId, $eventId) {
		$this->db->select(DB_PERSONHASEVENT_AVECPERSONID);
		$this->db->from(DB_TABLE_PERSONHASEVENT);
		$this->db->where(DB_PERSONHASEVENT_PERSONID, $personId);
		$this->db->where(DB_PERSONHASEVENT_EVENTID, $eventId);

		$query = $this->db->get();		
		if ($query->num_rows() == 1) {
			foreach($query->result_array() as $row){
				return $row[DB_PERSONHASEVENT_AVECPERSONID];
			}		
		} else {
			return NULL;
		}		
	}
	
	/**
	* Function used for deleting a single event
	*
	* @param string $personId GUID of the user
	*/		
	function deleteEvent($eventId) {	
		$this->db->where(DB_EVENT_ID, $eventId);
		$this->db->delete(DB_TABLE_EVENT);
	}	
	
	function getUpcomingEventsForPerson($personId) {
		$this->db->select(DB_EVENT_ID);
		$this->db->select(DB_EVENT_NAME);
		$this->db->select(DB_EVENT_LOCATION);
		$this->db->select(DB_EVENT_STARTDATE);
		$this->db->select(DB_EVENT_ENDDATE);
		$this->db->select('(SELECT COUNT(*) FROM personHasEvent AS A WHERE A.EventId = Event.Id) AS Enrolled', FALSE);
		$this->db->select(DB_PERSONHASEVENT_STATUS);
		$this->db->from(DB_TABLE_EVENT);
		$this->db->join(DB_TABLE_PERSONHASEVENT, DB_TABLE_EVENT . '.' . DB_EVENT_ID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID, 'LEFT OUTER');
		$this->db->where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID, $personId);
		$this->db->or_where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ' IS NULL');
		$this->db->order_by(DB_EVENT_STARTDATE);
		$this->db->order_by(DB_EVENT_ENDDATE);
		$this->db->order_by(DB_EVENT_NAME);			
	
		$query = $this->db->get();	
		return $query->result();
	}
	
	function isEmailAlreadyRegisteredToEvent($email, $eventId) {
		$this->db->select(DB_PERSONHASEVENT_EVENTID);
		$this->db->from(DB_TABLE_PERSONHASEVENT);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ' = ' . DB_TABLE_PERSON . '.' . DB_PERSON_ID);		
		$this->db->where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID, $eventId);		
		$this->db->where(DB_TABLE_PERSON . '.' . DB_PERSON_EMAIL, $email);
		$query = $this->db->get();		
		
		return ($query->num_rows() > 0);
	}
	
	// TODO: Join with get_closest_future_events and getEvent
	function getAttendanceCount($eventId) {
        $query = $this->db->query('COUNT PersonId FROM personhasevent WHERE EventId = ' . $eventId);
        return $query->result();		
	}
	
	//TODO: Clean up to only include necessary rows
	function getGuestList($eventId) {
        $query = $this->db->query('SELECT a.*, b.* FROM personhasevent a, Person b WHERE a.PersonId = b.Id AND EventId = "' . $eventId . '"');
        return $query->result();		
	}    
}

?>
