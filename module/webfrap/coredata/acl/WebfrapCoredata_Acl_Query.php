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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapCoredata_Acl_Query
  extends Webfrap_Acl_Query
{
////////////////////////////////////////////////////////////////////////////////
// fetch methodes
////////////////////////////////////////////////////////////////////////////////

 /**
   * Loading the tabledata from the database
   * @param int $areaId
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchGroupsByKey( $areaId, $key, $params = null )
  {

    if(!$params)
      $params = new TFlag();

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
    UPPER(name) like UPPER('{$db->addSlashes( $key )}%')
    AND NOT rowid IN( SELECT id_group FROM wbfsys_security_access WHERE id_area = {$areaId} )
  LIMIT 10;

SQL;

    $this->result = $db->select( $sql );

  }//end public function fetchGroupsByKey */

} // end class WebfrapCoredata_Acl_Query */

