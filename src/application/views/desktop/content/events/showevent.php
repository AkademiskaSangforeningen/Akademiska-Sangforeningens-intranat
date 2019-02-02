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
    
    


