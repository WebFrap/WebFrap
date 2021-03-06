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
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class WebfrapConfig_Exception extends Webfrap_Exception
{
/*//////////////////////////////////////////////////////////////////////////////
// Konstruktor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $message
   * @param string $debugMessage
   * @param int $errorKey
   */
  public function __construct($message, $debugMessage = 'Internal Error', $errorKey = Response::INTERNAL_ERROR  )
  {

    $request = Webfrap::$env->getRequest();
    $response = Webfrap::$env->getResponse();

    if (is_object($message)) {

      if (DEBUG && 'Internal Error' != $debugMessage)
        parent::__construct($debugMessage);
      else
        parent::__construct('Multiple Errors');

      $this->error = $message;

      $this->debugMessage = $debugMessage;
      $this->errorKey = $message->getId();

      if ('cli' == $request->type)
        $response->writeLn($debugMessage);

      Error::addException($debugMessage, $this);
    } else {
      if (DEBUG && 'Internal Error' != $debugMessage && !is_numeric($debugMessage))
        parent::__construct($debugMessage);
      else
        parent::__construct($message);

      $this->debugMessage = $debugMessage;
      $this->errorKey = $errorKey;

      if ('cli' == $request->type)
        $response->writeLn($message);

      Error::addException($message , $this);
    }

  }//end public function __construct */



}//end class WebfrapConfig_Exception

