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


$mails = $connector->getRange(1, 10);

foreach( $mails as /* @var ezMail */ $mail ){

  echo 'Mail: <br />';
  echo 'Subject: '.$mail->subject.'<br />';
  echo 'From: '.htmlentities($mail->from).'<br />';

  $parts = $mail->fetchParts();
  foreach ( $parts as $part ){
    if ( $part instanceof ezcMailFile ) {
      echo "File: ".$part->contentDisposition->displayFileName.'<br />';
    } else if ( $part instanceof ezcMailText ) {
      echo "Plain: ".$part->text.'<br />';
    }
  }

}



} catch( Exception $exc ){

  echo $exc->getMessage().NL.'<br /><br />'.$exc;

}