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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapCoredata_Acl_Qfdu_Model
  extends Model
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $domainKey = null;

  /**
   * the id of the area
   * @var int
   */
  protected $areaId = null;

////////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $domainKey
   */
  public function setDomainKey( $domainKey )
  {
    
    $this->domainKey = $domainKey;
    
  }//end public function setDomainKey */

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
      $this->areaId = $orm->get( 'WbfsysSecurityArea', 'mod-'.$this->domainKey.'-cat-core_data' )->getid();
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
  
    $entityWbfsysGroupUsers = $this->getRegisterd('entityWbfsysGroupUsers');

    //entity wbfsys_security_area
    if( !$entityWbfsysGroupUsers )
    {

      if( !is_null( $objid ) )
      {
        $orm = $this->getOrm();

        if( !$entityWbfsysGroupUsers = $orm->get( 'WbfsysGroupUsers', $objid) )
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
        $this->register( 'entityWbfsysGroupUsers', $entityWbfsysGroupUsers);
      }

    }
    elseif( $objid && $objid != $entityWbfsysGroupUsers->getId() )
    {
      $orm = $this->getOrm();

      if( !$entityWbfsysGroupUsers = $orm->get( 'WbfsysGroupUsers', $objid) )
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

    $orm   = $this->getOrm();
    $data  = array();

    $data['wbfsys_group_users']  = $this->getEntityWbfsysGroupUsers();

    $tabData = array();

    foreach( $data as $tabName => $ent )
      $tabData = array_merge( $tabData, $ent->getAllData( $tabName ) );

    $tabData['wbfsys_group_users_date_start'] = null;
    $tabData['wbfsys_group_users_date_end']   = null;

    $tabData['wbfsys_role_group_name']  = $orm->getField('WbfsysRoleGroup', $data['wbfsys_group_users']->id_group , 'name' );
    $tabData['wbfsys_role_group_rowid'] = $data['wbfsys_group_users']->id_group;
    $tabData['wbfsys_role_user_name']   = $orm->getField('WbfsysRoleUser', $data['wbfsys_group_users']->id_user , 'name' );
    $tabData['wbfsys_role_user_rowid']  = $data['wbfsys_group_users']->id_user;

    $userRole = $orm->get( 'WbfsysRoleUser', $data['wbfsys_group_users']->id_user  );

    $person = $orm->get( 'CorePerson', $userRole->id_person );

    $tabData['user'] = '('.$userRole->name.') '.
      (
        $person->lastname && $person->firstname
        ? $person->lastname.', '.$person->firstname
        : $person->lastname.$person->firstname
      );

    if( $data['wbfsys_group_users']->vid )
    {
      $refEntityWebfrapCoredata = $orm->get('WebfrapCoredata', $data['wbfsys_group_users']->vid);
      $tabData['project_iteration_title']  = $refEntityWebfrapCoredata->title;
      $tabData['project_iteration_name']  = $refEntityWebfrapCoredata->name;

    }
    $tabData['project_iteration_rowid'] = $data['wbfsys_group_users']->vid;

    return $tabData;

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
      'wbfsys_group_users',
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

    if(!$entity)
      $entity =  $this->getRegisterd('entityWbfsysGroupUsers');

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

      if(!$orm->insert($entityWbfsysGroupUsers))
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
   * Die Anfrage wird über ein WebfrapCoredata_Acl_Query Objekt
   * gehandelt, das result als array zurückgegeben
   *
   * @param string $key der Suchstring für den namen der Gruppe
   * @param TFlag $params
   * @return array
   */
  public function searchGroupsAutocomplete( $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'WebfrapCoredata_Acl' );
    /* @var $query WebfrapCoredata_Acl_Query  */

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
  public function searchQualifiedUsers( $areaId, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'WebfrapCoredata_Acl_Qfdu_Treetable' );
    /* @var $query WebfrapCoredata_Acl_Qfdu_Treetable_Query  */

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

    if( !$httpRequest->method( Request::POST )  )
      return $condition;

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
    $query  = $db->newQuery( 'WebfrapCoredata_Acl_Qfdu' );
    /* @var $query WebfrapCoredata_Acl_Qfdu_Query  */

    $query->fetchAreaGroups
    (
      $areaId,
      $params
    );

    return $query;

  }//end public function getAreaGroups */

  /**
   * @param int $areaId
   * @param string $key
   * @param TArray $params
   */
  public function getUsersByKey( $areaId, $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery('WebfrapCoredata_Acl_Qfdu' );
    /* @var $query WebfrapCoredata_Acl_Qfdu_Query  */

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
    $query  = $db->newQuery( 'WebfrapCoredata_Acl_Qfdu' );
    /* @var $query WebfrapCoredata_Acl_Qfdu_Query  */

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
   * @param int $objid
   * @param TFlag $params named parameters
   * @return void
   */
  public function deleteQfduDataset( $objid, $params  )
  {

    $response  = $this->getResponse();
    $orm       = $this->getOrm();

    try
    {
      $orm->delete( 'WbfsysGroupUsers', $objid );

      // ok hat geklappt, die nachricht dazu packen wir direkt in die response
      $response->addMessage
      (
        $response->i18n->l
        (
          'Successfully deleted the User Assignment {@id@}',
          'wbfsys.message',
          array( 'id' => $objid )
        )
      );

      $this->protocol
      (
        'Deleted user assignment: '.$objid,
        'delete',
        array( 'WbfsysGroupUsers', $objid )
      );

      // kein fehler passiert? bestens
      return null;
    }
    catch( LibDb_Exception $e )
    {
      // ok irgendwas passt nicht, wie das behandelt wird soll der controller
      // entscheiden
      return new Error
      (
        $response->i18n->l( 'Failed to delete user assignment', 'wbfsys.message' ),
        $e
      );
    }

  }//end public function deleteQfduDataset */

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
          'Failed to clean the user assignments '.$areaId,
          'wbf.message',
          array( $groupId )
        )
      );
    }

  }//end public function emptyQfduUsers */

} // end class WebfrapCoredata_Acl_Qfdu_Model */

