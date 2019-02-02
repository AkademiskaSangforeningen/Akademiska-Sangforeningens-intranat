<table>
	<thead>
		<tr>
			<th><?php echo lang(LANG_KEY_FIELD_EVENT); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_LOCATION); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ENROLLED); ?></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tfoot>

	</tfoot>
	<tbody>
	<?php foreach($eventList as $event) { ?>
		<tr>
			<td><?php echo $event->{DB_EVENT_NAME}; ?></td>	
			<td>
			<?php 
			echo formatDateGerman($event->{DB_EVENT_STARTDATE}); 
			if (isset($event->{DB_EVENT_ENDDATE}))	{
				echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
			}
			?></td>
			<td><?php echo $event->{DB_EVENT_LOCATION}; ?></td>		
			<td>
				<?php
				if ($event->{DB_EVENT_CANUSERSVIEWREGISTRATIONS} == FALSE) {
					echo '-';
				} else {
					echo '<a href="' . site_url() . CONTROLLER_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS . '/' . $event->{DB_EVENT_ID} . '" class="button" data-icon="ui-icon-person" data-listdialog="true">' .  $event->{DB_TOTALCOUNT} . '</a></td>';
				}
				?>
			</td>			
			<td>
				<?php 
					if (!isDateInPast($event->{DB_EVENT_REGISTRATIONDUEDATE}, TRUE)) { 
						if (isset($event->{DB_PERSONHASEVENT_PERSONID}) && $event->{DB_PERSONHASEVENT_PERSONID} != NULL) {
				?>
						<a href="<?php echo site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID} . '/' . $event->{DB_PERSONHASEVENT_PERSONID} . '/' . md5($event->{DB_EVENT_ID} . $this->config->item('encryption_key') . $event->{DB_PERSONHASEVENT_PERSONID} . 1); ?>/1?<?php echo HTTP_DIALOG; ?>=1" class="button" data-formdialog="true">Uppdatera din anmälan</a>
				<?php
						} else {
				?>
						<a href="<?php echo site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID} . '/' . $personId . '/' . md5($event->{DB_EVENT_ID} . $this->config->item('encryption_key') . $personId . 1); ?>/1?<?php echo HTTP_DIALOG; ?>=1" class="button" data-formdialog="true">Anmäl dig</a>
				<?php
						}
					} else {
				?>
						För sent att anmäla sig eller ändra sin anmälan.
				<?php
					}
				?>
			</td>
			<td>
				<?php if (isset($event->{DB_PERSONHASEVENT_PERSONID}) && !isDateInPast($event->{DB_EVENT_REGISTRATIONDUEDATE}, TRUE)) { ?>			
					<a href="<?php echo site_url() . CONTROLLER_SAVE_CANCEL_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID} . '/' . $event->{DB_PERSONHASEVENT_PERSONID} . '/' . md5($event->{DB_EVENT_ID} . $this->config->item('encryption_key') . $event->{DB_PERSONHASEVENT_PERSONID}); ?>?<?php echo HTTP_DIALOG; ?>=1" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_EVENT_REGISTRATION); ?></a>
				<?php } ?>			
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>	

