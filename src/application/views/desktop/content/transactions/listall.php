<div class="overflowscroll">
	<div class="filters">	
		<?php echo lang(LANG_KEY_FIELD_SEARCH); ?>:&nbsp;<input maxlength="50" type="text" name="<?php echo HTTP_WILDCARDSEARCH; ?>" id="<?php echo HTTP_WILDCARDSEARCH; ?>" value="<?php echo set_value(HTTP_WILDCARDSEARCH, isset($wildCardSearch) ? $wildCardSearch : "" ); ?>" class="required ui-corner-all short" placeholder="t.ex. herrsits" />	
		<?php echo lang(LANG_KEY_FIELD_PERSON); ?>:&nbsp;<?php echo form_dropdown(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, $persons, set_value(DB_TABLE_TRANSACTION . "_" . DB_TRANSACTION_PERSONID, isset($personId) ? $personId : "" ), 'id="' . DB_TABLE_TRANSACTION . '_' . DB_TRANSACTION_PERSONID . '" class="required ui-corner-all short"'); ?>		
		<hr/>
	</div>	
	<div class="tools">
		<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<a href="<?php echo CONTROLLER_TRANSACTIONS_EDITSINGLE ?>" class="button" data-icon="ui-icon-script" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_TRANSACTION); ?></a>
		<?php } ?>
	</div>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
	<table>
		<colgroup>
			<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
				<col style="width: 27px" />
			<?php } ?>
			<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
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
				<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
					<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_TRANSACTION); ?>"></span></th>
				<?php } ?>
				<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
					<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_TRANSACTION); ?>"></span></th>
				<?php } ?>			
				<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
				<th><?php echo lang(LANG_KEY_FIELD_PERSON); ?></th>
				<th><?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></th>
				<th><?php echo lang(LANG_KEY_FIELD_CREATEDBY); ?> / <?php echo lang(LANG_KEY_FIELD_MODIFIEDBY); ?></th>
				<th class="alignright"><?php echo lang(LANG_KEY_FIELD_AMOUNT); ?></th>			
			</tr>
		</thead>
		<tfoot>
			<td colspan="6" class="currency">Totalt:</td>
			<td class="alignright"><?php echo formatCurrency(($transactionSum->{DB_TOTALSUM} == NULL) ? 0 : $transactionSum->{DB_TOTALSUM}); ?></td>
		</tfoot>
		<tbody>
		<?php foreach($transactionList as $key => $transaction): ?>
			<tr>
				<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_EDIT, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
					<td>
						<?php if ($transaction->{DB_TRANSACTION_EVENTID} == NULL) { ?>
							<a href="<?php echo site_url() . CONTROLLER_TRANSACTIONS_EDITSINGLE . '/' . $transaction->{DB_TRANSACTION_ID}; ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_TRANSACTION); ?></a>						
						<?php } ?>
					</td>
				<?php } ?>
				<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_DELETE, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
						<td>
							<?php if ($transaction->{DB_TRANSACTION_EVENTID} == NULL) { ?>
								<a href="<?php echo site_url() . CONTROLLER_TRANSACTIONS_DELETESINGLE . '/' . $transaction->{DB_TRANSACTION_ID}; ?>" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_TRANSACTION); ?></a>
							<?php } ?>
						</td>
				<?php } ?>
				<td><?php echo formatDateGerman($transaction->{DB_TRANSACTION_TRANSACTIONDATE}) ?></td>
				<td><?php echo $transaction->{DB_PERSON_LASTNAME} . ", " . $transaction->{DB_PERSON_FIRSTNAME}; ?></td>			
				<td><i><?php echo $transaction->{DB_EVENT_NAME}; ?></i><?php echo $transaction->{DB_TRANSACTION_DESCRIPTION}; ?></td>
				<td>
				<?php
					if ($transaction->{DB_PERSON_MODIFIEDBY . DB_PERSON_LASTNAME} != NULL) {
						echo $transaction->{DB_PERSON_MODIFIEDBY . DB_PERSON_LASTNAME} . ", " . $transaction->{DB_PERSON_MODIFIEDBY . DB_PERSON_FIRSTNAME};
					} else {
						echo $transaction->{DB_PERSON_CREATEDBY . DB_PERSON_LASTNAME} . ", " . $transaction->{DB_PERSON_CREATEDBY . DB_PERSON_FIRSTNAME};
					}
				?>
				</td>
				<td class="alignright"><?php echo formatCurrency($transaction->{DB_TRANSACTION_AMOUNT}) ?></td>			
			</tr>
		<?php endforeach; ?>		
		</tbody>
	</table>
</div>
<script>
	$('.pagination a')
		.bind('click', function() {
			var selectedTab = $('#header_navitabs').tabs('option', 'active'),
				url = $(this).attr('href');

			$('#ui-tabs-' + (selectedTab + 1)).load(url, function() {
				AKADEMEN.initializeButtons();
				//Change tab-link to point to selected page
				$('.ui-tabs-active a').attr('href', url);
			});
			return false;
		});
		
	$filters = $('.filters').find('input, select');
	$filters.bind('change', function() {
			var selectedTab = $('#header_navitabs').tabs('option', 'active'),
				url = "<?php echo site_url() . CONTROLLER_TRANSACTIONS_LISTALL . '?'; ?>";
				url += $filters.serialize();
				
			$('#ui-tabs-' + (selectedTab + 1)).load(url, function() {
				AKADEMEN.initializeButtons();
				//Change tab-link to point to selected page
				$('.ui-tabs-active a').attr('href', url);
			});
			return false;		
		});
</script>
