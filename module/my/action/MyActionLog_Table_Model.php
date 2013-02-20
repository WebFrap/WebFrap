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
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyActionLog_Table_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// getter for the entities
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return MyActionLog_Entity
  */
  public function getEntityMyActionLog($objid = null )
  {

    $entityMyActionLog = $this->getRegisterd('entityMyActionLog');

    //entity my_task
    if (!$entityMyActionLog) {

      if (!is_null($objid ) ) {
        $orm = $this->getOrm();

        if (!$entityMyActionLog = $orm->get( 'WbfsysTask', $objid) ) {
          $this->getMessage()->addError
          (
            $this->i18n->l
            (
              'There is no wbfsystask with this id '.$objid,
              'wbfsys.task.message'
            )
          );

          return null;
        }

        $this->register('entityMyActionLog', $entityMyActionLog);

      } else {
        $entityMyActionLog   = new MyActionLog_Entity() ;
        $this->register('entityMyActionLog', $entityMyActionLog);
      }

    } elseif ($objid && $objid != $entityMyActionLog->getId() ) {
      $orm = $this->getOrm();

      if (!$entityMyActionLog = $orm->get( 'WbfsysTask', $objid) ) {
        $this->getMessage()->addError
        (
          $this->i18n->l
          (
            'There is no wbfsystask with this id '.$objid,
            'wbfsys.task.message'
          )
        );

        return null;
      }

      $this->register('entityMyActionLog', $entityMyActionLog);
    }

    return $entityMyActionLog;

  }//end public function getEntityMyActionLog */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param MyActionLog_Entity $entity
  */
  public function setEntityMyActionLog($entity )
  {

    $this->register('entityMyActionLog', $entity );

  }//end public function setEntityMyActionLog */

  /**
   * just fetch the post data without any required validation
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryData($params )
  {

    $orm   = $this->getOrm();

    $data  = array();

    $data['my_task']  = $this->getEntityMyActionLog();

    $tabData = array();

    foreach ($data as $tabName => $ent) {
      // prüfen ob etwas gefunden wurde
      if (!$ent) {
        Debug::console( "Missing Entity for Reference: ".$tabName );
        continue;
      }

      $tabData = array_merge($tabData , $ent->getAllData($tabName ) );

    }

    // if we have a value, try to load the display field
    if ($data['my_task']->id_type) {
      $valMyActionLogType = $orm->getField( 'WbfsysTaskType', 'rowid = '.$data['my_task']->id_type , 'name'  );
      $tabData['wbfsys_task_type_name'] = $valMyActionLogType;
    } else {
      // else just set an empty string, fastest way ;-)
      $tabData['wbfsys_task_type_name'] = '';
    }

    // if we have a value, try to load the display field
    if ($data['my_task']->id_status) {
      $valMyActionLogStatus = $orm->getField( 'WbfsysTaskStatus', 'rowid = '.$data['my_task']->id_status , 'name'  );
      $tabData['wbfsys_task_status_name'] = $valMyActionLogStatus;
    } else {
      // else just set an empty string, fastest way ;-)
      $tabData['wbfsys_task_status_name'] = '';
    }

    return $tabData;

  }// end public function getEntryData */

