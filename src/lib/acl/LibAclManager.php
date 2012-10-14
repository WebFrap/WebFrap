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
 * Webfrap Access Controll
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibAclManager
  extends BaseChild
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Das Modell zum laden der benötigten Daten
   * @var LibAcl_Db_Model
   */
  protected $model = null;

////////////////////////////////////////////////////////////////////////////////
// getter + setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * Getter mit Autocreate für das ACL Modell
   *
   * @return LibAcl_Db_Model
   */
  public function getModel(  )
  {

    if( !$this->model )
    {
      $this->model = new LibAcl_Db_Model( $this );
    }

    return $this->model;

  }//end public function getModel */
  
  /**
   * @param LibDbConnection $db
   */
  public function setDb( $db )
  {

    $this->db = $db;
    
    $model = $this->getModel();
    $model->setDb( $db );

  }//end public function setDb */

  /**
   * @param User $user
   */
  public function setUser( $user )
  {

    $this->user = $user;
    
    $model = $this->getModel();
    $model->setUser( $user );

  }//end public function setUser */
  
////////////////////////////////////////////////////////////////////////////////
// constructor
////////////////////////////////////////////////////////////////////////////////
  
  /**
   *
   * @param LibFlowApachemod $env
   */
  public function __construct( $env = null  )
  {

    if( !$env )
      $env = Webfrap::getActive();
    
    $this->env    = $env;
    
  }//end public function __construct */



}//end class LibAclAdapter

