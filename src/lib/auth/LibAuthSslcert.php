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
 */
class LibAuthSslcert
  extends LibAuthApdapter
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Prüfen ob es Authdata gibt
   * @return boolean
   */
  public function authDataAvailable( )
  {
  
    if( !isset( $_SERVER[X509_KEY_NAME] ) )
      return false; // no sso possible without cert

    return true;
  
  } //end public function authDataAvailable */
  
  /**
   * @param LibAuth $authobj
   * @return LibAuth
   */
  public function fetchLoginData( $authobj )
  {

    if( !isset( $_SERVER[X509_KEY_NAME] ) )
      return false; // no sso possible without cert

    $uid = $_SERVER[X509_KEY_NAME];

    $authobj->setUsername( $uid );

    // we need no passwd, we can asume that the user is the right user
    $authobj->setNoPasswd();

    return true;

  }//end public function fetchLoginData */


} // end class LibAuthSslcert

