<div>	
	<div>
	<h1>Din anmälning är nu annulerad</h1>
	<p>
	Om du vill anmäla dig på nytt, använd <a href="/<?php echo CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . (isset($eventId) ? "/" . $eventId : ""); ?>">denna länk</a>.
	</p>
	</div>
</div>
	
<script>
	var executeOnStart = function ($) {		
			AKADEMEN.initializeButtons();		
		};
</script>