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
class AclMgmt_Qfdu_Dset_Treetable_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var DomainNode
   */
  public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /** build criteria, interpret conditions and load data
   *
   * @param int $groupId
   * @param int $userId
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $context
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $groupId, $userId, $areaId, $condition = null, $context = null )
  {

    if( !$context )
      $context = new TFlag();

    $context->qsize = -1;

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria  = $db->orm->newCriteria();
    $dsetEntiy = $db->orm->newEntity( $this->domainNode->srcKey );
    
    $textKeys = $dsetEntiy->textKeys();
    $tableKey = $dsetEntiy->getTable();
    $fieldKeys = array();
    
    if( $textKeys )
    {
      foreach( $textKeys as $fieldName )
      {
        $fieldKeys[] = "{$tableKey}.{$fieldName}";
      }
    }
    
    $ids = new TFlag();
    $ids->groupId = $groupId;
    $ids->userId = $userId;
    $ids->areaId = $areaId;

    $this->setCols( $criteria, $tableKey, $fieldKeys );
    $this->setTables( $criteria, $tableKey );
    $this->appendConditions( $criteria, $condition, $ids, $tableKey, $fieldKeys, $context );
    $this->checkLimitAndOrder( $criteria, $tableKey, $fieldKeys, $context );


    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count( 'count(DISTINCT group_users.id_group) as '.Db::Q_SIZE, true );

  }//end public function fetch */
  
  /** 
   * build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $context
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchListUser( $userId, $areaId, $condition = null, $context = null )
  {

    if( !$context )
      $context = new TFlag();

    $context->qsize = -1;

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria  = $db->orm->newCriteria();
    $dsetEntiy = $db->orm->newEntity( $this->domainNode->srcKey );
    
    $textKeys = $dsetEntiy->textKeys();
    $tableKey = $dsetEntiy->getTable();
    $fieldKeys = array();
    
    if( $textKeys )
    {
      foreach( $textKeys as $fieldName )
      {
        $fieldKeys[] = "{$tableKey}.{$fieldName}";
      }
    }
    
    $ids = new TFlag();
    $ids->userId = $userId;
    $ids->areaId = $areaId;
    
    $context->groupBy = 'user';
    

    $this->setColsListUser( $criteria, $tableKey, $fieldKeys );
    $this->setTables( $criteria, $tableKey );
    $this->appendConditions( $criteria, $condition, $ids, $tableKey, $fieldKeys, $context );
    $this->checkLimitAndOrder( $criteria, $tableKey, $fieldKeys, $context );

    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count( 'count(DISTINCT group_users.id_user) as '.Db::Q_SIZE, true );

  }//end public function fetchListUser */
  
  /** 
   * build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $context
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchListDset( $areaId, $condition = null, $context = null )
  {

    if( !$context )
      $context = new TFlag();

    $context->qsize = -1;

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria  = $db->orm->newCriteria();
    $dsetEntiy = $db->orm->newEntity( $this->domainNode->srcKey );
    
    $textKeys = $dsetEntiy->textKeys();
    $tableKey = $dsetEntiy->getTable();
    $fieldKeys = array();
    
    if( $textKeys )
    {
      foreach( $textKeys as $fieldName )
      {
        $fieldKeys[] = "{$tableKey}.{$fieldName}";
      }
    }
    
    $ids = new TFlag();
    $ids->areaId = $areaId;
    
    $context->groupBy = 'dset';
    

    $this->setColsListDset( $criteria, $tableKey, $fieldKeys );
    $this->setTables( $criteria, $tableKey );
    $this->appendConditions( $criteria, $condition, $ids, $tableKey, $fieldKeys, $context );
    $this->checkLimitAndOrder( $criteria, $tableKey, $fieldKeys, $context );


    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count( 'count(DISTINCT group_users.vid) as '.Db::Q_SIZE, true );

  }//end public function fetchListDset */

 /** inject the requested cols in the criteria
   *
   * to add more cols overwrite this method, or create more methods that also
   * inject cols.
   * It't not expected that you try to remove a onetime setted col, so think
   * about what you are going to do.
   *
   * @param LibSqlCriteria $criteria
   * @param Entity $dsetEntiy
   * @return void
   */
  public function setCols( $criteria, $tableKey, $textKeys )
  {

    $colSql = '';
    
    if( $textKeys )
    {
      $colSql = implode( " || ', ' ||  ", $textKeys ).' as dset_text ';
    }
    else 
    {
      $colSql = "'{$this->domainNode->label}: ' || {$tableKey}.rowid as dset_text ";
    }
    
    
    $cols = array
    (
      "group_users.rowid as entry_id",
      "group_users.date_start as group_users_date_start",
      "group_users.date_end as group_users_date_end",
      $tableKey.".rowid as dset_rowid",
      $colSql
    );
    $criteria->select( $cols );

  }//end public function setCols */

 /** inject the requested cols in the criteria
   *
   * to add more cols overwrite this method, or create more methods that also
   * inject cols.
   * It't not expected that you try to remove a onetime setted col, so think
   * about what you are going to do.
   *
   * @param LibSqlCriteria $criteria
   * @param Entity $dsetEntiy
   * @return void
   */
  public function setColsListUser( $criteria, $tableKey, $textKeys )
  {

    $colSql = '';
    $groupBy = array
    (
      $tableKey.".rowid"
    );
    
    if( $textKeys )
    {
      $colSql = implode( " || ', ' ||  ", $textKeys ).' as dset_text ';
      
      foreach( $textKeys as $textKey )
      {
        $groupBy[] = $textKey;
      }
    }
    else 
    {
      $colSql = "'{$this->domainNode->label}: ' || {$tableKey}.rowid as dset_text ";
    }
    
    
    $cols = array
    (
      $tableKey.".rowid as dset_rowid",
      $colSql,
      "count( distinct group_users.id_group ) as num_groups"
    );
    $criteria->select( $cols );

    $criteria->groupBy( $groupBy );
    
  }//end public function setColsListUser */
  
 /** inject the requested cols in the criteria
   *
   * to add more cols overwrite this method, or create more methods that also
   * inject cols.
   * It't not expected that you try to remove a onetime setted col, so think
   * about what you are going to do.
   *
   * @param LibSqlCriteria $criteria
   * @param Entity $dsetEntiy
   * @return void
   */
  public function setColsListDset( $criteria, $tableKey, $textKeys )
  {

    $colSql = '';
    $groupBy = array
    (
      $tableKey.".rowid"
    );
    
    if( $textKeys )
    {
      $colSql = implode( " || ', ' ||  ", $textKeys ).' as dset_text ';
      
      foreach( $textKeys as $textKey )
      {
        $groupBy[] = $textKey;
      }
    }
    else 
    {
      $colSql = "'{$this->domainNode->label}: ' || {$tableKey}.rowid as dset_text ";
    }
    
    
    $cols = array
    (
      $tableKey.".rowid as dset_rowid",
      $colSql,
      "count( distinct group_users.id_user ) as num_users"
    );
    $criteria->select( $cols );

    $criteria->groupBy( $groupBy );
    
  }//end public function setColsListDset */
  
 /**
   * inject the table an join conditions in the criteria object
   * to append new join conditions overwrite this method, or create a second
   * method that injects more join conditions
   *
   * @param LibSqlCriteria $criteria
   * @param string $tableKey
   * @return void
   */
  public function setTables( $criteria, $tableKey )
  {

    $criteria->from( 'wbfsys_group_users group_users', 'group_users' );

    $criteria->join
    (
      '
        JOIN '.$tableKey.'
          ON group_users.vid = '.$tableKey.'.rowid
      ',
      array( $tableKey )
    );


  }//end public function setTables */

  /** inject conditions in the criteria object
   *
   * this method checks if there where conditions that has to injected in the
   * criteria
   * if condition is a int value the method expects to get the rowid
   * if condition is a string, the system expects to get a query fragment
   * if condition is an array the variable is delegated to checkConditions to be
   *   interpreted by convention
   *
   * if there's a flag begin on $context the system expect that this is a char
   * that sould be used to filter by a beginning char
   *
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param TFlag $ids
   * @param string $tableKey
   * @param array $textKeys
   * @param TFlag $context
   * @return void
   */
  public function appendConditions
  ( 
    $criteria, $condition, 
    $ids, $tableKey, 
    $textKeys, $context
  )
  {

    if( isset( $condition['free'] ) && trim( $condition['free'] ) != ''  )
    {

      if( ctype_digit( $condition['free'] ) )
      {
        $criteria->where
        (
          '(  '.$tableKey.'.rowid = \''.$condition['free'].'\' )'
        );
      }
      else
      {
      
        if( strpos( $condition['free'], ',' ) )
        {
        
          $parts = explode( ',', $condition['free'] );
          
          foreach( $parts as $part )
          {
          
            $part = trim( $part );
            
            // prüfen, dass der string nicht leer ist
            if( '' == trim( $part ) )
              continue;

            $tmp = array();
            
            foreach( $textKeys as $tKey )
            {
              $tmp[] = "(  upper({$tKey}) like upper(\''.$part.'%\') )";
            }
              
            $criteria->where( '( '.implode( ' OR ', $tmp ).' )' );
          
          }
        
        }
        else
        {
        
          $part = $condition['free'];
        
          $tmp = array();
          
          foreach( $textKeys as $tKey )
          {
            $tmp[] = "(  upper({$tKey}) like upper(\''.$part.'%\') )";
          }
            
          $criteria->where( '( '.implode( ' OR ', $tmp ).' )' );

        }
      
      }

    }//end if
    
    if( 'user' == $context->groupBy )
    {

      $criteria->where
      (
        "group_users.id_area = {$ids->areaId} 
        	AND group_users.id_user = {$ids->userId}
          AND 
          ( 
          	group_users.partial = 0 
          	OR  
          	group_users.partial is null 
          )"
      );
    
    }
    else if( 'dset' == $context->groupBy )
    {

      $criteria->where
      (
        "group_users.id_area = {$ids->areaId} 
          AND 
          ( 
          	group_users.partial = 0 
          	OR  
          	group_users.partial is null 
          )"
      );
    
    }
    else 
    {
      $criteria->where
      (
        "group_users.id_area = {$ids->areaId} 
        	AND group_users.id_group = {$ids->groupId}
        	AND group_users.id_user = {$ids->userId}
          AND 
          ( 
          	group_users.partial = 0 
          	OR  
          	group_users.partial is null 
          )"
      );
      
    }
    
    // and NOT group_users.vid IS NULL

  }//end public function appendConditions */

 /** check for limits, offset and order
   *
   * this method checks if there are parameters to manipulate the query result
   * - limit: if -1 the system sets no limit, if the limit is bigger than 500
   *          the system automatically resets the limit to 500
   * - offset: the offset for the query pointer
   * - order: an array of orders
   *
   * @param LibSqlCriteria $criteria
   * @param TArray $context
   * @return void
   */
  public function checkLimitAndOrder( $criteria, $tableKey, $textKeys, $context  )
  {
    
    if( $textKeys )
    {
      // check if there is a given order
      $criteria->orderBy( current($textKeys) );
    }
    else 
    {
      $criteria->orderBy( "{$tableKey}.rowid" );
    }


    // Check the offset
    if( $context->start )
    {
      if( $context->start < 0 )
        $context->start = 0;
    }
    else
    {
      $context->start = null;
    }
    $criteria->offset( $context->start );

    // Check the limit
    if( -1 == $context->qsize )
    {
      // no limit if -1
      $context->qsize = null;
    }
    else if( $context->qsize )
    {
      // limit must not be bigger than max, for no limit use -1
      if( $context->qsize > Wgt::$maxListSize )
        $context->qsize = Wgt::$maxListSize;
    }
    else
    {
      // if limit 0 or null use the default limit
      $context->qsize = Wgt::$defListSize;
    }

    $criteria->limit( $context->qsize );

  }//end public function checkLimitAndOrder */

} // end class AclMgmt_Qfdu_Treetable_User_Query */

