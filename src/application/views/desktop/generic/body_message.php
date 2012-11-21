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
