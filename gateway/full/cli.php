#!/usr/bin/php
<?php
/*@interface.header@*/

try {

  if ( php_sapi_name() != 'cli' || !empty($_SERVER['REMOTE_ADDR']))
    die('Invalid Call');

  include './conf/bootstrap.cli.php';

  View::setType('Cli');

  $webfrap = Webfrap::init();

  // calling the main main function
  $webfrap->main();

  $webfrap->shutdown( );

} // ENDE TRY
catch( Exception $exception ) {
  $extType = get_class($exception);

  Error::addError
  (
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  LibTemplateCli::printErrorPage
  (
    $exception->getMessage(),
    $exception
  );

}
