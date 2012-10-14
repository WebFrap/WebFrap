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
class Webfrap_Acl_Table_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   * @param string/array $condition conditions for the query
   * @param TFlowFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $areaId, $condition = null, $params = null )
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

    $criteria->where("id_area={$areaId}");

    // Run Query und save the result
    $this->result    = $db->orm->select( $criteria );
    $this->calcQuery = $criteria->count('count(wbfsys_security_access.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */

 /** build criteria, but don't interpret conditions
   *
   * This method builds the criteria without interpreting the conditions
   * it's an infiltered view, just handling limit, offset and order
   *
   * @param int $areaId
   * @param TFlowFlag $params named parameters
   * @return void
   */
  public function fetchAll( $areaId, $params )
  {

    $db                = $this->getDb();
    $criteria          = $db->orm->newCriteria();
    $this->sourceSize  = null;

    $this->setCols( $criteria );
    $this->setTables( $criteria );

    $this->checkLimitAndOrder( $criteria, $params );

    $criteria->where("id_area={$areaId}");

    // Run Query und save the result
    $this->result = $db->orm->select( $criteria );
    $this->calcQuery = $criteria->count('count(wbfsys_security_access.'.Db::PK.') as '.Db::Q_SIZE );

  }//end public function fetchAll */

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
      'wbfsys_role_group.name as wbfsys_role_group_name',
      'wbfsys_security_access.has_access as wbfsys_security_access_has_access',
      'wbfsys_security_access.has_insert as wbfsys_security_access_has_insert',
      'wbfsys_security_access.has_update as wbfsys_security_access_has_update',
      'wbfsys_security_access.has_delete as wbfsys_security_access_has_delete',
      'wbfsys_security_access.has_admin as wbfsys_security_access_has_admin',
      'wbfsys_security_access.rowid as wbfsys_security_access_rowid',
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

    $criteria->from('wbfsys_security_access');

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
   * @param TFlowFlag $params
   * @return void
   */
  public function appendConditions( $criteria, $condition, $params )
  {


    // append codition if the query has a default filter
    if( $this->condition )
    {

      if( is_string($this->condition) )
      {

        if( ctype_digit($this->condition) )
        {
          $criteria->where( 'wbfsys_security_access.rowid = '.$this->condition );
        }
        else
        {
          $criteria->where( $this->condition );
        }

      }
      else if( is_array($this->condition) )
      {
        $this->checkConditions( $criteria, $this->condition  );
      }
    }

    if( $condition )
    {

      if( is_string($condition) )
      {
        if( ctype_digit($condition ) )
        {
          $criteria->where( 'wbfsys_security_access.rowid = '.$condition );
        }
        else
        {
          $criteria->where( $condition );
        }
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

 /** interpret condition array by convention
   *
   * interpret condition array and inject conditions in the criteria object
   *
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
              '(  wbfsys_security_access.rowid = \''.$condition['free'].'\' )'
            );
         }

      }//end if


  }//end public function checkConditions */

 /** check the begin flag to filter entries by their first char
   *
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
   *           the system automatically resets the limit to 500
   * - offset: the offset for the query pointer
   * - order:  an array of orders
   *
   * @param LibSqlCriteria $criteria
   * @param TArray $params
   * @return void
   */
  public function checkLimitAndOrder( $criteria, $params  )
  {

    // check if there is a given order
    if( $params->order )
      $criteria->orderBy( $params->order );
    else // if not use the default
      $criteria->orderBy('wbfsys_role_group.name');


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

} // end class WebFrap_Acl_Table_Query */

