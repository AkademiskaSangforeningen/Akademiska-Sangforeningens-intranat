<div id="container" class="ui-corner-all">
	<h1><?php echo $this->lang->line(LANG_KEY_LOGIN_HEADER); ?></h1>
	<label class="error" for="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_EMAIL; ?>">
		<?php echo validation_errors(); ?>
	</label>
	<?php echo form_open(CONTROLLER_LOGIN_AUTHENTICATE, array('id' => 'form_login')); ?>
		<label for="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_EMAIL; ?>"><?php echo $this->lang->line(LANG_KEY_FIELD_EMAIL); ?>:</label><br/>
		<input type="email" size="20" id="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_EMAIL; ?>" name="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_EMAIL; ?>" class="email required ui-corner-all" />
		<br/>
		<label for="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_PASSWORD; ?>"><?php echo $this->lang->line(LANG_KEY_FIELD_PASSWORD); ?>:</label>
		<br/>
		<input type="password" size="20" id="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_PASSWORD; ?>" name="<?php echo DB_TABLE_PERSON; ?>_<?php echo DB_PERSON_PASSWORD; ?>" class="required ui-corner-all" />
		<br/>
		<input type="submit" value="<?php echo $this->lang->line(LANG_KEY_FORM_SUBMIT); ?>" id="form_login_submit_button" class="ui-corner-all" />
	</form>
</div>

<script>
	var executeOnStart = function ($) {
		$("#form_login_submit_button").button();
	
		//Validate the form already on client side
		$("#form_login").validate();
	};
</script>