<div class="tools">
<a href="<?php echo CONTROLLER_EVENTS_EDITSINGLE ?>" class="button" data-icon="ui-icon-calendar" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_EVENT); ?></a>
</div>

<table>
	<colgroup>
		<col style="width: 25px" />
		<col style="width: 25px" />
		<col />
		<col />
		<col />
		<col />
		<col style="text-align: right" />
		<col />
		<col />
		<col />				
	</colgroup>

	<thead>
		<tr>
			<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_MEMBER); ?>"></span></th>
			<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_MEMBER); ?>"></span></th>		
			<th><?php echo lang(LANG_KEY_FIELD_EVENT); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_PAYMENT_DUEDATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_PRICE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_LOCATION); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ENROLLED); ?></th>
		</tr>
	</thead>
	<tfoot>

	</tfoot>
	<tbody>
	<?php foreach($eventList as $key => $event): ?>
		<tr>
			<td><a href="<?php echo CONTROLLER_EVENTS_EDITSINGLE . "/" . $event->{DB_EVENT_ID}; ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_EVENT); ?></a></td>
			<td><a href="<?php echo CONTROLLER_EVENTS_DELETESINGLE . "/" . $event->{DB_EVENT_ID}; ?>" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_EVENT); ?></a></td>		
			<td><?php echo $event->{DB_EVENT_NAME}; ?></td>	
			<td>
			<?php 
			echo formatDateGerman($event->{DB_EVENT_STARTDATE}); 
			if (isset($event->{DB_EVENT_ENDDATE}))	{
				echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
			}
			?></td>
			<td><?php echo formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE}); ?></td>
			<td><?php echo formatDateGerman($event->{DB_EVENT_PAYMENTDUEDATE}); ?></td>
			<td class="alignright"><?php echo formatCurrency($event->{DB_EVENT_PRICE}); ?></td>
			<td><?php echo $event->{DB_EVENT_LOCATION}; ?></td>		
			<td><?php echo $event->{DB_EVENT_DESCRIPTION}; ?></td>		
			<td><a href="<?php echo CONTROLLER_EVENTS_LIST_ENROLLED . "/" . $event->{DB_EVENT_ID}; ?>"><?php echo $event->{DB_EVENT_NAME}; ?></a></td>	
			<td>
			
		</tr>
	<?php endforeach; ?>		
	</tbody>
</table>	

