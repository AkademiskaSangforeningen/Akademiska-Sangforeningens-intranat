<div class="tools">
<?php if ($this->userrights->hasRight(userrights::USERS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
	<a href="<?php echo CONTROLLER_PERSONS_EDITSINGLE ?>" class="button" data-icon="ui-icon-person" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_MEMBER); ?></a>
<?php } ?>
</div>

<table>
	<colgroup>
		<?php if ($this->userrights->hasRight(userrights::USERS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<col style="width: 27px" />
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::USERS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<col style="width: 27px" />
		<?php } ?>
		<col />
		<col />
		<col />
		<col />
		<col />				
	</colgroup>
	
	<thead>
		<tr>
			<?php if ($this->userrights->hasRight(userrights::USERS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_MEMBER); ?>"></span></th>
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::USERS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_MEMBER); ?>"></span></th>
			<?php } ?>				
			<th><?php echo lang(LANG_KEY_FIELD_NAME); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_VOICE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_EMAIL); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_PHONE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ADDRESS); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($personList as $key => $person): ?>
		<tr>
			<?php if ($this->userrights->hasRight(userrights::USERS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<td><a href="<?php echo CONTROLLER_PERSONS_EDITSINGLE . "/" . $person->{DB_PERSON_ID} ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_MEMBER); ?></a></td>
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::USERS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<td><a href="<?php echo CONTROLLER_PERSONS_DELETESINGLE . "/" . $person->{DB_PERSON_ID} ?>" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_MEMBER); ?></a></td>
			<?php } ?>
			<td><?php echo $person->{DB_PERSON_LASTNAME} . ", " . $person->{DB_PERSON_FIRSTNAME}; ?></td>
			<td><?php echo $person->{DB_PERSON_VOICE} ?></td>
			<td><a href="mailto:<?php echo $person->{DB_PERSON_EMAIL} ?>"><?php echo $person->{DB_PERSON_EMAIL} ?></a></td>
			<td><?php echo $person->{DB_PERSON_PHONE} ?></td>
			<td><?php echo $person->{DB_PERSON_ADDRESS} . ", " . $person->{DB_PERSON_POSTALCODE} . " " . $person->{DB_PERSON_CITY} ?></td>
		</tr>
	<?php endforeach; ?>		
	</tbody>
</table>