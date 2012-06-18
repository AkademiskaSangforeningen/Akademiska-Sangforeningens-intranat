<?php
  /**
   * helper fun to populate user table to aid pagination of persons view.
   * These passwords will be bogus, since it uses the wrong encryption key.
   * Usage: php insert_person <dbuser> <dbpassword>
   * 
   * @author Simon Cederqvist
   */
  
  $arr = str_split('abcdefghijklmnopqrstuvwxyz');
  if(!$argv || sizeof($argv) < 3)
    echo("usage: insert_users.php <dbuser> <dbpassword>\n");

  $mysqli = new mysqli("localhost",$argv[1],$argv[2],"akademen");

  for($i=0;$i<10;$i++)
  {
    shuffle($arr); 
    $fname = implode('',array_slice($arr, 0, 5));
    $sname = implode('',array_slice($arr, 5, 10));
    $hash = generateHash($fname,"gfdgfdwnujikgvwn");
    $guid = generateGuid();
    $query = "INSERT INTO Person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, Status, Password, Created, CreatedBy, Modified, ModifiedBy) ".
             " VALUES ( '".$guid."', '".$fname."', '".$sname."', '2B','".implode('',array_slice($arr, 3, 10))."gränden', ".rand(5,5).", '".implode('',array_slice($arr, 3, 4))."ville', NULL, ".rand(6,10).", '".$fname."@test.akademen.com', 'Allergi".implode('',array_slice($arr, 6, 12))."', 'Desc".implode('',array_slice($arr, 3, 5))."', 0, '".$hash."', NOW(), 'test script', NULL, NULL)";
    $mysqli->query($query);
    echo "\n$query\n";
    if($mysqli->error)
      echo $mysqli->errno . " " . $mysqli->error . "\n";
  }
  
  	function generateHash($stringToHash, $encryptionKey) {
		//First get the encryption key in a base64-encoding (to remove false characters) 
		$encryptionKey = base64_encode($encryptionKey);
		//Calculate a 22-char salt
		$salt = substr(str_replace('+', '.', $encryptionKey), 0, 22);
		// Return the hash
		// 2a is the bcrypt algorithm selector, see http://php.net/crypt
		// 10 is the workload factor (around 300ms on a Core i5 machine)
		return crypt($stringToHash, '$2a$10$' . $salt);				
	}
	

	function generateGuid(){
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)// "{"
					.substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12)
					.chr(125);// "}"
			return $uuid;
		}
	}
/*
INSERT INTO Person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, Status, Password, Created, CreatedBy, Modified, ModifiedBy) VALUES ( '1f0f5a3a-7203-11e1-abc6-88ae1d113b5e', 'alfons', 'Tester', '2B', NULL, NULL, NULL, NULL, NULL, 'alfons@test.akademen.com', NULL, NULL, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO2TPY2gTThrmY7O2G.4mbUkjzqW42Cqi', NOW(), 'test script', NULL, NULL);
INSERT INTO Person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, Status, Password, Created, CreatedBy, Modified, ModifiedBy) VALUES ( '1f0fca8c-7203-11e1-abc6-88ae1d113b5e', 'bert', 'Tester', '2B', NULL, NULL, NULL, NULL, NULL, 'bert@test.akademen.com', NULL, NULL, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO0vhA87iieVFqS/wBOK0OaHlIpkO1pzS', NOW(), 'test script', NULL, NULL);
INSERT INTO Person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, Status, Password, Created, CreatedBy, Modified, ModifiedBy) VALUES ( '1f180152-7203-11e1-abc6-88ae1d113b5e', 'carl', 'Tester', '2B', NULL, NULL, NULL, NULL, NULL, 'carl@test.akademen.com', NULL, NULL, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IO7/4wFH6jWHLfDS1ZPNzORr3zzzJL/se', NOW(), 'test script', NULL, NULL);
INSERT INTO Person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, Status, Password, Created, CreatedBy, Modified, ModifiedBy) VALUES ( '1f1863f5-7203-11e1-abc6-88ae1d113b5e', 'david', 'Tester', '2B', NULL, NULL, NULL, NULL, NULL, 'david@test.akademen.com', NULL, NULL, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IOPk80TEbPYN6/0jg/pQicreteh3DAmf6', NOW(), 'test script', NULL, NULL);
INSERT INTO Person (Id, FirstName, LastName, Voice, Address, PostalCode, City, CountryId, Phone, Email, Allergies, Description, Status, Password, Created, CreatedBy, Modified, ModifiedBy) VALUES ( '1f18c95a-7203-11e1-abc6-88ae1d113b5e', 'edward', 'Tester', '2B', NULL, NULL, NULL, NULL, NULL, 'edward@test.akademen.com', NULL, NULL, 0, '$2a$10$Uj8rZ1IkQTYucjNbWHd8IOGb42DHidJbT2M.4mPZ.01TMfjbZlQ/q', NOW(), 'test script', NULL, NULL);

*/