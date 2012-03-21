<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_PERSONS_SAVESINGLE, array('id' => 'form_editsingle_person')); ?>
	
	<legend>* 
	
	<fieldset class="ui-corner-all">
		<legend>Personlig information</legend>
	
		<label for="<?php echo DB_TABLE_PERSON . "_" .  DB_PERSON_FIRSTNAME; ?>">
			<?php echo lang(LANG_KEY_FIELD_FIRSTNAME); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" value="<?php echo $person->{DB_PERSON_FIRSTNAME} ?>" class="required ui-corner-all" />	
		<br/>
		
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME; ?>">
			<?php echo lang(LANG_KEY_FIELD_LASTNAME); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" value="<?php echo $person->{DB_PERSON_LASTNAME} ?>" class="required ui-corner-all" />	
		<br/>

		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>">
			<?php echo lang(LANG_KEY_FIELD_EMAIL); ?>
		</label>
		<br/>
		<input type="email" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" value="<?php echo $person->{DB_PERSON_EMAIL} ?>" class="required ui-corner-all" />	
		<br/>

		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>">
			<?php echo lang(LANG_KEY_FIELD_PASSWORD); ?>
		</label>
		<br/>
		<input type="password" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>" class="ui-corner-all" />	
		<br/>
		
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>_repeat">
			<?php echo lang(LANG_KEY_FIELD_PASSWORD_AGAIN); ?>
		</label>
		<br/>
		<input type="password" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>_repeat" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>_repeat" class="ui-corner-all" />	
		<br/>	
		
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_VOICE; ?>">
			<?php echo lang(LANG_KEY_FIELD_VOICE); ?>
		</label>
		<br/>
		<?php echo form_dropdown(DB_TABLE_PERSON . "_" . DB_PERSON_VOICE, getEnum(ENUM_VOICES), $person->{DB_PERSON_VOICE}, 'id="' . DB_TABLE_PERSON . '_' . DB_PERSON_VOICE . '" class="required ui-corner-all"'); ?>		
		<br/>
		
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES; ?>">
			<?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" value="<?php echo $person->{DB_PERSON_ALLERGIES} ?>" class="required ui-corner-all" />	
		<br/>
	
	</fieldset>
	<fieldset class="ui-corner-all">
		<legend>Kontaktuppgifter</legend>
	
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE; ?>">
			<?php echo lang(LANG_KEY_FIELD_PHONE); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" value="<?php echo $person->{DB_PERSON_PHONE} ?>" class="required ui-corner-all" />
		<br/>	
			
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS; ?>">
			<?php echo lang(LANG_KEY_FIELD_ADDRESS); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS ?>" value="<?php echo $person->{DB_PERSON_ADDRESS} ?>" class="required ui-corner-all" />	
		<br/>

		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE; ?>">
			<?php echo lang(LANG_KEY_FIELD_POSTALCODE); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE ?>" value="<?php echo $person->{DB_PERSON_POSTALCODE} ?>" class="required ui-corner-all" />	
		<br/>

		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY; ?>">
			<?php echo lang(LANG_KEY_FIELD_CITY); ?>
		</label>
		<br/>
		<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY ?>" value="<?php echo $person->{DB_PERSON_CITY} ?>" class="required ui-corner-all" />	
		<br/>
		
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID; ?>">
			<?php echo lang(LANG_KEY_FIELD_COUNTRYID); ?>
		</label>
		<br/>
		<?php echo form_dropdown(DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID, getEnum(ENUM_COUNTRIES), $person->{DB_PERSON_COUNTRYID}, 'id="' . DB_TABLE_PERSON . '_' . DB_PERSON_COUNTRYID . '" class="ui-corner-all"'); ?>		
		<br/>	
		
	</fieldset>
	
</form>

<script>
	var executeOnStart = function ($) {};
</script>