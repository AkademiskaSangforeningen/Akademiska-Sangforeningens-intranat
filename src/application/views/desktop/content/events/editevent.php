<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_EVENTS_SAVESINGLE . (isset($eventId) ? "/" . $eventId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend>Evenemangsinformation</legend>
	
		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_NAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_NAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_NAME ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_NAME ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_NAME, isset($event->{DB_EVENT_NAME}) ? $event->{DB_EVENT_NAME} : "" ); ?>" class="required ui-corner-all"/>	
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_LOCATION; ?>">
				<?php echo lang(LANG_KEY_FIELD_LOCATION); ?>
			</label>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION, isset($event->{DB_EVENT_LOCATION}) ? $event->{DB_EVENT_LOCATION} : "" ); ?>" class="ui-corner-all"/>	
		</div>		
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_STARTDATE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE, isset($event->{DB_EVENT_STARTDATE}) ? formatDateGerman($event->{DB_EVENT_STARTDATE}, false) : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_HH; ?>">
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_HH, isset($event->{DB_EVENT_STARTDATE}) ? extractHoursFromDate($event->{DB_EVENT_STARTDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_MM; ?>">
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_MM, isset($event->{DB_EVENT_STARTDATE}) ? extractMinutesFromDate($event->{DB_EVENT_STARTDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>	
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_FINISHDATE); ?>
			</label>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE, isset($event->{DB_EVENT_ENDDATE}) ? formatDateGerman($event->{DB_EVENT_ENDDATE}, false) : "" ); ?>" class="ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_HH; ?>">
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_HH, isset($event->{DB_EVENT_ENDDATE}) ? extractHoursFromDate($event->{DB_EVENT_ENDDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_MM; ?>">
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_MM, isset($event->{DB_EVENT_ENDDATE}) ? extractMinutesFromDate($event->{DB_EVENT_ENDDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>				
		</div>	

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE); ?>
			</label>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE}, false) : "" ); ?>" class="ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH; ?>">
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? extractHoursFromDate($event->{DB_EVENT_REGISTRATIONDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM; ?>">
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? extractMinutesFromDate($event->{DB_EVENT_REGISTRATIONDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_PAYMENT_DUEDATE); ?>
			</label>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? formatDateGerman($event->{DB_EVENT_PAYMENTDUEDATE}, false) : "" ); ?>" class="ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH; ?>">
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? extractHoursFromDate($event->{DB_EVENT_PAYMENTDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM; ?>">
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? extractMinutesFromDate($event->{DB_EVENT_PAYMENTDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>
    
		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_PAYMENTTYPE; ?>[]">
				<?php echo lang(LANG_KEY_FIELD_PAYMENTTYPE); ?>
			</label>
			<br/>
			<select multiple="multiple" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE ?>[]" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE ?>">	
				<option value="1" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE . '[]', 1) ?><?php echo ((isset($event->{DB_EVENT_PAYMENTTYPE}) ? $event->{DB_EVENT_PAYMENTTYPE} : 0 ) & 1) == 1 ? ' selected="selected"' : ''; ?>><?php echo getEnumValue(ENUM_PAYMENTTYPE, 1); ?></option>
				<option value="2" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE . '[]', 2) ?><?php echo ((isset($event->{DB_EVENT_PAYMENTTYPE}) ? $event->{DB_EVENT_PAYMENTTYPE} : 0 ) & 2) == 2 ? ' selected="selected"' : ''; ?>><?php echo getEnumValue(ENUM_PAYMENTTYPE, 2); ?></option>
				<option value="4" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE . '[]', 4) ?><?php echo ((isset($event->{DB_EVENT_PAYMENTTYPE}) ? $event->{DB_EVENT_PAYMENTTYPE} : 0 ) & 4) == 4 ? ' selected="selected"' : ''; ?>><?php echo getEnumValue(ENUM_PAYMENTTYPE, 4); ?></option>
			</select>			
		</div>	

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_PARTICIPANT; ?>[]">
				<?php echo lang(LANG_KEY_FIELD_PARTICIPANT); ?>
			</label>
			<br/>
			<select multiple="multiple" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PARTICIPANT ?>[]" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PARTICIPANT ?>">	
				<option value="1" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_PARTICIPANT . '[]', 1) ?><?php echo ((isset($event->{DB_EVENT_PARTICIPANT}) ? $event->{DB_EVENT_PARTICIPANT} : 0 ) & 1) == 1 ? ' selected="selected"' : ''; ?>>Aktiva korister</option>
				<option value="2" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_PARTICIPANT . '[]', 2) ?><?php echo ((isset($event->{DB_EVENT_PARTICIPANT}) ? $event->{DB_EVENT_PARTICIPANT} : 0 ) & 2) == 2 ? ' selected="selected"' : ''; ?>>Gamla akademare</option>
				<option value="4" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_PARTICIPANT . '[]', 4) ?><?php echo ((isset($event->{DB_EVENT_PARTICIPANT}) ? $event->{DB_EVENT_PARTICIPANT} : 0 ) & 4) == 4 ? ' selected="selected"' : ''; ?>>Övriga inbjudna</option>
			</select>			
		</div>							

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_AVECALLOWED; ?>">
				<?php echo lang(LANG_KEY_FIELD_AVEC); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED, getEnum(ENUM_ENABLED), set_value(DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED, isset($event->{DB_EVENT_AVECALLOWED}) ? $event->{DB_EVENT_AVECALLOWED} : "" ), 'id="' . DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED . '" class="ui-corner-all"'); ?>		
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_CANUSERSVIEWREGISTRATIONS; ?>">
				<?php echo lang(LANG_KEY_FIELD_CAN_USERS_VIEW_REGISTRATIONS); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_EVENT . "_" . DB_EVENT_CANUSERSVIEWREGISTRATIONS, getEnum(ENUM_ENABLED), set_value(DB_TABLE_EVENT . "_" . DB_EVENT_CANUSERSVIEWREGISTRATIONS, isset($event->{DB_EVENT_CANUSERSVIEWREGISTRATIONS}) ? $event->{DB_EVENT_CANUSERSVIEWREGISTRATIONS} : "" ), 'id="' . DB_TABLE_EVENT . '_' . DB_EVENT_CANUSERSVIEWREGISTRATIONS . '" class="ui-corner-all"'); ?>		
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_CANUSERSSETALLERGIES; ?>">
				<?php echo lang(LANG_KEY_FIELD_CAN_USERS_SET_ALLERGIES); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_EVENT . "_" . DB_EVENT_CANUSERSSETALLERGIES, getEnum(ENUM_ENABLED), set_value(DB_TABLE_EVENT . "_" . DB_EVENT_CANUSERSSETALLERGIES, isset($event->{DB_EVENT_CANUSERSSETALLERGIES}) ? $event->{DB_EVENT_CANUSERSSETALLERGIES} : "" ), 'id="' . DB_TABLE_EVENT . '_' . DB_EVENT_CANUSERSSETALLERGIES . '" class="ui-corner-all"'); ?>		
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_ISMAPSHOWN; ?>">
				<?php echo lang(LANG_KEY_FIELD_IS_MAP_SHOWN); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_EVENT . "_" . DB_EVENT_ISMAPSHOWN, getEnum(ENUM_ENABLED), set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ISMAPSHOWN, isset($event->{DB_EVENT_ISMAPSHOWN}) ? $event->{DB_EVENT_ISMAPSHOWN} : "" ), 'id="' . DB_TABLE_EVENT . '_' . DB_EVENT_ISMAPSHOWN . '" class="ui-corner-all"'); ?>		
		</div>		
		
	</fieldset>
	<fieldset class="ui-corner-all">
		<legend>Radinformation</legend>
		
		<div style="clear: both; width: 100%">
			<label><i><!--Förklarning hur det fungerar--></i></label>
			<div style="width: 100%; clear: both;" class="multirow">
				<div>
					<div style="float: left">
						<div class="multirow-header">Typ</div>
						<div class="multirow-field">
							<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_TYPE ?>" style="width: auto" disabled="disabled" >
								<option value="<?php echo EVENT_TYPE_RADIO; ?>">Valmöjlighet</option>
								<option value="<?php echo EVENT_TYPE_CHECKBOX; ?>">Extra möjlighet</option>
								<option value="<?php echo EVENT_TYPE_TEXTAREA; ?>">Textbox</option>
							</select>
						</div>
					</div>			
					<div style="float: left">
						<div class="multirow-header">Rubrik<span class="requiredsymbol">*</span></div>						
						<div class="multirow-field">
							<input name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_CAPTION ?>" type="text" value="" class="middle required" disabled="disabled" />
						</div>
					</div>
					<div style="float: left">
						<div class="multirow-header">Beskrivning</div>
						<div class="multirow-field">
							<input name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_DESCRIPTION ?>" type="text" value="" disabled="disabled" />
						</div>
					</div>				
					<div style="float: left">
						<div class="multirow-header">Summa</div>
						<div class="multirow-field">
							<input name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_AMOUNT ?>" type="text" value="" class="short number" disabled="disabled" />
						</div>
					</div>
					<div style="float: left">
						<div class="multirow-header">Max antal</div>
						<div class="multirow-field">
							<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_MAXPCS ?>" disabled="disabled" class="short">
								<option value="0">-</option>
								<?php for($i = 1; $i < 11; $i++) { ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>							
								<?php } ?>
							</select>
						</div>
					</div>				
					<div style="float: left">
						<div class="multirow-header">Färdigt vald</div>
						<div class="multirow-field">
							<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_PRESELECTED ?>" disabled="disabled" class="short">
								<?php foreach (getEnum(ENUM_ENABLED) as $key => $val) { ?>
									<option value="<?php echo $key; ?>" <?php echo set_select(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_PRESELECTED, $key); ?>><?php echo $val; ?></option>
								<?php } ?>							
							</select>
						</div>
					</div>
					<div style="float: left">
						<div class="multirow-header">Visa för avec</div>
						<div class="multirow-field">
							<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_SHOWFORAVEC ?>" disabled="disabled" class="short">
								<?php foreach (getEnum(ENUM_SHOW_FOR_AVEC) as $key => $val) { ?>
									<option value="<?php echo $key; ?>" <?php echo set_select(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_SHOWFORAVEC, $key); ?>><?php echo $val; ?></option>
								<?php } ?>							
							</select>
						</div>
					</div>						
					
					<div style="float: left">
						<div class="multirow-header">Ordning</div>
						<div class="multirow-field">
							<a href="" class="button" data-icon="ui-icon-arrowthick-1-n" data-text="false">Flytta uppåt</a>
							<a href="" class="button" data-icon="ui-icon-arrowthick-1-s" data-text="false">Flytta neråt</a>
						</div>
					</div>
					<div style="float: left">
						<div class="multirow-header">&nbsp;</div>
						<div class="multirow-field">
							<input type="hidden" name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_ID ?>" disabled="disabled" />
							<input type="hidden" name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_ROWORDER ?>" disabled="disabled" />
							<a href="" class="button" data-icon="ui-icon-trash" data-text="false">Radera</a>
						</div>
					</div>
				</div>
