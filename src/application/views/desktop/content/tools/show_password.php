<div id="container" class="ui-corner-all">
	<p><?php echo "-- Password hash for '$username':"; ?><br/>
     <?php echo "-- $passwordHash"; ?></p>
  <p>
  INSERT INTO `person` (`Id`, `FirstName`, `LastName`, `Voice`, `Address`, `PostalCode`, `City`, `CountryId`, `Phone`, `Email`, `Allergies`, `Description`, `Status`, `Password`, `Created`, `CreatedBy`, `Modified`, `ModifiedBy`) VALUES
( UUID(), '<?php echo "$username"; ?>', 'Tester', '2B', NULL, NULL, NULL, NULL, NULL, '<?php echo "$username@test.akademen.com"; ?>', NULL, NULL, 0, 'test script', NOW(), '<?php echo "$passwordHash"; ?>', NULL, NULL);
  </p>
</div>
