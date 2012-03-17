<div id="container" class="ui-corner-all">
	<h1><?php echo "Kvartettkonton"; ?></h1>

  <ul>
  <?php foreach ($persons as $person):?>

  <li><?php echo "{$person[DB_PERSON_FIRSTNAME]} {$person[DB_PERSON_LASTNAME]}"; ?></li>

  <?php endforeach;?>
  </ul>

</div>
