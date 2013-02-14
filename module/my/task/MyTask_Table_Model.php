<?php 
/*******************************************************************************
          _______          ______    _______      ______    _______
         |   _   | ______ |   _  \  |   _   \    |   _  \  |   _   |
         |   1___||______||.  |   \ |.  1   / __ |.  |   \ |.  1___|
         |____   |        |.  |    \|.  _   \|__||.  |    \|.  __)_
         |:  1   |        |:  1    /|:  1    \   |:  1    /|:  1   |
         |::.. . |        |::.. . / |::.. .  /   |::.. . / |::.. . |
         `-------'        `------'  `-------'    `------'  `-------'
                             __.;:-+=;=_.
                                    ._=~ -...    -~:
                     .:;;;:.-=si_=s%+-..;===+||=;. -:
                  ..;::::::..<mQmQW>  :::.::;==+||.:;        ..:-..
               .:.:::::::::-_qWWQWe .=:::::::::::::::   ..:::-.  . -:_
             .:...:.:::;:;.:jQWWWE;.+===;;;;:;::::.=ugwmp;..:=====.  -
           .=-.-::::;=;=;-.wQWBWWE;:++==+========;.=WWWWk.:|||||ii>...
         .vma. ::;:=====.<mWmWBWWE;:|+||++|+|||+|=:)WWBWE;=liiillIv; :
       .=3mQQa,:=====+==wQWBWBWBWh>:+|||||||i||ii|;=$WWW#>=lvvvvIvv;.
      .--+3QWWc:;=|+|+;=3QWBWBWWWmi:|iiiiiilllllll>-3WmW#>:IvlIvvv>` .
     .=___<XQ2=<|++||||;-9WWBWWWWQc:|iilllvIvvvnvvsi|\'\?Y1=:{IIIIi+- .
     ivIIiidWe;voi+|illi|.+9WWBWWWm>:<llvvvvnnnnnnn}~     - =++-
     +lIliidB>:+vXvvivIvli_."$WWWmWm;:<Ilvvnnnnonnv> .          .- .
      ~|i|IXG===inovillllil|=:"HW###h>:<lIvvnvnnvv>- .
        -==|1i==|vni||i|i|||||;:+Y1""'i=|IIvvvv}+-  .
           ----:=|l=+|+|+||+=:+|-      - --++--. .-
                  .  -=||||ii:. .              - .
                       -+ilI+ .;..
                         ---.::....

********************************************************************************
*
* @author      : Dominik Bonsch <db@s-db.de>
* @date        :
* @copyright   : s-db.de (Softwareentwicklung Dominik Bonsch) <contact@s-db.de>
* @distributor : s-db.de <contact@s-db.de>
* @project     : S-DB Modules
* @projectUrl  : http://s-db.de
* @version     : 1
* @revision    : 1
*
* @licence     : S-DB Business <contact@s-db.de>
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
class MyTask_Table_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// getter for the entities
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return MyTask_Entity
  */
  public function getEntityMyTask($objid = null )
  {

    $entityMyTask = $this->getRegisterd('entityMyTask');

    //entity my_task
    if (!$entityMyTask )
    {

      if (!is_null($objid ) )
      {
        $orm = $this->getOrm();

        if (!$entityMyTask = $orm->get( 'WbfsysTask', $objid) )
        {
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

        $this->register('entityMyTask', $entityMyTask);

      } else {
        $entityMyTask   = new MyTask_Entity() ;
        $this->register('entityMyTask', $entityMyTask);
      }

    }
    elseif ($objid && $objid != $entityMyTask->getId() )
    {
      $orm = $this->getOrm();

      if (!$entityMyTask = $orm->get( 'WbfsysTask', $objid) )
      {
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

      $this->register('entityMyTask', $entityMyTask);
    }

    return $entityMyTask;

  }//end public function getEntityMyTask */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param MyTask_Entity $entity
  */
  public function setEntityMyTask($entity )
  {

    $this->register('entityMyTask', $entity );

  }//end public function setEntityMyTask */

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

    $data['my_task']  = $this->getEntityMyTask();


    $tabData = array();

    foreach($data as $tabName => $ent )
    {
      // prüfen ob etwas gefunden wurde
      if (!$ent )
      {
        Debug::console( "Missing Entity for Reference: ".$tabName );
        continue;
      }

      $tabData = array_merge($tabData , $ent->getAllData($tabName ) );

    }


    // if we have a value, try to load the display field
    if ($data['my_task']->id_type )
    {
      $valMyTaskType = $orm->getField( 'WbfsysTaskType', 'rowid = '.$data['my_task']->id_type , 'name'  );
      $tabData['wbfsys_task_type_name'] = $valMyTaskType;
    } else {
      // else just set an empty string, fastest way ;-)
      $tabData['wbfsys_task_type_name'] = '';
    }

    // if we have a value, try to load the display field
    if ($data['my_task']->id_status )
    {
      $valMyTaskStatus = $orm->getField( 'WbfsysTaskStatus', 'rowid = '.$data['my_task']->id_status , 'name'  );
      $tabData['wbfsys_task_status_name'] = $valMyTaskStatus;
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


    if (!$fieldsMyTask = $this->getRegisterd('search_fields_my_task') )
    {
       $fieldsMyTask   = $orm->getSearchCols('WbfsysTask');
    }

    if ($refs = $httpRequest->dataSearchIds( 'search_my_task' ) )
    {
      $fieldsMyTask = array_unique( array_merge
      (
        $fieldsMyTask,
        $refs
      ));
    }

    $filterMyTask     = $httpRequest->checkSearchInput
    (
      $orm->getValidationData( 'WbfsysTask', $fieldsMyTask ),
      $orm->getErrorMessages( 'WbfsysTask'  ),
      'search_my_task'
    );
    $condition['my_task'] = $filterMyTask->getData();

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


    $query = $db->newQuery('MyTask_Table');
    
    // per exclude können regeln übergeben werden um bestimmte datensätze
    // auszublenden
    // wird häufig verwendet um bereits zugewiesenen datensätze aus zu blenden    
    if ($params->exclude )
    {

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

    try
    {

      //management  my_task source my_task
      $entityMyTask = $orm->newEntity('WbfsysTask');

      if (!$params->fieldsMyTask )
      {
        $params->fieldsMyTask  = $entityMyTask->getCols
        (
          $params->categories
        );
      }

      // if the validation fails report
      $httpRequest->validate
      (
        $entityMyTask,
        'my_task',
        $params->fieldsMyTask
      );

      // register the entity in the mode registry
      $this->register('entityMyTask',$entityMyTask);

      return !$this->getMessage()->hasErrors();
    }
    catch( InvalidInput_Exception $e )
    {
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
    if (!$entityMyTask = $this->getRegisterd('entityMyTask') )
    {
      $entityMyTask   = new MyTask_Entity() ;
    }

    $fieldsMyTask  = $entityMyTask->getSearchCols();
    $formMyTask    = $view->newForm('MyTask');
    $formMyTask->setNamespace('MyTask');
    $formMyTask->setPrefix('MyTask');
    $formMyTask->createSearchForm
    (
      $entityMyTask,
      $fieldsMyTask
    );


  }//end public function searchForm */

}//end class MyTask_Table_Model

