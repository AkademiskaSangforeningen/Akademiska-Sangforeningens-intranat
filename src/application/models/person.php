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
		$this->db->select(DB_PERSON_ID);
		$this->db->select(DB_PERSON_EMAIL);
		$this->db->select(DB_PERSON_FIRSTNAME);
		$this->db->select(DB_PERSON_LASTNAME);
		$this->db->select(DB_PERSON_USERRIGHTS);
		$this->db->from(DB_TABLE_PERSON);
		$this->db->where(DB_PERSON_EMAIL, 		$email);
		$this->db->where(DB_PERSON_PASSWORD, 	$password);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}
	}

	/**
	* Function used for loading a single person
	*
	* @param string $personId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/	
	function getPerson($personId, $columns = FALSE) {
		if ($personId == NULL) {
			return FALSE;
		}
	
		if ($columns === FALSE) {
			$this->db->select('*');
		} else { 
			foreach($columns as $column) {
				$this->db->select($column);
			}
		}	
		$this->db->from(DB_TABLE_PERSON);
		$this->db->where(DB_PERSON_ID,	$personId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}		
	}
	
	/**
	* Function used for loading a single person's id using the email address
	*
	* @param string $personId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/	
	function getPersonIdUsingEmail($email) {
		$this->db->limit(1);
		$this->db->select(DB_PERSON_ID);
		$this->db->from(DB_TABLE_PERSON);
		$this->db->where(DB_PERSON_EMAIL, $email);

		$query = $this->db->get();		
		if ($query->num_rows() == 1) {
			foreach($query->result_array() as $row){
				return $row[DB_PERSON_ID];
			}		
		} else {
			return NULL;
		}		
	}	

	/**
	* Function used for loading all persons
	*
	* @return database result
	*/		
	function getPersonList() {
		$this->db->select('*');
		$this->db->from(DB_TABLE_PERSON);
		$this->db->order_by(DB_PERSON_LASTNAME, "asc"); 
		$this->db->order_by(DB_PERSON_LASTNAME, "asc"); 

		$query = $this->db->get();		
		return $query->result();	
	}
	
	/**
	* Function used for loading all persons as an array for dropdowns
	*
	* @return database result
	*/		
	function getPersonListAsArray($addEmptyOption = NULL) {
		$this->db->select(DB_PERSON_ID);
		$this->db->select(DB_PERSON_FIRSTNAME);
		$this->db->select(DB_PERSON_LASTNAME);
		$this->db->from(DB_TABLE_PERSON);
		$this->db->order_by(DB_PERSON_LASTNAME, "asc"); 
		$this->db->order_by(DB_PERSON_LASTNAME, "asc"); 

		$data = array();	
		if ($addEmptyOption) {
			$data[''] = '-';
		}
		
		$query = $this->db->get();
		foreach($query->result_array() as $row){
            $data[$row[DB_PERSON_ID]] = $row[DB_PERSON_FIRSTNAME] . " " . $row[DB_PERSON_LASTNAME];
        }
        return $data;
	}	

	/**
	* Function used for saving a single person
	*
	* @param string $personId GUID of the user, if NULL an INSERT is made, otherwise UPDATE
	*/		
	function savePerson($data, $personId = NULL, $modifiedBy = NULL) {	
		if (!is_null($personId)) {
			$this->db->where(DB_PERSON_ID, $personId);
			$this->db->set(DB_PERSON_MODIFIED, 'NOW()', FALSE);
			$this->db->set(DB_PERSON_MODIFIEDBY, $modifiedBy);						
			$this->db->update(DB_TABLE_PERSON, $data);			
		} else {
			$personId = substr(generateGuid(), 1, 36);
			
			if (is_null($modifiedBy)) {
				$modifiedBy = $personId;
			}
			
			$data[DB_PERSON_ID] = $personId;
			$this->db->set(DB_PERSON_CREATED, 'NOW()', FALSE);
			$this->db->set(DB_PERSON_CREATEDBY, $modifiedBy);			
			$this->db->insert(DB_TABLE_PERSON, $data);
		}
		return $personId;
	}
	
	/**
	* Function used for deleting a single person
	*
	* @param string $personId GUID of the user
	*/		
	function deletePerson($personId) {	
		$this->db->where(DB_PERSON_ID, $personId);
		$this->db->delete(DB_TABLE_PERSON);
	}	
}