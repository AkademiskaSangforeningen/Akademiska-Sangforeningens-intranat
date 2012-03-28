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
	//Initialize not already initialized buttons
	$(".button:not(.ui-button)")
		.each(function() {
			var icon = $(this).data("icon"),
				text = $(this).data("text");
			$(this)
				.button({ icons: { primary: icon }, text: text })
				.css("display", "inline-block");			
		})
		//Special handling for those buttons that open a dialog
		.filter('[data-dialog="true"]')
			.on('click.openDialog', function (event) {			
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
							buttons: [
								{
									text: "Spara",
									click: function () {
										$('#form_editsingle_person').trigger('submit');
									},
								},
								{
									text: "Ångra",
									"data-priority": "secondary",
									click: function () {
										$( this ).dialog( "close" );
									},
								}
							],
							
							open: function(event, ui) {
								//Validate the form on submit
								$('#form_editsingle_person')	
									.validate({
										submitHandler: function(form) {
											$.ajax({
												type: 'POST',
												url: $(form).attr("action"),
												data: $(form).serialize(),
												success: function(data) { 
													$dialog.html(data);
												},
												error:  function(jqXHR, textStatus, errorThrown) {
													alert(errorThrown);
												},
												dataType: "html"
											});
											
											return false;
										}
									})																									
								//On open, set priority CSS-classes for buttons (if given)
								$(this)
									.closest('.ui-dialog')
										.find('.ui-dialog-buttonpane button[data-priority]')
											.each(function() {
												$(this).addClass("ui-priority-" + $(this).attr("data-priority"));
											});
							},
							
							close: function() {
								//Remove the dialog on close
								$dialog.remove();
							}
						})						
						.dialog('open');					  
				  },
				  error:  function(jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				  }
				});							
					
				return false;
			
			});	
</script>