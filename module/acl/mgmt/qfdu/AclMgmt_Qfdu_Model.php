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
class AclMgmt_Qfdu_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the id of the area
   * @var int
   */
  protected $areaId = null;
  
  /**
   * @var DomainNode
   */
  public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * request the id of the activ security area
   *
   * @return int
   */
  public function getAreaId( )
  {

    if( !$this->areaId )
    {
      $orm = $this->getOrm();
      $this->areaId = $orm->get
      ( 
      	'WbfsysSecurityArea', 
      	"upper(access_key)=upper('{$this->domainNode->aclBaseKey}')")->getid();
    }

    return $this->areaId;

  }//end public function getAreaId */

////////////////////////////////////////////////////////////////////////////////
// Getter & Setter for Group Users
////////////////////////////////////////////////////////////////////////////////

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysSecurityArea_Entity
  */
  public function getEntityWbfsysGroupUsers( $objid = null )
  {

    $response = $this->getResponse();
  
    $entityWbfsysGroupUsers = $this->getRegisterd( 'entityWbfsysGroupUsers' );

    //entity wbfsys_security_area
    if( !$entityWbfsysGroupUsers )
    {

      if( !is_null( $objid ) )
      {
        $orm = $this->getOrm();

        if( !$entityWbfsysGroupUsers = $orm->get( 'WbfsysGroupUsers', $objid ) )
        {
          $response->addError
          (
            $this->i18n->l
            (
              'There is no wbfsyssecurityarea with this id '.$objid,
              'wbfsys.security_area.message'
            )
          );
          return null;
        }

        $this->register( 'entityWbfsysGroupUsers', $entityWbfsysGroupUsers );

      }
      else
      {
        $entityWbfsysGroupUsers   = new WbfsysGroupUsers_Entity() ;
        $this->register( 'entityWbfsysGroupUsers', $entityWbfsysGroupUsers );
      }

    }
    elseif( $objid && $objid != $entityWbfsysGroupUsers->getId() )
    {
      $orm = $this->getOrm();

      if( !$entityWbfsysGroupUsers = $orm->get( 'WbfsysGroupUsers', $objid ) )
      {
        $response->addError
        (
          $this->i18n->l
          (
            'There is no wbfsyssecurityarea with this id '.$objid,
            'wbfsys.security_area.message'
          )
        );
        return null;
      }

      $this->register( 'entityWbfsysGroupUsers', $entityWbfsysGroupUsers );
    }

    return $entityWbfsysGroupUsers;

  }//end public function getEntityWbfsysGroupUsers */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysGroupUsers_Entity $entity
  */
  public function setEntityWbfsysGroupUsers( $entity )
  {

    $this->register( 'entityWbfsysGroupUsers', $entity );

  }//end public function setEntityWbfsysGroupUsers */

  /**
   * just fetch the post data without any required validation
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryWbfsysGroupUsers( $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( $this->domainNode->domainAclMask.'_Qfdu_Treetable' );
    
    $areaId = $this->getAreaId();
    
    $condition = array();
    $condition['free'] = $this->getEntityWbfsysGroupUsers()->getId();

    $query->fetch
    (
      $areaId,
      $condition,
      $params
    );

    return $query;
    

  }// end public function getEntryWbfsysGroupUsers */

