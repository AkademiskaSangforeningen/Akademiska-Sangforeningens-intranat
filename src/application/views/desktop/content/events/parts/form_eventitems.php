<div style="clear: both; width: auto">				
<?php
	$previousCaption = "";
	if (isset($eventItems)) {		
		foreach($eventItems as $key => $eventItem) {

			if ($currentIsAvec === TRUE && $eventItem->{DB_EVENTITEM_SHOWFORAVEC} == FALSE) {
				continue;
			} else if ($currentIsAvec === FALSE && $eventItem->{DB_EVENTITEM_SHOWFORAVEC} == 2) {
				continue;
			}

			// If event items should be duplicated for avecs, hide them with a special id
			if ($currentIsAvec === TRUE && $eventItem->{DB_EVENTITEM_SHOWFORAVEC} == ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE) { ?>
					<div style="display: none">
						<?php if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) { ?>
							<?php if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_RADIO) { ?>
								<!-- radio -->
								<input type="radio" id="hidden_<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_radio($fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL && !$internalRegistration ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> <?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? 'data-price="' . $eventItem->{DB_EVENTITEM_AMOUNT} . '"' : ''); ?> />
							<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_CHECKBOX) { ?>
								<!-- checkbox -->
								<input type="checkbox" id="hidden_<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_checkbox($fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> <?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? 'data-price="' . $eventItem->{DB_EVENTITEM_AMOUNT} . '"' : ''); ?> />
							<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) { ?>															
								<textarea id="hidden_<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>" name="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>"><?php echo set_value($fieldPrefix . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION}); ?></textarea>
								<input type="hidden" id="hidden_<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
							<?php } ?>
						<?php } else { ?>
							<select id="hidden_<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" name="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" <?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? 'data-price="' . $eventItem->{DB_EVENTITEM_AMOUNT} . '"' : ''); ?>>
								<?php for($i = 0; $i <= ($eventItem->{DB_EVENTITEM_MAXPCS}); $i++) { ?>
									<option value="<?php echo $i; ?>" <?php echo set_select($fieldPrefix . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, $i, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} == $i); ?>><?php echo $i; ?> st.</option>
								<?php } ?>
							</select>
							<input type="hidden" id="hidden_<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
						<?php } ?>				
					</div>
				<?php } else { ?>						
					<?php if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) { ?>
						<div style="margin-top: 1em"><label>
							<?php echo $eventItem->{DB_EVENTITEM_CAPTION}; ?>
							<?php if (strlen($eventItem->{DB_EVENTITEM_DESCRIPTION}) > 0 && $eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) { ?>
								(<i><?php echo $eventItem->{DB_EVENTITEM_DESCRIPTION}; ?></i>)
							<?php } ?>
						</label></div>
					<?php } ?>				
					<div>
					<?php if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) { ?>
						<?php if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_RADIO) { ?>
							<!-- radio -->
							<input type="radio" id="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" class="required" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_radio($fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL && !$internalRegistration ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> <?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? 'data-price="' . $eventItem->{DB_EVENTITEM_AMOUNT} . '"' : ''); ?> <?php if ($eventItem->{DB_EVENTITEM_SHOWFORAVEC} == ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE) { echo 'data-trigger-avec="true"'; } ?> />
						<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_CHECKBOX) { ?>
							<!-- checkbox -->
							<input type="checkbox" id="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_checkbox($fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> <?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? 'data-price="' . $eventItem->{DB_EVENTITEM_AMOUNT} . '"' : ''); ?> <?php if ($eventItem->{DB_EVENTITEM_SHOWFORAVEC} == ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE) { echo 'data-trigger-avec="true"'; } ?> />
						<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) { ?>															
							<textarea id="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>" name="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>" class="ui-corner-all" <?php if ($eventItem->{DB_EVENTITEM_SHOWFORAVEC} == ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE) { echo 'data-trigger-avec="true"'; } ?>><?php echo set_value($fieldPrefix . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION}); ?></textarea>
							<input type="hidden" id="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
							<br />
						<?php } ?>																	
						<?php if (strlen($eventItem->{DB_EVENTITEM_DESCRIPTION}) > 0 && $eventItem->{DB_EVENTITEM_TYPE} != EVENT_TYPE_TEXTAREA) { ?>
							<?php echo ' - ' .$eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
						<?php } ?>
						<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
							 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?>						
						<?php } ?>																															
					<?php } else { ?>
						<select id="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" name="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" class="short" <?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? 'data-price="' . $eventItem->{DB_EVENTITEM_AMOUNT} . '"' : ''); ?> <?php if ($eventItem->{DB_EVENTITEM_SHOWFORAVEC} == ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE) { echo 'data-trigger-avec="true"'; } ?>>
							<?php for($i = 0; $i <= ($eventItem->{DB_EVENTITEM_MAXPCS}); $i++) { ?>
								<option value="<?php echo $i; ?>" <?php echo set_select($fieldPrefix . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, $i, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} == $i); ?>><?php echo $i; ?> st.</option>
							<?php } ?>
						</select>
						<input type="hidden" id="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php if ($eventItem->{DB_EVENTITEM_SHOWFORAVEC} == ENUM_SHOW_FOR_AVECS_NO_BUT_INCLUDE_PRICE) { echo 'data-trigger-avec="true"'; } ?> /> 
						<?php echo $eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
						<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
							 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?> per styck
						<?php } ?>
					<?php } ?>
					</div>										
				<?php } ?>			
<?php
			$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
		}
	}
?>			
</div>