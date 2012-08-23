<div id="header_navitabs" style="clear: both; display: none">
	<ul>		
		<li><a href="#tab_dashboard">Min sida</a></li>
		<li><a href="<?php echo CONTROLLER_EVENTS_LISTALL ?>"><?php echo lang(LANG_KEY_FIELD_EVENT); ?></a></li>
		<li><a href="<?php echo CONTROLLER_TRANSACTIONS_LISTALL ?>">Kvartettkonto</a></li>
		<li><a href="<?php echo CONTROLLER_PERSONS_LISTALL ?>">Medlemmar</a></li>
    
    <?php if($isTransactionAdmin) { ?> 
      <li><a href="<?php echo CONTROLLER_TRANSACTIONS_ADMIN_LISTALL ?>">Administrera KK</a></li>
    <?php } ?> 
	</ul>