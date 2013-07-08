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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Dset_Model extends AclMgmt_Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Entity der Connection Tabelle
   * @var Entity
   */
  public $conEntity = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * get all groups that have
   * @param int $idGroup
   * @param int $areaId
   * @param TArray $params
   */
  public function getGroups($params)
  {

    $db     = $this->getDb();
    $query  = $db->newQuery('AclMgmt_Dset');
    /* @var $query AclMgmt_Dset_Query  */

    $query->fetchGroups
    (
      $params
    );

    return $query;

  }//end public function getDatasetGroups */

  /**
   * request the id of the activ area
   * @return Entity
   */
  public function getEntity($id)
  {

    $orm = $this->getOrm();

    return $orm->get($this->domainNode->srcKey, $id);

  }//end public function getEntity */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysSecurityArea_Entity
  */
  public function getEntityWbfsysGroupUsers($objid = null)
  {

    $response = $this->getResponse();

    $entityWbfsysGroupUsers = $this->getRegisterd('entityWbfsysGroupUsers');

    //entity wbfsys_security_area
    if (!$entityWbfsysGroupUsers) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityWbfsysGroupUsers = $orm->get('WbfsysGroupUsers', $objid)) {
          $response->addError
          (
            $response->i18n->l
            (
              'There is no wbfsyssecurityarea with this id '.$objid,
              'wbfsys.security_area.message'
            )
          );

          return null;
        }

        $this->register('entityWbfsysGroupUsers', $entityWbfsysGroupUsers);

      } else {
        $entityWbfsysGroupUsers   = new WbfsysGroupUsers_Entity() ;
        $this->register('entityWbfsysGroupUsers', $entityWbfsysGroupUsers);
      }

    } elseif ($objid && $objid != $entityWbfsysGroupUsers->getId()) {
      $orm = $this->getOrm();

      if (!$entityWbfsysGroupUsers = $orm->get('WbfsysGroupUsers', $objid)) {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no wbfsyssecurityarea with this id '.$objid,
            'wbfsys.security_area.message'
          )
        );

        return null;
      }

      $this->register('entityWbfsysGroupUsers', $entityWbfsysGroupUsers);
    }

    return $entityWbfsysGroupUsers;

  }//end public function getEntityWbfsysGroupUsers */

  /**
   *
   * @param int $dsetId
   * @param int $areaId
   * @param TFlag $params named parameters
   * @return void
   */
  public function searchQualifiedUsers($dsetId, $areaId, $params)
  {

    $db     = $this->getDb();
    $query  = $db->newQuery('AclMgmt_Dset_Treetable');
    /* @var $query AclMgmt_Dset_Treetable_Query  */

    $condition = $this->getSearchCondition();

    $query->fetch
    (
      $dsetId,
      $areaId,
      $condition,
      $params
    );

    return $query;

  }//end public function searchQualifiedUsers */

  /**
   * just fetch the post data without any required validation
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryWbfsysGroupUsers($params)
  {

    $orm   = $this->getOrm();
    $data  = array();

    $data['group_users']  = $this->getEntityWbfsysGroupUsers();

    $tabData = array();

    foreach ($data as $tabName => $ent)
      $tabData = array_merge($tabData , $ent->getAllData($tabName));

    $tabData['group_users_date_start'] = null;
    $tabData['group_users_date_end']   = null;

    $userRole = $orm->get('WbfsysRoleUser', $data['group_users']->id_user  );

    $person = $orm->get('CorePerson', $userRole->id_person);

    $tabData['user'] = '('.$userRole->name.') '.
      (
        $person->lastname && $person->firstname
        ? $person->lastname.', '.$person->firstname
        : $person->lastname.$person->firstname
      );

    $tabData['role_user_name']   = $userRole->name;
    $tabData['role_user_rowid']  = $data['group_users']->id_user;

    return $tabData;

  }// end public function getEntryWbfsysGroupUsers */

  /**
   * process userinput and map it to seachconditions that can be injected
   * in the query object
   *
   * @return array
   */
  public function getSearchCondition()
  {

    $condition    = array();
    $httpRequest  = $this->getRequest();

    if ($free = $httpRequest->param('free_search' , Validator::TEXT))
      $condition['free'] = $free;

    return $condition;

  }//end public function getSearchCondition */

  /**
   * @param int $areaId
   * @param string $key
   * @param TArray $params
   */
  public function getUsersByKey($areaId, $key, $params)
  {

    $db     = $this->getDb();
    $query  = $db->newQuery('AclMgmt_Dset');
    /* @var $query AclMgmt_Dset_Query  */

    $query->fetchUsersByKey
    (
      $areaId,
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUsersByKey */


  /**
   * fetch the update data from the http request object
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchConnectData($params)
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();
    $response    = $this->getResponse();

    $entityWbfsysGroupUsers = new WbfsysGroupUsers_Entity;

    $this->conEntity = $entityWbfsysGroupUsers;

    $fields = array
    (
      'id_group',
      'id_user',
      'vid',
    );

    $httpRequest->validateUpdate
    (
      $entityWbfsysGroupUsers,
      'group_users',
      $fields,
      array('vid', 'id_group', 'id_user')
    );

    if (!$entityWbfsysGroupUsers->vid) {
      $response->addError
      (
        $response->i18n->l('Missing Related Dataset', 'wbf.message')
      );
    }

    if (!$entityWbfsysGroupUsers->id_group) {
      $response->addError
      (
        $response->i18n->l('Missing Group', 'wbf.message')
      );
    }

    if (!$entityWbfsysGroupUsers->id_user) {
      $response->addError
      (
        $response->i18n->l('Missing User', 'wbf.message')
      );
    }

    $entityWbfsysGroupUsers->id_area = $this->getAreaId();
    $entityWbfsysGroupUsers->partial = 0;

    $this->register('entityWbfsysGroupUsers', $entityWbfsysGroupUsers);

    // check if there where any errors if not fine
    if ($response->hasErrors())
      throw new InvalidRequest_Exception();

  }//end public function fetchConnectData */

  /**
   * check if the reference allready exists
   * @param Entity $entity
   * @return array<Entity> returns all duplicates which where found
   */
  public function checkUnique($entity = null)
  {

    $orm = $this->getOrm();

    if (!$entity)
      $entity =  $this->getRegisterd('entityWbfsysGroupUsers');

    return $orm->checkUnique
    (
      $entity ,
      array('id_area', 'id_group', 'id_user', 'vid')
    );

  }//end public function checkUnique */

  /**
   * the update method of the model
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function connect($params)
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();
    $response  = $this->getResponse();

    try {
      if (!$entityWbfsysGroupUsers = $this->getRegisterd('entityWbfsysGroupUsers')) {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbf.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array('key' => 'entityWbfsysGroupUsers')
          )
        );
      }

      if (!$orm->insert($entityWbfsysGroupUsers)) {
        $entityText = $entityWbfsysGroupUsers->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update {@label@}',
            'wbf.message',
            array('label' => $entityText)
          )
        );

      } else {

        // wenn ein benutzer der gruppe hinzugefügt wird, jedoch nur
        // in relation zu einem datensatz, dann bekommt er einen teilzuweisung
        // zu der gruppe in relation zur area des datensatzes
        // diese teilzuweisung vermindert den aufwand um in listen elementen
        // zu entscheiden in welcher form die alcs ausgelesen werden müssen
        if ($entityWbfsysGroupUsers->vid) {
          $partUser = new WbfsysGroupUsers_Entity;
          $partUser->id_user    = $entityWbfsysGroupUsers->id_user;
          $partUser->id_group   = $entityWbfsysGroupUsers->id_group;
          $partUser->id_area    = $entityWbfsysGroupUsers->id_area;
          $partUser->partial    = 1;
          $orm->insertIfNotExists($partUser, array('id_area','id_group','id_user','partial'));
        }

        $entityText = $entityWbfsysGroupUsers->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated  {@label@}',
            'wbf.message',
            array('label' => $entityText)
          )
        );

        $this->protocol
        (
          'Edited: '.$entityText,
          'edit',
          $entityWbfsysGroupUsers
        );

      }
    } catch (LibDb_Exception $e) {
      return new Error($e, Response::INTERNAL_ERROR);
    }

    if ($response->hasErrors()) {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    } else {
      return null;
    }


  }//end public function connect */


  /**
   * de:
   * löschen einer gruppen -> benutzer zuweisung
   *
   * @param int $objid
   * @return null|Error im fehlerfall
   */
  public function deleteUser($objid   )
  {

    // erst mal alle nötigen resourcen organisieren
    $orm       = $this->getOrm();
    $response  = $this->getResponse();

    try {
      $orm->delete('WbfsysGroupUsers', $objid);

      $response->addMessage
      (
        $response->i18n->l
        (
          'Successfully deleted the User Assignment {@label@}',
          'wbf.message',
          array('label' => $objid)
        )
      );

      $this->protocol
      (
        'Deleted User Assignment: '.$objid,
        'delete_right',
        array('WbfsysGroupUsers', $objid)
      );

    } catch (LibDb_Exception $e) {
      $response->addError
      (
        $response->i18n->l
        (
          'Failed to delete the User Assignment {@label@}',
          'wbf.message',
          array
          (
            'label' => $objid
          )
        )
      );

      return new Error($e);
    }

    return null;

  }//end public function deleteUser */

  /**
   * delete all users that are assigned to this group in relation to this area
   *
   * @param int $groupId the id of the group
   * @param int $areaId the id of the area
   * @param TFlag $params named parameters
   * @return void
   */
  public function cleanQfduGroup($groupId, $areaId, $params  )
  {

    $orm       = $this->getOrm();
    $response  = $this->getResponse();

    try {
      $orm->deleteWhere('WbfsysGroupUsers', " id_group={$groupId} and id_area={$areaId} ");

      $response->addMessage
      (
        $response->i18n->l
        (
          'Successfully deleted the User Assignment {@id@}',
          'wbf.message',
          array('id' => $groupId)
        )
      );

      $this->protocol
      (
        'Deleted User Assignment: '.$groupId,
        'delete_right',
        $this->domainNode->srcKey
      );

      return true;
    } catch (LibDb_Exception $e) {
      $response->addError
      (
        $response->i18n->l
        (
          'Failed to delete the User Assignment {@id@}',
          'wbf.message',
          array('id' => $groupId)
        )
      );
    }

  }//end public function cleanQfduGroup */

} // end class AclMgmt_Dset_Model */

