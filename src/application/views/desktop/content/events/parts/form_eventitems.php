<div style="clear: both; width: auto">				
<?php
	$previousCaption = "";
	if (isset($eventItems)) {		
		foreach($eventItems as $key => $eventItem) {

			if ($currentIsAvec === TRUE && $eventItem->{DB_EVENTITEM_SHOWFORAVEC} == FALSE) {
				continue;
			}		
?>
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
						<input type="radio" class="required" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_radio($fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL && !$internalRegistration ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> data-price="<?php echo (!is_null($eventItem->{DB_EVENTITEM_AMOUNT}) ? $eventItem->{DB_EVENTITEM_AMOUNT} : 0); ?>" />
					<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_CHECKBOX) { ?>
						<!-- checkbox -->
						<input type="checkbox" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_checkbox($fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
					<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) { ?>															
						<textarea name="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>" class="ui-corner-all"><?php echo set_value($fieldPrefix . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION}); ?></textarea>
						<input type="hidden" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
						<br />
					<?php } ?>																	
					<?php if (strlen($eventItem->{DB_EVENTITEM_DESCRIPTION}) > 0 && $eventItem->{DB_EVENTITEM_TYPE} != EVENT_TYPE_TEXTAREA) { ?>
						<?php echo ' - ' .$eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
					<?php } ?>
					<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
						 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?>						
					<?php } ?>																															
				<?php } else { ?>
					<select name="<?php echo $fieldPrefix . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" class="short" data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>">
						<?php for($i = 0; $i <= ($eventItem->{DB_EVENTITEM_MAXPCS}); $i++) { ?>
							<option value="<?php echo $i; ?>" <?php echo set_select($fieldPrefix . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, $i, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} == $i); ?>><?php echo $i; ?> st.</option>
						<?php } ?>
					</select>
					<input type="hidden" name="<?php echo $fieldPrefix . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
					<?php echo $eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
					<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
						 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?> per styck
					<?php } ?>
				<?php } ?>									
			</div>					
<?php
			$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
		}
	}
?>			
</div>