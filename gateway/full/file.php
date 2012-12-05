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
  $webfrap = Webfrap::init();

  $request  = Request::getInstance();
  $key      = $request->get( 'f',Validator::CKEY );

  $tmp = explode( '-', $key );

  $id = (int)$tmp[2];

  if( $name = $request->get( 'n',Validator::TEXT ) )
  {
    $name = base64_decode($name);
  }
  else
  {
    $name = $id;
  }

  $fileName = PATH_GW.'data/uploads/'.$tmp[0].'/'.$tmp[1].SParserString::idToPath($id).'/'.$id;
  $contentType = 'application/octet-stream' ;

  // dummdämliche Fehlermeldung abfagen, dass der buffer leer ist
  if( BUFFER_OUTPUT )
  {
    $errors .= ob_get_contents();
    ob_end_clean();
  }


  header('Content-Type: '.$contentType);
  header('Content-Disposition: attachment;filename="'.urlencode($name).'"');
  header('ETag: '.md5_file($fileName));
  header('Content-Length: '.filesize( $fileName ));

  readfile($fileName);


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