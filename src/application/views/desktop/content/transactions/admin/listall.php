<div class="tools">
	<a href="<?php echo CONTROLLER_TRANSACTIONS_ADMIN_EDITSINGLE ?>" class="button" data-icon="ui-icon-document" data-dialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_TRANSACTION); ?></a>
</div>

<table>
	<thead>
		<tr>
			<th></th>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_PERSON); ?></th>
			<th class="alignright bold"><?php echo lang(LANG_KEY_FIELD_AMOUNT); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_STATUS); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($transactionList as $key => $transaction): ?>
		<tr>
			<td><a href="<?php echo CONTROLLER_TRANSACTIONS_ADMIN_EDITSINGLE . "/" . $transaction->{DB_TRANSACTION_ID} ?>" class="button" data-icon="ui-icon-document" data-text="false" data-dialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_TRANSACTION); ?></a></td>
			<td><?php echo formatDateGerman($transaction->{DB_TRANSACTION_TRANSACTIONDATE}) ?></td>
			<td><?php echo $transaction->{DB_PERSON_LASTNAME} . ", " . $transaction->{DB_PERSON_FIRSTNAME}; ?></td>			
			<td class="alignright"><?php echo formatCurrency($transaction->{DB_TRANSACTION_AMOUNT}) ?></td>
			<td><?php echo $transaction->{DB_PAYMENTTYPE_NAME} ?></td>			
			<td><?php echo $transaction->{DB_TRANSACTION_DESCRIPTION} ?></td>
		</tr>
	<?php endforeach; ?>		
	</tbody>
</table>