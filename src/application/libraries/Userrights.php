<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserRights {
  const ViewTransactions = 1;
  const AddTransactions = 2;
  const RemoveTransactions = 4;
  const EditTransactions = 8;

  const ViewUsers = 16;
  const AddUsers = 32;
  const RemoveUsers = 64;
  const EditUsers = 128;

  const ViewEvents = 256;
  const AddEvents = 512;
  const RemoveEvents = 1024;
  const EditEvents = 2048;

  function transactionAdmin(){
    return UserRights::ViewTransactions | 
           UserRights::AddTransactions | 
           UserRights::EditTransactions | 
           UserRights::RemoveTransactions;
  }

  function hasRight($right, $toCheck) {
    return $right & $toCheck;
  }

  function canAdministrate($module, $rights){
    if($module == 'transactions'){
      $required = $this->transactionAdmin();
      return $required == ($rights & $required);
    }

    return false;
  }
}

