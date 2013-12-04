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

    $id = $data->getId();
    
    $orm = $this->db->orm;

    if ($id) {
      $orm->update('WbfsysUserSetting', $id, array('jdata',$jsonString));
    } else {
      $orm->insert('WbfsysUserSetting', array('jdata',$jsonString));
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

      $sql = <<<SQL
SELECT rowid, vid, value, type, jdata from wbfsys_module_setting where upper(access_key) = upper('{$key}');
SQL;

      $data = $this->db->select($sql)->get();

      $node = new LibSettingsModNode($data);
      $this->moduleSettings[$key] = $node;
    }

    return $this->moduleSettings[$key];

  }//end public function getModuleSetting */

  /**
   * @param string $key
   * @param User $user Wenn das Setting User Spezifisch ist
   *
   * @return LibSettingsNode
   */
  public function getModuleSettings($keys)
  {

  }//end public function getModuleSettings */


  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function setModuleSetting($key, $data)
  {

    $this->moduleSettings[$key] = $data;
    $this->newModuleSettings[$key] = $data;

  }//end public function setModuleSetting */

  /**
   * Übergeben der Settings node an die Lib
   *
   * @param [LibSettingsModNode]
   */
  public function setModuleSettings($settings)
  {

    foreach ($settings as $key => $data) {
      $this->moduleSettings[$key] = $data;
      $this->newModuleSettings[$key] = $data;
    }

  }//end public function setModuleSettings */

  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function saveModuleSettings()
  {

    $orm = $this->getOrm();

    foreach ($this->newModuleSettings as $key => $setting) {
      if ($data->id) {
        $orm->update('WbfsysModuleSetting', $data->id, $data->saveValue() );
      } else {
        $orm->insert('WbfsysModuleSetting', $data->saveValue());
      }
    }

  }//end public function saveModuleSettings */

}// end class LibSettings

