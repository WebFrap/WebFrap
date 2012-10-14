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
 * Always Thrown If A Class Not Exists
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class MethodNotExists_Exception
  extends WebfrapFlow_Exception
{
  
  /**
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct( $method, $arguments, $debugMessage = 'Internal Error', $errorKey = Response::INTERNAL_ERROR  )
  {

    $message = 'Method '.$method.' not exists.';
    
    if( is_object($message) )
    {
      
      if( DEBUG && 'Internal Error' != $debugMessage )
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
      if( DEBUG && 'Internal Error' != $debugMessage && !is_numeric($debugMessage) )
        parent::__construct( $debugMessage );
      else
        parent::__construct( $message );
        
      $this->debugMessage = $debugMessage;
      $this->errorKey     = $errorKey;
  
      Error::addException( $message , $this );
    }


  }//end public function __construct */
  
}//end class MethodNotExists_Exception 



