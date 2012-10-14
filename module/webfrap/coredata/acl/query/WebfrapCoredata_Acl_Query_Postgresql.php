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
class WebfrapCoredata_Acl_Query_Postgresql
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

} // end class WebfrapCoredata_Acl_Query_Postgresql */

