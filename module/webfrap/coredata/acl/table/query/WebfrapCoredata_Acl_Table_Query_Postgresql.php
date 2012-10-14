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
class WebfrapCoredata_Acl_Table_Query_Postgresql
  extends Webfrap_Acl_Table_Query
{
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   *
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $areaId, $condition = null, $params = null )
  {

    if(!$params)
      $params = new TFlag();

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

    $criteria->where( "id_area={$areaId} and partial = 0" );

    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );
    $this->calcQuery = $criteria->count('count(DISTINCT wbfsys_security_access.'.Db::PK.') as '.Db::Q_SIZE);

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

    ///TODO remove one of redundant id_group attributes
    // take care for the getEntryData method on the model
    $cols = array
    (
      'wbfsys_security_access.rowid as "wbfsys_security_access_rowid"',
      'wbfsys_security_access.access_level as "wbfsys_security_access_access_level"',
      'wbfsys_security_access.date_start as "wbfsys_security_access_date_start"',
      'wbfsys_security_access.date_end as "wbfsys_security_access_date_end"',
      'wbfsys_security_access.id_group as "wbfsys_security_access_id_group"',
      'wbfsys_role_group.name as "wbfsys_role_group_name"',
      'wbfsys_role_group.rowid as "wbfsys_role_group_rowid"',
    );

    $criteria->select($cols);

  }//end public function setCols */

  /**
   * inject the table an join conditions in the criteria object
   * to append new join conditions overwrite this method, or create a second
   * method that injects more join conditions
   *
   * @param LibSqlCriteria $criteria
   * @return void
   */
  public function setTables( $criteria   )
  {

    $criteria->from( 'wbfsys_security_access' );

    $criteria->leftJoinOn
    (
      'wbfsys_security_access',
      'id_group',
      'wbfsys_role_group',
      'rowid',
      null,
      'wbfsys_role_group'
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
            '( wbfsys_security_access.rowid = \''.$condition['free'].'\' )'
          );
       }
       else
       {
          $criteria->where
          (
            '(  upper(wbfsys_role_group.name) like upper(\'%'.$condition['free'].'%\') )'
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

} // end class WebfrapCoredata_Acl_Table_Query_Postgresql */