/*//////////////////////////////////////////////////////////////////////////////
// context: table
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Suchfunktion für das Listen Element
   *
   * Wenn suchparameter übergeben werden, werden diese automatisch in die
   * Query eingebaut, ansonsten wird eine plain query ausgeführt
   *
   * Berechtigungen werden bei bedarf berücksichtigt
   *
   * Am Ende wird ein geladenes Query Objekt zurückgegeben, über welches
   * ( wie über einen Array ) itteriert werden kann
   *
   * @param TFlag $params named parameters
   * @return LibSqlQuery
   *
   * @throws LibDb_Exception
   *    wenn die Query fehlschlägt
   *    Datenbank Verbindungsfehler... etc ( siehe meldung )
   */
  public function search($params )
  {

    $condition = array();

    // laden der benötigten resourcen
    $view = $this->getView();
    $httpRequest = $this->getRequest();
    $db      = $this->getDb();
    $orm     = $db->getOrm();
    $user    = $this->getUser();

    // freitext suche
    if ($free = $httpRequest->param('free_search' , Validator::TEXT) )
      $condition['free'] = $free;

    if (!$fieldsMyActionLog = $this->getRegisterd('search_fields_my_task') ) {
       $fieldsMyActionLog   = $orm->getSearchCols('WbfsysTask');
    }

    if ($refs = $httpRequest->dataSearchIds( 'search_my_task' ) ) {
      $fieldsMyActionLog = array_unique( array_merge
      (
        $fieldsMyActionLog,
        $refs
      ));
    }

    $filterMyActionLog     = $httpRequest->checkSearchInput
    (
      $orm->getValidationData( 'WbfsysTask', $fieldsMyActionLog ),
      $orm->getErrorMessages( 'WbfsysTask'  ),
      'search_my_task'
    );
    $condition['my_task'] = $filterMyActionLog->getData();

    if ($mRoleCreate = $httpRequest->param('search_my_task', Validator::EID, 'm_role_create'   ) )
      $condition['my_task']['m_role_create'] = $mRoleCreate;

    if ($mRoleChange = $httpRequest->param('search_my_task', Validator::EID, 'm_role_change'   ) )
      $condition['my_task']['m_role_change'] = $mRoleChange;

    if ($mTimeCreatedBefore = $httpRequest->param('search_my_task', Validator::DATE, 'm_time_created_before'   ) )
      $condition['my_task']['m_time_created_before'] = $mTimeCreatedBefore;

    if ($mTimeCreatedAfter = $httpRequest->param('search_my_task', Validator::DATE, 'm_time_created_after'   ) )
      $condition['my_task']['m_time_created_after'] = $mTimeCreatedAfter;

    if ($mTimeChangedBefore = $httpRequest->param('search_my_task', Validator::DATE, 'm_time_changed_before'   ) )
      $condition['my_task']['m_time_changed_before'] = $mTimeChangedBefore;

    if ($mTimeChangedAfter = $httpRequest->param('search_my_task}', Validator::DATE, 'm_time_changed_after'   ) )
      $condition['my_task']['m_time_changed_after'] = $mTimeChangedAfter;

    if ($mRowid = $httpRequest->param('search_my_task', Validator::EID, 'm_rowid'   ) )
      $condition['my_task']['m_rowid'] = $mRowid;

    if ($mUuid = $httpRequest->param('search_my_task', Validator::TEXT, 'm_uuid'    ) )
      $condition['my_task']['m_uuid'] = $mUuid;

    $query = $db->newQuery('MyActionLog_Table');

    // per exclude können regeln übergeben werden um bestimmte datensätze
    // auszublenden
    // wird häufig verwendet um bereits zugewiesenen datensätze aus zu blenden
    if ($params->exclude) {

      $tmp = explode('-',$params->exclude );

      $conName   = $tmp[0];
      $srcId     = $tmp[1];
      $targetId  = $tmp[2];

      $excludeCond = ' wbfsys_task.rowid NOT IN '
      .'( select '.$targetId .' from '.$conName.' where '.$srcId.' = '.$params->objid.' ) ';

      $query->setCondition($excludeCond );

    }

    // wenn der user nur teilberechtigungen hat, müssen die ACLs direkt beim
    // lesen der Daten berücksichtigt werden
    if
    (
      $params->access->isPartAssign || $params->access->hasPartAssign
    )
    {

      $validKeys  = $params->access->fetchListIds
      (
        $user->getProfileName(),
        $query,
        'table',
        $condition,
        $params
      );

      $query->fetchInAcls
      (
        $validKeys,
        $params
      );

    } else {

      // da die rechte scheins auf die komplette datenquelle vergeben wurden
      // kann hier auch einfach mit der ganzen quelle geladen werden
      // es wird davon ausgegangen, dass ein standard level definiert wurde
      // wenn kein standard level definiert wurde, werden die daten nur
      // aufgelistet ohne weitere interaktions möglichkeit
      $query->fetch
      (
        $condition,
        $params
      );

    }

    return $query;

  }//end public function search */

  /**
   * just fetch the post data without any required validation
   *
   * @param int $id the id for the entity
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchPostData($params, $id = null  )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();
    $view        = $this->getView();

    try {

      //management  my_task source my_task
      $entityMyActionLog = $orm->newEntity('WbfsysTask');

      if (!$params->fieldsMyActionLog) {
        $params->fieldsMyActionLog  = $entityMyActionLog->getCols
        (
          $params->categories
        );
      }

      // if the validation fails report
      $httpRequest->validate
      (
        $entityMyActionLog,
        'my_task',
        $params->fieldsMyActionLog
      );

      // register the entity in the mode registry
      $this->register('entityMyActionLog',$entityMyActionLog);

      return !$this->getMessage()->hasErrors();
    } catch ( InvalidInput_Exception $e ) {
      return false;
    }

  }//end public function fetchPostData */

  /**
   * fill the elements in a search form
   *
   * @param LibTemplateWindow $view
   * @return boolean
   */
  public function searchForm($view )
  {

    //entity my_task
    if (!$entityMyActionLog = $this->getRegisterd('entityMyActionLog') ) {
      $entityMyActionLog   = new MyActionLog_Entity() ;
    }

    $fieldsMyActionLog  = $entityMyActionLog->getSearchCols();
    $formMyActionLog    = $view->newForm('WbfsysActionLog');
    $formMyActionLog->setNamespace('MyActionLog');
    $formMyActionLog->setPrefix('MyActionLog');
    $formMyActionLog->createSearchForm
    (
      $entityMyActionLog,
      $fieldsMyActionLog
    );

  }//end public function searchForm */

}//end class MyActionLog_Table_Model

