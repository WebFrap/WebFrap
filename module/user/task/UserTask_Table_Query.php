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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class UserTask_Table_Query
  extends LibSqlQuery
{

////////////////////////////////////////////////////////////////////////////////
// query elements table
////////////////////////////////////////////////////////////////////////////////

 /**
   * Loading the tabledata from the database
   * @param string/array $condition conditions for the query
   * @param TFlowFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $condition = null, $params = null )
  {

    if(!$params)
      $params = new TFlowFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    if( !$this->criteria )
    {
      $criteria = $db->orm->newCriteria();
    }
    else
    {
      $criteria = $this->criteria;
    }

    if( !$criteria->cols )
    {
      $this->setCols( $criteria );
    }

    $this->setTables( $criteria );
    $this->appendConditions( $criteria, $condition, $params  );
    $this->checkLimitAndOrder( $criteria, $params );


    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );
    $this->calcQuery = $criteria->count('count(project_task.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */

 /**
   * Loading the tabledata from the database
   * @param array $in
   * @param array $condition
   * @param TFlowFlag $params named parameters
   * @return void
   */
  public function fetchIn( array $in, $condition = array(), $params = null )
  {

    if( !$params )
      $params = new TFlowFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria          = $db->orm->newCriteria();

    $this->setCols( $criteria );
    $this->setTables( $criteria );


    $criteria->whereIn($in);
    $this->appendConditions( $criteria, $condition, $params  );
    $this->checkLimitAndOrder( $criteria, $params );

    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );
    $this->calcQuery = $criteria->count('count(project_task.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetchIn */

 /**
   * Loading the tabledata from the database
   *
   * @return void
   */
  public function fetchExclude( $condition, $params  )
  {
    if(!$params)
      $params = new TFlowFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $this->setCols( $criteria );
    $this->setTables( $criteria );


    $this->appendConditions( $criteria, $condition, $params  );
    $this->checkLimitAndOrder( $criteria, $params );

    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );
    $this->calcQuery = $criteria->count('count(project_task.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetchExclude */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setCols( $criteria )
  {

    $cols = array
    (
      'project_task.rowid as project_task_rowid',
      'project_task.title as project_task_title',
      'project_task.id_type as id_type_id_type',
      'project_task_type.name as project_task_type_name',
      'project_task.id_status as id_status_id_status',
      'project_task_status.name as project_task_status_name',
    );

    $criteria->select($cols);

  }//end public function setCols */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setTables( $criteria   )
  {

    $criteria->from('project_task');

    $criteria->joinOn
    (
      'project_task',
      'rowid',
      'project_task_employee',
      'id_task'
    );

    $criteria->leftJoinOn
    (
      'project_task',
      'id_status',
      'project_task_status',
      'rowid',
      null,
      'project_task_status'
    );// attribute reference project_task  by alias project_task_status

    $criteria->leftJoinOn
    (
      'project_task',
      'id_type',
      'project_task_type',
      'rowid',
      null,
      'project_task_type'
    );// attribute reference project_task  by alias project_task_type



  }//end public function setTables */

  /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param TFlowFlag $params
   * @return void
   */
  public function appendConditions( $criteria, $condition, $params )
  {


    // append codition if the query has a default filter
    if( $this->condition )
    {
      if( ctype_digit($this->condition) )
      {
        $criteria->where( 'project_task.rowid = '.$this->condition );
      }
      else if( is_string($this->condition) )
      {
        $criteria->where( $this->condition );
      }
      else if( is_array($this->condition) )
      {
        $this->checkConditions( $criteria, $this->condition  );
      }
    }

    if( $condition )
    {
      if( ctype_digit($condition ) )
      {
        $criteria->where( 'project_task.rowid = '.$condition );
      }
      else if( is_string($condition) )
      {
        $criteria->where( $condition );
      }
      else if( is_array($condition) )
      {
        $this->checkConditions( $criteria, $condition  );
      }
    }


    if( $params->begin )
    {
      $this->checkCharBegin( $criteria, $params );
    }

  }//end public function appendConditions */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @return void
   */
  public function checkConditions( $criteria, array $condition )
  {


      if( isset($condition['free']) && trim( $condition['free'] ) != ''  )
      {

         if( ctype_digit( $condition['free'] ) )
         {
            $criteria->where
            (
              '(
 project_task.rowid = \''.$condition['free'].'\'
              )'
            );
         }

      }//end if

      // search conditions for  project_task
      if( isset ($condition['project_task']) )
      {
        $whereCond = $condition['project_task'];

        if( isset($whereCond['title']) && trim($whereCond['title']) != ''  )
          $criteria->where( ' project_task.title = \''.$whereCond['title'].'\' ');

        if( isset($whereCond['id_develop_status']) && count($whereCond['id_develop_status']) )
          $criteria->where( " project_task.id_develop_status IN( '".implode("','",$whereCond['id_develop_status'])."' ) " );

        if( isset($whereCond['id_status']) && count($whereCond['id_status']) )
          $criteria->where( " project_task.id_status IN( '".implode("','",$whereCond['id_status'])."' ) " );

        if( isset($whereCond['id_type']) && count($whereCond['id_type']) )
          $criteria->where( " project_task.id_type IN( '".implode("','",$whereCond['id_type'])."' ) " );

        if( isset($whereCond['id_relevance']) && count($whereCond['id_relevance']) )
          $criteria->where( " project_task.id_relevance IN( '".implode("','",$whereCond['id_relevance'])."' ) " );

        // append meta information
        if( isset($whereCond['m_role_create']) && trim($whereCond['m_role_create']) != ''  )
          $criteria->where( ' project_task.m_role_create = '.$whereCond['m_role_create'].' ');

        if( isset($whereCond['m_role_change']) && trim($whereCond['m_role_change']) != ''  )
          $criteria->where( ' project_task.m_role_change = '.$whereCond['m_role_change'].' ');

        if( isset($whereCond['m_time_created_before']) && trim($whereCond['m_time_created_before']) != ''  )
          $criteria->where( ' project_task.m_time_created <= \''.$whereCond['m_time_created_before'].'\' ');

        if( isset($whereCond['m_time_created_after']) && trim($whereCond['m_time_created_after']) != ''  )
          $criteria->where( ' project_task.m_time_created => \''.$whereCond['m_time_created_after'].'\' ');

        if( isset($whereCond['m_time_changed_before']) && trim($whereCond['m_time_changed_before']) != ''  )
          $criteria->where( ' project_task.m_time_changed <= \''.$whereCond['m_time_changed_before'].'\' ');

        if( isset($whereCond['m_time_changed_after']) && trim($whereCond['m_time_changed_after']) != ''  )
          $criteria->where( ' project_task.m_time_changed => \''.$whereCond['m_time_changed_after'].'\' ');

        if( isset($whereCond['m_rowid']) && trim($whereCond['m_rowid']) != ''  )
          $criteria->where( ' project_task.rowid => \''.$whereCond['m_rowid'].'\' ');

        if( isset($whereCond['m_uuid']) && trim($whereCond['m_uuid']) != ''  )
          $criteria->where( ' project_task.m_uuid => \''.$whereCond['m_uuid'].'\' ');

      }//end if( isset ($condition['project_task']) )


  }//end public function checkConditions */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param TFlowFlag $params
   * @return void
   */
  public function checkCharBegin( $criteria, $params )
  {

      // filter for a beginning char
      if( $params->begin )
      {

        if( '?' == $params->begin  )
        {
          $criteria->where( "project_task.title ~* '^[^a-zA-Z]'" );
        }
        else
        {
          $criteria->where( "upper(substr(project_task.title,1,1)) = '".strtoupper($params->begin)."'" );
        }

      }


  }//end public function checkCharBegin */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param $params
   * @return void
   */
  public function checkLimitAndOrder( $criteria, $params  )
  {

    // check if there is a given order
    if( $params->order )
      $criteria->orderBy( $params->order );
    else // if not use the default
      $criteria->orderBy('project_task.rowid');


    // Check the offset
    if( $params->start )
    {
      if( $params->start < 0)
        $params->start = 0;
    }
    else
    {
      $params->start = null;
    }
    $criteria->offset( $params->start );

    // Check the limit
    if( -1 == $params->qsize )
    {
      // no limit if -1
      $params->qsize = null;
    }
    else if( $params->qsize )
    {
      // limit must not be bigger than max, for no limit use -1
      if( $params->qsize > Wgt::$maxListSize )
        $params->qsize = Wgt::$maxListSize;
    }
    else
    {
      // if limit 0 or null use the default limit
      $params->qsize = Wgt::$defListSize;
    }

    $criteria->limit( $params->qsize );

  }//end public function checkLimitAndOrder */


}//end class UserTask_Table_Query

