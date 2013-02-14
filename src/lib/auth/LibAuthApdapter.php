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
abstract class LibAuthApdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var LibRequestHttp
   */
  protected $httpRequest = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $httpRequest
   */
  protected function setHttpRequest($httpRequest )
  {
    $this->httpRequest = $httpRequest;
  }//end protected function setHttpRequest */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibAuth $authobj
   */
  public abstract function fetchLoginData($authobj );


} // end class LibAuthAbstract

