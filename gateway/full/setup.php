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

try
{

  include './conf/bootstrap.php';

  // Buffer Output
  if(BUFFER_OUTPUT)
    ob_start();

  $errors = '';

  View::setType('Html');
  $webfrap = Webfrap::init();

  // calling the main main function
  $webfrap->redirectByKey('tripple.setup');
  $errors = $webfrap->out();
  $webfrap->shutdown( $errors );

} // ENDE TRY
catch( Exception $exception )
{
  $extType = get_class($exception);

  Error::addError
  (
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  if( BUFFER_OUTPUT )
  {
    $errors .= ob_get_contents();
    ob_end_clean();
  }

  if( !DEBUG )
  {
    if( isset($view) and is_object($view) )
    {
      $view->publishError( $exception->getMessage() , $errors );
    }
    else
    {
      View::printErrorPage
      (
        $exception->getMessage(),
        '500',
        $errors
      );
    }
  }
  else
  {
    echo $errors;
  }

}