<?php
	$multirowCounter = 1;
	if (isset($eventItems)) {		
		foreach($eventItems as $key => $eventItem):
?>	
					<div>
						<div style="float: left">
							<div class="multirow-field">
								<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_TYPE .$multirowCounter ?>" style="width: auto">														
									<option value="<?php echo EVENT_TYPE_RADIO; ?>" <?php if (EVENT_TYPE_RADIO == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_TYPE, isset($eventItem->{DB_EVENTITEM_TYPE}) ? $eventItem->{DB_EVENTITEM_TYPE} : EVENT_TYPE_RADIO )) { echo "selected=\"selected\""; } ?>>Valmöjlighet</option>
									<option value="<?php echo EVENT_TYPE_CHECKBOX; ?>" <?php if (EVENT_TYPE_CHECKBOX == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_TYPE, isset($eventItem->{DB_EVENTITEM_TYPE}) ? $eventItem->{DB_EVENTITEM_TYPE} : EVENT_TYPE_RADIO )) { echo "selected=\"selected\""; } ?>>Extra möjlighet</option>
									<option value="<?php echo EVENT_TYPE_TEXTAREA; ?>" <?php if (EVENT_TYPE_TEXTAREA == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_TYPE, isset($eventItem->{DB_EVENTITEM_TYPE}) ? $eventItem->{DB_EVENTITEM_TYPE} : EVENT_TYPE_RADIO )) { echo "selected=\"selected\""; } ?>>Textbox</option>
								</select>
							</div>
						</div>			
						<div style="float: left">
							<div class="multirow-field">
								<input name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_CAPTION . $multirowCounter; ?>" type="text" value="<?php echo set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_CAPTION, isset($eventItem->{DB_EVENTITEM_CAPTION}) ? $eventItem->{DB_EVENTITEM_CAPTION} : "" ); ?>" class="middle required" />
							</div>
						</div>
						<div style="float: left">
							<div class="multirow-field">
								<input name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_DESCRIPTION . $multirowCounter; ?>" type="text" value="<?php echo set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_DESCRIPTION, isset($eventItem->{DB_EVENTITEM_DESCRIPTION}) ? $eventItem->{DB_EVENTITEM_DESCRIPTION} : "" ); ?>" />
							</div>
						</div>				
						<div style="float: left">
							<div class="multirow-field">
								<input name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_AMOUNT . $multirowCounter; ?>" type="text" value="<?php echo set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_AMOUNT, isset($eventItem->{DB_EVENTITEM_AMOUNT}) ? $eventItem->{DB_EVENTITEM_AMOUNT} : "" ); ?>" class="short number" />
							</div>
						</div>
						<div style="float: left">
							<div class="multirow-field">
								<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_MAXPCS . $multirowCounter; ?>" class="short">
									<option value="0" <?php if (0 == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_MAXPCS, isset($eventItem->{DB_EVENTITEM_MAXPCS}) ? $eventItem->{DB_EVENTITEM_MAXPCS} : 0 )) { echo "selected=\"selected\""; } ?>>-</option>
									<?php for($i = 1; $i < 11; $i++) { ?>
										<option value="<?php echo $i ?>" <?php if ($i == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_MAXPCS . $multirowCounter, isset($eventItem->{DB_EVENTITEM_MAXPCS}) ? $eventItem->{DB_EVENTITEM_MAXPCS} : 0 )) { echo "selected=\"selected\""; } ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
						</div>		
						<div style="float: left">
							<div class="multirow-field">
								<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_PRESELECTED  . $multirowCounter; ?>" class="short">
									<?php foreach (getEnum(ENUM_ENABLED) as $key => $val) { ?>
										<option value="<?php echo $key; ?>" <?php if ($key == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_PRESELECTED . $multirowCounter, isset($eventItem->{DB_EVENTITEM_PRESELECTED}) ? $eventItem->{DB_EVENTITEM_PRESELECTED} : 0 )) { echo "selected=\"selected\""; } ?>><?php echo $val ?></option>
									<?php } ?>							
								</select>
							</div>
						</div>
						<div style="float: left">
							<div class="multirow-field">
								<select name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_SHOWFORAVEC  . $multirowCounter; ?>" class="short">
									<?php foreach (getEnum(ENUM_SHOW_FOR_AVEC) as $key => $val) { ?>
										<option value="<?php echo $key; ?>" <?php if ($key == set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_SHOWFORAVEC . $multirowCounter, isset($eventItem->{DB_EVENTITEM_SHOWFORAVEC}) ? $eventItem->{DB_EVENTITEM_SHOWFORAVEC} : 0 )) { echo "selected=\"selected\""; } ?>><?php echo $val ?></option>
									<?php } ?>							
								</select>
							</div>
						</div>
						<div style="float: left">
							<div class="multirow-field">
								<a href="" class="button" data-icon="ui-icon-arrowthick-1-n" data-text="false">Flytta uppåt</a>
								<a href="" class="button" data-icon="ui-icon-arrowthick-1-s" data-text="false">Flytta neråt</a>
							</div>
						</div>					
						<div style="float: left">
							<div class="multirow-field">
								<input type="hidden" name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_ROWORDER . $multirowCounter; ?>" value="<?php echo set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_ROWORDER, isset($eventItem->{DB_EVENTITEM_ROWORDER}) ? $eventItem->{DB_EVENTITEM_ROWORDER} : "" ); ?>" />
								<input type="hidden" name="<?php echo DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_ID . $multirowCounter; ?>" value="<?php echo set_value(DB_TABLE_EVENTITEM . "_" . DB_EVENTITEM_ID, isset($eventItem->{DB_EVENTITEM_ID}) ? $eventItem->{DB_EVENTITEM_ID} : "" ); ?>" />
								<a href="" class="button" data-icon="ui-icon-trash" data-text="false">Radera</a>
							</div>
						</div>
					</div>					
