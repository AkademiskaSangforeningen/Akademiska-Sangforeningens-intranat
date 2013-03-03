<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_TRANSACTIONS_SAVESINGLE . (isset($transactionId) ? "/" . $transactionId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend>Transaktionsinformation</legend>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_AMOUNT; ?>">
				<?php echo lang(LANG_KEY_FIELD_AMOUNT); ?> (&euro;)
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_AMOUNT ?>" id="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_AMOUNT ?>" value="<?php echo set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_AMOUNT, isset($transaction->{DB_TRANSACTION_AMOUNT}) ? $transaction->{DB_TRANSACTION_AMOUNT} : "" ); ?>" class="required ui-corner-all short number" placeholder="0,00" />	
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_TRANSACTIONDATE; ?>">
				<?php echo lang(LANG_KEY_FIELD_DATE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="10" type="text" name="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE ?>" id="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE ?>" value="<?php echo set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE, isset($transaction->{DB_TRANSACTION_TRANSACTIONDATE}) ? formatDateGerman($transaction->{DB_TRANSACTION_TRANSACTIONDATE}, false) : "" ); ?>" class="required ui-corner-all short" placeholder="dd.mm.åååå" />	
		</div>
	
		<div class="single-field">
			<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_PERSONID; ?>">
				<?php echo lang(LANG_KEY_FIELD_PERSON); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<?php echo form_dropdown(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, $persons, set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, isset($transaction->{DB_TRANSACTION_PERSONID}) ? $transaction->{DB_TRANSACTION_PERSONID} : "" ), 'id="' . DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID . '" class="required ui-corner-all long"'); ?>		
		</div>		
	
		<div class="single-field" style="clear: both">
			<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_DESCRIPTION; ?>">
				<?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_DESCRIPTION ?>" id="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_DESCRIPTION ?>" value="<?php echo set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_DESCRIPTION, isset($transaction->{DB_TRANSACTION_DESCRIPTION}) ? $transaction->{DB_TRANSACTION_DESCRIPTION} : "" ); ?>" class="required ui-corner-all long" />
		</div>				
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeButtons('#dialog_form');		
	$('#<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE ?>').datepicker();
	AKADEMEN.initializeFormValidation();
</script>
