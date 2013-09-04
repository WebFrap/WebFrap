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
 * @subpackage tech_core
 */
class LibResource_Provider extends Provider
{

  /**
   * @var var LibResource_Provider
   */
  private static $default = null;

  /**
   * @var LibResource_Cache_File
   */
  protected $rCache = null;

  /**
   * @return LibResource_Provider
   */
  public static function getDefault()
  {

    if(!self::$default)
      self::$default = new LibResource_Provider(Webfrap::$env);

    return self::$default;

  } //end public static function getDefault */


  /**
   * @var $env LibFlow
   */
  public function __construct($env=null)
  {

    $this->env = $env?:Webfrap::$env;
    $this->rCache = new LibResource_Cache_File();

  }//end public function __construct */

  /**
   * @param string $key
   * @return int
   */
  public function getAreaId($key)
  {

    $areaId = $this->rCache->getAreaId($key);

    if (!$areaId) {

      $db = $this->getDb();
      $sql = <<<SQL
select rowid from wbsys_security_area where access_key = '{$db->escape($key)}';
SQL;
      $areaId = $db->select($sql)->getField('rowid');

      if ($areaId)
        $this->rCache->addAreaId($key, $areaId);

      // has a value or is null
      return $areaId;

    } else {

      return $areaId;
    }

  }//end public function getAreaId */

  /**
   * @param [string] $keys
   * @return [int]
   */
  public function getAreaIds($keys)
  {

    $areaIds = array();

    foreach ($keys as $key) {
      $areaIds[$key] = $this->getAreaId($key);
    }

    return $areaIds;

  }//end public function getAreaIds */

  /**
   * @param string $key
   * @return int
   */
  public function getGroupId($key)
  {

    $groupId = $this->rCache->getGroupId($key);

    if (!$groupId) {

      $db = $this->getDb();
      $sql = <<<SQL
select rowid from wbsys_group_role where access_key = '{$db->escape($key)}';
SQL;
      $groupId = $db->select($sql)->getField('rowid');

      if ($groupId)
        $this->rCache->addGroupId($key, $groupId);

      // has a value or is null
      return $groupId;

    } else {

      return $groupId;
    }

  }//end public function getGroupId */

  /**
   * @param [string] $keys
   * @return [int]
   */
  public function getGroupIds($keys)
  {

    $groupIds = array();

    foreach ($keys as $key) {
      $groupIds[$key] = $this->getGroupId($key);
    }

    return $groupIds;

  }//end public function getGroupIds */

} // end class LibResource_Provider