<?php
		$multirowCounter++;
		endforeach; 
	}
?>
			</div>			
			<div style="clear: both">
				<a id="multirow-price-button-add" class="button" href="#" data-icon="ui-icon-plus" data-row="<?php echo ($multirowCounter - 1); ?>">Lägg till rad</a>
			</div>						
		</div>

	</fieldset>
	<fieldset class="ui-corner-all">	
		<legend><?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></legend>					
		
		<div style="clear: both">
			<textarea name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION ?>"><?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION, isset($event->{DB_EVENT_DESCRIPTION}) ? $event->{DB_EVENT_DESCRIPTION} : "" ); ?></textarea>			
		</div>		
		
	</fieldset>

	<fieldset class="ui-corner-all">	
		<legend><?php echo lang(LANG_KEY_FIELD_PAYMENT_INFO); ?></legend>					
		
		<div style="clear: both">
			<textarea name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTINFO ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTINFO ?>"><?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTINFO, isset($event->{DB_EVENT_PAYMENTINFO}) ? $event->{DB_EVENT_PAYMENTINFO} : "" ); ?></textarea>			
		</div>		
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeButtons('#dialog_form');	
	
	$('#multirow-price-button-add')
		.on('click', function () {
			var nextRow = $('#multirow-price-button-add').data('row') + 1;	
			$(this).data('row', nextRow)
			$('.multirow>div:first').each(function() {
				$(this)
					.clone(true)
						.find('.multirow-header')
							.remove()
							.end()
						.show()										
							.find('input, select')
								.attr('name', function() { 
									return $(this).attr("name") + ($('#multirow-price-button-add').data('row')); 
								})
								.removeAttr("disabled")
								.end()
							.insertAfter($('.multirow>div:last'));
		});
		
		$('.multirow').trigger('custom.recalculateRowOrder');
		
		return false;		
	});
	
	$('.multirow')
		.on('custom.recalculateRowOrder', function () {
			var i = 0;
			$('input[name^="<?php echo DB_TABLE_EVENTITEM; ?>_<?php echo DB_EVENTITEM_ROWORDER; ?>"]').each(function () {
				$(this).val(i);
				i++;
			});	
			return false;
		});
	
	$('.multirow a[data-icon="ui-icon-trash"]')
		.on('click', function () {
			$(this).closest('.multirow>div').remove();
			return false;
		});		
		
	$('.multirow a[data-icon="ui-icon-arrowthick-1-s"]')
		.on('click', function () {
			var	$currentRow = $(this).closest('.multirow>div'),
				$nextRow 	= $currentRow.next();
				
			if ($nextRow.length) {
				$nextRow.after($currentRow.detach());			
			}
			
			$('.multirow').trigger('custom.recalculateRowOrder');
			
			return false;
		});
		
	$('.multirow a[data-icon="ui-icon-arrowthick-1-n"]')
		.on('click', function () {
			var	$currentRow = $(this).closest('.multirow>div'),
				$previousRow = $currentRow.prevAll();					
				
			if ($previousRow.length > 1) {
				$previousRow.first().before($currentRow.detach());			
			}
			
			$('.multirow').trigger('custom.recalculateRowOrder');
			
			return false;
		});		
		

	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE ?>').multiselect({ header: false, selectedList: 10, noneSelectedText: "Välj betalningssätt", height: "auto" });
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PARTICIPANT ?>').multiselect({ header: false, selectedList: 10, noneSelectedText: "Välj deltagare", height: "auto" });
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION ?>, #<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTINFO ?>').tinymce({
			// Location of TinyMCE script			
			script_url : '<?php echo base_url()?>js/desktop/plugins/tiny_mce/tiny_mce.js',
			// General options
			theme : "advanced",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_buttons1 : "formatselect,fontsizeselect,forecolor,backcolor,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,indent,outdent,separator,link,unlink,separator,bullist,numlist,hr",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,separator,undo,redo,separator,tablecontrols,separator,image,code,fullscreen",
			theme_advanced_buttons3 : "",
			theme_advanced_path: false,			
			plugins: "table,paste",
			height: 300,
			theme_advanced_resizing : true,
			theme_advanced_resizing_max_width: 710,
			theme_advanced_resizing_min_width: 710,
			relative_urls : false,
			remove_script_host : false			
		});
	AKADEMEN.initializeFormValidation();
</script>
