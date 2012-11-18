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
	<div class="registerdirectly-map">
		<img src="https://maps.googleapis.com/maps/api/staticmap?center=Grand+Plaza+Mannerheimv%C3%A4gen+50+Helsingfors&zoom=14&size=250x250&sensor=false&markers=mid%7Grand+Plaza+Mannerheimv%C3%A4gen+50+Helsingfors" />
	</div>
	<div style="clear: both">
	<label class="error" style="font-size: 1em">
		<?php echo validation_errors(); ?>
	</label>
		<p>
			<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
		</p>	
	</div>
	<?php echo form_open(CONTROLLER_EVENTS_SAVE_REGISTER_DIRECTLY . (isset($eventId) ? "/" . $eventId : ""), array('id' => 'form_editobject')); ?>
		<fieldset class="ui-corner-all">
			<legend>Mina anmälningsuppgifter</legend>

			<div class="single-field">
				<label for="<?php echo DB_TABLE_PERSON . "_" .  DB_PERSON_FIRSTNAME; ?>">
					<?php echo lang(LANG_KEY_FIELD_FIRSTNAME); ?>
				</label>
				<span class="requiredsymbol">*</span>
				<br/>
				<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME, isset($person->{DB_PERSON_FIRSTNAME}) ? $person->{DB_PERSON_FIRSTNAME} : "" ); ?>" maxlength="50" class="required ui-corner-all" />	
			</div>
			
			<div class="single-field">
				<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME; ?>">
					<?php echo lang(LANG_KEY_FIELD_LASTNAME); ?>
				</label>
				<span class="requiredsymbol">*</span>
				<br/>
				<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME, isset($person->{DB_PERSON_LASTNAME}) ? $person->{DB_PERSON_LASTNAME} : "" ); ?>" maxlength="50" class="required ui-corner-all" />	
			</div>

			<div class="single-field">
				<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>">
					<?php echo lang(LANG_KEY_FIELD_EMAIL); ?>
				</label>
				<span class="requiredsymbol">*</span>
				<br/>
				<input type="email" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL, isset($person->{DB_PERSON_EMAIL}) ? $person->{DB_PERSON_EMAIL} : "" ); ?>" maxlength="50" class="required email ui-corner-all" />	
			</div>
			
			<div class="single-field">
				<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE; ?>">
					<?php echo lang(LANG_KEY_FIELD_PHONE); ?>
				</label>
				<span class="requiredsymbol">*</span>
				<br/>
				<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_PHONE, isset($person->{DB_PERSON_PHONE}) ? $person->{DB_PERSON_PHONE} : "" ); ?>" maxlength="50" class="required phone ui-corner-all" />
			</div>

			<div class="single-field">
				<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES; ?>">
					<?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?>
				</label>
				<br/>
				<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES, isset($person->{DB_PERSON_ALLERGIES}) ? $person->{DB_PERSON_ALLERGIES} : "" ); ?>" maxlength="255" class="ui-corner-all" />	
			</div>			
			
			<div class="single-field" style="clear: both">
				<label for="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>">
					<?php echo lang(LANG_KEY_FIELD_PAYMENTTYPE); ?>
				</label>
				<span class="requiredsymbol">*</span>
				<br/>
				<?php if (($event->{DB_EVENT_PAYMENTTYPE} & 1) == 1) { ?>
					<input class="required" style="width: auto" type="radio" name="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" id="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" value="1" <?php echo set_radio(DB_TABLE_PERSONHASEVENT . '_' .  DB_PERSONHASEVENT_PAYMENTTYPE, 1, isset($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE}) ? $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == 1 : FALSE); ?> />KK<br/>
				<?php } ?>
				<?php if (($event->{DB_EVENT_PAYMENTTYPE} & 2) == 2) { ?>
					<input class="required" style="width: auto" type="radio" name="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" id="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" value="2" <?php echo set_radio(DB_TABLE_PERSONHASEVENT . '_' .  DB_PERSONHASEVENT_PAYMENTTYPE, 2, isset($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE}) ? $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == 2 : FALSE); ?> />Kontant<br/>
				<?php } ?>				
				<?php if (($event->{DB_EVENT_PAYMENTTYPE} & 4) == 4) { ?>
					<input class="required" style="width: auto" type="radio" name="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" id="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" value="4" <?php echo set_radio(DB_TABLE_PERSONHASEVENT . '_' .  DB_PERSONHASEVENT_PAYMENTTYPE, 4, isset($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE}) ? $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == 4 : FALSE); ?> />Konto<br/>
				<?php } ?>
				<label for="PersonHasEvent_PaymentType" class="error" generated="true"></label>
			</div>		 

			<div style="clear: both; width: auto">				
				<?php
					$previousCaption = "";
					$multirowCounter = 1;
					if (isset($eventItems)) {		
						foreach($eventItems as $key => $eventItem) {					
				?>
							<?php if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) { ?>
								<div style="margin-top: 1em"><label><?php echo $eventItem->{DB_EVENTITEM_CAPTION}; ?></label></div>
							<?php } ?>
							<div> 
								<?php if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) { ?>
									<?php if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_RADIO) { ?>
										<!-- radio -->
										<input type="radio" name="<?php echo DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_radio(DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : $eventItem->{DB_EVENTITEM_PRESELECTED}); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
									<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_CHECKBOX) { ?>
										<!-- checkbox -->
										<input type="checkbox" name="<?php echo DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_checkbox(DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : $eventItem->{DB_EVENTITEM_PRESELECTED}); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
									<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) { ?>									
										<textarea name="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_DESCRIPTION; ?>" class="ui-corner-all"><?php echo set_value($eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_DESCRIPTION, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION}); ?></textarea>
										<input type="hidden" name="<?php echo DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
									<?php } ?>																	
									<?php if (strlen($eventItem->{DB_EVENTITEM_DESCRIPTION}) > 0 ) { ?> - <?php } ?>
									<?php echo $eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
									<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
										 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?>						
									<?php } ?>																															
								<?php } else { ?>
									<select name="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>_<?php echo DB_PERSONHASEVENTITEM_AMOUNT; ?>" class="short" data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>">
										<?php for($i = 0; $i <= ($eventItem->{DB_EVENTITEM_MAXPCS}); $i++) { ?>
											<option value="<?php echo $i; ?>" <?php echo set_select($eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, $i, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT}); ?>><?php echo $i; ?> st.</option>
										<?php } ?>
									</select>
									<input type="hidden" name="<?php echo DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" /> 
									<?php echo $eventItem->{DB_EVENTITEM_DESCRIPTION}; ?>
									<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { ?>
										 - pris: <?php echo formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}); ?> per styck
									<?php } ?>
								<?php } ?>									
							</div>					
				<?php
							$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
							$multirowCounter++;
						}
					}
				?>			
			</div>
			<?php if ($event->{DB_EVENT_AVECALLOWED} == 1) { ?>
				<div style="clear: both">
					<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_AVECALLOWED; ?>">
						<?php echo lang(LANG_KEY_FIELD_AVEC); ?>
					</label>
					<br/>								
					<select name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED; ?>" class="ui-corner-all"> 
						<?php foreach (getEnum(ENUM_ENABLED) as $key => $val) { ?>
							<option value="<?php echo $key; ?>" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED, $key, isset($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID}) ? $personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} != NULL : FALSE); ?>><?php echo $val; ?></option>
						<?php } ?>
					</select>
				</div>	
			<?php } ?>			
		</fieldset>
		<?php if ($event->{DB_EVENT_AVECALLOWED} == 1) { ?>
			<fieldset style="<?php if (isset($personhasevent->{DB_PERSONHASEVENT_AVECPERSONID}) && !is_null($personhasevent->{DB_PERSONHASEVENT_AVECPERSONID})) { echo ""; } ?>" id="registeravec">							
				<legend>Min avecs anmälningsuppgifter</legend>			
			
				<div>
					<label for="<?php echo DB_CUSTOM_AVEC . "_" .  DB_PERSON_FIRSTNAME; ?>">
						<?php echo lang(LANG_KEY_FIELD_FIRSTNAME); ?>
					</label>
					<span class="requiredsymbol">*</span>
					<br/>
					<input type="text" name="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME ?>" id="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME ?>" value="<?php echo set_value(DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME, isset($personAvec->{DB_PERSON_FIRSTNAME}) ? $personAvec->{DB_PERSON_FIRSTNAME} : "" ); ?>" maxlength="50" class="required ui-corner-all" />	
				</div>
				
				<div>
					<label for="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME; ?>">
						<?php echo lang(LANG_KEY_FIELD_LASTNAME); ?>
					</label>
					<span class="requiredsymbol">*</span>
					<br/>
					<input type="text" name="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME ?>" id="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME ?>" value="<?php echo set_value(DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME, isset($personAvec->{DB_PERSON_LASTNAME}) ? $personAvec->{DB_PERSON_LASTNAME} : "" ); ?>" maxlength="50" class="required ui-corner-all" />	
				</div>

				<div style="clear: both">
					<label for="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_ALLERGIES; ?>">
						<?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?>
					</label>
					<br/>
					<input type="text" name="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_ALLERGIES ?>" id="<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_ALLERGIES ?>" value="<?php echo set_value(DB_CUSTOM_AVEC . "_" . DB_PERSON_ALLERGIES, isset($personAvec->{DB_PERSON_ALLERGIES}) ? $personAvec->{DB_PERSON_ALLERGIES} : "" ); ?>" maxlength="255" class="ui-corner-all" />	
				</div>			

				<div style="clear: both; width: auto">
					<?php
						$previousCaption = "";
						$multirowCounter = 1;
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
										<input type="radio" name="<?php echo DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_radio(DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : $eventItem->{DB_EVENTITEM_PRESELECTED}); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
									<?php } else if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_CHECKBOX) { ?>
										<!-- checkbox -->
										<input type="checkbox" name="<?php echo DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID; ?>[]" value="<?php echo $eventItem->{DB_EVENTITEM_ID}; ?>" <?php echo set_checkbox(DB_CUSTOM_AVEC . '_' .DB_PERSONHASEVENTITEM_EVENTITEMID . '[]', $eventItem->{DB_EVENTITEM_ID}, isset($eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID}) ? $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_EVENTITEMID} = $eventItem->{DB_EVENTITEM_ID} : $eventItem->{DB_EVENTITEM_PRESELECTED}); ?> data-price="<?php if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) { echo $eventItem->{DB_EVENTITEM_AMOUNT}; } ?>" />
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
											<option value="<?php echo $i; ?>" <?php echo set_select(DB_CUSTOM_AVEC . '_' . $eventItem->{DB_EVENTITEM_ID} . '_' . DB_PERSONHASEVENTITEM_AMOUNT, $i, $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT}); ?>><?php echo $i; ?> st.</option>
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
								$multirowCounter++;
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
	};
</script>
