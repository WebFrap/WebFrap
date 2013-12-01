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
 * Standard Query Objekt zum laden der Benutzer anhand der Rolle
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSettings
{

  const T_VID = 1;

  const T_VAL = 2;

  const T_JSON = 3;

  /**
   * @var LibSettings
   */
  private static $instance = null;

  /**
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * @var LibCache_L1Adapter
   */
  protected $cache = null;

  /**
   * Alle bereits geladenen settings
   * @var array
   */
  protected $userSettings = array();

  /**
   * Alle bereits geladenen settings
   * @var array
   */
  protected $moduleSettings = array();

  /**
   * Alle bereits geladenen settings
   * @var array
   */
  protected $newModuleSettings = array();

  /**
   * @return LibSettings
   */
  public static function getActive()
  {
    if(!self::$instance){
      $env = Webfrap::$env;
      self::$instance = new LibSettings($env->getDb(), $env->getL1Cache());
    }

    return self::$instance;

  }//end public static function getActive */

  /**
   * @param LibDbConnection $db
   * @param User $user
   * @param LibCache_L1Adapter $cache
   */
  public function __construct($db, $cache)
  {
    $this->db = $db;
    $this->cache = $cache;
  }//end public function __construct */



  /**
   * @param string $key
   * @param User $user Wenn das Setting User Spezifisch ist
   *
   * @return LibSettingsNode
   */
  public function getUserSetting($key)
  {

    if (!isset($this->userSettings[$key])) {

      $className = EUserSettingType::getClass($key);

      $sql = <<<SQL
SELECT rowid, jdata from wbfsys_user_setting where type = {$key} AND id_user is null;
SQL;

      $data = $this->db->select($sql)->get();

      if ($data)
        $setting = new $className($data['jdata'],$data['rowid']);
      else
        $setting = new $className();

      $this->userSettings[$key] = $setting;

    }

    return $this->userSettings[$key];

  }//end public function getUserSetting */

  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function saveUserSetting($key, $data)
  {

    $this->userSettings[$key] = $data;

    $jsonString = $this->db->escape($data->toJson());

    if ($data->id) {
      $this->db->orm()->update('WbfsysUserSetting', $data->id, array('jdata',$jsonString));
    } else {
      $this->db->orm()->insert('WbfsysUserSetting', array('jdata',$jsonString));
    }

  }//end public function saveUserSetting */


  /**
   * @param string $key
   * @param User $user Wenn das Setting User Spezifisch ist
   *
   * @return LibSettingsNode
   */
  public function getModuleSetting($key)
  {

    if (!isset($this->moduleSettings[$key])) {

      $className = EUserSettingType::getClass($key);

      $sql = <<<SQL
SELECT rowid, vid, value, jdata from wbfsys_module_setting where upper(access_key) = upper('{$key}');
SQL;

      $data = $this->db->select($sql)->get();

      if (!$data) {
        $this->moduleSettings[$key] = null;
      } else if (!is_null($data['vid'])) {
        $this->moduleSettings[$key] = $data['vid'];
      } elseif (!is_null($data['value'])) {
        $this->moduleSettings[$key] = $data['value'];
      } else if(!is_null($data['jdata'])){
        $this->moduleSettings[$key] = json_decode($data['jdata']);
      }
    }

    return $this->moduleSettings[$key];

  }//end public function getModuleSetting */

  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function setModuleSetting($key, $data)
  {

    $this->settings[$key] = $data;

    $jsonString = $this->db->escape($data->toJson());

    if ($data->id) {
      $this->db->orm()->update('WbfsysModuleSetting', $data->id, array('jdata',$jsonString));
    } else {
      $this->db->orm()->insert('WbfsysModuleSetting', array('jdata',$jsonString));
    }

  }//end public function setModuleSetting */

  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function saveModuleSetting()
  {

    $jsonString = $this->db->escape($data->toJson());

    foreach ($this->newModuleSettings as $key => $setting) {
      if ($data->id) {
        $this->db->orm()->update('WbfsysModuleSetting', $data->id, array('jdata',$jsonString));
      } else {
        $this->db->orm()->insert('WbfsysModuleSetting', array('jdata',$jsonString));
      }
    }



  }//end public function saveModuleSetting */

}// end class LibSettings

