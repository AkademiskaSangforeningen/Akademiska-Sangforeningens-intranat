<div class="tools">
<a href="<?php echo BASE_URL() . CONTROLLER_PERSONS_EDITSINGLE ?>" class="button" data-icon="ui-icon-person" data-dialog="true">Skapa ny medlem</a>
</div>

<table>
	<thead>
		<tr>
			<th></th>
			<th>Namn</th>
			<th>Stämma</th>
			<th>E-post</th>
			<th>Telefonnummer</th>
			<th>Adress</th>
		</tr>
	<tbody>
	<?php foreach($personList as $key => $person): ?>
		<tr>
			<td><a href="<?php echo BASE_URL() . CONTROLLER_PERSONS_EDITSINGLE . "/" . $person->{DB_PERSON_ID} ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-dialog="true">Redigera medlem</a></td>
			<td><?php echo $person->{DB_PERSON_LASTNAME} . ", " . $person->{DB_PERSON_FIRSTNAME}; ?></td>
			<td><?php echo $person->{DB_PERSON_VOICE} ?></td>
			<td><a href="mailto:<?php echo $person->{DB_PERSON_EMAIL} ?>"><?php echo $person->{DB_PERSON_EMAIL} ?></a></td>
			<td><?php echo $person->{DB_PERSON_PHONE} ?></td>
			<td><?php echo $person->{DB_PERSON_ADDRESS} . ", " . $person->{DB_PERSON_POSTALCODE} . " " . $person->{DB_PERSON_CITY} ?></td>
		</tr>
	<?php endforeach; ?>		
	</tbody>
</table>	
		

<script>
	$(".button:not(.ui-button)")
		.each(function() {
			var icon = $(this).data("icon"),
				text = $(this).data("text");
			$(this)
				.button({ icons: { primary: icon }, text: text })
				.css("display", "inline-block");			
		})
		.filter('[data-dialog="true"]')
			.on('click', function (event) {			
				var title = $(this).text();

				$.ajax({
				  url: $(this).attr("href"),				  
				  dataType: "html",
				  cache: false,
				  success: function(data) {
					var $dialog = $('<div></div>')
						.html(data)
						.dialog({
							autoOpen: false,
							title: title,
							height: 500,
							width: 700,
							modal: true,
							buttons: {
								Spara: function() {},
								Ångra: function() {
									$( this ).dialog( "close" );
								}
							}
						}).dialog('open');					  
				  },
				  error:  function(jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				  }
				});							
					
				return false;
			
			});	
</script>