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
class WgtPanelElement
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die HTML Id
   * @var string
   */
  public $id = null;

  /**
   * @var Base
   */
  public $env = null;

  /**
   * @var LibI18nPhp
   */
  public $i18n = null;

  /**
   * @var User
   */
  public $user = null;

  /**
   * @var LibAclAdapter
   */
  public $acl = null;

  /**
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * Container mit den Rechten
   * @var LibAclPermission
   */
  public $access = null;

  /**
   * @var TArray
   */
  public $accessPath = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {

    if (!$this->i18n)
      $this->i18n = I18n::getActive();

    return $this->i18n;

  }//end public function getI18n */

  /**
   * @return User
   */
  public function getUser()
  {
    if (!$this->user)
      $this->user = User::getActive();

    return $this->user;

  }//end public function getUser */

  /**
   * @return LibDbConnection
   */
  public function getDb()
  {
    if (!$this->db)
      $this->db = Db::getActive();

    return $this->db;

  }//end public function getDb */

  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {
    if (!$this->acl)
      $this->acl = Acl::getActive();

    return $this->acl;

  }//end public function getAcl */

  /**
   * @param LibAclPermission $access
   */
  public function setAccess($access)
  {

    $this->access = $access;

  }//public function setAccess  */

  /**
   * ID aus einem Key generieren lassen
   * @param string $key
   */
  public function setIdByKey($key)
  {
    $this->id = 'wgt-cntrl-'.$key;
  }//end public function setIdByKey */

/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * set up the panel data
   */
  public function setUp()
  {

  }//end public function setUp */

  /**
   * @return string
   */
  public function render()
  {

    $this->setUp();

    $html = '';

    return $html;

  }//end public function render */

  /**
   * @return string
   */
  public function build()
  {

    $html = '';

    $html .= $this->render();

    return $html;

  }//end public function build */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $name
   * @param string $alt
   * @param string $size
   * @return string
   */
  protected function icon($name, $alt, $size = 'xsmall')
  {
    return Wgt::icon($name, $size, array('alt'=>$alt));
  }//end public function icon */

}//end class WgtPanelElement

