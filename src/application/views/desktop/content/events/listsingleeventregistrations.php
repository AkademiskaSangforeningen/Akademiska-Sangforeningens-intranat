<?php if (isset($part_eventInfo)) { echo $part_eventInfo; } ?>
<div class="tools">
	<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
		<a href="<?php echo site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID} ?>?<?php echo HTTP_DIALOG; ?>=1" class="button" data-icon="ui-icon-calendar" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_EVENT_REGISTRATION); ?></a>
	<?php } ?>
	<a href="<?php echo site_url() . CONTROLLER_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS . '/' . $eventId . '/?' . HTTP_SHOWASCSV . '=true'; ?>" class="button" data-icon="ui-icon-document">Exportera som CSV-fil</a>
	
</div>
<div class="pagination">
	<?php echo $pagination; ?>
</div>
<table>
	<colgroup>
		<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<col style="width: 27px" />
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::EVENTS_DELETE_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<col style="width: 27px" />
		<?php } ?>
		<col style="width: 27px" />
		<col /> <!-- Name and allergies -->
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
		<?php foreach($eventItems as $key => $eventItem) { ?>
			<col /> <!-- <?php echo $eventItem->{DB_EVENTITEM_CAPTION}; ?>	-->
		<?php } ?>
	</colgroup>

	<thead>
		<tr>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_MEMBER); ?>"></span></th>
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_DELETE_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>				
				<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_MEMBER); ?>"></span></th>		
			<?php } ?>
			<th><span class="ui-icon ui-icon-mail-closed"></span></th>		
			<th><?php echo lang(LANG_KEY_FIELD_NAME); ?><?php if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) { echo ' & ' . lang(LANG_KEY_FIELD_ALLERGIES); } ?></th>
			<th>Anmäld</th>
			<th>1T</th>
			<th>2T</th>
			<th>1B</th>
			<th>2B</th>
			<th>Totalt</th>
			<th><?php echo lang(LANG_KEY_FIELD_PAYMENTTYPE); ?></th>
			<?php
				foreach($eventItems as $key => $eventItem) {
					echo "<th>";
					switch ($eventItem->{DB_EVENTITEM_TYPE}) {
							case EVENT_TYPE_RADIO:
							case EVENT_TYPE_CHECKBOX:					
								echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
								if ($eventItem->{DB_EVENTITEM_AMOUNT} != 0) {
									echo ' (' . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . ')';
								}
								break;
							case EVENT_TYPE_TEXTAREA:
								echo $eventItem->{DB_EVENTITEM_CAPTION};
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
			<td colspan="5">Totalt:</td>
			<td><?php echo $voiceSums[ENUM_VOICE_1T]; ?></td>
			<td><?php echo $voiceSums[ENUM_VOICE_2T]; ?></td>
			<td><?php echo $voiceSums[ENUM_VOICE_1B]; ?></td>
			<td><?php echo $voiceSums[ENUM_VOICE_2B]; ?></td>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<td></td>
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_DELETE_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>				
				<td></td>
			<?php } ?>			
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
				if ($this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) {
					echo '<td><a href="' . site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID} . '/' . $person->{DB_PERSON_ID} . '/' . md5($event->{DB_EVENT_ID} . $this->config->item('encryption_key') . $person->{DB_PERSON_ID}) .'?' . HTTP_DIALOG . '=1" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true">' . lang(LANG_KEY_BUTTON_EDIT_EVENT_REGISTRATION) . '</a></td>';
				}
				if ($this->userrights->hasRight(userrights::EVENTS_DELETE_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) {
					echo '<td><a href="' . site_url() . CONTROLLER_SAVE_CANCEL_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID} . '/' . $person->{DB_PERSON_ID} . '/' . md5($event->{DB_EVENT_ID} . $this->config->item('encryption_key') . $person->{DB_PERSON_ID}) .'?' . HTTP_DIALOG . '=1" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true">' . lang(LANG_KEY_BUTTON_DELETE_EVENT_REGISTRATION) . '</a></td>';
				}
				echo '<td><a href="mailto:' . $person->{DB_PERSON_EMAIL} . '" class="button" data-icon="ui-icon-mail-closed" data-text="false">' . $person->{DB_PERSON_EMAIL} . '</a></td>';				
				echo '<td><span class="bold" style="white-space: nowrap">' . $person->{DB_PERSON_LASTNAME} . ', ' . $person->{DB_PERSON_FIRSTNAME} . '</span>';
				if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) {
					echo '<br/><i>' . $person->{DB_PERSON_ALLERGIES} . '</i>';
				}
				echo '</td>';
				echo '<td>' . formatDateGerman($person->{DB_PERSONHASEVENT_CREATED}) . '</td>';
				echo '<td>' . ($person->{DB_PERSON_VOICE} == ENUM_VOICE_1T ? '<input type="checkbox" checked="checked" disabled="disabled"/>' : '') . '</td>';
				echo '<td>' . ($person->{DB_PERSON_VOICE} == ENUM_VOICE_2T ? '<input type="checkbox" checked="checked" disabled="disabled"/>' : '') . '</td>';
				echo '<td>' . ($person->{DB_PERSON_VOICE} == ENUM_VOICE_1B ? '<input type="checkbox" checked="checked" disabled="disabled"/>' : '') . '</td>';
				echo '<td>' . ($person->{DB_PERSON_VOICE} == ENUM_VOICE_2B ? '<input type="checkbox" checked="checked" disabled="disabled"/>' : '') . '</td>';
				echo '<td class="bold">' . formatCurrency($person->{DB_TOTALSUM} + $person->{DB_CUSTOM_AVEC . DB_TOTALSUM}) . '</td>';
				echo '<td>' . getEnumValue(ENUM_PAYMENTTYPE, $person->{DB_PERSONHASEVENT_PAYMENTTYPE}) . '</td>';
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
					echo "<td>Avec:</td>";
					if ($this->userrights->hasRight(userrights::EVENTS_EDIT_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) {
						echo '<td></td>';
					}
					if ($this->userrights->hasRight(userrights::EVENTS_DELETE_REGISTRATION, $this->session->userdata(SESSION_ACCESSRIGHT))) {
						echo '<td></td>';
					}					
					echo '<td><span class="bold" style="white-space: nowrap">' . $person->{DB_CUSTOM_AVEC . DB_PERSON_LASTNAME} . ', ' . $person->{DB_CUSTOM_AVEC . DB_PERSON_FIRSTNAME} . '</span>';
					if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) {
						echo '<br/><i>' . $person->{DB_CUSTOM_AVEC . DB_PERSON_ALLERGIES} . '</i>';
					}
					echo '</td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td>(' . formatCurrency($person->{DB_CUSTOM_AVEC . DB_TOTALSUM}) . ')</td>';										
					echo '<td></td>';					
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