////////////////////////////////////////////////////////////////////////////////
// Connect Code
////////////////////////////////////////////////////////////////////////////////

  /**
   * de:
   * Extrahieren und validieren der Daten zum erstellen einer Verknüpfung,
   * aus dem Userrequest
   *
   * @param TFlag $params named parameters
   * @return null/Error im Fehlerfall
   */
  public function fetchConnectData( $params )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();
    $response    = $this->getResponse();

    $entityWbfsysGroupUsers = new WbfsysGroupUsers_Entity;

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
      array( 'id_group', 'id_user' )
    );

    // aus sicherheitsgründen setzen wir die hier im code
    $entityWbfsysGroupUsers->id_area = $this->getAreaId();

    // ist eine direkte verknüpfung
    $entityWbfsysGroupUsers->partial = 0;

    if( !$entityWbfsysGroupUsers->id_group )
    {
      $response->addError
      (
        $response->i18n->l( 'Missing Group', 'wbf.message' )
      );
    }

    if( !$entityWbfsysGroupUsers->id_user )
    {
      $response->addError
      (
        $response->i18n->l( 'Missing User', 'wbf.message' )
      );
    }

    if( !$entityWbfsysGroupUsers->vid )
    {
      if( !$httpRequest->data( 'assign_full', Validator::BOOLEAN ) )
      {
        $response->addError
        (
          $response->i18n->l
          (
            'Please confirm, that you want to access this use to the full Area.',
            'wbf.message'
          )
        );
      }        
    }
      
    $this->register( 'entityWbfsysGroupUsers', $entityWbfsysGroupUsers );

    if( $response->hasErrors() )
    {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry this request was invlalid.',
          'wbf.message'
        ),
        Response::BAD_REQUEST
      );
    }
    else
    {
      return null;
    }

  }//end public function fetchConnectData */

  /**
   * de:
   * prüfen ob der benutzer nicht schon unter diesen bedingungen der
   * gruppe zugeordnet wurde
   *
   * @param WbfsysGroupUsers_Entity $entity
   * @return boolean false wenn doppelten einträge vorhanden sind
   */
  public function checkUnique( $entity = null )
  {

    $orm = $this->getOrm();

    if( !$entity )
      $entity =  $this->getRegisterd( 'entityWbfsysGroupUsers' );

    return $orm->checkUnique
    (
      $entity,
      array( 'id_area', 'id_group', 'id_user', 'vid', 'partial' )
    );

  }//end public function checkUnique */

  /**
   * the update method of the model
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function connect( $params )
  {

    // erst mal die nötigen resourcen laden
    $db        = $this->getDb();
    $orm       = $db->getOrm();
    $response  = $this->getResponse();

    try
    {
      if( !$entityWbfsysGroupUsers = $this->getRegisterd( 'entityWbfsysGroupUsers' ) )
      {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbfsys.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array( 'key' => 'entityWbfsysGroupUsers' )
          )
        );
      }

      if( !$orm->insert( $entityWbfsysGroupUsers ) )
      {
        $entityText = $entityWbfsysGroupUsers->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update {@label@}',
            'wbf.message',
            array( 'label' => $entityText )
          )
        );

      }
      else
      {

        // wenn ein benutzer der gruppe hinzugefügt wird, jedoch nur
        // in relation zu einem datensatz, dann bekommt er einen teilzuweisung
        // zu der gruppe in relation zur area des datensatzes
        // diese teilzuweisung vermindert den aufwand um in listen elementen
        // zu entscheiden in welcher form die alcs ausgelesen werden müssen
        if( $entityWbfsysGroupUsers->vid )
        {
          $partUser = new WbfsysGroupUsers_Entity;
          $partUser->id_user    = $entityWbfsysGroupUsers->id_user;
          $partUser->id_group   = $entityWbfsysGroupUsers->id_group;
          $partUser->id_area    = $entityWbfsysGroupUsers->id_area;
          $partUser->partial  = 1;
          $orm->insertIfNotExists( $partUser, array('id_area','id_group','id_user','partial') );
        }

        $entityText = $entityWbfsysGroupUsers->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated {@label@}',
            'wbfsys.message',
            array('label'=>$entityText)
          )
        );

        $this->protocol
        (
          'Edited: '.$entityText,
          'edit',
          $entityWbfsysGroupUsers
        );

      }
    }
    catch( LibDb_Exception $e )
    {
      return new Error( $e, Response::INTERNAL_ERROR );
    }

    if( $response->hasErrors() )
    {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    }
    else
    {
      return null;
    }


  }//end public function connect */

