<?php 
  
  $loader = new ExtensionLoader( 'index', 'data/docu/' );

  foreach( $loader as $file )
  {
    echo View::includeFile( PATH_GW.'data/docu/index/'.$file, $this ) ;
  }
    
?>
<div class="wgt-clear xxsmall">&nbsp;</div>

