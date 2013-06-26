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
 * 
 * Many To Many referenz
 * 
 * @package WebFrap
 * @subpackage webfrap.core.procedures
 */
class BuizCore_AssignUserToEntity_Action extends Action
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param DomainRefNode $domainNode
   * @param int $srcId
   * @param int $targetId
   * 
   * @interface role_item_entity_ref
   * 
   * @return boolean, true wenn ein neues assignment angelegt wurde
   */
  public function assign($domainNode, $srcId, $targetId, $env = null)
  {
    
    $orm = $this->getOrm();
    
    $conKey = SFormatStrings::subToCamelCase($domainNode->connectionName);
    
    $srcKey = $domainNode->srcId;
    
    
    $targetKey = $domainNode->targetId;
    
    
    if ( !$srcId || !$targetId) {
    	$this->env->getResponse()->addError('Missing required information');
    }
    
    
    $conEntity = $orm->getWhere(
      $conKey, 
      " {$srcKey} = {$srcId} AND {$targetKey} = {$targetId} " 
    );
    
    if ($conEntity){
    	$this->env->getResponse()->addError("Assignment {$srcKey} = {$srcId} AND {$targetKey} = {$targetId} allready exists");
    	return true;
    }
		
    $conEntity = $orm->newEntity($conKey);
    $conEntity->{$srcKey} = $srcId;
    $conEntity->{$targetKey} = $targetId;
    
    // sollte nicht gespeichert werden können
    if(!$orm->save($conEntity)){
    	return false;
    }
    
    return true;
    
  }//end public function assign */
  

} // end class BuizCore_AssignUserToEntity_Action

