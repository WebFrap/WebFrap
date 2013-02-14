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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlNode_EntityAttribute_Edit_Maintab_View extends WgtMaintab
{
  
  /**
   * @var DaidalosBdlNode_EntityAttribute_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayEdit($idx, $params )
  {

    $db = $this->model->getDb();
    
    $this->setLabel( 'Edit Attribute '.$idx );
    $this->setTitle( 'Edit Attribute '.$idx );

    $this->addVar( 'node', $this->model->node );
    $this->addVar( 'entityNode', $this->model->entityNode );
    
    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    
    $this->addVar( 'idx', $idx );
    
    $this->setTabId( 'wgt-tab-daidalos-bdl_entity-attribute-edit-'.$idx );
    
    $this->setTemplate( 'daidalos/bdl/node/entity/attribute/maintab/edit' );
    
    //p: Selectbox Type
    $selectType = $this->newItem( 'selectType', 'BdlAttributeTypeKey_Selectbox' );
    $selectType->setFirstFree( ' ' );
    $queryType = $db->newQuery( 'BdlAttributeTypeKey_Selectbox' );

    $queryType->fetchSelectbox();
    $selectType->setData($queryType->getAll() );
    
    //p: Selectbox Validator
    $selectValidator = $this->newItem( 'selectValidator', 'BdlAttributeValidatorKey_Selectbox' );
    $selectValidator->setFirstFree( ' ' );
    $queryValidator = $db->newQuery( 'BdlAttributeValidatorKey_Selectbox' );

    $queryValidator->fetchSelectbox();
    $selectValidator->setData($queryValidator->getAll() );
    
    //p: Selectbox Definition
    $selectDefinition = $this->newItem( 'selectDefinition', 'BdlDefinitionKey_Selectbox' );
    $selectDefinition->setFirstFree( ' ' );
    $queryDefinition = $db->newQuery( 'BdlDefinitionKey_Selectbox' );

    $queryDefinition->fetchSelectbox();
    $selectDefinition->setData($queryDefinition->getAll() );

    $params = new TArray();
    $this->addMenu($idx, $params );

  }//end public function displayEdit */


  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($idx, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_EntityAttribute_Edit'
    );
    /* @var $menu DaidalosBdlNode_EntityAttribute_Edit_Maintab_Menu */
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );
    
    $menu->injectActions($idx, $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdlNode_EntityAttribute_Edit_Maintab_View

