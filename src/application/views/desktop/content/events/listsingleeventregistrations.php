<div>	
	<div class="registerdirectly-header">
		<h1><?php echo $event->{DB_EVENT_NAME}; ?></h1>
	</div>
	<div class="registerdirectly-info">					
		Datum:
		<b>
		<?php 
			echo formatDateGerman($event->{DB_EVENT_STARTDATE}); 
			if (isset($event->{DB_EVENT_ENDDATE}))	{
				echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
			}
			?>
		</b>
		<br/>
		Plats:
		<b><?php echo $event->{DB_EVENT_LOCATION}; ?></b>		
		<br/>
		<div style="max-width: 900px">
			<?php echo $event->{DB_EVENT_DESCRIPTION}; ?>
		</div>
	</div>	
	<!--
	<div class="registerdirectly-map">
		<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode(str_replace(',', ' ', $event->{DB_EVENT_LOCATION})); ?>&zoom=14&size=250x250&sensor=false&markers=mid%7<?php echo urlencode(str_replace(',', ' ', $event->{DB_EVENT_LOCATION})); ?>" />
	</div>
	-->
</div>
<div class="tools">
<a href="<?php echo CONTROLLER_EVENTS_EDITSINGLE ?>" class="button" data-icon="ui-icon-calendar" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_EVENT); ?></a>
</div>
<div class="pagination">
	<?php echo $pagination; ?>
</div>
<table>
	<colgroup>
		<col style="width: 25px" />
		<col style="width: 25px" />
		<col /> <!-- Name -->
		<col /> <!-- Allergies -->
		<?php foreach($eventItems as $key => $eventItem) { ?>
			<col /> <!-- <?php echo $eventItem->{DB_EVENTITEM_CAPTION}; ?>	-->
		<?php } ?>
	</colgroup>

	<thead>
		<tr>
			<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_MEMBER); ?>"></span></th>
			<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_MEMBER); ?>"></span></th>		
			<th><?php echo lang(LANG_KEY_FIELD_NAME); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?></th>			
			<?php
				foreach($eventItems as $key => $eventItem) {
					echo "<th>";
					switch ($eventItem->{DB_EVENTITEM_TYPE}) {
							case EVENT_TYPE_RADIO:
							case EVENT_TYPE_CHECKBOX:					
								echo $eventItem->{DB_EVENTITEM_DESCRIPTION} . '<br/>pris: ' . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
								break;
							case EVENT_TYPE_TEXTAREA:
								if ($eventItem->{DB_EVENTITEM_DESCRIPTION} == '') {
									echo $eventItem->{DB_EVENTITEM_CAPTION};
								} else {
									echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
								}
								break;
							default:
								break;
					}
					echo "</th>";
				}
			?>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="2">Totalt:</td>
			<td></td>
			<td></td>
			<?php
				foreach($eventItems as $key => $eventItem) {
					if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
						echo '<td style="text-align: center">';						
					} else {
						echo "<td>";
					}
					switch ($eventItem->{DB_EVENTITEM_TYPE}) {
							case EVENT_TYPE_RADIO:
							case EVENT_TYPE_CHECKBOX:
								if (isset($eventItemSums[$eventItem->{DB_EVENTITEM_ID}])) {
									echo $eventItemSums[$eventItem->{DB_EVENTITEM_ID}] . ' st.';
								}
								break;
							case EVENT_TYPE_TEXTAREA:
								break;
							default:
								break;
					}
					echo "</td>";
				}
			?>		
		</tr>
	</tfoot>
	<tbody>		
		<?php
			$previousPersonId = NULL;
			foreach($persons as $key => $person) {
				echo "<tr>";
				echo '<td><a href="' . site_url() . CONTROLLER_EVENTS_EDITSINGLE . '/' . $event->{DB_EVENT_ID} . '" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true">' . lang(LANG_KEY_BUTTON_EDIT_EVENT) . '</a></td>';
				echo '<td><a href="' . site_url() . CONTROLLER_EVENTS_DELETESINGLE . '/' . $event->{DB_EVENT_ID} . '" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true">' . lang(LANG_KEY_BUTTON_DELETE_EVENT) . '</a></td>';
				echo "<td>" . $person->{DB_PERSON_FIRSTNAME} . " " . $person->{DB_PERSON_LASTNAME} . "</td>";
				echo "<td>" . $person->{DB_PERSON_ALLERGIES} . "</td>";
				foreach($eventItems as $key => $eventItem) {					
					if (isset($personHasEventItems[$person->{DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}])) {
						if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {								
							switch ($eventItem->{DB_EVENTITEM_TYPE}) {
								case EVENT_TYPE_RADIO:
								case EVENT_TYPE_CHECKBOX:
									echo '<td style="text-align: center;"><input type="checkbox" checked="checked" disabled="disabled"/></td>';
									break;
								case EVENT_TYPE_TEXTAREA:
									echo "<td>";
									echo $personHasEventItems[$person->{DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_DESCRIPTION];	
									echo "</td>";
									break;
								default:
									break;
							}							
						} else {
							echo "<td>";
							echo $personHasEventItems[$person->{DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_AMOUNT] . " st.";	
							echo "</td>";
						}																												
					} else {						
						echo "<td></td>";
					}
				}												
				echo "</tr>";
				
				if ($event->{DB_EVENT_AVECALLOWED} == TRUE && $person->{DB_CUSTOM_AVEC . DB_PERSON_ID} != NULL) {
					echo "<tr>";
					echo "<td colspan=\"2\">Avec:</td>";
					echo "<td>" . $person->{DB_CUSTOM_AVEC . DB_PERSON_FIRSTNAME} . " " . $person->{DB_CUSTOM_AVEC . DB_PERSON_LASTNAME} . "</td>";
					echo "<td>" . $person->{DB_CUSTOM_AVEC . DB_PERSON_ALLERGIES} . "</td>";
					foreach($eventItems as $key => $eventItem) {					
						if (isset($personHasEventItems[$person->{DB_CUSTOM_AVEC . DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}])) {
							if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {								
								switch ($eventItem->{DB_EVENTITEM_TYPE}) {
									case EVENT_TYPE_RADIO:
									case EVENT_TYPE_CHECKBOX:
										echo '<td style="text-align: center;"><input type="checkbox" checked="checked" disabled="disabled"/></td>';
										break;
									case EVENT_TYPE_TEXTAREA:
										echo "<td>";
										echo $personHasEventItems[$person->{DB_CUSTOM_AVEC . DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_DESCRIPTION];	
										echo "</td>";
										break;
									default:
										break;
								}							
							} else {
								echo "<td>";
								echo $personHasEventItems[$person->{DB_CUSTOM_AVEC . DB_PERSON_ID}][$eventItem->{DB_EVENTITEM_ID}][DB_PERSONHASEVENTITEM_AMOUNT] . " st.";	
								echo "</td>";
							}																												
						} else {
							echo "<td></td>";
						}
					}												
					echo "</tr>";					
				}				
			} 
		?>	
	</tbody>
</table>

<script>
	$('#dialog_list')
		.find('.pagination a')
			.bind('click', function() {		
				$('#dialog_list').load($(this).attr('href'), function() {				
					AKADEMEN.initializeButtons();
				});
				return false;
			});
</script>

