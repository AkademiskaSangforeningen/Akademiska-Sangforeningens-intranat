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
	</div>
	<?php echo form_open(CONTROLLER_SAVE_CANCEL_REGISTER_DIRECTLY . (isset($eventId) ? "/" . $eventId : "") . (isset($personId) ? "/" . $personId : "") . (isset($hash) ? "/" . $hash : ""), array('id' => 'form_editobject')); ?>		
		<button type="submit" class="button">Annullera din anmälan</button>
	</form>
</div>
	
<script>
	var executeOnStart = function ($) {		
		AKADEMEN.initializeButtons();		
		AKADEMEN.initializeFormValidation(true);		
	};
</script>
