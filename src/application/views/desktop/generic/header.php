<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $this->lang->line(LANG_KEY_LOGIN_HEADER); ?></title>	
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/libraries/normalize.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/libraries/jquery-ui.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/desktop/main.css" />
		
		<?php //TODO: Title som input från parenten? ?>
		<?php //<link rel="SHORTCUT ICON" href="img/favicon.png"> ?>
	</head>
	<body>
		<div id="container" class="ui-corner-all">
			<div>
				<div style="float: left">
					<h1><?php echo lang(LANG_KEY_LOGIN_HEADER); ?></h1>
				</div>
				<?php if ($this->session->userdata(SESSION_LOGGEDIN) == true) { ?>				
					<div style="float: right">
						<a href="#" id="button_mysettings" class="button" data-icon="ui-icon-gear"><?php echo $this->session->userdata(SESSION_NAME); ?></a>
						<a href="<?php echo base_url() . CONTROLLER_LOGIN_LOGOUT ?>" id="logout" class="button" data-icon="ui-icon-circlesmall-close">Logga ut</a>				
					</div>
				<?php } ?>				
			</div>
