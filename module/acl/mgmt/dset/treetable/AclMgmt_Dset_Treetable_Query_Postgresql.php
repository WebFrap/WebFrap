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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Dset_Treetable_Query_Postgresql
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


////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /** build criteria, interpret conditions and load data
   *
   * @param int $datasetId
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $datasetId, $areaId, $condition = null, $params = null )
  {

    if(!$params)
      $params = new TFlag();

    $params->qsize = -1;

    $this->queryGroups( $areaId, $condition );

    $groupIds = array();
    foreach( $this->data as $data )
      $groupIds[] = $data['wbfsys_role_group_rowid'];

    $this->queryUsers( $areaId, $groupIds, $datasetId, $condition );

  }//end public function fetch */


 /**
   *
   * @param int $idArea
   * @return void
   */
  public function queryGroups( $idArea, $condition )
  {

    $db = $this->getDb();

    $sqlGroups = <<<SQL
  SELECT
    wbfsys_role_group.rowid as "wbfsys_role_group_rowid",
    wbfsys_role_group.name as "wbfsys_role_group_name",
    wbfsys_security_access.rowid as "wbfsys_security_access_rowid",
    wbfsys_security_access.access_level as "wbfsys_security_access_access_level",
    wbfsys_security_access.date_start as "wbfsys_security_access_date_start",
    wbfsys_security_access.date_end as "wbfsys_security_access_date_end",
    wbfsys_security_access.id_group as "wbfsys_security_access_id_group"
  FROM
    wbfsys_role_group
  JOIN
    wbfsys_security_access
      ON wbfsys_security_access.id_group = wbfsys_role_group.rowid
  WHERE
    wbfsys_security_access.id_area = {$idArea}
      AND (wbfsys_security_access.partial = 0 or wbfsys_security_access.partial is null)

SQL;

    /*
    if( isset($condition['free']) && trim( $condition['free'] ) != ''  )
    {

      if( ctype_digit( $condition['free'] ) )
      {
        $sqlGroups .= ' AND wbfsys_role_group.rowid = \''.$condition['free'].'\' ';

      }
      else
      {
        $sqlGroups .= ' AND upper(wbfsys_role_group.name) like upper(\''.$condition['free'].'%\')';
      }

    }//end if
    */

    $sqlGroups .= <<<SQL

    ORDER BY
      wbfsys_role_group.name

SQL;

    $this->data = $db->select( $sqlGroups )->getAll();

  }//end public function queryGroups */

 /**
  * @param int $areaId
  * @param int $groupIds
  * @param int $datasetId
  * @param int $condition
  *
  * @return void
  */
  public function queryUsers( $areaId, $groupIds, $datasetId, $condition )
  {

    if( !$groupIds )
      return null;

    $db = $this->getDb();

    $inGroup = implode(',', $groupIds);

    $sqlUsers = <<<SQL
  SELECT
    wbfsys_role_user.rowid as "wbfsys_role_user_rowid",
    COALESCE
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
    )  as user ,
    wbfsys_group_users.rowid as "wbfsys_group_users_rowid",
    wbfsys_group_users.vid as "wbfsys_group_users_vid",
    wbfsys_group_users.id_group as "wbfsys_group_users_id_group",
    wbfsys_group_users.date_start as "wbfsys_group_users_date_start",
    wbfsys_group_users.date_end as "wbfsys_group_users_date_end",
    wbfsys_group_users.description as "wbfsys_group_users_description"
  FROM
    wbfsys_role_user
  JOIN
    core_person
      ON core_person.rowid = wbfsys_role_user.id_person
  JOIN
    wbfsys_group_users
      ON wbfsys_group_users.id_user = wbfsys_role_user.rowid
  WHERE
    wbfsys_group_users.id_group IN( {$inGroup} )
    AND 
      wbfsys_group_users.id_area = {$areaId}
    AND
      ( wbfsys_group_users.partial = 0 OR wbfsys_group_users.partial is null )
    AND
      wbfsys_group_users.vid = {$datasetId}

SQL;

    if( isset($condition['free']) && trim( $condition['free'] ) != ''  )
    {

      if( ctype_digit( $condition['free'] ) )
      {
        $sqlUsers .= ' AND wbfsys_role_group.rowid = \''.$condition['free'].'\' ';
      }
      else
      {
          // prüfen ob mehrere suchbegriffe kommagetrennt übergeben wurden
          if( strpos( $condition['free'], ',' ) )
          {
          
            $parts = explode( ',', $condition['free'] );
            
            $tmpChecks = array();
            
            foreach( $parts as $part )
            {
            
              $safeVal = $db->addSlashes( trim( $part ) );
              
              // prüfen, dass der string nicht leer ist
              if( '' == trim( $safeVal ) )
                continue;
         
              $tmpChecks[] = " upper( wbfsys_role_user.name ) like upper('{$safeVal}%') ";
              $tmpChecks[] = " upper( core_person.lastname ) like upper('{$safeVal}%') ";
              $tmpChecks[] = " upper( core_person.firstname ) like upper('{$safeVal}%') ";
              
           }
           
           // alle checks mit or verknüpfen
           $sqlChecks = implode( ' OR ', $tmpChecks );
           
           $sqlUsers .= <<<SQL
  AND
  (
    {$sqlChecks}
  )
  
SQL;
           
         }
         else
         {
           $safeVal = $db->addSlashes( $condition['free'] );
            
           // hier haben wir nur einen Check, daher einfach hardcoded abfragen
           $sqlUsers .= <<<SQL
  AND
  (
    upper( wbfsys_role_user.name ) like upper('{$safeVal}%') 
    OR
      upper( core_person.lastname ) like upper('{$safeVal}%') 
    OR
      upper( core_person.firstname ) like upper('{$safeVal}%') 
  )
  
SQL;
            
         }
      
        
      }

    }//end if

    $sqlUsers .= <<<SQL

    order by
      wbfsys_role_user.name

SQL;

    $tmp = $db->select( $sqlUsers )->getAll();

    foreach( $tmp as $user )
    {
      $this->users[$user['wbfsys_group_users_id_group']][$user['wbfsys_role_user_rowid']] = $user;
    }

  }//end public function queryUsers */



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
   * @param TFlag $params
   * @return void
   */
  public function appendConditions( $criteria, $condition, $params )
  {

    if( isset($condition['free']) && trim( $condition['free'] ) != ''  )
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
        $criteria->where
        (
          '(
            (  upper(wbfsys_role_group.name) like upper(\''.$condition['free'].'%\') )
            OR
            (  upper(wbfsys_role_user.name) like upper(\''.$condition['free'].'%\') )
            OR
            (  upper(enterprise_employee.name) like upper(\''.$condition['free'].'%\') )

           )
          '
        );
      }

    }//end if


    if( $params->begin )
    {
      $this->checkCharBegin( $criteria, $params );
    }

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

} // end class AclMgmt_Dset_Treetable_Query_Postgresql */

