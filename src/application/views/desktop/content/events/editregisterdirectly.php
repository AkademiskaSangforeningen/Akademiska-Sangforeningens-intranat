<div>	
	<?php if (isset($part_info_event)) { echo $part_info_event; } ?>
	<div style="clear: both">
	<label class="error" style="font-size: 1em">
		<?php echo validation_errors(); ?>
	</label>
		<p>
			<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
		</p>	
	</div>
	<?php echo form_open(CONTROLLER_EVENTS_SAVE_REGISTER_DIRECTLY . (isset($eventId) ? "/" . $eventId : "") . (isset($personId) ? "/" . $personId : "") . (isset($hash) ? "/" . $hash : ""), array('id' => 'form_editobject')); ?>
		<fieldset class="ui-corner-all">
			<legend>Mina anmälningsuppgifter</legend>
			
			<?php if (isset($part_form_person)) { echo $part_form_person; } ?>				
			
			<?php if (isset($part_form_payment)) { echo $part_form_payment; } ?>				 
			
			<?php if (isset($part_form_eventitems)) { echo $part_form_eventitems; } ?>

			<?php if (isset($part_form_avecallowed)) { echo $part_form_avecallowed; } ?>			

		</fieldset>
		<?php if ($event->{DB_EVENT_AVECALLOWED} == 1) { ?>
			<fieldset style="<?php if (isset($personhasevent->{DB_PERSONHASEVENT_AVECPERSONID}) && !is_null($personhasevent->{DB_PERSONHASEVENT_AVECPERSONID})) { echo ""; } ?>" id="registeravec">							
				<legend>Min avecs anmälningsuppgifter</legend>						
			
				<?php if (isset($part_form_personAvec)) { echo $part_form_personAvec; } ?>								
				
				<?php if (isset($part_form_eventitemsAvec)) { echo $part_form_eventitemsAvec; } ?>		
			
			</fieldset>			
		<?php } ?>
		<div style="font-weight: bold">
			Totalt: <span id="totalprice"></span> euro
		</div>
		<button type="submit" class="button">Anmäl mig</button>
	</form>
</div>
	
<script>
	var executeOnStart = function ($) {		
		AKADEMEN.initializeButtons();		
		AKADEMEN.initializeFormValidation(true);
		
		$('#<?php echo DB_TABLE_EVENT . '_' . DB_EVENT_AVECALLOWED; ?>').on('change.toggleRegisterAvec', function() {
			var val = $(this).val(),
				$registerAvec = $('#registeravec');
			if (val === "0") {
				$registerAvec
					.slideUp("fast", function() {
						$('input[data-price], select[data-price]').eq(0).trigger('change.calculateTotalPrice');
					})
					.find('#<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME ?>, #<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME ?>')
						.removeClass("required");
				$('button[type="submit"] span').text('Anmäl mig');
			} else {
				$registerAvec
					.slideDown("fast", function() {
						$('input[data-price], select[data-price]').eq(0).trigger('change.calculateTotalPrice');		
					})
					.find('#<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_FIRSTNAME ?>, #<?php echo DB_CUSTOM_AVEC . "_" . DB_PERSON_LASTNAME ?>')
						.addClass("required");					
				$('button[type="submit"] span').text('Anmäl oss');
			}						
		}).trigger('change.toggleRegisterAvec');
		
		// Calculate the total sum
		$('input[data-price], select[data-price]')
			.on('change.calculateTotalPrice', function () {
				var totalPrice = 0;
				$('input[data-price]:checked:visible').each(function() {
					totalPrice += parseFloat($(this).data('price'));
				});
				$('select[data-price]:visible').each(function() {
					totalPrice += (parseFloat($(this).data('price')) * $(this).val());
				});
				$('#totalprice').text(totalPrice);
			})
			.eq(0)
				.trigger('change.calculateTotalPrice');
				
		$('input:first').focus();
	};
</script>
