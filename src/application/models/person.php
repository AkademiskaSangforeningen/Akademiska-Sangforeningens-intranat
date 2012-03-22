<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
        $this->db->where(DB_PERSON_EMAIL,               $email);
        $this->db->where(DB_PERSON_PASSWORD,    $password);
    
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
    
    function get_all_persons($order = "DESC", $status = -1)
    {
        
        if($order!="DESC")
            $order = "ASC"; // Just to be safe, when I still don't know how this framework works.
        $this->db->select(DB_PERSON_ID.','.
                          DB_PERSON_FIRSTNAME.','.
                          DB_PERSON_LASTNAME.','.
                          DB_PERSON_STATUS.','.
                          DB_PERSON_VOICE.','.
                          DB_PERSON_EMAIL.','.DB_PERSON_PHONE);
        $this->db->from(DB_TABLE_PERSON);
        if($status != -1)
            $this->db->where(DB_PERSON_STATUS,$status);
        $this->db->order_by(DB_PERSON_LASTNAME,$order);
        $query = $this->db->get();
        return $query->result();
    }  
    function search_person($searchcriteria)
    {
        $this->db->select(DB_PERSON_ID.','.
                  DB_PERSON_FIRSTNAME.','.
                  DB_PERSON_LASTNAME.','.
                  DB_PERSON_STATUS.','.
                  DB_PERSON_VOICE.','.
                  DB_PERSON_EMAIL.','.DB_PERSON_PHONE);
        $this->db->from(DB_TABLE_PERSON);
        $this->db->where(DB_PERSON_FIRSTNAME,$searchcriteria);
        $this->db->or_where(DB_PERSON_LASTNAME,$searchcriteria);
        $query = $this->db->get();
        return $query->result();
        
    }
}
