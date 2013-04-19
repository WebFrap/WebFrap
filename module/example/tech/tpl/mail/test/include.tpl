mail test

<?php

LibVendorEz::load();

try {

  if( Webfrap::classLoadable('ezcMailPop3Transport'))
    $pop3 = new ezcMailPop3Transport( "webfrap-servers.de" );

} catch(Exception $exc) {
  echo $exc;
}

?>