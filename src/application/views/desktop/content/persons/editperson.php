<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open($controller . (isset($personId) ? "/" . $personId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend>Personlig information</legend>
	
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" .  DB_PERSON_FIRSTNAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_FIRSTNAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME, isset($person->{DB_PERSON_FIRSTNAME}) ? $person->{DB_PERSON_FIRSTNAME} : "" ); ?>" class="required ui-corner-all" />	
		</div>
		
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_LASTNAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME, isset($person->{DB_PERSON_LASTNAME}) ? $person->{DB_PERSON_LASTNAME} : "" ); ?>" class="required ui-corner-all" />	
		</div>

		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>">
				<?php echo lang(LANG_KEY_FIELD_EMAIL); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="email" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL, isset($person->{DB_PERSON_EMAIL}) ? $person->{DB_PERSON_EMAIL} : "" ); ?>" class="required email ui-corner-all" />	
		</div>

		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>">
				<?php echo lang(LANG_KEY_FIELD_PASSWORD); ?>
			</label>
			<br/>
			<input type="password" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>" class="ui-corner-all" />	
		</div>
		
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>_repeat">
				<?php echo lang(LANG_KEY_FIELD_PASSWORD_AGAIN); ?>
			</label>
			<br/>
			<input type="password" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>_repeat" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>_repeat" class="ui-corner-all" />	
		</div>	
		
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_VOICE; ?>">
				<?php echo lang(LANG_KEY_FIELD_VOICE); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_PERSON . "_" . DB_PERSON_VOICE, getEnum(ENUM_VOICES), set_value(DB_TABLE_PERSON . "_" . DB_PERSON_VOICE, isset($person->{DB_PERSON_VOICE}) ? $person->{DB_PERSON_VOICE} : "" ), 'id="' . DB_TABLE_PERSON . '_' . DB_PERSON_VOICE . '" class="ui-corner-all"'); ?>		
		</div>
		
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES; ?>">
				<?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES, isset($person->{DB_PERSON_ALLERGIES}) ? $person->{DB_PERSON_ALLERGIES} : "" ); ?>" class="ui-corner-all" />	
		</div>
	
	</fieldset>
	<fieldset class="ui-corner-all">
		<legend>Kontaktuppgifter</legend>
	
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE; ?>">
				<?php echo lang(LANG_KEY_FIELD_PHONE); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_PHONE, isset($person->{DB_PERSON_PHONE}) ? $person->{DB_PERSON_PHONE} : "" ); ?>" class="ui-corner-all" />
		</div>	
			
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS; ?>">
				<?php echo lang(LANG_KEY_FIELD_ADDRESS); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS, isset($person->{DB_PERSON_ADDRESS}) ? $person->{DB_PERSON_ADDRESS} : "" ); ?>" class="ui-corner-all" />	
		</div>

		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE; ?>">
				<?php echo lang(LANG_KEY_FIELD_POSTALCODE); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE, isset($person->{DB_PERSON_POSTALCODE}) ? $person->{DB_PERSON_POSTALCODE} : "" ); ?>" class="ui-corner-all" />	
		</div>

		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY; ?>">
				<?php echo lang(LANG_KEY_FIELD_CITY); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_CITY, isset($person->{DB_PERSON_CITY}) ? $person->{DB_PERSON_CITY} : "" ); ?>" class="ui-corner-all" />	
		</div>
		
		<div>
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID; ?>">
				<?php echo lang(LANG_KEY_FIELD_COUNTRYID); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID, getEnum(ENUM_COUNTRIES), set_value(DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID, isset($person->{DB_PERSON_COUNTRYID}) ? $person->{DB_PERSON_COUNTRYID} : "" ), 'id="' . DB_TABLE_PERSON . '_' . DB_PERSON_COUNTRYID . '" class="ui-corner-all"'); ?>		
		</div>	
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeFormValidation();
</script>