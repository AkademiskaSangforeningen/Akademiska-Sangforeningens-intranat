<?php 
/*
* VERY MUCH UNDER CONSTRUCTION!
* -Emil
*/

?>
<label class="error">
	<?php echo validation_errors(); ?>
</label>

<?php 
//Get the event id and, TODO: event data

$eventId = "'" . $eventData->{'Id'} . "'";

$query = $this->db->query("SELECT * FROM Event WHERE Id = " . $eventId);
if($query->num_rows() > 0)
{
	$event_row = $query->row(); 

	$eventName = $event_row->Name;
	$eventDate = $event_row->StartDate;
}
?>

   
        <h2 style="font-weight:normal; margin-top:0px">Signup for <?php //echo $this->lang->line(LANG_KEY_EVENTSIGNUP_HEADER); 
		echo $eventName;
		echo " (" .  formatDateGerman($eventDate) . ")"; 	
		?></h2>
		
		<?php 
		if ($event_row->Price != 0)
		echo "Pris " . $event_row->Price . " EUR. ";
		echo "Anm&auml;lning senast " . formatDateGerman($event_row->RegistrationDueDate) . ".<br /><br />";
		echo $event_row->Description;
		echo '<br><hr/>';
		
		?>
	

                
                <?php //echo form_open(CONTROLLER_EVENTSIGNUP_SIGNUP, array('id' => 'form_login')); ?>
                        
                        
                        <?php // Name field pre-filled and locked if user is logged in? ?>
                        <label for="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>"><?php echo $this->lang->line(LANG_KEY_FIELD_NAME); ?>:</label>
                        <input type="name" size="20" id="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>" name="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_FIRSTNAME; ?>" class="required ui-corner-all" />
                        <br/>

					<?php // TODO: Make dynamic ?>

					
					<table><tr>
					<td width="400px">Betalning:<span class="requiredsymbol">*</span><br/>
					
					<input type="radio" name="paymentType" value="0" checked="yes" id="radioP_0"/> <label for="radioP_0">KK</label>
					<input type="radio" name="paymentType" value="1" checked="no" id="radioP_1"/> <label for="radioP_1">Konto</label>
					<input type="radio" name="paymentType" value="2" checked="no" id="radioP_2"/> <label for="radioP_2">Kontant</label>
					
					</td></tr></table>
			
			<input type="submit" value="<?php echo lang("signup_submit"); ?>" id="form_eventsignup_submit_button" class="ui-corner-all" />

		
		</form>




	<table style="table-layout: fixed; width: 500px"><tr><td style="width:200px">
	<table style="table-layout: fixed; width: 250px">
		
		<thead>
			<tr>
				<th>Anm&auml;lda: 
					<?php 
					if (isset($guestList)){
							echo count($guestList); 
					} else echo "0";
					?>
				</th>
			</tr>
		</thead>
		<tfoot>

		</tfoot>
		<tbody>
		<?php $n = 1;
		foreach($guestList as $key => $glist): ?>
			<tr>
				<td class="cutoff"><font style="color:#999999; font-size:11px"><?php echo $n ?></font><font style="font-size:14px">&nbsp;&nbsp;<?php echo $glist->{DB_PERSON_FIRSTNAME} . " " . $glist->{DB_PERSON_LASTNAME}; echo " (" . $glist->{DB_PERSON_VOICE} . ")"; ?></font></td>		
			</tr>
			<?php 
				$n++;
				if ($n == round(count($guestList) / 2 + 1) && count($guestList) > 20){
                 echo '</table></td><td style="width:200px"><table style="table-layout: fixed; width:200px"><thead><tr><th>Namn</th><th>St&auml;mma</th></tr></thead><tfoot></tfoot><tbody>';
				}?>
				
			
		<?php endforeach; ?>		
		</tbody>
	
	</table>
	</td></tr></table>

<?php

/*
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

*/
 ?>

 
<?php 
/*
// VISA GÄSTTYP
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

// VISA STÄMFÖRDELNING
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

/*
// REMOVE SIGNUP
echo '<br /><FORM ACTION="signup.php?eventId=' . $eventId . '" METHOD="post" name="remove_signup">';
echo '<INPUT type="text" name="remove_name" size="20">';
echo '<input type="submit" value="Radera namn" class="button"/></form>';
//echo '<br /><font style="color:#f36d00; font-size: 14px">' . $remove_message . '</font>';

*/

		echo "<br/>Id for debug: " . $event_row->Id . "<br/>";
?>
