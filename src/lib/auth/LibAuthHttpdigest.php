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
 * @subpackage core/auth
 */
class LibAuthHttpauth extends LibAuthApdapter
{

  //////////////////////////////////////////////////////////////////////////////*/
  // Attributes
  //////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prüfen ob es Authdata gibt
   * @return boolean
   */
  public function authDataAvailable( )
  {

    if ($this->httpRequest)
      $httpRequest = $this->httpRequest;
    else
      $httpRequest = Request::getActive();

    if (!$httpRequest->hasServer( 'PHP_AUTH_USER' ) )
      return false;

    if (!$httpRequest->hasServer( 'PHP_AUTH_PW' ) )
      return false;

    return true;

  } //end public function authDataAvailable */

  /**
   * @param LibAuth $data
   * @return LibAuth
   */
  public function fetchLoginData($authobj )
  {

    //$_SERVER['PHP_AUTH_USER']
    //$_SERVER['PHP_AUTH_PW']

    if ($this->httpRequest)
      $httpRequest = $this->httpRequest;
    else
      $httpRequest = Request::getActive();

    $username = $httpRequest->server( 'PHP_AUTH_USER', Validator::TEXT );
    $password = $httpRequest->server( 'PHP_AUTH_PW', Validator::PASSWORD );

    // if one of both is empty
    if (! $username || ! $password)
      return false;

    $authobj->setUsername ($username );
    $authobj->setPassword ($password );

    return true;

  } //end public function fetchLoginData */

  /**
   * @param string $digest
   * @return string
   */
  public function parseHttpDigest($digest )
  {

    preg_match_all
    (
      '@(username|nonce|uri|nc|cnonce|qop|response)=[\'"]?([^\'",]+)@',
      preg_quote($digest ),
      $token
    );

    $data = array_combine($token[1], $token[2]);

    // rückgabe nur wenn vollständig
    return (count($data)==7) ? $data : null;

  }//end public function http_digest_parse */

} // end class LibAuthHttpauth

