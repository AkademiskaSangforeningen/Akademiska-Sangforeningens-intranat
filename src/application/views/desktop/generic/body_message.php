<?php if ($closeFormDialog == TRUE) { ?>
	<script>		
		$('#dialog_form, #dialog_confirm, #dialog_alert').dialog('close');
		
		$('#dialog_alert')
			.html("<?php if (isset($body)) { ?><p><?php echo $body; ?></p><?php } ?>")
			.dialog("option", "title", "<?php if (isset($header)) { ?><?php echo $header; ?><?php } ?>")								
			.dialog('open');
			
		//Reload the open tab
		$("#header_navitabs").tabs("load", $("#header_navitabs").tabs("option", "selected"));
		//Update the open dialog list
		$("#dialog_list").trigger('updateList');
	</script>
<?php } else { ?>
	<div>	
		<div>
		<?php if (isset($header)) { ?>
			<h1><?php echo $header; ?></h1>
		<?php } ?>
		<?php if (isset($body)) { ?>
			<p>
				<?php echo $body; ?>
			</p>
		<?php } ?>
		<?php if (isset($links)) { ?>
			<p>
			<?php foreach($links as $key => $value) { ?>
				<a href="<?php echo $key; ?>" class="button"><?php echo $value; ?></a>
			<?php }	?>
			</p>
		<?php } ?>	
		</div>
	</div>
		
	<script>
		var executeOnStart = function ($) {		
				AKADEMEN.initializeButtons();			
			};		
	</script>
<?php } ?>	