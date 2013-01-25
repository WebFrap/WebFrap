<?php 

  echo $VAR->menuPanel;
  
  if( '' != trim($VAR->entity->content) )
    echo $VAR->entity->content;
  else 
    echo "Sorry, this Help Page has no content yet";

?>

<div class="wgt-clear xxsmall">&nbsp;</div>

