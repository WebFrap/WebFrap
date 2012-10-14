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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtWindowMenu
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var string
   */
  public $content;

  /**
   *
   * @var string
   */
  public $view;

  /**
   *
   * @var User
   */
  public $user;

  /**
   *
   * @var string
   */
  public $id;

////////////////////////////////////////////////////////////////////////////////
// construct
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * Enter description here ...
   * @param unknown_type $view
   */
  public function __construct( $view = null )
  {
    $this->view = $view;
  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * Enter description here ...
   * @param int $id
   */
  public function setId( $id )
  {
    $this->id = $id;
  }//end public function setId */

  /**
   * @return User
   */
  public function getUser()
  {
    if(!$this->user)
      $this->user = User::getActive();

    return $this->user;
  }//end public function getUser */

  /**
   *
   */
  public function build()
  {
    return '<button type="menu" ><![CDATA['.$this->content.']]></button>';
  }//end public function build */

  /**
   *
   */
  public function buildSubwindow()
  {
    return '<button type="menu" ><![CDATA['.$this->content.']]></button>';
  }//end public function buildSubwindow */

  /**
   *
   */
  public function buildMainwindow()
  {
    return $this->content;
  }//end public function buildMainwindow */

  /**
   *
   */
  public function buildMaintab()
  {
    return $this->content;
  }//end public function buildMaintab */


}// end class WgtButton


