<div class="single-field" style="clear: both">
	<label for="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>">
		<?php echo lang(LANG_KEY_FIELD_PAYMENTTYPE); ?>
	</label>
	<span class="requiredsymbol">*</span>
	<br/>
	<?php if (($event->{DB_EVENT_PAYMENTTYPE} & 1) == 1) { ?>
		<input class="required" style="width: auto" type="radio" name="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" id="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" value="1" <?php echo set_radio(DB_TABLE_PERSONHASEVENT . '_' .  DB_PERSONHASEVENT_PAYMENTTYPE, 1, isset($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE}) ? $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == 1 : FALSE); ?> />KK<br/>
	<?php } ?>
	<?php if (($event->{DB_EVENT_PAYMENTTYPE} & 2) == 2) { ?>
		<input class="required" style="width: auto" type="radio" name="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" id="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" value="2" <?php echo set_radio(DB_TABLE_PERSONHASEVENT . '_' .  DB_PERSONHASEVENT_PAYMENTTYPE, 2, isset($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE}) ? $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == 2 : FALSE); ?> />Kontant<br/>
	<?php } ?>				
	<?php if (($event->{DB_EVENT_PAYMENTTYPE} & 4) == 4) { ?>
		<input class="required" style="width: auto" type="radio" name="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" id="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" value="4" <?php echo set_radio(DB_TABLE_PERSONHASEVENT . '_' .  DB_PERSONHASEVENT_PAYMENTTYPE, 4, isset($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE}) ? $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == 4 : FALSE); ?> />Konto<br/>
	<?php } ?>
	<label for="<?php echo DB_TABLE_PERSONHASEVENT . "_" .  DB_PERSONHASEVENT_PAYMENTTYPE; ?>" class="error" generated="true"></label>
</div>	