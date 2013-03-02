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
class AclMgmt_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the id of the active area
   * @var int
   */
  protected $areaId = null;

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * request the id of the activ area
   * @return int
   */
  public function loadAreaId(  )
  {

    if ($this->areaId )
      return $this->areaId;

    $orm = $this->getOrm();

    $this->areaId = $orm->get( 'WbfsysSecurityArea',"upper(access_key)=upper('{$this->domainNode->aclBaseKey}')" )->getid();

    return $this->areaId;

  }//end public function loadAreaId */

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter for Entities Area
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysSecurityArea_Entity
  */
  public function getEntityWbfsysSecurityArea($objid = null )
  {

    $entityWbfsysSecurityArea = $this->getRegisterd( 'entityWbfsysSecurityArea' );

    //entity wbfsys_security_area
    if (!$entityWbfsysSecurityArea) {

      if (!is_null($objid ) ) {
        $orm = $this->getOrm();

        if (!$entityWbfsysSecurityArea = $orm->get( 'WbfsysSecurityArea', $objid ) ) {
          $this->getResponse()->addError
          (
            $this->i18n->l
            (
              'There is no wbfsyssecurityarea with this id '.$objid,
              'wbfsys.security_area.message'
            )
          );

          return null;
        }

        $this->register( 'entityWbfsysSecurityArea', $entityWbfsysSecurityArea );

      } else {
        $entityWbfsysSecurityArea   = new WbfsysSecurityArea_Entity() ;
        $this->register( 'entityWbfsysSecurityArea', $entityWbfsysSecurityArea );
      }

    } elseif ($objid && $objid != $entityWbfsysSecurityArea->getId() ) {
      $orm = $this->getOrm();

      if (!$entityWbfsysSecurityArea = $orm->get( 'WbfsysSecurityArea', $objid) ) {
        $this->getResponse()->addError
        (
          $this->i18n->l
          (
            'There is no wbfsyssecurityarea with this id '.$objid,
            'wbfsys.security_area.message'
          )
        );

        return null;
      }

      $this->register( 'entityWbfsysSecurityArea', $entityWbfsysSecurityArea );
    }

    return $entityWbfsysSecurityArea;

  }//end public function getEntityWbfsysSecurityArea */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysSecurityArea_Entity $entity
  */
  public function setEntityWbfsysSecurityArea($entity )
  {

    $this->register( 'entityWbfsysSecurityArea', $entity );

  }//end public function setEntityWbfsysSecurityArea */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditFields()
  {
    return array
    (
      'security_area' => array
      (
        'id_ref_listing',
        'id_ref_access',
        'id_ref_insert',
        'id_ref_update',
        'id_ref_delete',
        'id_ref_admin',

        'id_level_listing',
        'id_level_access',
        'id_level_insert',
        'id_level_update',
        'id_level_delete',
        'id_level_admin',

        'description'
      ),

    );

  }//end public function getEditFields */

  /**
   * request the id of the activ area
   *
   * @return int
   */
  public function getAreaId()
  {

    $orm = $this->getOrm();

    return $orm->getByKey( 'WbfsysSecurityArea', $this->domainNode->aclKey )->getid();

  }//end public function getAreaId */

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter for Entities Access
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysSecurityArea_Entity
  */
  public function getEntityWbfsysSecurityAccess($objid = null )
  {

    $entityWbfsysSecurityAccess = $this->getRegisterd( 'entityWbfsysSecurityAccess' );

    //entity wbfsys_security_area
    if (!$entityWbfsysSecurityAccess) {

      if (!is_null($objid ) ) {
        $orm = $this->getOrm();

        if (!$entityWbfsysSecurityAccess = $orm->get( 'WbfsysSecurityAccess', $objid) ) {
          $this->getResponse()->addError
          (
            $this->i18n->l
            (
              'There is no wbfsyssecurityarea with this id '.$objid,
              'wbfsys.security_area.message'
            )
          );

          return null;
        }

        $this->register( 'entityWbfsysSecurityAccess', $entityWbfsysSecurityAccess );

      } else {
        $entityWbfsysSecurityAccess   = new WbfsysSecurityAccess_Entity() ;
        $this->register( 'entityWbfsysSecurityAccess', $entityWbfsysSecurityAccess );
      }

    } elseif ($objid && $objid != $entityWbfsysSecurityAccess->getId() ) {
      $orm = $this->getOrm();

      if (!$entityWbfsysSecurityAccess = $orm->get( 'WbfsysSecurityAccess', $objid ) ) {
        $this->getResponse()->addError
        (
          $this->i18n->l
          (
            'There is no wbfsyssecurityarea with this id '.$objid,
            'wbfsys.security_area.message'
          )
        );

        return null;
      }

      $this->register( 'entityWbfsysSecurityAccess', $entityWbfsysSecurityAccess );
    }

    return $entityWbfsysSecurityAccess;

  }//end public function getEntityWbfsysSecurityAccess */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysSecurityAccess_Entity $entity
  */
  public function setEntityWbfsysSecurityAccess($entity )
  {

    $this->register( 'entityWbfsysSecurityAccess', $entity );

  }//end public function setEntityWbfsysSecurityAccess */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditFieldsAccess()
  {
    return array
    (
      'security_access' => array
      (
        'access_level',
        'description',
        'date_start',
        'date_end'
      ),

    );

  }//end public function getEditFieldsAccess */

  /**
   * just fetch the post data without any required validation
   * @param LibTemplatePresenter $view
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryDataAccess($view,  $params )
  {

    $orm   = $this->getOrm();
    $data  = array();

    $data['security_access'] = $this->getEntityWbfsysSecurityAccess();

    $tabData = array();

    foreach($data as $tabName => $ent )
      $tabData = array_merge($tabData , $ent->getAllData($tabName ) );

    $tabData['num_assignments'] = 0;
    $tabData['role_group_rowid'] = $data['security_access']->id_group;

    $tabData['role_group_name'] = $orm->getField
    (
      'WbfsysRoleGroup',
      $data['security_access']->id_group ,
      'name'
    );

    return $tabData;

  }// end public function getEntryDataAccess */

