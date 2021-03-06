<div id="header_navitabs" style="clear: both; display: none">
	<ul>
		<li><a href="<?php echo CONTROLLER_MY_PAGE_DASHBOARD; ?>">Min sida</a></li>
		<?php if ($this->userrights->hasRight(userrights::EVENTS_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<li><a href="<?php echo CONTROLLER_EVENTS_LISTALL; ?>"><?php echo lang(LANG_KEY_FIELD_EVENT); ?></a></li>
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::TRANSACTIONS_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<li><a href="<?php echo CONTROLLER_TRANSACTIONS_LISTALL; ?>">Kvartettkonto</a></li>
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::USERS_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<li><a href="<?php echo CONTROLLER_PERSONS_LISTALL; ?>">Medlemmar</a></li>
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::WIKI_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<li><a href="/wiki/" target="_blank">Wiki</a></li>
		<?php } ?>
		<?php if ($this->userrights->hasRight(userrights::WIKI_VIEW, $this->session->userdata(SESSION_ACCESSRIGHT))) { ?>
			<li><a href="https://drive.google.com/drive/folders/1oj4PYk75asTbW-ANViGTfkerwVplIZxw" target="_blank">Övningsfiler</a></li>
		<?php } ?>
	</ul>
