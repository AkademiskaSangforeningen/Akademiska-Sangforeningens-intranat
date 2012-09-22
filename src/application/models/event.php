<?php
/**
 * Event model.
 * 
 * @author Simon Cederqvist
 */

// TODO: See if this actually works.
class Event extends CI_Model {

  var $Id = '';                    //char(36)
  var $Name = '';                  //varchar(256)
  var $StartDate = NULL;           //datetime
  var $EndDate = NULL;             //datetime
  var $RegistrationDueDate = NULL; //datetime
  var $PaymentDueDate = NULL;      //datetime
  var $Description = '';           //text
  var $Price = 0;                  //decimal(10,2)
  var $Location = '';              //varchar(256)
  var $IsAtClub = 0;               //tinyint(4)
  var $Type = 0;                   //tinyint(4)
  var $IsExternal = 0;             //tinyint(4)
  var $ResponsibleId = '';         //char(36)
  var $Created = NULL;             //datetime
  var $CreatedBy = '';             //char(36)
  var $Modified = NULL;            //datetime
  var $ModifiedBy = '';            //char(36)
  
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
        $query = $this->db->query('SELECT * FROM Event WHERE StartDate>='.time().
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
			return false;
		}		
	}
	
	/**
	* Function used for saving a single evemt
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
			$data[DB_EVENT_ID] = substr(generateGuid(), 1, 36);
			$this->db->set(DB_EVENT_CREATED, 'NOW()', FALSE);
			$this->db->set(DB_EVENT_CREATEDBY, $this->session->userdata(SESSION_PERSONID));			
			$this->db->insert(DB_TABLE_EVENT, $data);
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
	
	// TODO: Join with get_closest_future_events and getEvent
	function getAttendanceCount($eventId) {
        $query = $this->db->query('COUNT PersonId FROM Personhasevent WHERE EventId = ' . $eventId);
        return $query->result();		
	}
	
	//TODO: Clean up to only include necessary rows
	function getGuestList($eventId) {
        $query = $this->db->query('SELECT a.*, b.* FROM Personhasevent a, Person b WHERE a.PersonId = b.Id AND EventId = "' . $eventId . '"');
        return $query->result();		
	}
    
    
    function insert_event()
    {
      $this->Name   = $this->input->post('Name');
      $this->StartDate = $this->input->post('StartDate');
      $this->EndDate = $this->input->post('EndDate');
      $this->RegistrationDueDate = $this->input->post('RegistrationDueDate');
      $this->PaymentDueDate = $this->input->post('PaymentDueDate');
      $this->Description = $this->input->post('Description');
      $this->Price = $this->input->post('Price');
      $this->Location = $this->input->post('Location');
      $this->IsAtClub = $this->input->post('IsAtClub');
      $this->Type = $this->input->post('IsExternal');
      $this->IsExternal = $this->input->post('');
      $this->ResponsibleId = $this->input->post('ResponsibleId');
      $this->Created = time();
      $this->CreatedBy = '';  // HOW DO WE GET THIS
      $this->Modified = time();
      $this->ModifiedBy = ''; // HOW DO WE GET THIS
      
      $this->db->insert('Event', $this);
    }

    function update_event()
    {
      $this->Name   = $this->input->post('Name');
      $this->StartDate = $this->input->post('StartDate');
      $this->EndDate = $this->input->post('EndDate');
      $this->RegistrationDueDate = $this->input->post('RegistrationDueDate');
      $this->PaymentDueDate = $this->input->post('PaymentDueDate');
      $this->Description = $this->input->post('Description');
      $this->Price = $this->input->post('Price');
      $this->Location = $this->input->post('Location');
      $this->IsAtClub = $this->input->post('IsAtClub');
      $this->Type = $this->input->post('IsExternal');
      $this->IsExternal = $this->input->post('');
      $this->ResponsibleId = $this->input->post('ResponsibleId');
      $this->Created = time(); // We allow modification of creation date for simplicity.
      $this->CreatedBy = $this->input->post('CreatedBy'); // Differs from insert. Possible to modify this as well.
      $this->Modified = time(); 
      $this->ModifiedBy = ''; // HOW DO WE GET THIS
      
      $this->db->update('Event', $this, array('Id' => $this->input->post('Id')));
    }

}

?>
