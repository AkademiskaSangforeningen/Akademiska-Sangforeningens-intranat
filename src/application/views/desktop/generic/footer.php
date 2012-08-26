		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<script>
			//Fallback to local jQuery-copy if CDN is down
			window.jQuery || document.write('\x3Cscript src="<?php echo base_url()?>js/desktop/libraries/jquery.min.js">\x3C/script>');		
		</script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
		<script>
			//Fallback to local jQuery UI-copy if CDN is down
			window.jQuery.ui || document.write('\x3Cscript src="<?php echo base_url()?>js/desktop/libraries/jquery-ui.min.js">\x3C/script>');		
		</script>			
		<script src="<?php echo base_url()?>js/desktop/plugins/jquery.multiselect.min.js"></script>
		<script src="<?php echo base_url()?>js/desktop/plugins/jquery.validate.min.js"></script>
		<script src="<?php echo base_url()?>js/desktop/plugins/tiny_mce/jquery.tinymce.js"></script>
		<script src="<?php echo base_url()?>js/desktop/plugins/localization/messages_<?php echo LANG_LANGUAGE_SV; ?>.js"></script>
		<script src="<?php echo base_url()?>js/desktop/main.js"></script>
		<script>
			$(function() {
				AKADEMEN.initializeFormDialog("<?php echo lang(LANG_KEY_BUTTON_SAVE); ?>", "<?php echo lang(LANG_KEY_BUTTON_CANCEL); ?>");
				AKADEMEN.initializeConfirmDialog("<?php echo lang(LANG_KEY_BUTTON_CONFIRM); ?>", "<?php echo lang(LANG_KEY_BUTTON_OK); ?>", "<?php echo lang(LANG_KEY_BUTTON_CANCEL); ?>");
				AKADEMEN.initializeButtons();
				AKADEMEN.initializeTabs();	
				AKADEMEN.initializeDatepicker();
			});			
		
			//Check and execute executeOnStart if found
			if (typeof window.executeOnStart === 'function') {
				$(executeOnStart($));
			}
		</script>
	</body>
</html>