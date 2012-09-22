<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo lang(LANG_KEY_LOGIN_HEADER); ?></title>	
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/libraries/normalize.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/libraries/jquery-ui.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/libraries/jquery.multiselect.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/main.css" />
	</head>
	<body>
		<div id="container" class="ui-corner-all">

    <h1><?php echo $event->Name?></h1>
    <h2>När: <?php echo $event->StartDate?></h2>
    <h2>Pris: <?php echo $event->Price?> €</h2>
    <h2>Beskrivning:</h2>
    <p><?php echo $event->Description?></p>
    
    <h2>Anmälningsinfo:</h2>
    <form>
      <p class="ui-state-error">TODO: Generate required fields!</p>
      <p class="ui-state-error">TODO: Figure out how to handle registered vs unregistered users!</p>
      
      <input id="submitRegistration" type="submit" value="Skicka anmälan!"/>
    </form>
    
    


