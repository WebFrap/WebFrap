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
class DaidalosBdlNode_EntityAttribute_Create_Maintab_View extends WgtMaintab
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
  public function displayCreate(  $params )
  {

    $db = $this->model->getDb();
    
    $this->setLabel( 'Create Attribute' );
    $this->setTitle( 'Create Attribute' );

    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    
    $this->setTabId( 'wgt-tab-daidalos-bdl_entity_attribute-create' );
    
    $this->setTemplate( 'daidalos/bdl/node/entity/attribute/maintab/create' );
    
    
    //p: Selectbox Type
    $selectType = $this->newItem( 'selectType', 'BdlAttributeTypeKey_Selectbox' );
    $selectType->setFirstFree( ' ' );
    $queryType = $db->newQuery( 'BdlAttributeTypeKey_Selectbox' );

    $queryType->fetchSelectbox();
    $selectType->setData( $queryType->getAll() );
    
    //p: Selectbox Validator
    $selectValidator = $this->newItem( 'selectValidator', 'BdlAttributeValidatorKey_Selectbox' );
    $selectValidator->setFirstFree( ' ' );
    $queryValidator = $db->newQuery( 'BdlAttributeValidatorKey_Selectbox' );

    $queryValidator->fetchSelectbox();
    $selectValidator->setData( $queryValidator->getAll() );
    
    //p: Selectbox Definition
    $selectDefinition = $this->newItem( 'selectDefinition', 'BdlDefinitionKey_Selectbox' );
    $selectDefinition->setFirstFree( ' ' );
    $queryDefinition = $db->newQuery( 'BdlDefinitionKey_Selectbox' );

    $queryValidator->fetchSelectbox();
    $selectDefinition->setData( $queryDefinition->getAll() );

    $params = new TArray();
    $this->addMenu( $params );

  }//end public function displayCreate */


  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_EntityAttribute_Create'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );
    
    $menu->injectActions( $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdlNode_EntityAttribute_Create_Maintab_View

