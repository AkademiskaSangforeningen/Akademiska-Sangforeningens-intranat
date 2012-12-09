	<div id="tab_dashboard">
		<div class="ui-widget-content ui-corner-all" style="width: 98%; float: left; margin-bottom: 20px">								
			<div class="ui-widget-header" style="padding: 5px">Kommande evenemang du inte är anmäld till</div>
			<div style="padding: 5px" id="myupcomingevents-body">
				
			</div>			
		</div>

		<div class="ui-widget-content ui-corner-all" style="width: 98%; float: left; margin-bottom: 20px">								
			<div class="ui-widget-header" style="padding: 5px">Evenemang du anmält dig till</div>
			<div style="padding: 5px" id="mypreviousevents-body">

			</div>			
		</div>
		
		<div style="clear: both"></div>
	
</div>

<script>
		$('#myupcomingevents-body').load("<?php echo CONTROLLER_MY_PAGE_LIST_UPCOMING_EVENTS; ?>", function() {
			AKADEMEN.initializeButtons();
		});
		$('#mypreviousevents-body').load("<?php echo CONTROLLER_MY_PAGE_LIST_REGISTERED_EVENTS; ?>", function() {
			AKADEMEN.initializeButtons();
		});
		
</script>