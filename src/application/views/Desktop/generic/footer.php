	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>
		//Fallback to local jQuery-copy if CDN is down
		window.jQuery || document.write('\x3Cscript src="<?php echo base_url()?>js/libraries/jquery.min.js">\x3C/script>');		
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script>
		//Fallback to local jQuery UI-copy if CDN is down
		window.jQuery || document.write('\x3Cscript src="<?php echo base_url()?>js/libraries/jquery-ui.min.js">\x3C/script>');		
	</script>			
	<script src="<?php echo base_url()?>js/plugins/jquery.validate.min.js"></script>
	<script src="<?php echo base_url()?>js/plugins/localization/messages_<?php echo LANG_LANGUAGE_SV; ?>.js"></script>
	<script>
		//Check and execute executeOnStart if found
		if (typeof window.executeOnStart === 'function') {
			$(executeOnStart($));
		}
	</script>
	</body>
</html>