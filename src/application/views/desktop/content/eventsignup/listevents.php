
	<table>
		<thead>
			<tr>
				<th><?php echo "Evenemang" ?></th>
				<th><?php echo "Tidpunkt" ?></th>
				<th><?php echo "Anm&auml;lnings- / Betalnings-DL" ?></th>
				<th><?php echo "Pris" ?></th>
				<th><?php echo "Plats" ?></th>
				<th><?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></th>
				<th>Debug</th>
			</tr>
		</thead>
		<tfoot>

		</tfoot>
		<tbody>
		<?php foreach($futureEventList as $key => $event): ?>
			<tr>
				<td><a href="<?php echo BASE_URL() . CONTROLLER_EVENTSIGNUP_SIGNUP . "/" . $event->{DB_EVENT_ID} ?>" class="button" data-icon="ui-icon-document" data-text="true" data-dialog="true"><?php echo $event->{DB_EVENT_NAME} ?></a></td>	
				<td>
				<?php 
				echo formatDateGerman($event->{DB_EVENT_STARTDATE}); 
				if (isset($event->{DB_EVENT_ENDDATE}))	{
					echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
				}
				?></td>
				<td><?php echo formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE});
				if (isset($event->{DB_EVENT_PAYMENTDUEDATE}))	{
					echo " / " .  formatDateGerman($event->{DB_EVENT_PAYMENTDUEDATE}); 	
				} 
				?></td>
				<td class="alignright"><?php echo formatCurrency($event->{DB_EVENT_PRICE}) ?></td>
				<td><?php echo $event->{DB_EVENT_LOCATION} ?></td>		
				<td><?php echo $event->{DB_EVENT_DESCRIPTION} ?></td>		
				<td><a href="<?php echo BASE_URL() . CONTROLLER_EVENTSIGNUP_SIGNUP . "/" . $event->{DB_EVENT_ID} ?>"><?php echo $event->{DB_EVENT_NAME} ?></a></td>	
				<td>
				
			</tr>
		<?php endforeach; ?>		
		</tbody>
	</table>	