/*//////////////////////////////////////////////////////////////////////////////
// Connect Code
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * fetch the update data from the http request object
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchConnectData($params )
  {

    $httpRequest = $this->getRequest();
    $view        = $this->getView();
    $response    = $this->getResponse();
    $orm         = $this->getOrm();

    $entityWbfsysSecurityAccess = new WbfsysSecurityAccess_Entity;

    $fields = array
    (
      'id_group',
      'id_area',
      'access_level',
      'date_start',
      'date_end',
    );

    $httpRequest->validateUpdate
    (
      $entityWbfsysSecurityAccess,
      'security_access',
      $fields,
      array( 'id_group' )
    );

    $entityWbfsysSecurityAccess->partial = 0;

    // wenn kein access level mit übergeben wurde wird access als standard
    // angenommen
    if (is_null($entityWbfsysSecurityAccess->access_level ) )
      $entityWbfsysSecurityAccess->access_level = 1;

    $this->register( 'entityWbfsysSecurityAccess', $entityWbfsysSecurityAccess );

    // check if there where any errors if not fine
    return !$response->hasErrors();

  }//end public function fetchConnectData */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function connect(  $params )
  {

    // laden der benötigten resourcen
    $db        = $this->getDb();
    $orm       = $db->getOrm();
    $response  = $this->getResponse();

    try {
      if (!$entityWbfsysSecurityAccess = $this->getRegisterd( 'entityWbfsysSecurityAccess' ) ) {
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
            array( 'key' => 'entityWbfsysSecurityAccess' )
          )
        );
      }

      $entityWbfsysSecurityAccess->access_level  = 1;
      $entityWbfsysSecurityAccess->ref_access_level  = 1;
      $entityWbfsysSecurityAccess->message_level  = 0;
      $entityWbfsysSecurityAccess->meta_level  = 0;

      if (!$orm->insert($entityWbfsysSecurityAccess ) ) {
        $entityText = $entityWbfsysSecurityAccess->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to updated {@key@}',
            'wbf.message',
            array('key'=>$entityText)
          )
        );

      } else {

        // ok jetzt müssen wir noch kurz partiellen zugriff auf die unteren ebene vergeben
        $partialMod = new WbfsysSecurityAccess_Entity;
        $partialMod->id_area     = $orm->getByKey( 'WbfsysSecurityArea', $this->domainNode->modAclKey );
        $partialMod->id_group    = $entityWbfsysSecurityAccess->id_group;
        $partialMod->partial       = 1;
        $partialMod->access_level  = 1;
        $partialMod->ref_access_level  = 1;
        $partialMod->meta_level  = 1;
        $partialMod->message_level  = 1;
        $orm->insertIfNotExists($partialMod, array( 'id_area', 'id_group', 'partial' ) );


        $partialEntity = new WbfsysSecurityAccess_Entity;
        $partialEntity->id_area    = $orm->getByKey( 'WbfsysSecurityArea', $this->domainNode->aclBaseKey );
        $partialEntity->id_group   = $entityWbfsysSecurityAccess->id_group;
        $partialEntity->partial        = 1;
        $partialEntity->access_level   = 1;
        $partialEntity->ref_access_level  = 1;
        $partialEntity->meta_level  = 1;
        $partialEntity->message_level  = 1;
        $orm->insertIfNotExists($partialEntity, array('id_area','id_group','partial') );


        $entityText = $entityWbfsysSecurityAccess->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated {@key@}',
            'wbf.message',
            array( 'key' => $entityText )
          )
        );

        $this->protocol
        (
          'Edited : '.$entityText,
          'edit',
          $entityWbfsysSecurityAccess
        );

      }
    } catch ( LibDb_Exception $e ) {
      return new Error($e, Response::INTERNAL_ERROR );
    }

    if ($response->hasErrors() ) {
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
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function deleteGroup(  $groupId )
  {

    $orm = $this->getOrm();

    $orm->delete( 'WbfsysSecurityAccess', $groupId  );


  }//end public function deleteGroup */

/*//////////////////////////////////////////////////////////////////////////////
// CRUD Code
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * fetch the update data from the http request object
   * @param int $id
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($id, $params )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();
    $response    = $this->getResponse();

    if (!$entityWbfsysSecurityArea = $orm->get( 'WbfsysSecurityArea',  $id ) ) {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'There ist no Security Area with the ID: {@id@}',
          'wbf.message',
          array
          (
            'id' => $id
          )
        ),
        Response::NOT_FOUND
      );
    }

    $fields = $this->getEditFields();

    $httpRequest->validateUpdate
    (
      $entityWbfsysSecurityArea,
      'security_area',
      $fields['security_area']
    );
    $this->register( 'entityWbfsysSecurityArea', $entityWbfsysSecurityArea );


    // check if there where any errors if not fine
    if ($response->hasErrors() ) {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Validation failed',
          'wbf.message'
        ),
        Response::BAD_REQUEST
      );
    }

  }//end public function fetchUpdateData */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function update($params )
  {

    // fetch the required technical objects
    $db   = $this->getDb();
    $orm  = $db->getOrm();
    $view = $this->getView();
    $response = $this->getResponse();

    try {
      if (!$entityWbfsysSecurityArea = $this->getRegisterd( 'entityWbfsysSecurityArea' ) ) {
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
            array( 'key' => 'entityWbfsysSecurityArea' )
          )
        );
      }

      if (!$orm->update($entityWbfsysSecurityArea ) ) {
        $entityText = $entityWbfsysSecurityArea->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update '.$entityText,
            'wbf.message',
            array($entityText )
          )
        );

      } else {
        $entityText = $entityWbfsysSecurityArea->text( );

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated '.$entityText,
            'wbf.message',
            array($entityText )
          )
        );

        $this->protocol
        (
          'Edited : '.$entityText,
          'edit',
          $entityWbfsysSecurityArea
        );

      }
    } catch ( LibDb_Exception $e ) {
      return new Error($e, Response::INTERNAL_ERROR );
    }

    if ($response->hasErrors() ) {
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

  }//end public function update */

