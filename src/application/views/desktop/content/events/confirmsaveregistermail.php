<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php if ($updateRegistration) { ?>	
		<title>Du anmälan till <?php echo $event->{DB_EVENT_NAME}; ?> är nu uppdaterad</title>		
	<?php } else { ?>
		<title>Du är nu anmäld till <?php echo $event->{DB_EVENT_NAME}; ?></title>		
	<?php } ?>
	<style type="text/css">
		/* Based on The MailChimp Reset INLINE: Yes. */  
		/* Client-specific Styles */
		#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
		.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */  
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		/* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */ 
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		/* End reset */

		/* Some sensible defaults for images
		Bring inline: Yes. */
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}

		/* Yahoo paragraph fix
		Bring inline: Yes. */
		p {margin: 1em 0;}

		/* Hotmail header color reset
		Bring inline: Yes. */
		h1, h2, h3, h4, h5, h6 {color: black !important;}

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		/* Outlook 07, 10 Padding issue fix
		Bring inline: No.*/
		table td {border-collapse: collapse;}

    /* Remove spacing around Outlook 07, 10 tables
    Bring inline: Yes */
    table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }

		/* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
		Bring inline: Yes. */
		a {color: orange;}


		/***************************************************
		****************************************************
		MOBILE TARGETING
		****************************************************
		***************************************************/
		@media only screen and (max-device-width: 480px) {
			/* Part one of controlling phone number linking for mobile. */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}

		}

		/* More Specific Targeting */

		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		/* You guessed it, ipad (tablets, smaller screens, etc) */
			/* repeating for the ipad */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
		/* Put your iPhone 4g styles in here */ 
		}

		/* Android targeting */
		@media only screen and (-webkit-device-pixel-ratio:.75){
		/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
		/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
		/* Put CSS for high density (hdpi) Android layouts in here */
		}
		/* end Android targeting */

	</style>

	<!-- Targeting Windows Mobile -->
	<!--[if IEMobile 7]>
	<style type="text/css">
	
	</style>
	<![endif]-->   

	<!-- ***********************************************
	****************************************************
	END MOBILE TARGETING
	****************************************************
	************************************************ -->

	<!--[if gte mso 9]>
		<style>
		/* Target Outlook 2007 and 2010 */
		</style>
	<![endif]-->
