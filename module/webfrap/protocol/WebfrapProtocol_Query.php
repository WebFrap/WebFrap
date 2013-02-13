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
class WebfrapProtocol_Query
  extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// queries
//////////////////////////////////////////////////////////////////////////////*/


 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchFullProtocol(  $params )
  {

    $this->sourceSize   = null;
    $db                 = $this->getDb();

    $criteria           = $db->orm->newCriteria();

    $cols = array
    (
      'wbfsys_protocol_message.message  as wbfsys_protocol_message_message',
      'wbfsys_protocol_message.context  as wbfsys_protocol_message_context',
      'wbfsys_protocol_message.m_time_created  as wbfsys_protocol_m_time_created',
      'wbfsys_protocol_message.m_role_create  as wbfsys_protocol_m_role_create',
      'wbfsys_protocol_message.vid      as wbfsys_protocol_message_vid',
      'wbfsys_protocol_message.rowid    as wbfsys_protocol_message_rowid',
      'view_person_role.core_person_firstname ',
      'view_person_role.core_person_lastname '
    );

    $criteria->select($cols);

    $criteria->from('wbfsys_protocol_message');

    $criteria->leftJoinOn
    (
      'wbfsys_protocol_message',
      'm_role_create',
      'view_person_role',
      'wbfsys_role_user_rowid'
    );// attribute reference


    $this->checkLimitAndOrder( $criteria, $params );

    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count('count(wbfsys_protocol_message.'.Db::PK.') as '.Db::Q_SIZE);


  }//end public function fetchFullProtocol */

 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchEntityProtocol( $entityKey , $params )
  {

    $this->sourceSize   = null;
    $db                 = $this->getDb();

    $entityId           = $db->orm->getResourceId( $entityKey );
    $criteria           = $db->orm->newCriteria();

    $cols = array
    (
      'wbfsys_protocol_message.message  as wbfsys_protocol_message_message',
      'wbfsys_protocol_message.context  as wbfsys_protocol_message_context',
      'wbfsys_protocol_message.m_time_created  as wbfsys_protocol_m_time_created',
      'wbfsys_protocol_message.m_role_create  as wbfsys_protocol_m_role_create',
      'wbfsys_protocol_message.vid      as wbfsys_protocol_message_vid',
      'wbfsys_protocol_message.rowid    as wbfsys_protocol_message_rowid',
      'view_person_role.core_person_firstname ',
      'view_person_role.core_person_lastname '
    );

    $criteria->select($cols);

    $criteria->from('wbfsys_protocol_message');

    $criteria->leftJoinOn
    (
      'wbfsys_protocol_message',
      'm_role_create',
      'view_person_role',
      'wbfsys_role_user_rowid'
    );// attribute reference

    //Wenn ein Standard Condition gesetzt wurde dann kommt diese in die Query
    $criteria->where( ' wbfsys_protocol_message.id_vid_entity = '.$entityId );

    $this->checkLimitAndOrder( $criteria, $params );

    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count('count(wbfsys_protocol_message.'.Db::PK.') as '.Db::Q_SIZE);


  }//end public function fetchEntityProtocol */

  
 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchDatasetProtocol( $entityKey, $objid, $params )
  {

    $this->sourceSize   = null;
    $db                 = $this->getDb();

    $entityId           = $db->orm->getResourceId( $entityKey );
    $criteria           = $db->orm->newCriteria();

    $cols = array
    (
      'wbfsys_protocol_message.message  as wbfsys_protocol_message_message',
      'wbfsys_protocol_message.context  as wbfsys_protocol_message_context',
      'wbfsys_protocol_message.m_time_created  as wbfsys_protocol_m_time_created',
      'wbfsys_protocol_message.m_role_create  as wbfsys_protocol_m_role_create',
      'wbfsys_protocol_message.vid      as wbfsys_protocol_message_vid',
      'wbfsys_protocol_message.rowid    as wbfsys_protocol_message_rowid',
      'view_person_role.core_person_firstname ',
      'view_person_role.core_person_lastname '
    );

    $criteria->select( $cols );

    $criteria->from( 'wbfsys_protocol_message' );

    $criteria->leftJoinOn
    (
      'wbfsys_protocol_message',
      'm_role_create',
      'view_person_role',
      'wbfsys_role_user_rowid'
    );// attribute reference

    //Wenn ein Standard Condition gesetzt wurde dann kommt diese in die Query
    $criteria->where( ' wbfsys_protocol_message.id_vid_entity = '.$entityId.' and wbfsys_protocol_message.vid = '.$objid );

    $this->checkLimitAndOrder( $criteria, $params );

    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );
    $this->calcQuery  = $criteria->count('count(wbfsys_protocol_message.'.Db::PK.') as '.Db::Q_SIZE);


  }//end public function fetchDatasetProtocol */

/*//////////////////////////////////////////////////////////////////////////////
// append query parts
//////////////////////////////////////////////////////////////////////////////*/

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
      $criteria->orderBy('wbfsys_protocol_message.m_time_created desc');


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

}//end class WebfrapProtocol_Query

