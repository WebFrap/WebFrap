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
 * de:
 *
 * Basisklasse für die Dropmenüs in den Tabs und Subwindows,
 * wird hauptsächlich als html container verwendet.
 *
 * Der Einfachheit halben werden die Menüs in Markup Blöcken zusammengebaut
 * für jeden Knoten eine Objekt anzulegen bringt kaum vorteile, würde
 * die nötigen Resourcen zum erstellen des Menüs jedoch unnötig in die
 * Höhe treiben
 *
 * @package     WebFrap
 * @subpackage  tech_core
 * @author  dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class WgtDropmenu
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $content;

  /**
   * @var LibTemplate
   */
  public $view;

  /**
   * @var Model
   */
  public $model;

  /**
   * @var User
   */
  public $user;

  /**
   * de:
   * Das ACL Objekt für eine saubere verwaltung der Rechte
   * @var LibAclAdapter
   */
  public $acl;

  /**
   * de:
   * Die Html Id des Menü Elements
   * @var string
   */
  public $id;

////////////////////////////////////////////////////////////////////////////////
// construct
////////////////////////////////////////////////////////////////////////////////

  /**
   * de:
   * Konstruktor halt, keine Besonderheiten, beide Parameter optional
   * @param string $id
   * @param LibTemplate $view
   */
  public function __construct( $id = null, $view = null )
  {
    $this->id   = $id;
    $this->view = $view;
  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @setter WgtDropmenu::$id
   * @param int $id
   */
  public function setId( $id )
  {
    $this->id = $id;
  }//end public function setId */

  /**
   * @getter WgtDropmenu::$user
   * @return User
   */
  public function getUser()
  {
    if(!$this->user)
      $this->user = User::getActive();

    return $this->user;
  }//end public function getUser */


  /**
   * @setter WgtDropmenu::$view LibTemplate
   * @param LibTemplate $view
   */
  public function setView( $view )
  {
    $this->view = $view;
  }//end public function setView */

  /**
   *
   */
  public function getView()
  {
    if(!$this->view)
      $this->view  = View::getActive();

    return $this->view;

  }//end public function getView */

  /**
   * @setter WgtDropmenu::$model Model
   * @param Model $model
   */
  public function setModel( $model )
  {
    $this->model = $model;
  }//end public function setModel */

  /**
   * @return Model
   */
  public function getModel()
  {

    return $this->model;

  }//end public function getModel */

  /**
   * @setter WgtDropmenu::$acl LibAclAdapter
   * @param LibTemplate $acl
   */
  public function setAcl( $acl )
  {
    $this->acl = $acl;
  }//end public function setAcl */

  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {

    if( !$this->acl )
      $this->acl = Acl::getActive();

    return $this->acl;

  }//end public function getAcl */

/*//////////////////////////////////////////////////////////////////////////////
// Die Build Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {
    return '<button type="menu" ><![CDATA['.$this->content.']]></button>';
  }//end public function build */

  /**
   * @return string
   */
  public function buildSubwindow()
  {
    return '<button type="menu" ><![CDATA['.$this->content.']]></button>';
  }//end public function buildSubwindow */

  /**
   * @return string
   */
  public function buildMainwindow()
  {
    return $this->content;
  }//end public function buildMainwindow */

  /**
   * @return string
   */
  public function buildMaintab()
  {
    return $this->content;
  }//end public function buildMaintab */


}// end class WgtDropmenu


