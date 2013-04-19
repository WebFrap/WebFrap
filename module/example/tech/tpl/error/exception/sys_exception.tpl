<?php 

try {
  
  throw new WebfrapSys_Exception( 'Some Debug Message'  );
  
}
catch( Exception $e )
{
  echo $e;
}


?>