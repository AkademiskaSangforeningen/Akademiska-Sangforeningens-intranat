<table>
	<thead>
		<tr>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_PERSON); ?></th>
			<th class="alignright bold"><?php echo lang(LANG_KEY_FIELD_AMOUNT); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_STATUS); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></th>
		</tr>
	</thead>
	<tfoot>
		<td colspan="3" class="currency">Totalt:</td>
		<td class="alignright bold"><?php echo formatCurrency($transactionSum->{DB_TRANSACTION_AMOUNT}) ?></td>
		<td colspan="2"></td>
	</tfoot>
	<tbody>
	<?php foreach($transactionList as $key => $transaction): ?>
		<tr>
			<td><?php echo formatDateGerman($transaction->{DB_TRANSACTION_TRANSACTIONDATE}) ?></td>
			<td><?php echo $transaction->{DB_PERSON_LASTNAME} . ", " . $transaction->{DB_PERSON_FIRSTNAME}; ?></td>			
			<td class="alignright"><?php echo formatCurrency($transaction->{DB_TRANSACTION_AMOUNT}) ?></td>
			<td><?php echo $transaction->{DB_PAYMENTTYPE_NAME} ?></td>			
			<td><?php echo $transaction->{DB_TRANSACTION_DESCRIPTION} ?></td>
		</tr>
	<?php endforeach; ?>		
	</tbody>
</table>