<div>	
	<?php if (isset($part_info_event)) { echo $part_info_event; } ?>
	<div style="clear: both">
	<label class="error" style="font-size: 1em">
		<?php echo validation_errors(); ?>
	</label>
		<p>
			<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
		</p>	
	</div>
	<?php echo form_open(CONTROLLER_EVENTS_SAVE_REGISTER_DIRECTLY . (isset($eventId) ? "/" . $eventId : "") . (isset($personId) ? "/" . $personId : "") . (isset($hash) ? "/" . $hash : ""), array('id' => 'form_editobject')); ?>
		<fieldset class="ui-corner-all">
			<legend>Mina anmälningsuppgifter</legend>
			
			<?php if (isset($part_form_person)) { echo $part_form_person; } ?>				
			
			<?php if (isset($part_form_payment)) { echo $part_form_payment; } ?>				 
			
			<?php if (isset($part_form_eventitems)) { echo $part_form_eventitems; } ?>

			<?php if (isset($part_form_avecallowed)) { echo $part_form_avecallowed; } ?>			

		</fieldset>
		<?php if ($event->{DB_EVENT_AVECALLOWED} == 1) { ?>
			<fieldset style="<?php if (isset($personhasevent->{DB_PERSONHASEVENT_AVECPERSONID}) && !is_null($personhasevent->{DB_PERSONHASEVENT_AVECPERSONID})) { echo ""; } ?>" id="registeravec">							
				<legend>Min avecs anmälningsuppgifter</legend>						
			
				<?php if (isset($part_form_personAvec)) { echo $part_form_personAvec; } ?>								
				
				<?php if (isset($part_form_eventitemsAvec)) { echo $part_form_eventitemsAvec; } ?>

				<div style="clear: both; width: auto">
					<?php
						$previousCaption = "";
						if (isset($avecEventItems)) {		
							foreach($avecEventItems as $key => $eventItem) {
					
								if ($eventItem->{DB_EVENTITEM_SHOWFORAVEC} == FALSE) {
									continue;
								}
					?>
							<?php if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) { ?>
								<div style="margin-top: 1em"><label><?php echo $eventItem->{DB_EVENTITEM_CAPTION}; ?></label></div>
							<?php } ?>
							<div> 
								<?php if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) { ?>
									<?php if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_RADIO) { ?>
										<!-- radio -->
										<input type="radio" class="required" name="<?php echo DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_radio(DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
									<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_CHECKBOX) { ?>
										<!-- checkbox -->
										<input type="checkbox" name="<?php echo DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_checkbox(DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, (isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : ($personId != NULL ? FALSE : $eventItem->{DB_EVENTITEM_PRESELECTED}))); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
									<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) { ?>									
										<textarea name="<?php echo DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>" class="ui-corner-all"><?php echo set_value(DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION}); ?></textarea>
										<input type="hidden" name="<?php echo DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
									<?php } ?>																	
									<?php if (strlen($eventItem->{DB_EVENTITEM_DESCRIPTION}) > 0 ) { ?> - <?php } ?>
									<?php echo $eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
									<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
										 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?>						
									<?php } ?>																															
								<?php } else { ?>
									<select name="<?php echo DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" class="short" data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>">
										<?php for($i = 0; $i <= ($eventItem->{DB_EVENTITEM_MAXPCS}); $i++) { ?>
											<option value="<?php echo $i; ?>" <?php echo set_select(DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, $i, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} == $i); ?>><?php echo $i; ?> st.</option>
										<?php } ?>
									</select>
									<input type="hidden" name="<?php echo DB_CUSTOM_AVEC . '_' . DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
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
			
			</fieldset>			
		<?php } ?>
		<div style="font-weight: bold">
			Totalt: <span id="totalprice"></span> euro
		</div>
		<button type="submit" class="button">Anmäl mig</button>
	</form>
</div>
	
<script>
	var executeOnStart = function ($) {		
		AKADEMEN.initializeButtons();		
		AKADEMEN.initializeFormValidation(true);
		
		$('#<?php echo DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED; ?>').on('change.toggleRegisterAvec', function() {
			var val = $(this).val(),
				$registerAvec = $('#registeravec');
			if (val === "0") {
				$registerAvec
					.slideUp("fast", function() {
						$('input[data-price], select[data-price]').eq(0).trigger('change.calculateTotalPrice');
					})
					.find('#<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME ?>, #<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME ?>')
						.removeClass("required");
				$('button[type="submit"] span').text('Anmäl mig');
			} else {
				$registerAvec
					.slideDown("fast", function() {
						$('input[data-price], select[data-price]').eq(0).trigger('change.calculateTotalPrice');		
					})
					.find('#<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME ?>, #<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME ?>')
						.addClass("required");					
				$('button[type="submit"] span').text('Anmäl oss');
			}						
		}).trigger('change.toggleRegisterAvec');
		
		// Calculate the total sum
		$('input[data-price], select[data-price]')
			.on('change.calculateTotalPrice', function () {
				var totalPrice = 0;
				$('input[data-price]:checked:visible').each(function() {
					totalPrice += parseFloat($(this).data('price'));
				});
				$('select[data-price]:visible').each(function() {
					totalPrice += (parseFloat($(this).data('price')) * $(this).val());
				});
				$('#totalprice').text(totalPrice);
			})
			.eq(0)
				.trigger('change.calculateTotalPrice');
				
		$('input:first').focus();
	};
</script>
