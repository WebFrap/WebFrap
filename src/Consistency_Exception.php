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
 * Exception die im Controller geworfen wird um das bearbeiten einer Anfrage
 * des Benutzers entgültig ab zu brechen
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Consistency_Exception extends WebfrapUser_Exception
{

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   *
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct($message, $debugMessage = 'Consistency check failed', $errorKey = Error::PRECONDITION_FAILED)
  {

    if (is_object($message)) {
      
      if (DEBUG && 'Consistency check failed' != $debugMessage)
        parent::__construct($debugMessage);
      else
        parent::__construct('Multiple Errors');
      
      $this->error = $message;
      
      $this->debugMessage = $debugMessage;
      $this->errorKey = $message->getId();
      
      Error::addException($debugMessage, $this);
    } else {
      
      if (DEBUG && 'Consistency check failed' != $debugMessage && ! is_numeric($debugMessage))
        parent::__construct($debugMessage);
      else
        parent::__construct($message);
      
      $this->debugMessage = $debugMessage;
      $this->errorKey = $errorKey;
      
      Error::addException($message, $this);
    }
  
  } //end public function __construct */


}//end Consistency_Exception */



