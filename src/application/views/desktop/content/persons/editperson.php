<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open($controller . (isset($personId) ? "/" . $personId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend>Personlig information</legend>
	
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" .  DB_PERSON_FIRSTNAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_FIRSTNAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_FIRSTNAME, isset($person->{DB_PERSON_FIRSTNAME}) ? $person->{DB_PERSON_FIRSTNAME} : "" ); ?>" class="required ui-corner-all" />	
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_LASTNAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_LASTNAME, isset($person->{DB_PERSON_LASTNAME}) ? $person->{DB_PERSON_LASTNAME} : "" ); ?>" class="required ui-corner-all" />	
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>">
				<?php echo lang(LANG_KEY_FIELD_EMAIL); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input type="email" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL, isset($person->{DB_PERSON_EMAIL}) ? $person->{DB_PERSON_EMAIL} : "" ); ?>" class="required email ui-corner-all" />	
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>">
				<?php echo lang(LANG_KEY_FIELD_PASSWORD); ?>
			</label>
			<br/>
			<input type="password" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>" class="ui-corner-all" />	
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>_repeat">
				<?php echo lang(LANG_KEY_FIELD_PASSWORD_AGAIN); ?>
			</label>
			<br/>
			<input type="password" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>_repeat" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD ?>_repeat" class="ui-corner-all" />	
		</div>	
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_VOICE; ?>">
				<?php echo lang(LANG_KEY_FIELD_VOICE); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_PERSON . "_" . DB_PERSON_VOICE, getEnum(ENUM_VOICES), set_value(DB_TABLE_PERSON . "_" . DB_PERSON_VOICE, isset($person->{DB_PERSON_VOICE}) ? $person->{DB_PERSON_VOICE} : "" ), 'id="' . DB_TABLE_PERSON . '_' . DB_PERSON_VOICE . '" class="ui-corner-all"'); ?>		
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES; ?>">
				<?php echo lang(LANG_KEY_FIELD_ALLERGIES); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_ALLERGIES, isset($person->{DB_PERSON_ALLERGIES}) ? $person->{DB_PERSON_ALLERGIES} : "" ); ?>" class="ui-corner-all" />	
		</div>
	
	</fieldset>
	<fieldset class="ui-corner-all">
		<legend>Kontaktuppgifter</legend>
	
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE; ?>">
				<?php echo lang(LANG_KEY_FIELD_PHONE); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PHONE ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_PHONE, isset($person->{DB_PERSON_PHONE}) ? $person->{DB_PERSON_PHONE} : "" ); ?>" class="ui-corner-all" />
		</div>	
			
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS; ?>">
				<?php echo lang(LANG_KEY_FIELD_ADDRESS); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_ADDRESS, isset($person->{DB_PERSON_ADDRESS}) ? $person->{DB_PERSON_ADDRESS} : "" ); ?>" class="ui-corner-all" />	
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE; ?>">
				<?php echo lang(LANG_KEY_FIELD_POSTALCODE); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_POSTALCODE, isset($person->{DB_PERSON_POSTALCODE}) ? $person->{DB_PERSON_POSTALCODE} : "" ); ?>" class="ui-corner-all" />	
		</div>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY; ?>">
				<?php echo lang(LANG_KEY_FIELD_CITY); ?>
			</label>
			<br/>
			<input type="text" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY ?>" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_CITY ?>" value="<?php echo set_value(DB_TABLE_PERSON . "_" . DB_PERSON_CITY, isset($person->{DB_PERSON_CITY}) ? $person->{DB_PERSON_CITY} : "" ); ?>" class="ui-corner-all" />	
		</div>
		
		<div class="single-field">
			<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID; ?>">
				<?php echo lang(LANG_KEY_FIELD_COUNTRYID); ?>
			</label>
			<br/>
			<?php echo form_dropdown(DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID, getEnum(ENUM_COUNTRIES), set_value(DB_TABLE_PERSON . "_" . DB_PERSON_COUNTRYID, isset($person->{DB_PERSON_COUNTRYID}) ? $person->{DB_PERSON_COUNTRYID} : "" ), 'id="' . DB_TABLE_PERSON . '_' . DB_PERSON_COUNTRYID . '" class="ui-corner-all"'); ?>		
		</div>
		
	</fieldset>
	<?php if ($this->userrights->hasRight(userrights::USERS_EDIT_ACCESS_RIGHTS, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
		<fieldset class="ui-corner-all">
			<legend>Användarrättigheter</legend>
			<div>
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::FULL_ACCESS_RIGHTS; ?>" value="<?php echo userrights::FULL_ACCESS_RIGHTS; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::FULL_ACCESS_RIGHTS, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::FULL_ACCESS_RIGHTS) == userrights::FULL_ACCESS_RIGHTS); ?> />
					Fulla administrationsrättigheter
				</label>		
			</div>
			
			<hr style="clear: both"/>
			
			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::TRANSACTIONS_VIEW; ?>" value="<?php echo userrights::TRANSACTIONS_VIEW; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::TRANSACTIONS_VIEW, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::TRANSACTIONS_VIEW) == userrights::TRANSACTIONS_VIEW); ?> />
					Se kvartettkonto-transaktioner
				</label>		
			</div>		

			<div>
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::TRANSACTIONS_EDIT; ?>" value="<?php echo userrights::TRANSACTIONS_EDIT; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::TRANSACTIONS_EDIT, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::TRANSACTIONS_EDIT) == userrights::TRANSACTIONS_EDIT); ?> />
					Redigera kvartettkonto-transaktioner
				</label>		
			</div>

			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::TRANSACTIONS_DELETE; ?>" value="<?php echo userrights::TRANSACTIONS_DELETE; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::TRANSACTIONS_DELETE, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::TRANSACTIONS_DELETE) == userrights::TRANSACTIONS_DELETE); ?> />
					Radera kvartettkonto-transaktioner
				</label>		
			</div>
			
			<hr style="clear: both"/>		
			
			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::USERS_VIEW; ?>" value="<?php echo userrights::USERS_VIEW; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::USERS_VIEW, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::USERS_VIEW) == userrights::USERS_VIEW); ?> />
					Se medlemmar
				</label>		
			</div>		

			<div>
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::USERS_EDIT; ?>" value="<?php echo userrights::USERS_EDIT; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::USERS_EDIT, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::USERS_EDIT) == userrights::USERS_EDIT); ?> />
					Redigera medlemmar
				</label>		
			</div>
			
			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::USERS_EDIT_ACCESS_RIGHTS; ?>" value="<?php echo userrights::USERS_EDIT_ACCESS_RIGHTS; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::USERS_EDIT_ACCESS_RIGHTS, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::USERS_EDIT_ACCESS_RIGHTS) == userrights::USERS_EDIT_ACCESS_RIGHTS); ?> />
					Redigera användingsrättigheter
				</label>		
			</div>			

			<div>
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::USERS_DELETE; ?>" value="<?php echo userrights::USERS_DELETE; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::USERS_DELETE, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::USERS_DELETE) == userrights::USERS_DELETE); ?> />
					Radera medlemmar
				</label>		
			</div>	

			<hr style="clear: both"/>
			
			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::EVENTS_VIEW; ?>" value="<?php echo userrights::EVENTS_VIEW; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::EVENTS_VIEW, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::EVENTS_VIEW) == userrights::EVENTS_VIEW); ?> />
					Se evenemang
				</label>		
			</div>		

			<div>
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::EVENTS_EDIT; ?>" value="<?php echo userrights::EVENTS_EDIT; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::EVENTS_EDIT, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::EVENTS_EDIT) == userrights::EVENTS_EDIT); ?> />
					Redigera evenemang
				</label>		
			</div>

			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::EVENTS_DELETE; ?>" value="<?php echo userrights::EVENTS_DELETE; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::EVENTS_DELETE, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::EVENTS_DELETE) == userrights::EVENTS_DELETE); ?> />
					Radera evenemang
				</label>
			</div>
			
			<div>
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::EVENTS_EDIT_REGISTRATION; ?>" value="<?php echo userrights::EVENTS_EDIT_REGISTRATION; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::EVENTS_EDIT_REGISTRATION, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::EVENTS_EDIT_REGISTRATION) == userrights::EVENTS_EDIT_REGISTRATION); ?> />
					Redigera evenemangsanmälningar
				</label>
			</div>	

			<div style="clear: both">
				<label>
					<input type="checkbox" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>[]" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS; ?>_<?php echo userrights::EVENTS_DELETE_REGISTRATION; ?>" value="<?php echo userrights::EVENTS_DELETE_REGISTRATION; ?>" <?php echo set_checkbox(DB_TABLE_PERSON . "_" . DB_PERSON_USERRIGHTS . '[]', userrights::EVENTS_DELETE_REGISTRATION, ((isset($person->{DB_PERSON_USERRIGHTS}) ? $person->{DB_PERSON_USERRIGHTS} : 0 ) & userrights::EVENTS_DELETE_REGISTRATION) == userrights::EVENTS_DELETE_REGISTRATION); ?> />
					Radera evenemangsanmälningar
				</label>
			</div>	
			
		</fieldset>
	<?php } ?>	
</form>

<script>
	AKADEMEN.initializeFormValidation();
</script>