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

/**
 * Der Status dieses Fehlers ist nicht eindeutig definiert.
 * 
 * Eigentlich ist die Anfrage falsch, es könnte teilweise jedoch auf einen
 * Falschen link im System hinweisen.
 * 
 * Wenn der Verdacht auf einen falschen Link besteht muss geloggt werden.
 * 
 * Der Benutzer benötigt eine klare Fehlermeldung was er falsch gemacht hat, bzw
 * wichtiger wie er es richtig machen kann.
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class InvalidRequest_Exception
  extends WebfrapUser_Exception
{
////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct
  (
    $message = 'Sorry, this request was invalid.',
    $debugMessage = 'Invalid Request',
    $errorKey = Response::BAD_REQUEST
  )
  {

    $request = Webfrap::$env->getRequest();
    $response = Webfrap::$env->getResponse();

    if( is_int( $debugMessage ) )
      $response->setStatus( $debugMessage );
    else
      $response->setStatus( $errorKey );


    if( is_object( $message ) )
    {

      if( DEBUG && 'Invalid Request' != $debugMessage )
        parent::__construct( $debugMessage );
      else
        parent::__construct( 'Multiple Errors' );

      $this->error = $message;

      $this->debugMessage = $debugMessage;
      $this->errorKey     = $message->getId();

      if( 'cli' == $request->type )
        $response->writeLn( $debugMessage );

      Error::addException( $debugMessage, $this );
    }
    else
    {
      if( DEBUG && 'Invalid Request' != $debugMessage && !is_numeric($debugMessage) || !$message )
        parent::__construct( $debugMessage );
      else
        parent::__construct( $message );

      $this->debugMessage = $debugMessage;
      $this->errorKey     = $errorKey;

      if( 'cli' == $request->type )
        $response->writeLn( $message );

      Error::addException( $message , $this );
    }


  }//end public function __construct */

}//end InvalidRequest_Exception */