////////////////////////////////////////////////////////////////////////////////
// Search Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * de:
   * Suche für den Autocomplete service
   * Die Anfrage wird über ein AclMgmt_Query Objekt
   * gehandelt, das result als array zurückgegeben
   *
   * @param string $key der Suchstring für den namen der Gruppe
   * @param TFlag $params
   * @return array
   */
  public function searchGroupsAutocomplete( $key, $params )
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
   * @param TFlag $params named parameters
   * @return void
   */
  public function loadGroups( $areaId, $params )
  {

    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Group_Treetable_Query  */
    $query  = $db->newQuery( 'AclMgmt_Qfdu_Group_Treetable' );

    $condition = $this->getSearchCondition();
  
    $query->fetch
    (
      $areaId,
      $condition,
      $params
    );

    return $query;

  }//end public function searchQualifiedUsers */
  
  /**
   *
   * @param int $areaId
   * @param TFlag $params named parameters
   * @return void
   */
  public function searchQualifiedUsers( $areaId, $params )
  {

    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Group_Treetable_Query  */
    $query  = $db->newQuery( 'AclMgmt_Qfdu_Group_Treetable' );

    $condition = $this->getSearchCondition();

    $query->fetch
    (
      $areaId,
      $condition,
      $params
    );

    return $query;

  }//end public function searchQualifiedUsers */
  
  /**
   * @param int $groupId
   * @param string $context
   */
  public function loadGridUsers( $groupId, $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_User_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_User_Treetable' );
    $condition  = $this->getSearchCondition();

    $query->fetch
    (
      $groupId,
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadGridUsers */
  
  
  
  /**
   * @param int $groupId
   * @param int $userId
   * @param Context $context
   * 
   * @return AclMgmt_Qfdu_Dset_Treetable_Query
   */
  public function loadGridDsets( $groupId, $userId, $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Dset_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Dset_Treetable' );
    $query->domainNode = $this->domainNode;
    $condition  = $this->getSearchCondition();

    $query->fetch
    (
      $groupId,
      $userId,
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadGridDsets */
  
  /**
   * @param string $context
   * @return AclMgmt_Qfdu_User_Treetable_Query
   */
  public function loadListByUser_Users( $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_User_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_User_Treetable' );
    $condition  = $this->getSearchCondition();

    $query->fetchListUser
    (
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadListByUser_Users */
  
  /**
   * @param string $context
   * @return AclMgmt_Qfdu_Dset_Treetable_Query
   */
  public function loadListByUser_Dset( $userId, $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Dset_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Dset_Treetable' );
    $query->domainNode = $this->domainNode;
    $condition  = $this->getSearchCondition();

    $query->fetchListUser
    (
      $userId,
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadListByUser_Dset */
  
  /**
   * @param string $context
   * @return AclMgmt_Qfdu_Group_Treetable_Query
   */
  public function loadListByUser_Groups( $userId, $dsetId, $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Group_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Group_Treetable' );
    $query->domainNode = $this->domainNode;
    $condition  = $this->getSearchCondition();

    $query->fetchListUser
    (
      $userId,
      $dsetId,
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadListByUser_Groups */
  
  /**
   * @param string $context
   * @return AclMgmt_Qfdu_Dset_Treetable_Query
   */
  public function loadListByDset_Dsets( $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Dset_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Dset_Treetable' );
    $query->domainNode = $this->domainNode;
    $condition  = $this->getSearchCondition();

    $query->fetchListDset
    (
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadListByDset_Dsets */
  
  /**
   * @param string $context
   * @return AclMgmt_Qfdu_User_Treetable_Query
   */
  public function loadListByDset_Users( $vid,  $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_User_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_User_Treetable' );
    $condition  = $this->getSearchCondition();

    $query->fetchListDset
    (
      $vid,
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadListByDset_Users */

  /**
   * @param int $userId
   * @param int $dsetId
   * @param Context $context
   * @return AclMgmt_Qfdu_Group_Treetable_Query
   */
  public function loadListByDset_Groups( $userId, $dsetId,  $context )
  {
    
    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Group_Treetable_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Group_Treetable' );
    $condition  = $this->getSearchCondition();

    $query->fetchListDset
    (
      $userId,
      $dsetId,
      $context->areaId,
      $condition,
      $context
    );

    return $query;
    
  }//end public function loadListByDset_Groups */
  
  /**
   * @param int $areaId
   * @param Context $context
   * @return AclMgmt_Qfdu_Group_Export_Query
   */
  public function loadExportByGroup( $areaId, $context )
  {

    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Group_Export_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Group_Export' );
    $query->domainNode = $this->domainNode;
    $query->fetch
    (
      $areaId,
      $context
    );

    return $query;
    
  }//end public function loadExportByGroup */
  
  /**
   * @param int $areaId
   * @param Context $context
   * @return AclMgmt_Qfdu_Dset_Export_Query
   */
  public function loadExportByDset( $areaId, $context )
  {

    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_Dset_Export_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_Dset_Export' );
    $query->domainNode = $this->domainNode;
    $query->fetch
    (
      $areaId,
      $context
    );

    return $query;
    
  }//end public function loadExportByDset */
  
  /**
   * @param int $areaId
   * @param Context $context
   * @return AclMgmt_Qfdu_User_Export_Query
   */
  public function loadExportByUser( $areaId, $context )
  {

    $db     = $this->getDb();
    
    /* @var $query AclMgmt_Qfdu_User_Export_Query  */
    $query      = $db->newQuery( 'AclMgmt_Qfdu_User_Export' );
    $query->domainNode = $this->domainNode;
    $query->fetch
    (
      $areaId,
      $context
    );

    return $query;
    
  }//end public function loadExportByUser */
  

  /**
   * process userinput and map it to seachconditions that can be injected
   * in the query object
   *
   * @return array
   */
  public function getSearchCondition()
  {

    $condition  = array();

    $httpRequest = $this->getRequest();
    $db          = $this->getDb();
    $orm         = $db->getOrm();

    if( $free = $httpRequest->param( 'free_search' , Validator::TEXT ) )
      $condition['free'] = $free;

    return $condition;

  }//end public function getSearchCondition */

  /**
   * @param int $areaId the rowid of the activ area
   * @param TArray $params
   */
  public function getAreaGroups( $areaId, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( $this->domainNode->domainAclMask.'_Qfdu' );
    /* @var $query AclMgmt_Qfdu_Query  */

    $query->fetchAreaGroups
    (
      $areaId,
      $params
    );

    return $query->getAll();

  }//end public function getAreaGroups */

  /**
   * @param int $areaId
   * @param string $key
   * @param TArray $params
   */
  public function getUsersByKey( $areaId, $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( $this->domainNode->domainAclMask.'_Qfdu' );
    /* @var $query AclMgmt_Qfdu_Query  */

    $query->fetchUsersByKey
    (
      $areaId,
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUsersByKey */

  /**
   * @lang de
   * Laden der Datensätze der Target Entität zum zuweisen von Rechten
   * Diese Methode wird für die Rückgabe der Autoload Methode auf die
   * Entity verwendet
   *
   * @param int $areaId
   * @param string $key
   * @param TArray $params
   */
  public function getEntitiesByKey( $areaId, $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( $this->domainNode->domainAclMask.'_Qfdu' );
    /* @var $query AclMgmt_Qfdu_Query  */

    $query->fetchTargetEntityByKey
    (
      $areaId,
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getEntitiesByKey */

////////////////////////////////////////////////////////////////////////////////
// Delete Methodes
////////////////////////////////////////////////////////////////////////////////

 
  /**
   * delete a dataset from the database
   * @param int $groupId
   * @param int $userId
   * @param int $areaId
   * @param TFlag $params named parameters
   * @return void
   */
  public function cleanQfdUser( $groupId, $userId, $areaId, $params  )
  {

    $orm       = $this->getOrm();
    $response  = $this->getResponse();

    try
    {
      $orm->deleteWhere
      ( 
        'WbfsysGroupUsers', 
        " id_group={$groupId} 
            and id_user={$userId} 
            and id_area={$areaId} 
            and NOT vid is null
            and ( partial = 0 or partial is null )" 
      );

      $response->addMessage
      (
        $this->view->i18n->l
        (
          'Successfully deleted the User Assignment '.$groupId,
          'wbf.message',
          array( $groupId )
        )
      );

      $this->protocol
      (
        'Deleted User Assignment: '.$groupId,
        'delete',
        array( 'WbfsysGroupUsers', $groupId )
      );

      return true;
    }
    catch( LibDb_Exception $e )
    {
      $response->addError
      (
        $this->view->i18n->l
        (
          'Failed to delete the User Assignment '.$groupId,
          'wbf.message',
          array( $groupId )
        )
      );
    }

  }//end public function cleanQfdUser */

  /**
   * delete a user assignment and all dataset related assignments for this user
   * @param int $groupId
   * @param int $userId
   * @param int $areaId
   * @param TFlag $params named parameters
   * @return void
   */
  public function deleteQfdUser( $groupId, $userId, $areaId, $params  )
  {

    $orm = $this->getOrm();
    $response  = $this->getResponse();

    try
    {
      $orm->deleteWhere
      ( 
        'WbfsysGroupUsers', 
        "id_group={$groupId} and id_user={$userId} and id_area={$areaId}" 
      );

      $response->addMessage
      (
        $this->view->i18n->l
        (
          'Successfully deleted the User Assignment '.$groupId,
          'wbf.message',
          array( $groupId )
        )
      );

      $this->protocol
      (
        'Deleted User Assignment: '.$groupId,
        'delete',
        array('WbfsysGroupUsers',$groupId)
      );

      return true;
    }
    catch( LibDb_Exception $e )
    {
      $response->addError
      (
        $this->view->i18n->l
        (
          'Failed to delete the User Assignment '.$groupId,
          'wbf.message',
          array( $groupId )
        )
      );
    }

  }//end public function deleteQfdUser */

  /**
   * delete all users that are assigned to this group in relation to this area
   *
   * @param int $groupId the id of the group
   * @param int $areaId the id of the area
   * @param TFlag $params named parameters
   * @return void
   */
  public function cleanQfduGroup( $groupId, $areaId, $params  )
  {

    $orm   = $this->getOrm();
    $view  = $this->getView();
    $response  = $this->getResponse();

    try
    {
      $orm->deleteWhere
      ( 
        'WbfsysGroupUsers', 
        " id_group={$groupId} and id_area={$areaId} and ( partial = 0 or partial is null ) " 
      );

      $response->addMessage
      (
        $view->i18n->l
        (
          'Successfully deleted the User Assignment {@id@}',
          'wbf.message',
          array( 'id' => $groupId )
        )
      );

      $this->protocol
      (
        'Deleted User Assignment: '.$groupId,
        'delete',
        array( 'WbfsysGroupUsers', $groupId )
      );

      return true;
    }
    catch( LibDb_Exception $e )
    {
      $response->addError
      (
        $view->i18n->l
        (
          'Failed to delete the User Assignment {@id@}',
          'wbf.message',
          array( 'id' => $groupId)
        )
      );
    }

  }//end public function cleanQfduGroup */

  /**
   * Alle Userassignments zu dieser Area löschen
   * @param int $areaId
   * @param TFlag $params named parameters
   * @return void
   */
  public function emptyQfduUsers( $areaId, $params  )
  {

    $orm       = $this->getOrm();
    $response  = $this->getResponse();

    try
    {
      $orm->deleteWhere
      ( 
        'WbfsysGroupUsers', 
        "id_area={$areaId} and (partial = 0 or partial is null)" 
      );

      $response->addMessage
      (
        $this->view->i18n->l
        (
          'Successfully removed all user assignments '.$areaId,
          'wbf.message',
          array( $areaId )
        )
      );

      $this->protocol
      (
        'Removed alle user assignments from area: '.$areaId,
        'empty_reference',
        array( 'WbfsysGroupUsers', $areaId )
      );

      return true;
    }
    catch( LibDb_Exception $e )
    {
      $response->addError
      (
        $this->view->i18n->l
        (
          'Failed to clean the user assignments {@area_id@}',
          'wbf.message',
          array( 'area_id' => $areaId )
        )
      );
    }

  }//end public function emptyQfduUsers */
  
  /**
   * de:
   * prüfen ob eine derartige referenz nicht bereits existiert
   *
   * @param WbfsysSecurityAccess_Entity $entity
   * @return boolean false wenn eine derartige verknüpfung bereits existiert
   */
  public function checkAccess( $domainNode, $context )
  {

    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this, $domainNode );
    $access->load( $user->getProfileName(), $context );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( $domainNode->label, $domainNode->domainI18n.'.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $context->access = $access;

  }//end public function checkAccess */

} // end class AclMgmt_Qfdu_Model */

