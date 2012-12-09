<div class="tools">
	<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
		<a href="<?php echo CONTROLLER_EVENTS_EDITSINGLE ?>" class="button" data-icon="ui-icon-calendar" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_EVENT); ?></a>
	<?php } ?>
</div>
<div class="pagination">
	<?php echo $pagination; ?>
</div>
<table>
	<colgroup>
		<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<col style="width: 27px" />
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::EVENTS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<col style="width: 27px" />
		<?php } ?>
		<col style="width: 27px" />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
	</colgroup>

	<thead>
		<tr>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_MEMBER); ?>"></span></th>
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_MEMBER); ?>"></span></th>
			<?php } ?>
			<th><span class="ui-icon ui-icon-extlink" title="<?php echo lang(LANG_KEY_BUTTON_VIEW_EVENT); ?>"></span></th>
			<th><?php echo lang(LANG_KEY_FIELD_EVENT); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_PAYMENT_DUEDATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ENROLLMENT_DUEDATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_LOCATION); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_ENROLLED); ?></th>
		</tr>
	</thead>
	<tfoot>

	</tfoot>
	<tbody>
	<?php foreach($eventList as $key => $event) { ?>
		<tr>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<td><a href="<?php echo site_url() . CONTROLLER_EVENTS_EDITSINGLE . '/' . $event->{DB_EVENT_ID}; ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_EVENT_REGISTRATION); ?></a></td>
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::EVENTS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<td>
				<?php if ((($event->{DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT} + $event->{DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT}) == 0)) { ?>
					<a href="<?php echo site_url() . CONTROLLER_EVENTS_DELETESINGLE . '/' . $event->{DB_EVENT_ID}; ?>" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_EVENT); ?></a>
				<?php } ?>
				</td>
			<?php } ?>
			<td><a href="<?php echo site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' . $event->{DB_EVENT_ID}; ?>" target="_blank" class="button" data-icon="ui-icon-extlink" data-text="false"><?php echo lang(LANG_KEY_BUTTON_VIEW_EVENT); ?></a></td>
			<td><?php echo $event->{DB_EVENT_NAME}; ?></td>
			<td>
			<?php
			echo formatDateGerman($event->{DB_EVENT_STARTDATE});
			if (isset($event->{DB_EVENT_ENDDATE}))	{
				echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE});
			}
			?></td>
			<td><?php echo formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE}); ?></td>
			<td><?php echo formatDateGerman($event->{DB_EVENT_PAYMENTDUEDATE}); ?></td>
			<td><?php echo $event->{DB_EVENT_LOCATION}; ?></td>
			<td><a href="<?php echo site_url() . CONTROLLER_EVENTS_LIST_SINGLE_EVENT_REGISTRATIONS . '/' . $event->{DB_EVENT_ID}; ?>" class="button" data-icon="ui-icon-person" data-listdialog="true">
				<?php echo $event->{DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT}; ?>
				+
				<?php echo $event->{DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT}; ?>
				=
				<?php echo ($event->{DB_TABLE_PERSONHASEVENT . DB_TOTALCOUNT} + $event->{DB_TABLE_PERSONHASEVENT . DB_CUSTOM_AVEC . DB_TOTALCOUNT}); ?>
				</a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
	$('.pagination a')
		.bind('click', function() {
			var selectedTab = $('#header_navitabs').tabs('option', 'active'),
				url = $(this).attr('href');

			$('#ui-tabs-' + selectedTab).load(url, function() {
				AKADEMEN.initializeButtons();
				//Change tab-link to point to selected page
				$('.ui-tabs-active a').attr('href', url);
			});
			return false;
		});
</script>

