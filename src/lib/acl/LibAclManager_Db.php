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
 * Manager Class zum bearbeiten der ACLs
 *
 * @package WebFrap
 * @subpackage tech_core
 *
 * @todo die queries müssen noch in query objekte ausgelagert werden
 *
 */
class LibAclManager_Db extends LibAclManager
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibAclAdapter_Db $adapter
   */
  public function __construct($adapter )
  {

    $this->env    = $adapter;
    $this->model  = $adapter->getModel();

  }//end public function __construct */

  /**
   * Erstellen eines neuen Gruppen / Secarea assignment
   *
   * @param WbfsysSecurityAccess_Entity $entityAccess
   * @param array $parents liste mit parent security areas, wird expliziet übergeben
   * @param boolean $syncMode im syncmode ist es kein fehler wenn ein assigment bereits existiert
   *
   * @return void Wirft im Fehlerfall eine Exception, keien Rückgabe nötig
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function createAreaAssignment($entityAccess, $parents = array(), $syncMode = false )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    // sicher stellen, dass auch alle Daten vorhanden sind
    if (!$entityAccess->id_area) {
      throw new LibAcl_Exception( "Missing required data: Area" );
    }

    if (!$entityAccess->id_group) {
      throw new LibAcl_Exception( "Missing required data: Group" );
    }

    // per definition nicht partiell
    $entityAccess->partial       = 0;

    // im syncmode wird
    if ($syncMode) {
      $orm->insertIfNotExists($entityAccess, array( 'id_area', 'id_group', 'partial' ) );
    } else {
      if (!$orm->insert($entityAccess ) ) {

        $entityText = $entityAccess->text();
        throw new LibAcl_Exception( 'Failed to create the new Assignment for '.$entityText );

      }
    }

    foreach ($parents as $parent) {

      // partielle zuweisung zu den parents
      $partial = new WbfsysSecurityAccess_Entity( null, array(), $this->getDb() );
      $partial->id_area       = $orm->getByKey( 'WbfsysSecurityArea', $parent );
      $partial->id_group      = $entityAccess->id_group;
      $partial->partial       = 1;
      $partial->access_level  = Acl::LISTING;
      $orm->insertIfNotExists($partial, array( 'id_area', 'id_group', 'partial' ) );

    }

  }//end public function createAreaAssignment */

  /**
   * Weißt einen User einer Gruppe korrekt zu
   *
   * @param WbfsysGroupUsers_Entity $entityGUser
   *
   * @return void Wirft im Fehlerfall eine Exception, keine Rückgabe nötig
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function createGroupAssignment
  (
    $entityGUser,
    $groupName = null,
    $areaName = null,
    $entity = null
  )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    if ( is_object($entityGUser) &&  $entityGUser instanceof User ) {
      $entityGUser = $entityGUser->getId();
    }

    // wenn nur ein User übergeben wird, muss das assignment selbst zusammen gebaut werden
    if ( is_numeric($entityGUser) || $entityGUser instanceof  WbfsysRoleUser_Entity   ) {

      $entityUser = $entityGUser;

      $entityGUser = new WbfsysGroupUsers_Entity(null,array(),$this->getDb());
      $entityGUser->id_user  = $entityUser;

      if ($groupName) {
        if ( is_string($groupName ) ) {
          $entityGUser->id_group = $orm->getByKey( 'WbfsysRoleGroup', $groupName  );
        } else {
          $entityGUser->id_group = $groupName;
        }
      }

      if ($areaName) {

        $area = $orm->getByKey( 'WbfsysSecurityArea', $areaName  );

        if (!$area) {
          throw new LibAcl_Exception
          (
            "Tried to assign a user: ".$entityGUser->text()." group: "
              .$groupName." in relation to a nonexisting security area: ".$areaName
          );
        }

        $entityGUser->id_area = $area;

      }

      if ($entity )
        $entityGUser->vid = $entity;
    }

    // sicher stellen, dass auch alle Daten vorhanden sind
    if (!$entityGUser->id_user || !$entityGUser->id_group) {
      throw new LibAcl_Exception( "Missing required data: User or Group {$entityGUser->id_user} || {$entityGUser->id_group}" );
    }

    // per definition nicht partiell
    $entityGUser->partial       = 0;

    $orm->insertIfNotExists
    (
      $entityGUser,
      array
      (
        'id_area',
        'id_group',
        'id_user',
        'vid',
        'partial'
      )
    );

    // wenn ein benutzer der gruppe hinzugefügt wird, jedoch nur
    // in relation zu einem datensatz, dann bekommt er einen teilzuweisung
    // zu der gruppe in relation zur area des datensatzes
    // diese teilzuweisung vermindert den aufwand um in listen elementen
    // zu entscheiden in welcher form die alcs ausgelesen werden müssen
    if ($entityGUser->id_area) {

      $partUser = new WbfsysGroupUsers_Entity( null, array(), $db );
      $partUser->id_user    = $entityGUser->id_user;
      $partUser->id_group   = $entityGUser->id_group;
      $partUser->partial  = 1;
      $orm->insertIfNotExists($partUser, array('id_area','id_group','id_user','vid','partial') );

      // ohne area kein vid
      if ($entityGUser->vid) {
        $partUser = new WbfsysGroupUsers_Entity( null, array(), $db );
        $partUser->id_user    = $entityGUser->id_user;
        $partUser->id_group   = $entityGUser->id_group;
        $partUser->id_area    = $entityGUser->id_area;
        $partUser->partial    = 1;
        $orm->insertIfNotExists($partUser, array('id_area','id_group','id_user','vid','partial') );
      }

    }

  }//end public function createGroupAssignment */

  /**
   * Zählen wieviele Assignments es aktuell zu einer Gruppe gibt
   *
   * @param WbfsysGroupUsers_Entity $entityGUser
   *
   * @return void Wirft im Fehlerfall eine Exception, keine Rückgabe nötig
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function countGroupAssignment
  (
    $group = null,
    $area = null,
    $entity = null,
    $inherit = false
  )
  {

    if ($area) {
      $keyData  = $this->model->extractWeightedKeys($area );
    } else {
      $keyData = null;
    }

    return $this->model->countGroupAssignment($group, $keyData, $entity, $inherit  );

  }//end public function countGroupAssignment */

  /**
   * Die Zuweisung zu einer Gruppe sauber auflösen
   *
   * @param WbfsysGroupUsers_Entity $entityGUser
   *
   * @return void Wirft im Fehlerfall eine Exception, keine Rückgabe nötig
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function removeGroupAssignment
  (
    $entityGUser,
    $groupName = null,
    $areaName = null,
    $entity = null
  )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    $userId   = null;
    $groupId  = null;
    $areaId   = null;
    $dsetId   = null;

    if ($entityGUser instanceof WbfsysGroupUsers_Entity) {

      $userId   = $entityGUser->id_user;
      $groupId  = $entityGUser->id_group;
      $areaId   = $entityGUser->id_area;
      $dsetId   = $entityGUser->vid;

      $orm->delete($entityGUser );

    } elseif ($entityGUser instanceof  WbfsysRoleUser_Entity || is_numeric($entityGUser) ) {

      $userId   = (string) $entityGUser;
      $groupId  = null;
      $areaId   = null;
      $dsetId   = null;

      if ($groupName) {
        if ( is_string($groupName ) ) {
          $groupId= $orm->getByKey( 'WbfsysRoleGroup', $groupName  );
        } else {
          $groupId = $groupName;
        }
      }

      if ($areaName) {

        $area = $orm->getByKey( 'WbfsysSecurityArea', $areaName  );

        if (!$area) {
          throw new LibAcl_Exception
          (
            "Tried to assign a user: ".$entityGUser->text()." group: "
              .$groupName." in relation to a nonexisting security area: ".$areaName
          );
        }

        $areaId = $area->getId();

      }

      if ($entity) {
        if ( is_object($entity) )
          $dsetId = $entity->getId();
        else
          $dsetId = $entity;
      }

      $whereDelete = "id_group = {$groupId}"
        ." and id_user = {$userId}"
        ." and ( partial = 0 or partial is null )";

      if ($areaId) {
        $whereDelete .=" and id_area = {$areaId}";
      } else {
        $whereDelete .=" and id_area is null";
      }

      if ($dsetId) {
        $whereDelete .=" and vid = {$dsetId}";
      } else {
        $whereDelete .=" and vid is null";
      }

      $orm->deleteWhere( 'WbfsysGroupUsers', $whereDelete );

    }

    if ($dsetId) {

      $whereCount = "id_area = {$areaId}"
        ." and id_group = {$groupId}"
        ." and id_user = {$userId}"
        ." and vid = {$dsetId} "
        ." and ( partial = 0 or partial is null )";

      $whereDelete = "id_area = {$areaId}"
        ." and id_group = {$groupId}"
        ." and id_user = {$userId}"
        ." and vid = {$dsetId} "
        ." and partial = 1";

      if (!$orm->countRows( 'WbfsysGroupUsers', $whereCount ) )
        $orm->deleteWhere( 'WbfsysGroupUsers', $whereDelete );
    }

    if ($areaId) {

      $whereCount = "id_area = {$areaId}"
        ." and id_group = {$groupId}"
        ." and id_user = {$userId}"
        ." and ( partial = 0 or partial is null )";

      $whereDelete = "id_area = {$areaId}"
        ." and id_group = {$groupId}"
        ." and id_user = {$userId}"
        ." and partial = 1";

      if (!$orm->countRows( 'WbfsysGroupUsers', $whereCount ) )
        $orm->deleteWhere( 'WbfsysGroupUsers', $whereDelete );
    }

    $whereCount = "id_group = {$groupId}"
      ." and id_user = {$userId}"
      ." and ( partial = 0 or partial is null )";

    $whereDelete = "id_group = {$groupId}"
      ." and id_user = {$userId}"
      ." and partial = 1";

    if (!$orm->countRows( 'WbfsysGroupUsers', $whereCount ) )
      $orm->deleteWhere( 'WbfsysGroupUsers', $whereDelete );

  }//end public function createGroupAssignment */

  /**
   * Alle Relationen zu einem bestimmten Datensatz löschen
   *
   * @param int $relId
   *
   * @return TDataObject mit den nötigen Metadaten um das UI anzupassen
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function deleteAssgignmentById($relId )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    if ( is_object($relId ) ) {
      $entity = $relId;
      $relId  = $entity->getId();
    } else {
      $entity = $orm->get( 'WbfsysGroupUsers', $relId  );
    }

    if (!$entity) {
      throw new LibAcl_Exception( "Assignment not exists" );
    }

    $asgdData = new TDataObject();

    $asgdData->id      = $relId;
    $asgdData->userId  = $entity->id_user;
    $asgdData->groupId = $entity->id_group;
    $asgdData->areaId  = $entity->id_area;
    $asgdData->dsetId  = $entity->vid;

    /* @var $cModel LibAcl_Db_Maintiner_Model */
    $cModel = $this->getMaintainerModel();

    $cModel->deleteRoleAssignmentById($relId );

    // wenn keine direkten assignments mehr vorhanden sind
    if (!$cModel->hasUserRoleAssignmentsSingleArea($asgdData->userId, $asgdData->groupId, $asgdData->areaId ) ) {
      // müssen die partial assignment flags gelöscht werden
      $cModel->cleanUserRoleAssignmentsSingleArea($asgdData->userId, $asgdData->groupId, $asgdData->areaId );
    }

    return $asgdData;

  }//end public function deleteDatasetRelationById */

  /**
   * Löschen Aller Assignments von einem User zu einer Rolle
   *   Kann in Relation zu einer Area sein
   *
   * @param int $userId
   * @param int $groupId
   * @param int $areaId
   */
  public function deleteUserRoleAssignments($userId, $groupId, $areaId = null )
  {

    /* @var $cModel LibAcl_Db_Maintainer_Model */
    $cModel = $this->getMaintainerModel();

    $cModel->cleanUserRoleAssignmentsSingleArea($userId, $groupId, $areaId );

  }//end public function deleteUserRoleAssignments */

  /**
   * Löschen Aller Assignments von einem User zu einem Datensatz
   *   Kann in Relation zu einer Area sein
   *
   * @param int $userId
   * @param int $dsetId
   * @param int $areaId
   */
  public function deleteUserDsetAssignments($userId, $dsetId, $areaId = null )
  {

    /* @var $cModel LibAcl_Db_Maintainer_Model */
    $cModel = $this->getMaintainerModel();

    $cModel->cleanUserDsetAssignmentsSingleArea($userId, $dsetId, $areaId );

  }//end public function deleteUserDsetAssignments */

  /**
   * Löschen Aller Assignments von einem User zu einem Datensatz
   *   Kann in Relation zu einer Area sein
   *
   * @param int $userId
   * @param int $dsetId
   * @param int $areaId
   */
  public function deleteUserAssignments($userId,  $areaId = null )
  {

    /* @var $cModel LibAcl_Db_Maintainer_Model */
    $cModel = $this->getMaintainerModel();

    $cModel->cleanUserAssignmentsSingleArea($userId,  $areaId );

  }//end public function deleteUserAssignments */

  /**
   * Löschen Aller Assignments von einem User zu einem Datensatz
   *   Kann in Relation zu einer Area sein
   *
   * @param int $userId
   * @param int $dsetId
   * @param int $areaId
   */
  public function deleteGroupAssignments($groupId,  $areaId = null )
  {

    /* @var $cModel LibAcl_Db_Maintainer_Model */
    $cModel = $this->getMaintainerModel();

    $cModel->cleanGroupAssignmentsSingleArea($groupId,  $areaId );

  }//end public function deleteGroupAssignments */

  /**
   * Alle Relationen zu einem bestimmten Datensatz löschen
   *
   * @param Entity $entity
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function cleanDatasetRelations($entity )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    $dsetId = null;

    if ( is_object($entity) ) {
      $dsetId = $entity->getId();
    } else {
      $dsetId = $entity;
    }

    if (!ctype_digit($dsetId) ) {
      throw new LibAcl_Exception( "Tried to clean Relations with an invalid ID ".$dsetId );
    }

    $orm->deleteWhere( 'WbfsysGroupUsers', " vid = {$dsetId}" );

  }//end public function cleanDatasetRelations */

  /**
   * Alle Relationen zu einem bestimmten Datensatz löschen
   *
   * @param Entity $entity
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function cleanUserRelations($user )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    $dsetId = null;

    if ( is_object($user) ) {
      $userId = $user->getId();
    } else {
      $userId = $user;
    }

    if (!ctype_digit($userId) ) {
      throw new LibAcl_Exception( "Tried to clean Relations with an invalid ID ".$userId );
    }

    $orm->deleteWhere( 'WbfsysGroupUsers', " id_user = {$userId}" );

  }//end public function cleanUserRelations */

  /**
   * Weißt einen User einer Gruppe korrekt zu
   *
   * @param WbfsysUserProfile_Entity $entityUserProfile
   * @param WbfsysProfile_Entity $entityProfile
   * @param WbfsysRoleUser_Entity $entityUser
   *
   * @return void Wirft im Fehlerfall eine Exception, keine Rückgabe nötig
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function assignUserProfile
  (
    $entityUserProfile,
    $entityProfile = null,
    $entityUser = null,
    $accessKey = null
  )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    if ($entityUserProfile instanceof User) {
      $entityUser = $entityUserProfile->getId();
    }

    // wenn nur ein User übergeben wird, muss das assignment selbst zusammen gebaut werden
    if ($entityUserProfile instanceof  WbfsysRoleProfile_Entity || is_numeric($entityUserProfile) ) {

      $entityUser = $entityUserProfile;

      $entityUserProfile = new WbfsysRoleProfile_Entity(null,array(),$this->getDb());
      $entityUserProfile->id_user  = $entityUser;

      if ($entityProfile) {
        if ( is_string($entityProfile ) ) {
          $entityUserProfile->id_profile = $orm->getByKey( 'WbfsysProfile', $entityProfile  );
        } else {
          $entityUserProfile->id_profile = $entityProfile;
        }
      } else {
        throw new LibAcl_Exception( "Missing the Profile information. It is not possible to assign a unkown profile to a user" );
      }

    }

    if ($accessKey )
      $entityUserProfile->access_key = $accessKey;

    // sicher stellen, dass auch alle Daten vorhanden sind
    if (!$entityUserProfile->id_user || !$entityUserProfile->id_profile) {
      throw new LibAcl_Exception( "Missing required data: User or Profile {$entityUserProfile->id_user} || {$entityUserProfile->id_profile}" );
    }

    $orm->insertIfNotExists
    (
      $entityGUser,
      array
      (
        'id_profile',
        'id_user',
      )
    );

  }//end public function assignUserProfile */

  /**
   * Die Zuweisung von einem User zu einem Profile sauber lösen
   *
   * @param WbfsysUserProfile_Entity $entityUserProfile
   * @param WbfsysProfile_Entity $entityProfile
   * @param WbfsysRoleUser_Entity $entityUser
   *
   * @return void Wirft im Fehlerfall eine Exception, keine Rückgabe nötig
   *
   * @throws LibDb_Exception wenn die Datenbank abfrage fehl schlägt
   * @throws LibAcl_Exception bei sonstigen schweren Fehlern
   */
  public function removeUserProfile
  (
    $entityUserProfile,
    $entityProfile = null,
    $entityUser = null,
    $accessKey = null
  )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    $userId     = null;
    $profileId  = null;

    if ($entityUserProfile instanceof WbfsysUserProfile_Entity) {

      $userId     = $entityUserProfile->id_user;
      $profileId  = $entityUserProfile->id_group;

      $orm->delete($entityUserProfile );

    } elseif ($entityUserProfile instanceof  WbfsysRoleUser_Entity || is_numeric($entityUserProfile) ) {

      $userId     = $entityUserProfile->getId();
      $profileId  = null;

      if ($entityProfile) {
        if ( is_string($entityProfile ) ) {
          $profileId = $orm->getByKey( 'WbfsysProfile', $entityProfile  );
        } else {
          $profileId = $entityProfile;
        }
      } else {
        throw new LibAcl_Exception( "Missing the Profile information. It is not possible to assign a unkown profile to a user" );
      }

      $whereDelete = "id_profile = {$profileId}"
        ." and id_user = {$userId}";

      $orm->deleteWhere( 'WbfsysUserProfile', $whereDelete );

    } else {
      throw new LibAcl_Exception( "Invalid parameter for removeUserProfile" );
    }

  }//end public function removeUserProfile */

  /**
   * de:
   * Debug Daten in die Console pushen
   */
  public function debug( )
  {

  }//end public function debug */

}//end class LibAclManager_Db

