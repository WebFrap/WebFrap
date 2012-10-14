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
class Webfrap_Acl_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// fetch methodes
////////////////////////////////////////////////////////////////////////////////

 /**
   * Loading the tabledata from the database
   * @param string $key
   * @param int $areaId
   * @param TFlowFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchGroupsByKey( $areaId, $key, $params = null )
  {

    if(!$params)
      $params = new TFlowFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $sql = <<<SQL
  SELECT
    rowid as id,
    name as value,
    name as label
  FROM
    wbfsys_role_group
  where
    upper(name) like upper('{$key}%')
    AND NOT rowid IN( select id_group from wbfsys_security_access where id_area = {$areaId} )
  limit 10;
SQL;

    $this->result = $db->select( $sql );

  }//end public function fetchGroupsByKey */

} // end class WebFrap_Acl_Query */

