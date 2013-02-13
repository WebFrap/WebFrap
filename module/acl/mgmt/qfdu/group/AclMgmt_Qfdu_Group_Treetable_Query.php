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
class AclMgmt_Qfdu_Group_Treetable_Query
  extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $context
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $areaId, $condition = null, $context = null )
  {

    if( !$context )
      $context = new Context();

    $context->qsize = -1;

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

    $this->setCols( $criteria );
    $this->setTables( $criteria );
    $this->appendConditions( $criteria, $condition, null, $areaId, $context  );
    $this->checkLimitAndOrder( $criteria, $context );


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
  public function fetchListUser( $userId, $dsetId, $areaId, $condition = null, $context = null )
  {

    if( !$context )
      $context = new TFlag();

    $context->qsize = -1;
    $context->groupBy = 'user';

    $this->sourceSize  = null;
    $db                = $this->getDb();
    
    $ids = new TFlag();
    $ids->userId = $userId;
    $ids->dsetId = $dsetId;
    

    $criteria = $db->orm->newCriteria();

    $this->setColsListUser( $criteria );
    $this->setTables( $criteria );
    $this->appendConditions( $criteria, $condition, $ids, $areaId, $context  );
    $this->checkLimitAndOrder( $criteria, $context );


    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count( 'count(DISTINCT group_users.id_group) as '.Db::Q_SIZE, true );

  }//end public function fetchListUser */
  
  /** 
   * build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param int $dsetId
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $context
   * 
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchListDset( $userId, $dsetId, $areaId, $condition = null, $context = null )
  {

    if( !$context )
      $context = new TFlag();

    $context->qsize = -1;
    $context->groupBy = 'dset';

    $this->sourceSize  = null;
    $db                = $this->getDb();
    
    $ids = new TFlag();
    $ids->userId = $userId;
    $ids->dsetId = $dsetId;
    

    $criteria = $db->orm->newCriteria();

    $this->setColsListUser( $criteria );
    $this->setTables( $criteria );
    $this->appendConditions( $criteria, $condition, $ids, $areaId, $context  );
    $this->checkLimitAndOrder( $criteria, $context );


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
   * @return void
   */
  public function setCols( $criteria )
  {

    $cols = array
    (
      'role_group.name as "role_group_name"',
      'role_group.rowid as "role_group_rowid"',
      'count( distinct group_users.id_user ) as "group_assignments"'
    );

    $criteria->select( $cols, true );
    $criteria->groupBy( array( 'role_group.name', 'role_group.rowid' )  );

  }//end public function setCols */
  
 /** inject the requested cols in the criteria
   *
   * to add more cols overwrite this method, or create more methods that also
   * inject cols.
   * It't not expected that you try to remove a onetime setted col, so think
   * about what you are going to do.
   *
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setColsListUser( $criteria )
  {

    $cols = array
    (
      'role_group.rowid as role_group_rowid',
      'role_group.name as role_group_name',
      'group_users.rowid as group_users_rowid',
      'group_users.date_start as group_users_date_start',
      'group_users.date_end as group_users_date_end'
    );

    $criteria->select( $cols, true );

  }//end public function setColsListUser */

 /**
   * inject the table an join conditions in the criteria object
   * to append new join conditions overwrite this method, or create a second
   * method that injects more join conditions
   *
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setTables( $criteria )
  {

    $criteria->from( 'wbfsys_group_users group_users', 'group_users' );

    $criteria->join
    (
      'JOIN wbfsys_role_group role_group
          ON group_users.id_group = role_group.rowid
      ',
      array( 'role_group' )
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
   * @param int $areaId the area id
   * @param TFlag $context
   * @return void
   */
  public function appendConditions( $criteria, $condition, $ids, $areaId, $context )
  {

    if( isset( $condition['free'] ) && trim( $condition['free'] ) != ''  )
    {

      if( ctype_digit( $condition['free'] ) )
      {
        $criteria->where
        (
          '(  group_users.rowid = \''.$condition['free'].'\' )'
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
              
            $criteria->where
            (
              ' ( upper(role_group.name) like upper(\''.$part.'%\') ) '
            );
          
          }
        
        }
        else
        {
        
          $part = $condition['free'];
        
          $criteria->where
          (
            ' (  upper(role_group.name) like upper(\''.$part.'%\') ) '
          );
        
        }
      

      }

    }//end if


    if( 'user' == $context->groupBy )
    {

      $criteria->where
      (
        "group_users.id_area = {$areaId} 
        	AND group_users.id_user = {$ids->userId} 
        	AND group_users.vid = {$ids->dsetId}
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
        "group_users.id_area = {$areaId} 
        	AND group_users.id_user = {$ids->userId} 
        	AND group_users.vid = {$ids->dsetId}
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
        "group_users.id_area={$areaId} 
          and ( group_users.partial = 0 or group_users.partial is null ) "
      );
      
    }

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
  public function checkLimitAndOrder( $criteria, $context  )
  {

    // check if there is a given order
    if( $context->order )
    {
      $criteria->orderBy( $context->order );
    }
    else // if not use the default
    {
      $criteria->orderBy( 'role_group.name' );
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

} // end class AclMgmt_Qfdu_Treetable_Query_Postgresql */

