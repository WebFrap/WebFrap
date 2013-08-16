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
class PermissionDenied_Exception extends InvalidRequest_Exception
{

  protected $defMessage = "You have no permission to execute this request!";

  protected $defDebugMessage = 'The user tried to process an operation without the required permissions!';

  /**
   *
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct
  (
    $message = "You have no permission to execute this request!",
    $debugMessage = 'The user tried to process an operation without the required permissions!',
    $errorKey = Response::FORBIDDEN
  )
  {

    if (is_object($message)) {

      if (DEBUG && $this->defDebugMessage != $debugMessage)
        parent::__construct($debugMessage);
      else
        parent::__construct($message->getMessage());

      $this->error = $message;
      $this->debugMessage = $debugMessage;
      $this->errorKey = $message->getId();

      Error::addException($debugMessage, $this);
    } else {
      if (DEBUG && 'Permission Denied' != $debugMessage && !is_numeric($debugMessage))
        parent::__construct($debugMessage);
      else
        parent::__construct($message);

      $this->debugMessage = $debugMessage;
      $this->errorKey = $errorKey;

      Error::addException($message , $this);
    }

  }//end public function __construct */

}//end class PermissionDenied_Exception */

