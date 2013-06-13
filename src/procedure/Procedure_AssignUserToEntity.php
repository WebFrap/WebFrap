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
class Procedure_AssignUserToEntity extends Action
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/
 
 
  /**
   * @param DomainRefNode $domainNode
   * @param int $srcId
   * @param int $targetId
   * 
   * @return boolean, true wenn ein neues assignment angelegt wurde
   */
  public function assign($domainNode, $srcId, $targetId, $env = null)
  {
    
    $orm = $this->getOrm();
    
    $conKey = SFormatStrings::subToCamelCase($domainNode->connectionName);
    
    $srcKey = $domainNode->srcId;
    $targetKey = $domainNode->targetId;
    
    
    $conEntity = $orm->getWhere(
      $conKey, 
      " {$srcKey} = {$srcId} AND {$targetKey} = {$targetId} " 
    );
    
    if ($conEntity)
    	return false;
		
    $conEntity = $orm->newEntity($conKey);
    $conEntity->{$srcKey} = $srcId;
    $conEntity->{$targetKey} = $targetId;
    
    $orm->save($conEntity);
    
    return true;
    
  }//end public function assign */
  

} // end abstract class Procedure_AssignUserToEntity

