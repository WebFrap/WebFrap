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
 * @subpackage Core
 *
 */
class User_Stub extends User
{

  /**
   * @return User_Stub
   */
  public static function getStubObject()
  {
    return new User_Stub();
  }//end public function getStubObject */

  /**
   *
   * Enter description here ...
   * @param unknown_type $id
   */
  public function setId($id )
  {
    $this->userId = $id;
  }//ebd public function setId */

  /**
   * @param string $key
   */
  public  function switchUser($key )
  {
    $this->clean();
    $this->loadUserData($key);
  }//end public function switchUser */

} // end class User_Stub

