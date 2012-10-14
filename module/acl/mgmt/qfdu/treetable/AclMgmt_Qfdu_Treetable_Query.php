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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_Treetable_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Sub Users
   * @var array
   */
  public $users    = array();

  /**
   * Sub Datasets
   * @var array
   */
  public $datasets = array();

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $areaId, $condition = null, $params = null )
  {

    if( !$params )
      $params = new TFlag();

    $params->qsize = -1;

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
    $this->appendConditions( $criteria, $condition, $areaId, $params  );
    $this->checkLimitAndOrder( $criteria, $params );


    // Run Query und save the result
    $result           = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count( 'count(DISTINCT wbfsys_group_users.rowid) as '.Db::Q_SIZE );

    $this->data       = array();
    $this->users      = array();

    foreach( $result as $row )
    {
      $this->data[(int)$row['wbfsys_role_group_rowid']] = $row;

      if( !is_null($row['wbfsys_group_users_vid']) )
      {
        $this->datasets[(int)$row['wbfsys_role_group_rowid']][(int)$row['wbfsys_role_user_rowid']][]  = $row;
      }
      else
      {
        $this->users[(int)$row['wbfsys_role_group_rowid']][(int)$row['wbfsys_role_user_rowid']]  = $row;
      }

      if( !isset($this->users[(int)$row['wbfsys_role_group_rowid']][(int)$row['wbfsys_role_user_rowid']]) )
      {
        $this->users[(int)$row['wbfsys_role_group_rowid']][(int)$row['wbfsys_role_user_rowid']] = array
        (
          'name' => $row['user'],
          'id'   => $row['wbfsys_role_user_rowid'],
        );
      }

    }

  }//end public function fetch */

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
      'wbfsys_group_users.rowid as "wbfsys_group_users_rowid"',
      "COALESCE
      (
        '('||wbfsys_role_user.name||') ',
        ''
      )
      || COALESCE
      (
        core_person.lastname || ', ' || core_person.firstname,
        core_person.lastname,
        core_person.firstname,
        ''
      )  as user",
      'wbfsys_group_users.vid as "wbfsys_group_users_vid"',
      'wbfsys_group_users.date_start as "wbfsys_group_users_date_start"',
      'wbfsys_group_users.date_end as "wbfsys_group_users_date_end"',
      'wbfsys_group_users.description as "wbfsys_group_users_description"',
      'wbfsys_role_group.name as "wbfsys_role_group_name"',
      'wbfsys_role_group.rowid as "wbfsys_role_group_rowid"',
      'wbfsys_role_user.name as "wbfsys_role_user_name"',
      'wbfsys_role_user.rowid as "wbfsys_role_user_rowid"',
      'enterprise_employee.rowid as "enterprise_employee_rowid"',

    );

    $criteria->select( $cols );

  }//end public function setCols */

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

    $criteria->from( 'wbfsys_group_users' );

    $criteria->join
    (
      '
        JOIN wbfsys_role_group
          ON wbfsys_group_users.id_group = wbfsys_role_group.rowid
        JOIN wbfsys_role_user
          ON wbfsys_group_users.id_user = wbfsys_role_user.rowid
        JOIN
          core_person
            ON core_person.rowid = wbfsys_role_user.id_person
      ',
      array('wbfsys_role_group','wbfsys_role_user')
    );

    $criteria->join
    (
      'LEFT JOIN enterprise_employee on wbfsys_group_users.vid = enterprise_employee.rowid'
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
   * if there's a flag begin on $params the system expect that this is a char
   * that sould be used to filter by a beginning char
   *
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param int $areaId the area id
   * @param TFlag $params
   * @return void
   */
  public function appendConditions( $criteria, $condition, $areaId, $params )
  {

    if( isset( $condition['free'] ) && trim( $condition['free'] ) != ''  )
    {

      if( ctype_digit( $condition['free'] ) )
      {
        $criteria->where
        (
          '(  wbfsys_group_users.rowid = \''.$condition['free'].'\' )'
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
              '(
                (  upper(wbfsys_role_group.name) like upper(\''.$part.'%\') )
                OR
                (  upper(wbfsys_role_user.name) like upper(\''.$part.'%\') )
                OR
                (  upper(core_person.firstname) like upper(\''.$part.'%\') )
                OR
                (  upper(core_person.lastname) like upper(\''.$part.'%\') )
                OR

               )
              '
            );
          
          }
        
        }
        else
        {
        
          $part = $condition['free'];
        
          $criteria->where
          (
            '(
              (  upper(wbfsys_role_group.name) like upper(\''.$part.'%\') )
              OR
              (  upper(wbfsys_role_user.name) like upper(\''.$part.'%\') )
              OR
              (  upper(core_person.firstname) like upper(\''.$part.'%\') )
              OR
              (  upper(core_person.lastname) like upper(\''.$part.'%\') )
              OR

             )
            '
          );
        
        }
      

      }

    }//end if


    if( $params->begin )
    {
      $this->checkCharBegin( $criteria, $params );
    }
    

    $criteria->where
    (
      "wbfsys_group_users.id_area={$areaId} 
        and ( wbfsys_group_users.partial = 0 or  wbfsys_group_users.partial is null ) "
    );
    
    // and NOT wbfsys_group_users.vid IS NULL

  }//end public function appendConditions */

 /** check the begin flag to filter entries by their first char
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   * @return void
   */
  public function checkCharBegin( $criteria, $params )
  {

    // filter for a beginning char
    if( $params->begin )
    {

      if( '?' == $params->begin  )
      {
        $criteria->where( "wbfsys_role_group.name ~* '^[^a-zA-Z]'" );
      }
      else
      {
        $criteria->where( "upper(substr(wbfsys_role_group.name,1,1)) = '".strtoupper($params->begin)."'" );
      }

    }

  }//end public function checkCharBegin */

 /** check for limits, offset and order
   *
   * this method checks if there are parameters to manipulate the query result
   * - limit: if -1 the system sets no limit, if the limit is bigger than 500
   *          the system automatically resets the limit to 500
   * - offset: the offset for the query pointer
   * - order: an array of orders
   *
   * @param LibSqlCriteria $criteria
   * @param TArray $params
   * @return void
   */
  public function checkLimitAndOrder( $criteria, $params  )
  {

    // check if there is a given order
    if( $params->order )
    {
      $criteria->orderBy( $params->order );
    }
    else // if not use the default
    {
      $criteria->orderBy( 'wbfsys_role_group.name' );
    }

    // Check the offset
    if( $params->start )
    {
      if( $params->start < 0 )
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

} // end class AclMgmt_Qfdu_Treetable_Query */

