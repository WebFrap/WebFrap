#!/usr/bin/php
<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

try {

  if( php_sapi_name() != 'cli' || !empty( $_SERVER['REMOTE_ADDR'] ) )
    die( 'Invalid Call' );

  include './conf/bootstrap.cli.php';

  View::setType('Cli');

  $webfrap = Webfrap::init();

  // calling the main main function
  $webfrap->main();

  $webfrap->shutdown( );

} // ENDE TRY
catch( Exception $exception ) {
  $extType = get_class( $exception );

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
