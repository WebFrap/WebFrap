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
 * @subpackage Core
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class ProcessBase_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prozess Id
   * @var int
   */
  public $processId = null;

  /**
   * Key zum laden der passenden Entity
   * @var string
   */
  public $entityKey = null;

  /**
   * Die Id der Entity
   * @var int
   */
  public $entityId = null;

  /**
   * Die Entity
   * @var Entity
   */
  public $entity = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $processId
   */
  public function setProcessId($processId)
  {
    $this->processId =  $processId;
  }//end public function setProcessId */

  /**
   * @param string $entityKey
   */
  public function setEntityKey($entityKey)
  {
    $this->entityKey =  $entityKey;
  }//end public function setEntityKey */

  /**
   * @param int $entityId
   */
  public function setEntityId($entityId)
  {
    $this->entityId =  $entityId;
  }//end public function setEntityId */

  /**
   * @param string $entityKey
   * @param int $entityId
   */
  public function loadEntity($entityKey, $entityId)
  {

    $this->entityKey =  $entityKey;
    $this->entityId  =  $entityId;

    $entityKey    = SParserString::subToCamelCase($this->entityKey);
    $this->entity = $this->getDb()->getOrm()->get
    (
      $entityKey,
      $this->entityId
    );

  }//end public function loadEntity */

  /**
   * @param int $processId
   * @return ProcessBase_Query
   */
  public function getProcessEdges($processId)
  {

    $query = $this->getDb()->newQuery('ProcessBase');
    $query->fetchProcessEdges($processId);

    return $query;

  }//end public function getProcessEdges */

  /**
   * @return Entity
   */
  public function getEntity()
  {

    if (!$this->entity) {

      $entityKey = SParserString::subToCamelCase($this->entityKey);
      $this->entity = $this->getDb()->getOrm()->get
      (
        $entityKey,
        $this->entityId
      );

    }

    return $this->entity;

  }//end public function getEntity */

} // end class ProcessBase_Model

