mail test

<?php

$conf = Webfrap::$env->getConf();

$mail = $conf->getResource( 'mail', 'connections' );

$mailConf = $mail['default'];

try {
$connector = new LibConnector_Message_Ez($mailConf);
$connector->open();

echo "you have ".$connector->getNumMessages().' messages ';

echo "<ul><li>";
echo implode('</li><li>', $connector->listUniqueIdentifiers()) ;
echo "</li></ul>";

echo "<ul><li>";
echo implode('</li><li>', $connector->listMessages()) ;
echo "</li></ul>";


} catch( Exception $exc ){

  echo $exc->getMessage().NL.'<br /><br />'.$exc;

}