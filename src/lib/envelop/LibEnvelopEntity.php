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
 * @subpackage tech_core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class LibEnvelopEntity
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the entity in the envelop
   * @var Entity
   */
  protected $entity = null;

  /**
   * Entity object of the data repository
   * @var EntityWbfsysDataRepository
   */
  protected $repository = null;

  /**
   * the id from the referencing system
   * @var string
   */
  protected $refId = null;

  /**
   * Pool with all to the entity connected Entities to build a net of entities
   * to save alle connected entities in one way
   * That makes it easier for developers to same the entities in the correct
   * order to solve all dependencies
   *
   * @var array<entity>
   */
  protected $singleRef = array();

  /**
   * List to be able to connect multiple references
   * @var array<entity>
   */
  protected $multiRef = array();

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    return $this->entity->$key;
  }//end public function __get */

  /**
   *
   * @param string $key
   * @param string $value
   * @return void
   */
  public function __set($key , $value)
  {
     $this->entity->$key = $value;
  }//end public function __set */

  /**
   *
   * @param string $repo
   * @param string $entity
   * @param string $refId
   * @return void
   */
  public function __construct($repo = null, $entity = null, $refId = null)
  {
    $this->repository = $repo;
    $this->entity = $entity;
    $this->refId = $refId;
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * set the reference id
   * @param string $id
   */
  public function getId($id)
  {
    return $this->entity->getId();
  }//end public function setRefId */

  /**
   * set the reference id
   * @param string $id
   */
  public function setRefId($id)
  {
    $this->refId = $id;
  }//end public function setRefId */

  /**
   * @return string
   */
  public function getRefId()
  {
    return $this->refId;
  }//end public function getRefId */

  /**
   * @return EntityWbfsysDataRepository
   */
  public function getRepository()
  {
    return $this->repository;
  }//end public function getRepository */

  /**
   * @return Entity
   */
  public function getEntity()
  {
    return $this->entity;
  }//end public function getEntity */

  /**
   *
   * @param string $key
   * @param Entity $entity
   * @return void
   */
  public function connect($key , $entity)
  {
    $this->singleRef[$key] = $entity;
  }//end public function connect */

  /**
   *
   * @param string $key
   * @param Entity $entity
   * @return void
   */
  public function append($key , $entity)
  {
    $this->multiRef[$key][$entity->getId()] = $entity;
  }//end public function append */

  /**
   * @getter
   * @return array<string:Entity>
   */
  public function getConnected()
  {
    return $this->singleRef;
  }//end public function getConnected */

  /**
   * @getter
   * @return array<array<scalar(int/uuid):Entity>>
   */
  public function getAppends()
  {
    return $this->multiRef;
  }//end public function getAppends */

}//end class LibEnvelopEntity

