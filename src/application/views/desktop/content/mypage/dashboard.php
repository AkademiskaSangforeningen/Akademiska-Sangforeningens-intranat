<div id="tab_dashboard">
		Här visas din personliga information<br/>
    
    <div id=active_events>
    <h1>Kommande evenemang</h1>
    <table>
    <?php foreach($events as $key => $event): ?>
      <tr>
        <td><?php echo $event->StartDate ?></td>
        <td><?php echo $event->Name ?></td>
        <td><a href=<?php echo '"events/showevent/' . $event->Id . '"' ?> target="_blank">Anmäl!</a></td>
      </tr>
    <?php endforeach; ?>
    </table>
    </div>
	</div>
</div>

<script>
	var executeOnStart = function ($) {	
		
	};
</script>