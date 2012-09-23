<table>
	<thead>
		<tr>
			<th><?php echo lang(LANG_KEY_FIELD_EVENT); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_LOCATION); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ENROLLED); ?></th>
			<th></th>
		</tr>
	</thead>
	<tfoot>

	</tfoot>
	<tbody>
	<?php foreach($eventList as $key => $event): ?>
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
			<td><a href="<?php echo CONTROLLER_EVENTS_LIST_ENROLLED . "/" . $event->{DB_EVENT_ID}; ?>"><?php echo $event->{'Enrolled'}; ?></a></td>				
			<td><a href="<?php echo CONTROLLER_EVENTS_EDITSINGLE . "/" . $event->{DB_EVENT_ID}; ?>" class="button" data-formdialog="true">Anmäl mig</a></td>
		</tr>
	<?php endforeach; ?>		
	</tbody>
</table>	

