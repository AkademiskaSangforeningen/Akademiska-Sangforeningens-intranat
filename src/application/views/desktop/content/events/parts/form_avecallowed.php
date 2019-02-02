<div style="clear: both">
	<label for="<?php echo DB_TABLE_EVENT . "_" .  DB_EVENT_AVECALLOWED; ?>">
		<?php echo lang(LANG_KEY_FIELD_AVEC); ?>
	</label>
	<br/>								
	<select name="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED; ?>" id="<?php echo DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED; ?>" class="ui-corner-all"> 
		<?php foreach (getEnum(ENUM_ENABLED) as $key => $val) { ?>
			<option value="<?php echo $key; ?>" <?php echo set_select(DB_TABLE_EVENT . "_" . DB_EVENT_AVECALLOWED, $key, isset($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID}) ? $personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} != NULL : FALSE); ?>><?php echo $val; ?></option>
		<?php } ?>
	</select>
</div>	