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
 * Basisklasse für Table Panels
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtPanelElementFilter
  extends WgtPanelElement
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $filters = null;

  /**
   * @var string
   */
  public $formId = null;
  
  /**
   * @var string
   */
  public $searchKey = null;
  
  /**
   * @var string
   */
  public $tableId = null;

  /**
   * @var BaseChild
   */
  public $env = null;

  /**
   * Container mit den Rechten
   * @var LibAclPermission
   */
  public $access = null;
  
  /**
   * Der Status des Filters
   * @var TFlag
   */
  public $filterStatus = null;

/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * when a table object is given, the panel is automatically injected in the
   * table object
   *
   * @param WgtTable $table
   */
  public function __construct( $env,  $table = null )
  {

    $this->env = $env;
    
    if( $table )
    {
      $this->tableId  = $table->id;
      $this->formId   = $table->searchForm;
    }

  }//end public function __construct */

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {
    return $this->env->getI18n();
  }//end public function getI18n */
  
  /**
   * @return User
   */
  public function getUser()
  {
    return $this->env->getUser();
  }//end public function getUser */
  
  /**
   * @return LibDbConnection
   */
  public function getDb()
  {
    return $this->env->getDb();

  }//end public function getDb */
  
  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {
    return $this->env->getAcl();

  }//end public function getAcl */
  
  /**
   * @param LibAclPermission $access
   */
  public function setAccess( $access )
  {
    
    $this->access = $access;
    
  }//public function setAccess  */

  
  /**
   * @param string $formId
   */
  public function setSearchForm( $formId )
  {
    
    $this->formId = $formId;
    
  }//public function setSearchForm  */
  
  /**
   * 
   * @param TFlag $filterStatus
   */
  public function setFilterStatus( $filterStatus )
  {
    
    $this->filterStatus = $filterStatus;
    
  }//public function setSearchForm  */

/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @return string
   */
  public function render()
  {
    
    $this->setUp();

    $html = '';

    $html .= $this->renderFilterArea();

    return $html;

  }//end public function render */

/*//////////////////////////////////////////////////////////////////////////////
// panel methodes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * Rendern der Filter
   * @return string
   */
  public function renderFilterArea()
  {
    
    $buttonBuilder = WgtButtonBuilder::getDefault();
    $html = '<div class="right inner" >'.$buttonBuilder->buildButtons( $this->filters ).'</div>';

    return $html;

  }//end public function panelMenu */


}//end class WgtPanelElementFilter


