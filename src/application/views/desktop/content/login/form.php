<div style="clear: both">
	<label class="error" for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>">
		<?php echo validation_errors(); ?>
	</label>
	<?php echo form_open(CONTROLLER_LOGIN_AUTHENTICATE, array('id' => 'form_login')); ?>
		<label for="<?php echo DB_TABLE_PERSON . "_" .  DB_PERSON_EMAIL; ?>">
			<?php echo lang(LANG_KEY_FIELD_EMAIL); ?>
		</label>
		<br/>
		<input type="email" size="20" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_EMAIL; ?>" class="email required ui-corner-all" />
		<br/>
		<label for="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>">
			<?php echo lang(LANG_KEY_FIELD_PASSWORD); ?>
		</label>
		<br/>
		<input type="password" size="20" id="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>" name="<?php echo DB_TABLE_PERSON . "_" . DB_PERSON_PASSWORD; ?>" class="required ui-corner-all" />
		<br/>
		<input type="submit" value="<?php echo lang(LANG_KEY_BUTTON_LOG_IN); ?>" id="form_login_submit_button" class="button ui-corner-all" />
	</form>

	<script>
		var executeOnStart = function ($) {			
			//Validate the form already on client side
			$("#form_login").validate({
				submitHandler: function(form) {
					$("#form_login_submit_button")
						.button({ disabled: true })
						.val('<?php echo lang(LANG_KEY_BUTTON_LOGGING_IN); ?>');
					form.submit();
				}		
			});		
		};
	</script>
</div>