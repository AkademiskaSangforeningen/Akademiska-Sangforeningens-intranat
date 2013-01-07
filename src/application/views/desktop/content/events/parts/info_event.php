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
	<?php if ($event->{DB_EVENT_ISMAPSHOWN} == TRUE) { ?>
		<div class="registerdirectly-map">
			<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode(str_replace(',', ' ', $event->{DB_EVENT_LOCATION})); ?>&zoom=14&size=250x250&sensor=false&markers=mid%7<?php echo urlencode(str_replace(',', ' ', $event->{DB_EVENT_LOCATION})); ?>" />
		</div>
	<?php } ?>
</div>