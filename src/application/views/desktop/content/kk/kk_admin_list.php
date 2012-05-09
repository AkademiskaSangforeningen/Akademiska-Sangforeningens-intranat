	<h1>Kvartettkonton</h1>
  <table>
  <tr><th>Namn</th><th>KK</th></tr>
    <?php foreach ($persons as $person):?>

    <tr><td><?php echo "{$person[DB_PERSON_LASTNAME]} {$person[DB_PERSON_FIRSTNAME]}"; ?></td><td><?php echo "{$person['TotalBalance']} &euro;"; ?></td></tr>
    
    <?php endforeach;?>

  </table>
