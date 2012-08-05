<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_TRANSACTIONS_ADMIN_SAVESINGLE . (isset($transactionId) ? "/" . $transactionId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> Obligatoriskt fält</legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend>Information om transaktionen</legend>
	
		<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_TRANSACTIONDATE; ?>">
			<?php echo lang(LANG_KEY_FIELD_DATE); ?>
		</label>
		<span class="requiredsymbol">*</span>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE ?>" id="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE ?>" value="<?php echo set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_TRANSACTIONDATE, isset($transaction->{DB_TRANSACTION_TRANSACTIONDATE}) ? formatDateGerman($transaction->{DB_TRANSACTION_TRANSACTIONDATE}) : "" ); ?>" class="required ui-corner-all" data-datepicker="dd.mm.yy"/>	
		<br/>
		
		<label for="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID; ?>">
			<?php echo lang(LANG_KEY_FIELD_PERSON); ?>
		</label>
		<span class="requiredsymbol">*</span>
		<br/>
		<?php echo form_dropdown(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, $personList, set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, isset($transaction->{DB_TRANSACTION_PERSONID}) ? $transaction->{DB_TRANSACTION_PERSONID} : "" ), 'id="' . DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID . '" class="required ui-corner-all"'); ?>		
		<br/>
		
		<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_AMOUNT; ?>">
			<?php echo lang(LANG_KEY_FIELD_AMOUNT); ?>
		</label>
		<span class="requiredsymbol">*</span>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_AMOUNT ?>" id="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_AMOUNT ?>" value="<?php echo set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_AMOUNT, isset($transaction->{DB_TRANSACTION_AMOUNT}) ? $transaction->{DB_TRANSACTION_AMOUNT} : "" ); ?>" class="required ui-corner-all" />	
		<br/>

		<label for="<?php echo DB_TABLE_TRANSACTION . "_" .  DB_TRANSACTION_DESCRIPTION; ?>">
			<?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_DESCRIPTION ?>" id="<?php echo DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_DESCRIPTION ?>" value="<?php echo set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_DESCRIPTION, isset($transaction->{DB_TRANSACTION_DESCRIPTION}) ? $transaction->{DB_TRANSACTION_DESCRIPTION} : "" ); ?>" class="ui-corner-all" />	
		<br/>		
	
	</fieldset>
</form>

<script>
	AKADEMEN.initializeFormValidation();
	AKADEMEN.initializeDatePicker();
</script>