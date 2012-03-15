<div id="container" class="ui-corner-all">
	
	<h1><?php //echo $this->lang->line(LANG_KEY_EVENTSIGNUP_HEADER); ?></h1>
		
		<?php //echo form_open(CONTROLLER_EVENTSIGNUP_SIGNUP, array('id' => 'form_login')); ?>
			
			
			<?php // Name field pre-filled and locked if user is logged in? ?>
			<label for="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>"><?php echo $this->lang->line(LANG_KEY_FIELD_NAME); ?>:</label>
			<input type="name" size="20" id="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>" name="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>" class="required ui-corner-all" />
			<br/>
			
	
			<input type="submit" value="<?php echo lang("signup_submit"); ?>" id="form_eventsignup_submit_button" class="ui-corner-all" />
	</form>
</div>

<div id="container" class="ui-corner-all">

<?php
// Event id for testing
$EventId = "'64267e8e-6eae-11e1-91de-00241d8659f1'";
$query = $this->db->query("SELECT * FROM event WHERE Id = " . $EventId);
if($query->num_rows() > 0)
{
	$row = $query->row(); 
	echo $row->Id;
	echo '<br>';
	echo $row->Name;
	echo '<br>';
	echo $row->StartDate;
	echo '<br>';
}


// Get the list of Guests for the current event.
		/*$guests = mysql_query("SELECT * FROM personhasevent WHERE (EventId = " . $EventId .  ") ORDER BY EventId ASC");

		while($row = mysql_fetch_array($guests)) {
			$i = $row['Id'];
			$n = $row['Name'];
			$guestList[$i] = $n; 
		}
		*/
		$n = 0;
		$query = $this->db->query("SELECT * FROM personhasevent WHERE (EventId = " . $EventId .  ")");
		foreach($query->result_array() as $row)
		{
			$i = $row['PersonId'];
			$person_query = $this->db->query("SELECT * FROM person WHERE Id = '" . $i . "'");
			$person_row = $person_query->row(); 
			$n = $person_row->FirstName . " " . $person_row->LastName;
			$guestList[$i] = $n; 
		}
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


echo '<br /><FORM ACTION="signup.php?eventId=' . $EventId . '" METHOD="post" name="remove_signup">';
echo '<INPUT type="text" name="remove_name" size="20">';
echo '<input type="submit" value="Radera namn" class="button"/></form>';
//echo '<br /><font style="color:#f36d00; font-size: 14px">' . $remove_message . '</font>';
?>

</div>
