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
 * 
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class WebfrapSys_Exception extends Webfrap_Exception
{
/*//////////////////////////////////////////////////////////////////////////////
// Konstruktor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $userMessage Die Meldung welche der Systemanwender zu sehen bekommen wird
   * @param string $debugMessage Die Meldung an den Entwickler
   * @param int $errorKey ein Error Key analog zum HTTP Status
   * @param boolean $protocol soll der Fehler in der Datenbank protokolliert werden?
   */
  public function __construct(
    $debugMessage,
    $userMessage = 'undefined error',
    $errorKey = Response::INTERNAL_ERROR,
    $protocol = true,
    $dset = null,
    $mask = null
  ) {

    $request = Webfrap::$env->getRequest();
    $response = Webfrap::$env->getResponse();

    if (defined('DUMP_ERRORS')) {
      if (!DUMP_ERRORS)
        $protocol = false;
    }

    if ('undefined error' === $debugMessage)
      $debugMessage = Error::PROGRAM_BUG;

    if (DEBUG || WBF_RESPONSE_ADAPTER === 'cli') {
      //$userMessage = $debugMessage;
      parent::__construct($debugMessage);
    } else {
      parent::__construct($userMessage);
    }

    $this->debugMessage = $debugMessage;
    $this->errorKey = $errorKey;

    if ('cli' === $request->type)
      $response->writeLn($userMessage);

    Error::addException($userMessage , $this);

    if ($protocol) {
      $logger = LibProtocol_SystemError::getDefault();
      $logger->write(
        $debugMessage,
        $this->getTraceAsString(),
        $request,
        $mask,
        $dset
      );
    }

  }//end public function __construct */



}//end class WebfrapSys_Exception

