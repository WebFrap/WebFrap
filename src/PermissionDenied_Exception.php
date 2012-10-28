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
 * Exception welche geworfen wird denn der User etwas machen wollte für das er
 * keine Rechte hat
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class PermissionDenied_Exception
  extends InvalidRequest_Exception
{

  /**
   *
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct
  ( 
    $message = "You have no permission to execute this request!", 
    $debugMessage = 'Permission Denied', 
    $errorKey = Response::FORBIDDEN 
  )
  {

    if( is_object( $message ) )
    {
      
      if( DEBUG && 'Permission Denied' != $debugMessage )
        parent::__construct( $debugMessage );
      else
        parent::__construct( 'Multiple Errors' );
      
      $this->error = $message;
        
      $this->debugMessage = $debugMessage;
      $this->errorKey     = $message->getId();
  
      Error::addException( $debugMessage, $this );
    }
    else 
    {
      if( DEBUG && 'Permission Denied' != $debugMessage && !is_numeric($debugMessage) )
        parent::__construct( $debugMessage );
      else
        parent::__construct( $message );
        
      $this->debugMessage = $debugMessage;
      $this->errorKey     = $errorKey;
  
      Error::addException( $message , $this );
    }


  }//end public function __construct */

}//end class PermissionDenied_Exception */