</head>
<body>
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
	<tr>
		<td valign="top">
			<?php if ($updateRegistration) { ?>	
				<h2>Din anmälan till <b><?php echo $event->{DB_EVENT_NAME}; ?></b> är nu uppdaterad</h2>		
			<?php } else { ?>
				<h2>Du är nu anmäld till <b><?php echo $event->{DB_EVENT_NAME}; ?></b></h2>
			<?php } ?>							
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="75">Datum:</td>
					<td>
						<b>
							<?php 
								echo formatDateGerman($event->{DB_EVENT_STARTDATE}); 
								if (isset($event->{DB_EVENT_ENDDATE}))	{
									echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
								}
								?>
						</b>
					</td>
				</tr>
				<tr>
					<td width="75">Plats:</td>			
					<td>
						<b><?php echo $event->{DB_EVENT_LOCATION}; ?></b>		
					</td>
				</tr>				
				<?php
					$totalSum = 0;
					if (isset($eventItems)) {		
						foreach($eventItems as $key => $eventItem) {								
							$totalSum += ($eventItem->{DB_EVENTITEM_AMOUNT} * $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT});
						}
					}
					if (isset($avecEventItems)) {		
						foreach($avecEventItems as $key => $eventItem) {								
							$totalSum += ($eventItem->{DB_EVENTITEM_AMOUNT} * $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT});
						}
					}				
				?>
				<tr>
					<td width="75">Totalt:</td>
					<td><b><?php echo formatCurrency($totalSum); ?></b></td>
				</tr>
			</table>
			<p>Betalning bör ske till Akademiska Sångföreningens konto FI97 4055 1810 0000 87 (BIC: HELSFIHH), ange som meddelande i betalningen "jubileum".</p>			
			<p><a href="<?php echo site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY; ?>/<?php echo $eventId; ?>/<?php echo $personId; ?>/<?php echo $hash; ?>"><b>Klicka här</b></a> för att ändra din anmälan.</p>
			<p><a href="<?php echo site_url() . CONTROLLER_EVENTS_CANCEL_REGISTER_DIRECTLY; ?>/<?php echo $eventId; ?>/<?php echo $personId; ?>/<?php echo $hash; ?>"><b>Klicka här</b></a> för att annulera din anmälan.</p>
			<?php if (isset($event->{DB_EVENT_REGISTRATIONDUEDATE})) { ?>
				<p>Det är möjligt att ändra eller annulera anmälningen fram till den <b><?php echo formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE}); ?></b>.</p>
			<?php } ?>
			<hr/>
			<p>
				<h3>Mina anmälningsuppgifter</h3>				
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="75">Namn:</td>
						<td><b><?php echo $person->{DB_PERSON_FIRSTNAME} . ' ' . $person->{DB_PERSON_LASTNAME}; ?></b></td>
					</tr>
					<tr>
						<td width="75">E-post:</td>
						<td><a href="mailto:<?php echo $person->{DB_PERSON_EMAIL}; ?>"><b><?php echo $person->{DB_PERSON_EMAIL}; ?></b></a></td>
					</tr>
					<tr>
						<td width="75">Telefon:</td>
						<td><b><?php echo $person->{DB_PERSON_PHONE}; ?></b></td>
					</tr>
					<?php if (isset($person->{DB_PERSON_ALLERGIES}) && $person->{DB_PERSON_ALLERGIES} != '') { ?>
					<tr>
						<td width="75">Allergier:</td>
						<td><b><?php echo $person->{DB_PERSON_ALLERGIES}; ?></b></td>
					</tr>
					<?php } ?>
				</table>
				<?php
					$previousCaption = "";
					if (isset($eventItems)) {		
						foreach($eventItems as $key => $eventItem) {					
							if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) {
								echo "<br/>" . $eventItem->{DB_EVENTITEM_CAPTION} . ":";
								echo "<br/>";
							}
							if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
								echo "<b>";
								if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) {
									echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION};
								}								
								echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
								if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
									 echo " - pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
								}
								echo "</b>";
								echo "<br/>";
							} else {
								echo "<b>";
								echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} . " st. ";
								echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
								if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
									 echo " - pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . " per styck";
								}
								echo "</b>";
								echo "<br/>";
							}
							$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
						}
					}
				?>													
			<?php
				if ($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} != NULL) {
			?>
				<h3>Min avecs anmälningsuppgifter</h3>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="75">Namn:</td>
						<td><b><?php echo $personAvec->{DB_PERSON_FIRSTNAME} . ' ' . $personAvec->{DB_PERSON_LASTNAME}; ?></b></td>
					</tr>
					<?php if (isset($personAvec->{DB_PERSON_ALLERGIES}) && $personAvec->{DB_PERSON_ALLERGIES} != '') { ?>
					<tr>
						<td width="75">Allergier:</td>
						<td><b><?php echo $personAvec->{DB_PERSON_ALLERGIES}; ?></b></td>
					</tr>
					<?php } ?>
				</table>								
			<?php
					$previousCaption = "";
					if (isset($avecEventItems)) {		
						foreach($avecEventItems as $key => $eventItem) {					
							if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) {
								echo "<br/>" . $eventItem->{DB_EVENTITEM_CAPTION} . ":";
								echo "<br/>";
							}
							if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
								echo "<b>";
								if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) {
									echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION};
								}								
								echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
								if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
									 echo "- pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
								}
								echo "</b>";
								echo "<br/>";
							} else {
								echo "<b>";
								echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} . " st. ";
								echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
								if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
									 echo "- pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . " per styck";
								}
								echo "</b>";
								echo "<br/>";
							}
							$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
						}
					}				
				} 
			?>
			</p>
		</td>
	</tr>
</table>  
<!-- End of wrapper table -->
</body>
</html>