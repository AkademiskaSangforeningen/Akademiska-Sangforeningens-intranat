<div id="container" class="ui-corner-all">
	<h1><?php echo "Kvartettkonton"; ?></h1>

  <table>
  <tr><th>Namn</th><th>KK</th></tr>
    <?php foreach ($persons as $person):?>

    <tr><td><?php echo "{$person[DB_PERSON_FIRSTNAME]} {$person[DB_PERSON_LASTNAME]}"; ?></td><td><?php echo "{$person['TotalBalance']} &euro;"; ?></td></tr>
    
    <?php endforeach;?>

  </table>
</div>
