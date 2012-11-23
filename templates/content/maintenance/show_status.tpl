<fieldset class="nearly_full" >
  <legend>show status</legend>

   <ul>
   <?php

   $conf = Conf::getInstance();

   foreach( $conf->status as $key => $value )
   {
     echo "<li><strong>{$key}:</strong>{$value}</li>".NL;
   }
   ?>
   </ul>

  <div class="wgt-clear small">&nbsp;</div>
</fieldset>