/*//////////////////////////////////////////////////////////////////////////////
// Search Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param TArray $params
   */
  public function searchGroupsAutocomplete($key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'AclMgmt' );
    /* @var $query AclMgmt_Query  */

    $query->fetchGroupsByKey
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function searchGroupsAutocomplete */

  /**
   *
   * @param int $areaId
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   * @return void
   */
  public function search($areaId, $access, $params )
  {

    $db         = $this->getDb();
    $query      = $db->newQuery( 'AclMgmt_Table' );
    /* @var $query AclMgmt_Table_Query  */

    $condition  = $this->getSearchCondition( );

    $query->fetch
    (
      $areaId,
      $condition,
      $params
    );

    return $query;

  }//end public function search */

  /**
   * process userinput and map it to seachconditions that can be injected
   * in the query object
   * @return array
   */
  public function getSearchCondition()
  {

    $condition  = array();

    $httpRequest = $this->getRequest();
    $db          = $this->getDb();
    $orm         = $db->getOrm();

    if ($free = $httpRequest->param('free_search', Validator::TEXT))
      $condition['free'] = $free;

    return $condition;

  }//end public function getSearchCondition */

  /**
   * de:
   * prüfen ob eine derartige referenz nicht bereits existiert
   *
   * @param WbfsysSecurityAccess_Entity $entity
   * @return boolean false wenn eine derartige verknüpfung bereits existiert
   */
  public function checkUnique($entity = null )
  {

    $orm = $this->getOrm();

    if (!$entity )
      $entity =  $this->getRegisterd( 'entityWbfsysSecurityAccess' );

    return $orm->checkUnique
    (
      $entity ,
      array
      (
        'id_area',
        'id_group',
        'partial'
      )
    );

  }//end public function checkUnique */


  /**
   * de:
   * prüfen ob eine derartige referenz nicht bereits existiert
   *
   * @param WbfsysSecurityAccess_Entity $entity
   * @return boolean false wenn eine derartige verknüpfung bereits existiert
   */
  public function checkAccess($domainNode, $params )
  {

    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this, $domainNode );
    $access->load($user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->admin) {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l($domainNode->label, $domainNode->domainI18n.'.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

  }//end public function checkAccess */


  /**
   * @param Tflag $params
   * @return Error
   */
  public function pushMgmtConfigurationToEntity($params )
  {

    $db         = $this->getDb();
    $orm        = $db->getOrm();

    $entityAreaId = $this->getEntityAreaId();
    $areaId       = $this->getAreaId();

    /* @var $groupQuery AclMgmt_SyncGroup_Query */
    $groupQuery   = $db->newQuery( 'AclMgmt_SyncGroup' );
    $groupQuery->fetch($areaId );

    foreach ($groupQuery as $entry) {
      $partialEntity = new WbfsysSecurityAccess_Entity;
      $partialEntity->id_area    = $entityAreaId;
      $partialEntity->id_group   = $entry['security_access_id_group'];
      $partialEntity->partial        = 0;
      $partialEntity->access_level   = $entry['security_access_access_level'];
      $orm->insertIfNotExists
      (
        $partialEntity,
        array
        (
          'id_area',
          'id_group',
          'partial'
        )
      );
    }

    /* @var $assignmentQuery AclMgmt_SyncAssignment_Query */
    $assignmentQuery = $db->newQuery( 'AclMgmt_SyncAssignment' );
    $assignmentQuery->fetch($areaId );

    foreach ($assignmentQuery as $entry) {

      $partUser = new WbfsysGroupUsers_Entity;
      $partUser->id_user    = $entry['group_users_id_user'];
      $partUser->id_group   = $entry['group_users_id_group'];

      if ($entry['group_users_vid'] )
        $partUser->vid = $entry['group_users_vid'];

      $partUser->id_area  = $entityAreaId;
      $partUser->partial  = 0;

      $orm->insertIfNotExists
      (
        $partUser,
        array
        (
          'id_area',
          'id_group',
          'id_user',
          'vid',
          'partial'
        )
      );

    }

  }//end public function pushMgmtConfigurationToEntity */

  /**
   * @param Tflag $params
   * @return Error
   */
  public function pullMgmtConfigurationfromEntity($params )
  {

    $db         = $this->getDb();
    $orm        = $db->getOrm();

    $entityAreaId = $this->getEntityAreaId();
    $areaId       = $this->getAreaId();

    /* @var $groupQuery AclMgmt_SyncGroup_Query */
    $groupQuery      = $db->newQuery( 'AclMgmt_SyncGroup' );
    $groupQuery->fetch($entityAreaId );

    foreach ($groupQuery as $entry) {
      $partialEntity = new WbfsysSecurityAccess_Entity;
      $partialEntity->id_area    = $areaId;
      $partialEntity->id_group   = $entry['security_access_id_group'];
      $partialEntity->partial        = 0;
      $partialEntity->access_level   = $entry['security_access_access_level'];
      $orm->insertIfNotExists
      (
        $partialEntity,
        array
        (
          'id_area',
          'id_group',
          'partial'
        )
      );
    }

    /* @var $assignmentQuery AclMgmt_SyncAssignment_Query */
    $assignmentQuery = $db->newQuery( 'AclMgmt_SyncAssignment' );
    $assignmentQuery->fetch($entityAreaId );

    foreach ($assignmentQuery as $entry) {

      $partUser = new WbfsysGroupUsers_Entity;
      $partUser->id_user    = $entry['group_users_id_user'];
      $partUser->id_group   = $entry['group_users_id_group'];

      if ($entry['group_users_vid'] )
        $partUser->vid = $entry['group_users_vid'];

      $partUser->id_area    = $areaId;
      $partUser->partial    = 0;

      $orm->insertIfNotExists
      (
        $partUser,
        array
        (
          'id_area',
          'id_group',
          'id_user',
          'vid',
          'partial'
        )
      );

    }

  }//end public function pullMgmtConfigurationfromEntity */

} // end class AclMgmt_Model */

