<?php
echo $header;
echo "\r\n";
echo "\r\n";
echo 'Datum: ' . formatDateGerman($event->{DB_EVENT_STARTDATE});
if (isset($event->{DB_EVENT_ENDDATE}))	{
	echo " - " . formatDateGerman($event->{DB_EVENT_ENDDATE}); 	
}
echo "\r\n";
echo 'Plats: ' . $event->{DB_EVENT_LOCATION};
echo "\r\n";
if ($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} != NULL) {
	echo lang(LANG_KEY_FIELD_PAYMENTTYPE) . ': ' . getEnumValue(ENUM_PAYMENTTYPE, $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE});
	echo "\r\n";
}
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
if ($totalSum > 0) {
	echo 'Totalt: ' . formatCurrency($totalSum);
	echo "\r\n";
}
if (($personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == ENUM_PAYMENTTYPE_BANK_ACCOUNT || $personHasEvent->{DB_PERSONHASEVENT_PAYMENTTYPE} == ENUM_PAYMENTTYPE_E_INVOICE) && $totalSum > 0) {
	echo "\r\n";
	echo strip_tags($event->{DB_EVENT_PAYMENTINFO});
	echo "\r\n";
}
echo "\r\n";
echo 'Klicka på länken nedan för att ändra din amälan:';
echo "\r\n";
echo '{unwrap}' . site_url() . CONTROLLER_EVENTS_EDIT_REGISTER_DIRECTLY . '/' .  $eventId . '/' . $personId . '/' . $hash . '{/unwrap}';
echo "\r\n";
echo "\r\n";
echo 'Klicka på länken nedan för att annullera din amälan:';
echo "\r\n";
echo '{unwrap}' . site_url() . CONTROLLER_EVENTS_CANCEL_REGISTER_DIRECTLY . '/' .  $eventId . '/' . $personId . '/' . $hash . '{/unwrap}';
echo "\r\n";
echo "\r\n";
if (isset($event->{DB_EVENT_REGISTRATIONDUEDATE})) {
	echo 'Det är möjligt att ändra eller annullera anmälningen fram till den ' . formatDateGerman($event->{DB_EVENT_REGISTRATIONDUEDATE});
	echo "\r\n";
}
echo "\r\n";
echo "\r\n";
echo 'Dina anmälningsuppgifter';
echo "\r\n";
echo 'Namn: ' . $person->{DB_PERSON_FIRSTNAME} . ' ' . $person->{DB_PERSON_LASTNAME};
echo "\r\n";
echo 'E-post: ' . $person->{DB_PERSON_EMAIL};
echo "\r\n";
echo 'Telefon: ' . $person->{DB_PERSON_PHONE};
echo "\r\n";
if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE && isset($person->{DB_PERSON_ALLERGIES}) && $person->{DB_PERSON_ALLERGIES} != '') {
	echo lang(LANG_KEY_FIELD_ALLERGIES) . ': ' . $person->{DB_PERSON_ALLERGIES};
	echo "\r\n";
}

$previousCaption = "";
if (isset($eventItems)) {		
	foreach($eventItems as $key => $eventItem) {					
		if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) {
			echo "\r\n" . $eventItem->{DB_EVENTITEM_CAPTION};
			if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA && $eventItem->{DB_EVENTITEM_DESCRIPTION} != '') {
				echo " (" . $eventItem->{DB_EVENTITEM_DESCRIPTION} . ")";
			}
			echo ":";
			echo "\r\n";
		}
		if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
			if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) {
				echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION};
			} else {								
				echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
			}
			if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
				 echo " " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
			}
			echo "\r\n";
		} else {
			echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} . " st. ";
			echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
			if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
				 echo " " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . " per styck";
			}
			echo "\r\n";
		}
		$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
	}
}

if ($personHasEvent->{DB_PERSONHASEVENT_AVECPERSONID} != NULL) {
	echo "\r\n";
	echo 'Din avecs anmälningsuppgifter';
	echo "\r\n";
	echo 'Namn: ' . $personAvec->{DB_PERSON_FIRSTNAME} . ' ' . $personAvec->{DB_PERSON_LASTNAME};
	echo "\r\n";
	if ($event->{DB_EVENT_CANUSERSSETALLERGIES} == TRUE && isset($personAvec->{DB_PERSON_ALLERGIES}) && $personAvec->{DB_PERSON_ALLERGIES} != '') {
		echo lang(LANG_KEY_FIELD_ALLERGIES) . ': ' . $personAvec->{DB_PERSON_ALLERGIES};
		echo "\r\n";
	}

	$previousCaption = "";
	if (isset($avecEventItems)) {		
		foreach($avecEventItems as $key => $eventItem) {					
			if ($eventItem->{DB_EVENTITEM_CAPTION} != $previousCaption) {
				echo "\r\n" . $eventItem->{DB_EVENTITEM_CAPTION};
				if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA && $eventItem->{DB_EVENTITEM_DESCRIPTION} != '') {
					echo " (" . $eventItem->{DB_EVENTITEM_DESCRIPTION} . ")";
				}
				echo ":";
				echo "\r\n";
			}
			if ($eventItem->{DB_EVENTITEM_MAXPCS} == 0) {
				if ($eventItem->{DB_EVENTITEM_TYPE} == EVENT_TYPE_TEXTAREA) {
					echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_DESCRIPTION};
				} else {							
					echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
				}
				if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
					 echo " " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT});
				}
				echo "\r\n";
			} else {
				echo $eventItem->{DB_TABLE_PERSONHASEVENTITEM . DB_PERSONHASEVENTITEM_AMOUNT} . " st. ";
				echo $eventItem->{DB_EVENTITEM_DESCRIPTION};
				if (!is_null($eventItem->{DB_EVENTITEM_AMOUNT})) {
					 echo " " . formatCurrency($eventItem->{DB_EVENTITEM_AMOUNT}) . " per styck";
				}
				echo "\r\n";
			}
			$previousCaption = $eventItem->{DB_EVENTITEM_CAPTION};
		}
	}				
}