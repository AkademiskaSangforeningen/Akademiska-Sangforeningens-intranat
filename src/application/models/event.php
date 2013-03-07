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
    
	function getAllEvents($limit = FALSE, $offset = FALSE) {
		$this->db->select('*');
		$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_EVENT . ') AS ' . DB_TOTALCOUNT, FALSE);
		$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' WHERE ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ') AS ' . DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT, FALSE);	
		$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' WHERE ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ' AND ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_AVECPERSONID . ' IS NOT NULL) AS ' . DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT, FALSE);
		$this->db->from(DB_TABLE_EVENT);
		$this->db->order_by(DB_EVENT_STARTDATE, "desc");
		$this->db->order_by(DB_EVENT_ENDDATE, 	"desc");
		$this->db->order_by(DB_EVENT_NAME, 		"asc");
		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function getEvent($eventId, $columns = FALSE) {
		if ($eventId == NULL) {
			return FALSE;
		}	
	
		if ($columns === FALSE) {
			$this->db->select('*');
		} else { 
			foreach($columns as $column) {
				if ($column == DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT) {
					$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' WHERE ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ') AS ' . DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT, FALSE);	
				} else if ($column == DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT) {
					$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' WHERE ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ' AND ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_AVECPERSONID . ' IS NOT NULL) AS ' . DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT, FALSE);						
				} else {			
					$this->db->select($column);
				}
			}
		}		
		
		$this->db->from(DB_TABLE_EVENT);
		$this->db->where(DB_EVENT_ID, $eventId);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}		
	}
	
	function getPersonVoiceSumsForEvent($eventId) {
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_VOICE);
		$this->db->select('COUNT(*) AS ' . DB_TOTALCOUNT, FALSE);		
		$this->db->from(DB_TABLE_PERSONHASEVENT);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ' = ' . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'inner');
		$this->db->where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID, $eventId);
		$this->db->where(DB_TABLE_PERSON . '.' . DB_PERSON_VOICE . ' IS NOT NULL', null, FALSE);
		$this->db->group_by(DB_TABLE_PERSON . '.' . DB_PERSON_VOICE);	
		
		$query = $this->db->get();		
		return $query->result();		
	}
	
	function getPersonsForEvent($eventId, $limit = FALSE, $offset = FALSE) {
		$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' AS A WHERE A.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ') AS '. DB_TOTALCOUNT, FALSE);	
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_ID);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_FIRSTNAME);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_LASTNAME);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_EMAIL);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_PHONE);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_ALLERGIES);
		$this->db->select(DB_TABLE_PERSON . '.' . DB_PERSON_VOICE);		
		$this->db->select(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PAYMENTTYPE);
		$this->db->select(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_CREATED);
		$this->db->select('(SELECT SUM(IFNULL(' . DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_AMOUNT . ', 0) * IFNULL(' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_AMOUNT . ', 0))'
				. ' FROM ' . DB_TABLE_PERSONHASEVENTITEM
				. ' INNER JOIN ' . DB_TABLE_EVENTITEM . ' ON ' . DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID . ' = ' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_ID
				. ' WHERE ' 
				. DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_PERSONID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID 
				. ' AND ' 
				. DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_EVENTID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID
			. ') AS ' . DB_TOTALSUM, FALSE);				
		$this->db->select('(SELECT SUM(IFNULL(' . DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_AMOUNT . ', 0) * IFNULL(' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_AMOUNT . ', 0))'
				. ' FROM ' . DB_TABLE_PERSONHASEVENTITEM
				. ' INNER JOIN ' . DB_TABLE_EVENTITEM . ' ON ' . DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_EVENTITEMID . ' = ' . DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_ID
				. ' WHERE ' 
				. DB_TABLE_PERSONHASEVENTITEM . '.' . DB_PERSONHASEVENTITEM_PERSONID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_AVECPERSONID 
				. ' AND ' 
				. DB_TABLE_EVENTITEM . '.' . DB_EVENTITEM_EVENTID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID
			. ') AS ' . DB_CUSTOM_AVEC . DB_TOTALSUM, FALSE);			
		$this->db->select(DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_ID . ' AS ' . DB_CUSTOM_AVEC . DB_PERSON_ID, 				FALSE);
		$this->db->select(DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_FIRSTNAME . ' AS ' . DB_CUSTOM_AVEC . DB_PERSON_FIRSTNAME, FALSE);
		$this->db->select(DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_LASTNAME . ' AS ' . DB_CUSTOM_AVEC . DB_PERSON_LASTNAME, 	FALSE);
		$this->db->select(DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_ALLERGIES . ' AS ' . DB_CUSTOM_AVEC . DB_PERSON_ALLERGIES, FALSE);		
		$this->db->select(DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_EMAIL . ' AS ' . DB_CUSTOM_AVEC . DB_PERSON_EMAIL, 	FALSE);
		$this->db->select(DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_PHONE . ' AS ' . DB_CUSTOM_AVEC . DB_PERSON_PHONE, 	FALSE);
		$this->db->from(DB_TABLE_PERSONHASEVENT);
		$this->db->join(DB_TABLE_PERSON, DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ' = ' . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'inner');
		$this->db->join(DB_TABLE_PERSON . ' AS ' . DB_CUSTOM_AVEC . DB_TABLE_PERSON, DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_AVECPERSONID . ' = ' . DB_CUSTOM_AVEC . DB_TABLE_PERSON . '.' . DB_PERSON_ID, 'left');
		$this->db->where(DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID, $eventId);
		$this->db->order_by(DB_TABLE_PERSON . '.' . DB_PERSON_LASTNAME);
		$this->db->order_by(DB_TABLE_PERSON . '.' . DB_PERSON_FIRSTNAME);		
		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();		
		return $query->result();
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
	* Function used for saving a single event. Return TRUE if an UPDATE is made.
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
				return TRUE;
			} else {
				//INSERT
				$this->db->set(DB_PERSONHASEVENT_CREATED, 'NOW()', FALSE);
				$this->db->set(DB_PERSONHASEVENT_CREATEDBY, $personId);			
				$this->db->set(DB_PERSONHASEVENT_EVENTID, $eventId);
				$this->db->set(DB_PERSONHASEVENT_PERSONID, $personId);
				$this->db->insert(DB_TABLE_PERSONHASEVENT, $data);
				return FALSE;
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
	
	function getUpcomingEvents($personId) {
		$this->db->select(DB_EVENT_ID);
		$this->db->select(DB_EVENT_NAME);
		$this->db->select(DB_EVENT_LOCATION);
		$this->db->select(DB_EVENT_STARTDATE);
		$this->db->select(DB_EVENT_ENDDATE);
		$this->db->select(DB_EVENT_REGISTRATIONDUEDATE);
		$this->db->select(DB_EVENT_CANUSERSVIEWREGISTRATIONS);
		$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' AS A WHERE A.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ') AS ' . DB_TOTALCOUNT, FALSE);
		$this->db->from(DB_TABLE_EVENT);		
		$this->db->where('NOT EXISTS (SELECT 1 FROM ' . DB_TABLE_PERSONHASEVENT . ' WHERE ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' AND ' .  DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ' = \'' . $personId . '\')', NULL, FALSE);
		$this->db->where(DB_EVENT_PARTICIPANT . ' & 1', NULL, FALSE); // Only list events that "active singers" are set as participiants
		$this->db->order_by(DB_EVENT_STARTDATE);
		$this->db->order_by(DB_EVENT_ENDDATE);
		$this->db->order_by(DB_EVENT_NAME);			
	
		$query = $this->db->get();	
		return $query->result();
	}
	
	function getRegisteredEvents($personId) {
		$this->db->select(DB_EVENT_ID);
		$this->db->select(DB_EVENT_NAME);
		$this->db->select(DB_EVENT_LOCATION);
		$this->db->select(DB_EVENT_STARTDATE);
		$this->db->select(DB_EVENT_ENDDATE);
		$this->db->select(DB_EVENT_REGISTRATIONDUEDATE);
		$this->db->select(DB_EVENT_CANUSERSVIEWREGISTRATIONS);
		$this->db->select('(SELECT COUNT(*) FROM ' . DB_TABLE_PERSONHASEVENT . ' AS A WHERE A.' . DB_PERSONHASEVENT_EVENTID . ' = ' . DB_TABLE_EVENT . '.' . DB_EVENT_ID . ') AS ' . DB_TOTALCOUNT, FALSE);
		$this->db->select(DB_PERSONHASEVENT_PERSONID);
		$this->db->from(DB_TABLE_EVENT);
		$this->db->join(DB_TABLE_PERSONHASEVENT, DB_TABLE_EVENT . '.' . DB_EVENT_ID . ' = ' . DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_EVENTID . ' AND ' .  DB_TABLE_PERSONHASEVENT . '.' . DB_PERSONHASEVENT_PERSONID . ' = \'' . $personId . '\'', 'inner');
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
