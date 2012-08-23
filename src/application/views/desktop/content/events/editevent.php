<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_EVENTS_SAVESINGLE . (isset($eventId) ? "/" . $eventId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend>Evenemangsinformation</legend>
	
		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_NAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_NAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_NAME ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_NAME ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_NAME, isset($event->{DB_EVENT_NAME}) ? $event->{DB_EVENT_NAME} : "" ); ?>" class="required ui-corner-all"/>	
		</div>
		
		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_LOCATION; ?>">
				<?php echo lang(LANG_KEY_FIELD_LOCATION); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION, isset($event->{DB_EVENT_LOCATION}) ? $event->{DB_EVENT_LOCATION} : "" ); ?>" class="required ui-corner-all"/>	
		</div>		
		
		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_STARTDATE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE, isset($event->{DB_EVENT_STARTDATE}) ? $event->{DB_EVENT_STARTDATE} : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>_hh">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>_mm">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>

		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_FINISHDATE); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE, isset($event->{DB_EVENT_STARTDATE}) ? $event->{DB_EVENT_STARTDATE} : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>_hh">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>_mm">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>				
		</div>	

		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? $event->{DB_EVENT_REGISTRATIONDUEDATE} : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>_hh">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>_mm">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>

		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_PAYMENT_DUEDATE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? $event->{DB_EVENT_PAYMENTDUEDATE} : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>_hh">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>_mm">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>				

	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeFormValidation();
</script>