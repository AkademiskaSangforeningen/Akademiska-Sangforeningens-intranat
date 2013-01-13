<?php if (in_array(DB_PERSON_FIRSTNAME, $showFields)) { ?>
	<div class="single-field">
		<label for="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" .  DB_PERSON_FIRSTNAME; ?>">
			<?php echo lang(LANG_KEY_FIELD_FIRSTNAME); ?>
		</label>
		<span class="requiredsymbol">*</span>
		<br/>
		<input type="text" <?php if ($disableFields == TRUE) { echo 'disabled="disabled"'; } ?> name="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" id="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" value="<?php echo set_value($fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME, isset($person->{DB_PERSON_FIRSTNAME}) ? $person->{DB_PERSON_FIRSTNAME} : "" ); ?>" maxlength="50" class="required ui-corner-all" />	
	</div>
<?php } ?>

<?php if (in_array(DB_PERSON_LASTNAME, $showFields)) { ?>
<div class="single-field">
	<label for="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME; ?>">
		<?php echo lang(LANG_KEY_FIELD_LASTNAME); ?>
	</label>
	<span class="requiredsymbol">*</span>
	<br/>
	<input type="text" <?php if ($disableFields == TRUE) { echo 'disabled="disabled"'; } ?> name="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" id="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" value="<?php echo set_value($fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME, isset($person->{DB_PERSON_LASTNAME}) ? $person->{DB_PERSON_LASTNAME} : "" ); ?>" maxlength="50" class="required ui-corner-all" />	
</div>
<?php } ?>

<?php if (in_array(DB_PERSON_EMAIL, $showFields)) { ?>
	<div class="single-field">
		<label for="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>">
			<?php echo lang(LANG_KEY_FIELD_EMAIL); ?>
		</label>
		<span class="requiredsymbol">*</span>
		<br/>
		<input type="email" <?php if ($disableFields == TRUE) { echo 'disabled="disabled"'; } ?> name="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" id="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" value="<?php echo set_value($fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL, isset($person->{DB_PERSON_EMAIL}) ? $person->{DB_PERSON_EMAIL} : "" ); ?>" maxlength="50" class="required email ui-corner-all" />	
	</div>
<?php } ?>

<?php if (in_array(DB_PERSON_PHONE, $showFields)) { ?>
	<div class="single-field">
		<label for="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_PHONE; ?>">
			<?php echo lang(LANG_KEY_FIELD_PHONE); ?>
		</label>
		<span class="requiredsymbol">*</span>
		<br/>
		<input type="text" <?php if ($disableFields == TRUE) { echo 'disabled="disabled"'; } ?> name="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" id="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" value="<?php echo set_value($fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_PHONE, isset($person->{DB_PERSON_PHONE}) ? $person->{DB_PERSON_PHONE} : "" ); ?>" maxlength="50" class="required phone ui-corner-all" />
	</div>
<?php } ?>

<?php if (in_array(DB_PERSON_ALLERGIES, $showFields) && $event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE) { ?>
	<div class="single-field">
		<label for="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES; ?>">
			<?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?>
		</label>
		<br/>
		<input type="text" <?php if ($disableFields == TRUE) { echo 'disabled="disabled"'; } ?> name="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" id="<?php echo $fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" value="<?php echo set_value($fieldPrefix . DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES, isset($person->{DB_PERSON_ALLERGIES}) ? $person->{DB_PERSON_ALLERGIES} : "" ); ?>" maxlength="255" class="ui-corner-all" />	
	</div>
<?php } ?>