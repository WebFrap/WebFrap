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
class WebfrapSecurity_Exception extends Webfrap_Exception
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  protected $debugMessage = 'Internal Error'; // unspecified error

  /**
   *
   * @var string
   */
  protected $errorKey     = Response::INTERNAL_ERROR; // unspecified error

  /**
   * Container der eine oder mehrere Fehlermeldungen enthält
   *
   * @var ErrorContainer
   */
  public $error     = null;

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
      $this->errorKey     = $message->getId();

      if ('cli' == $request->type)
        $response->writeLn($debugMessage);

      Error::addException($debugMessage, $this);
    } else {
      if (DEBUG && 'Internal Error' != $debugMessage && !is_numeric($debugMessage))
        parent::__construct($debugMessage);
      else
        parent::__construct($message);

      $this->debugMessage = $debugMessage;
      $this->errorKey     = $errorKey;

      if ('cli' == $request->type)
        $response->writeLn($message);

      Error::addException($message , $this);
    }

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return string
   */
  public function getDebugMessage()
  {
    return $this->debugMessage;

  }//end public function getDebugMessage */

  /**
   *
   * @return string
   */
  public function getErrorKey()
  {
    return $this->errorKey;

  }//end public function getErrorKey */

  /**
   * @param LibResponseHttp $response
   */
  public function publish($response)
  {

    if ($this->error) {
      $this->error->publish($response);
    } else {
      $response->addError($this->message);
    }

  }//end public function publish */

}//end class WebfrapUser_Exception

