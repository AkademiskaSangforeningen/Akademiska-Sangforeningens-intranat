<?php echo $header; ?>
<?php echo "\r\n"; ?>
<?php echo "\r\n"; ?>
Datum: <?php echo formatDateGerman($event->{DB_EVENT_STARTDATE}); 
	if (isset($event->{DB_EVENT_ENDDATE}))	{
		echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
	}
	?>
<?php echo "\r\n"; ?>
Plats: <?php echo $event->{DB_EVENT_LOCATION}; ?>
<?php echo "\r\n"; ?>
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
Totalt: <?php echo formatCurrency($totalSum); ?>
<?php echo "\r\n"; ?>
<?php echo "\r\n"; ?>
Betalning bör ske till Akademiska Sångföreningens konto FI97 4055 1810 0000 87 (BIC: HELSFIHH), ange som meddelande i betalningen "jubileum".
<?php echo "\r\n"; ?>
Klicka på länken nedan för att ändra din amälan
<?php echo "\r\n"; ?>
<?php echo site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY; ?>/<?php echo $eventId; ?>/<?php echo $personId; ?>/<?php echo $hash; ?>
<?php echo "\r\n"; ?>
<?php echo "\r\n"; ?>
Klicka på länken nedan för att annulera din amälan
<?php echo "\r\n"; ?>
<?php echo site_url() . CONTROLLER_EVENTS_CANCEL_REGISTER_DIRECTLY; ?>/<?php echo $eventId; ?>/<?php echo $personId; ?>/<?php echo $hash; ?>
<?php echo "\r\n"; ?>
<?php echo "\r\n"; ?>
<?php if (isset($event->{DB_EVENT_REGISTRATIONDUEDATE})) { ?>
	Det är möjligt att ändra eller annulera anmälningen fram till den <?php echo formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE}); ?>.
	<?php echo "\r\n"; ?>
<?php } ?>
<?php echo "\r\n"; ?>
<?php echo "\r\n"; ?>
Mina anmälningsuppgifter
<?php echo "\r\n"; ?>
Namn: <?php echo $person->{DB_PERSON_FIRSTNAME} . ' ' . $person->{DB_PERSON_LASTNAME}; ?>
<?php echo "\r\n"; ?>
E-post: <?php echo $person->{DB_PERSON_EMAIL}; ?>
<?php echo "\r\n"; ?>
Telefon: <?php echo $person->{DB_PERSON_PHONE}; ?>
<?php echo "\r\n"; ?>
<?php if (isset($person->{DB_PERSON_ALLERGIES}) && $person->{DB_PERSON_ALLERGIES} != '') { ?>
	Allergier: <?php echo $person->{DB_PERSON_ALLERGIES}; ?>
	<?php echo "\r\n"; ?>
<?php } ?>
<?php
	$previousCaption = "";
	if (isset($eventItems)) {		
		foreach($eventItems as $key => $eventItem) {					
			if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) {
				echo "\r\n" . $eventItem->{DB_EVENTITEM_CAPTION} . ":";
				echo "\r\n";
			}
			if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
				if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) {
					echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION};
				}								
				echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
				if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
					 echo " - pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
				}
				echo "\r\n";
			} else {
				echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} . " st. ";
				echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
				if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
					 echo " - pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . " per styck";
				}
				echo "\r\n";
			}
			$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
		}
	}
?>													
<?php if ($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} != NULL) { ?>
	<?php echo "\r\n"; ?>
	Min avecs anmälningsuppgifter
	<?php echo "\r\n"; ?>
	Namn: <?php echo $personAvec->{DB_PERSON_FIRSTNAME} . ' ' . $personAvec->{DB_PERSON_LASTNAME}; ?>
	<?php echo "\r\n"; ?>
	<?php if (isset($personAvec->{DB_PERSON_ALLERGIES}) && $personAvec->{DB_PERSON_ALLERGIES} != '') { ?>
		Allergier: <?php echo $personAvec->{DB_PERSON_ALLERGIES}; ?>
		<?php echo "\r\n"; ?>
	<?php } ?>
	<?php
	$previousCaption = "";
	if (isset($avecEventItems)) {		
		foreach($avecEventItems as $key => $eventItem) {					
			if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) {
				echo "\r\n" . $eventItem->{DB_EVENTITEM_CAPTION} . ":";
				echo "\r\n";
			}
			if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
				if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) {
					echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION};
				}								
				echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
				if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
					 echo " - pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
				}
				echo "\r\n";
			} else {
				echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} . " st. ";
				echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
				if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
					 echo " - pris: " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . " per styck";
				}
				echo "\r\n";
			}
			$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
		}
	}				
} 
?>