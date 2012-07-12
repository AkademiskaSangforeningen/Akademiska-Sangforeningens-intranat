<?php 
/*
* VERY MUCH UNDER CONSTRUCTION!
* -Emil
*/

?>

   
        <h1>Signup<?php //echo $this->lang->line(LANG_KEY_EVENTSIGNUP_HEADER); ?></h1>
                
                <?php //echo form_open(CONTROLLER_EVENTSIGNUP_SIGNUP, array('id' => 'form_login')); ?>
                        
                        
                        <?php // Name field pre-filled and locked if user is logged in? ?>
                        <label for="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>"><?php echo $this->lang->line(LANG_KEY_FIELD_NAME); ?>:</label>
                        <input type="name" size="20" id="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>" name="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>" class="required ui-corner-all" />
                        <br/>
        
                        <input type="submit" value="<?php echo lang("signup_submit"); ?>" id="form_eventsignup_submit_button" class="ui-corner-all" />
						
        </form>



<div id="container" class="ui-corner-all">
<?php
//Get the event id and event data
//REPLACE WITH MODEL
$eventId = "'" . $eventData->{'Id'} . "'";

$query = $this->db->query("SELECT * FROM Event WHERE Id = " . $eventId);
if($query->num_rows() > 0)
{
	$event_row = $query->row(); 
	echo '<br>';
	echo $event_row->Id;
	echo '<br>';
	echo $event_row->Name;
	echo '<br>';
	echo $event_row->StartDate;
	echo '<br>';
}


// Get the list of Guests for the current event.
//REPLACE WITH MODEL
                /*$guests = mysql_query("SELECT * FROM Personhasevent WHERE (EventId = " . $eventId .  ") ORDER BY EventId ASC");

                while($row = mysql_fetch_array($guests)) {
                        $i = $row['Id'];
                        $n = $row['Name'];
                        $guestList[$i] = $n; 
                }
                */
				$n = 0;
				$query = $this->db->query("SELECT * FROM PersonHasEvent WHERE (EventId = " . $eventId .  ")");
				foreach($query->result_array() as $row)
				{
					$i = $row['PersonId'];
					$person_query = $this->db->query("SELECT * FROM Person WHERE Id = '" . $i . "'");
					$person_row = $person_query->row(); 
					$n = $person_row->FirstName . " " . $person_row->LastName;
					$guestList[$i] = $n; 
				}
				
				

//Move to controller?
//Load the model Person with database access
$this->load->model(DB_TABLE_PERSON, 'person', TRUE);
//Get username. 
$username = $this->input->post(DB_TABLE_PERSON . '_' . DB_PERSON_EMAIL);
$this->db->select('*');
$this->db->from(DB_TABLE_PERSON);
$this->db->where(DB_PERSON_EMAIL,$username);
$query = $this->db->get();
$FullName = "";
if ($query->num_rows() == 1) {
	$person_row = $query->row(); 
	$FullName = $person_row->FirstName . " " . $person_row->LastName;
} else {
	echo "USER NOT FOUND!";
}
 ?>

<div id="container" class="ui-corner-all">
	<table border="0" cellpadding="6">
	<tr height="100%">
	<td style="vertical-align:top; width:400px">
	<h2 style="font-weight:normal; margin-top:0px">
	<?php 
	echo $event_row->Name . " (" . $event_row->StartDate . ")";
	?>
	</h2>
	<?php 
	if ($event_row->Price != 0)
	echo "Pris " . $event_row->Price . " €.";
	echo "Anmälning senast " . $event_row->RegistrationDueDate . ".<br /><br />";

	echo $event_row->Description;
	echo '<table border="0" cellpadding="6">';
	?>
	

				



<br /><b>Anm&auml;lda: 

<?php 
if (isset($guestList)){
        echo count($guestList); 
} else echo "0";
?></b>
<?php 
/*
if (isset($showGuestType)){

        $result = mysql_query('SELECT COUNT(Name) FROM `Signup` WHERE  (`EventId` = ' . $eventId .  ' AND `GuestType` = 1 AND `Hidden` =  0)');
        if (!$result) {
                echo 'Could not run query: ' . mysql_error();
                exit;
        }
        $row = mysql_fetch_row($result);
        echo " (" . $row[0];
        echo ' Akademare / ';

        $result = mysql_query('SELECT COUNT(Name) FROM `Signup` WHERE  (`EventId` = ' . $eventId .  ' AND `GuestType` = 2 AND `Hidden` =  0)');
        if (!$result) {
                echo 'Could not run query: ' . mysql_error();
                exit;
        }
        $row = mysql_fetch_row($result);
        echo $row[0];   
        echo ' Lyror / ';
        
        $result = mysql_query('SELECT COUNT(Name) FROM `Signup` WHERE  (`EventId` = ' . $eventId .  ' AND `GuestType` > 2 AND `Hidden` =  0)');
        if (!$result) {
                echo 'Could not run query: ' . mysql_error();
                exit;
        }
        $row = mysql_fetch_row($result);
        echo $row[0];   
        echo ' övriga gäster)<br />';
}
if ($showVoice > 0){
        echo 'Stämfördelning: ';
        foreach ($voices as $k => $v) {
                $result = mysql_query('SELECT COUNT(Name) FROM `Signup` WHERE  (`EventId` = ' . $eventId .  ' AND `Voice` = "' . $v . '" AND `Hidden` =  0)');
                if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                }
                $row = mysql_fetch_row($result);
                if ($k > 0)
                        echo " / ";
                echo $v . ": " . $row[0];

        }
}
*/

echo '<br /><table style="table-layout: fixed; width: 400px"><tr><td style="width:200px">';
echo '<table style="table-layout: fixed; width:200px">';

        $n = 1;
        if (isset($guestList)){
                foreach ($guestList as $k => $v) {
                        echo '<tr><td class="cutoff"><font style="color:#999999; font-size:11px">' . $n . '</font><font style="font-size:14px">&nbsp;&nbsp;' . $v . '</font></td></tr>';
                        $n++;
                        if ($n == round(count($guestList) / 2 + 1) && count($guestList) > 20)
                                echo '</table></td><td style="width:200px"><table style="table-layout: fixed; width:200px">';
                        
                }
        }
echo '</td></tr></table>';
echo '</td></tr></table>';


echo '<br /><FORM ACTION="signup.php?eventId=' . $eventId . '" METHOD="post" name="remove_signup">';
echo '<INPUT type="text" name="remove_name" size="20">';
echo '<input type="submit" value="Radera namn" class="button"/></form>';
//echo '<br /><font style="color:#f36d00; font-size: 14px">' . $remove_message . '</font>';
?>

</div>
