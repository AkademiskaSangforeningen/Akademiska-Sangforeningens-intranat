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
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_NAME ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_NAME ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_NAME, isset($event->{DB_EVENT_NAME}) ? $event->{DB_EVENT_NAME} : "" ); ?>" class="required ui-corner-all"/>	
		</div>
		
		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_LOCATION; ?>">
				<?php echo lang(LANG_KEY_FIELD_LOCATION); ?>
			</label>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_LOCATION, isset($event->{DB_EVENT_LOCATION}) ? $event->{DB_EVENT_LOCATION} : "" ); ?>" class="ui-corner-all"/>	
		</div>		
		
		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_STARTDATE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE, isset($event->{DB_EVENT_STARTDATE}) ? formatDateGerman($event->{DB_EVENT_STARTDATE}, false) : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_HH; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_HH, isset($event->{DB_EVENT_STARTDATE}) ? extractHoursFromDate($event->{DB_EVENT_STARTDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_MM; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE . PREFIX_MM, isset($event->{DB_EVENT_STARTDATE}) ? extractMinutesFromDate($event->{DB_EVENT_STARTDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>

		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_FINISHDATE); ?>
			</label>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE, isset($event->{DB_EVENT_ENDDATE}) ? formatDateGerman($event->{DB_EVENT_ENDDATE}, false) : "" ); ?>" class="ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_HH; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_HH, isset($event->{DB_EVENT_ENDDATE}) ? extractHoursFromDate($event->{DB_EVENT_ENDDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_MM; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE . PREFIX_MM, isset($event->{DB_EVENT_ENDDATE}) ? extractMinutesFromDate($event->{DB_EVENT_ENDDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>				
		</div>	

		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE); ?>
			</label>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE}, false) : "" ); ?>" class="ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_HH, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? extractHoursFromDate($event->{DB_EVENT_REGISTRATIONDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE . PREFIX_MM, isset($event->{DB_EVENT_REGISTRATIONDUEDATE}) ? extractMinutesFromDate($event->{DB_EVENT_REGISTRATIONDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>

		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_PAYMENT_DUEDATE); ?>
			</label>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>" value="<?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? formatDateGerman($event->{DB_EVENT_PAYMENTDUEDATE}, false) : "" ); ?>" class="ui-corner-all short" placeholder="dd.mm.åååå" />	
			
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 24; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_HH, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? extractHoursFromDate($event->{DB_EVENT_PAYMENTDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>
			:
			<select class="ui-corner-all short" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM; ?>">
				<option value="">-</option>
				<?php for($i = 0; $i < 60; $i++) { ?>
					<option value="<?php echo $i; ?>" <?php if ($i === set_value(DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE . PREFIX_MM, isset($event->{DB_EVENT_PAYMENTDUEDATE}) ? extractMinutesFromDate($event->{DB_EVENT_PAYMENTDUEDATE}, false) : "" )) { echo "selected=\"selected\""; } ?>><?php echo ($i < 10) ? 0 . $i : $i; ?></option>
				<?php } ?>
			</select>			
		</div>				
		
		<div>
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_PAYMENTTYPE; ?>">
				<?php echo lang(LANG_KEY_FIELD_PAYMENTTYPE); ?>
			</label>
			<br/>
			<select multiple="multiple" name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE ?>">	
				<option value="KK">KK</option>
				<option value="Cash">Cash</option>
				<option value="Kontobetalning">Konto</option>
			</select>			
		</div>
		
		<div style="clear: both">
			<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_DESCRIPTION; ?>">
				<?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?>
			</label>		
			<br/>
			<textarea name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION ?>"><?php echo set_value(DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION, isset($event->{DB_EVENT_DESCRIPTION}) ? $event->{DB_EVENT_DESCRIPTION} : "" ); ?></textarea>			
		</div>
		

	</fieldset>
	
</form>

<script>
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_STARTDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_ENDDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_REGISTRATIONDUEDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTDUEDATE ?>').datepicker();
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_PAYMENTTYPE ?>').multiselect({ header: false, selectedList: 10, noneSelectedText: "Välj betalningssätt", height: "auto" });
	$('#<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_DESCRIPTION ?>').tinymce({
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
			plugins: "table,paste"
		});
	AKADEMEN.initializeFormValidation();
</script>