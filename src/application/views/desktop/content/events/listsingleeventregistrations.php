<?php if (isset($part_eventInfo)) { echo $part_eventInfo; } ?>
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
				echo '<td><a href="' . site_url() . CONTROLLER_EVENTS_EDIT_REGISTER . '/' . $event->{DB_EVENT_ID} . '/' . $person->{DB_PERSON_ID} . '/' . md5($event->{DB_EVENT_ID} . $this->config->item('encryption_key') . $person->{DB_PERSON_ID}) .'" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true">' . lang(LANG_KEY_BUTTON_EDIT_EVENT_REGISTRATION) . '</a></td>';
				echo '<td><a href="' . site_url() . CONTROLLER_EVENTS_DELETESINGLE . '/' . $event->{DB_EVENT_ID} . '" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true">' . lang(LANG_KEY_BUTTON_DELETE_EVENT_REGISTRATION) . '</a></td>';
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
		.bind('updateList', function() {
			$(this).load($(this).data("url"), function() {
				AKADEMEN.initializeButtons();
			});
		})	
		.find('.pagination a')
			.bind('click', function() {		
				$('#dialog_list')
					.data("url", $(this).attr('href'))
					.trigger('updateList');
				return false;
			});
</script>