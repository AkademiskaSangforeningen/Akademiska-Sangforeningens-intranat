<div id="container" class="ui-corner-all">
   Testink.
   <table border=0>
      <?php
      echo "<tr><td>Förnamn</td><td>Efternamn</td><td>Status</td><td>Stämma</td><td>Email</td><td>Telefon</td></tr>";
	foreach($users as $key => $val)
        {
            echo "<tr>";
            foreach($users[$key] as $key2 => $val2)
            {
                if($key2!="Id")
                   echo "<td>$val2</td>";
            }
            echo "</tr>";
        }
      ?>
   </table>	 
   <?php
   //print_r($users);
   ?>
</div>
