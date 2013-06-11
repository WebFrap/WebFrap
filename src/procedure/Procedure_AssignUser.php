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
 * Assign
 * @package WebFrap
 * @subpackage webfrap.core.procedures
 */
class Procedure_AssignUserToEntity extends Action
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
	/**
	 * @var string
	 */
  public $tableName = null;
  
	/**
	 * @var string
	 */
  public $srcKey = null;
  
  /**
	 * @var string
	 */
  public $userKey = null;

 
  /**
   * @param int $sourceId
   * @param int $userId
   * 
   * @return boolean, true wenn ein neues assignment angelegt wurde
   */
  public function assign($sourceId, $userId)
  {
    
    $orm = $this->getOrm();
    
    $conKey = SFormatStrings::subToCamelCase($this->tableName);
    
    
    $conEntity = $orm->getWhere(
      $conKey, 
      " $this->srcKey = {$sourceId} AND $this->userKey = {$userId} " 
    );
    
    if($conEntity)
    	return false;
		
    $conEntity = $orm->newEntity($conKey);
    $conEntity->{$this->srcKey} = $sourceId;
    $conEntity->{$this->userKey} = $userId;
    
    $orm->save($conEntity);
    
    return true;
    
    
  }//end public function assign */
  

} // end abstract class Procedure_AssignUser

