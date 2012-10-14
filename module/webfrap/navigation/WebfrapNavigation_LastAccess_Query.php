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
class WebfrapNavigation_LastAccess_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// queries
////////////////////////////////////////////////////////////////////////////////


 /**
   * Laden der Einträge auf welche zuletzt zugegriffen wurde
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchLastAccessed( $userId, $areaId = null, $mask = null )
  {

    $this->sourceSize   = null;
    $db                 = $this->getDb();

    $criteria           = $db->orm->newCriteria();

    $cols = array
    (
      'wbfsys_protocol_message.context  as context',
      'wbfsys_protocol_message.vid  as vid',
      'wbfsys_protocol_message.mask  as mask'
    );

    $criteria->select( $cols, true );

    $criteria->from('wbfsys_protocol_message');

    $this->checkLimitAndOrder( $criteria, $params );

    // Run Query und save the result
    $this->result     = $db->orm->select( $criteria );

  }//end public function fetchLastAccessed */



////////////////////////////////////////////////////////////////////////////////
// append query parts
////////////////////////////////////////////////////////////////////////////////

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
      $params->qsize = 10;
    }

    $criteria->limit( $params->qsize );

  }//end public function checkLimitAndOrder */

}//end class WebfrapProtocol_Query

