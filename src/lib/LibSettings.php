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

  /**
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * @var LibCache_L1Adapter
   */
  public $cache = null;

  /**
   * Alle bereits geladenen settings
   * @var array
   */
  public $settings = array();

  /**
   * @param LibDbConnection $db
   * @param User $user
   * @param LibCache_L1Adapter $cache
   */
  public function __construct($db, $cache)
  {
    $this->db   = $db;
    $this->cache = $cache;
  }//end public function __construct */

  /**
   * @param string $key
   * @param User $user Wenn das Setting User Spezifisch ist
   *
   * @return LibSettingsNode
   */
  public function getSetting( $key, $user = null )
  {

    $cKey = null;
    $userId = null;

    if($user){

      $cKey = "{$key}-".$user->getId();
      $userId = $user->getId();
    }
    else{

      $cKey = $key;
      $userId = null;
    }

    if(!isset($this->settings[$cKey])){

      $className = EUserSettingType::getClass($key);


      $sql = <<<SQL
SELECT rowid, jdata from wbfsys_user_setting where type = {$key}
SQL;

      if( $userId ){

        $sql .= " AND id_user = {$userId}; ";

      } else {

        $sql .= " AND id_user is null;";
      }

      $data = $this->db->select($sql)->get();

      if($data)
        $setting = new $className($data['jdata'],$data['rowid']);
      else
        $setting = new $className();

      $this->settings[$key] = $setting;

    }

    return $this->settings[$key];

  }//end public function getSetting */

  /**
   * Speichern der Settings
   *
   * @param int $key
   * @param TArray $data
   */
  public function saveSetting( $key, $data )
  {

    $this->settings[$key] = $data;

    $jsonString = $this->db->addSlashes($data->toJson());

    if( $data->id ){
      $this->db->orm()->update( 'WbfsysUserSetting', $data->id, array('jdata',$jsonString) );
    } else {
      $this->db->orm()->insert( 'WbfsysUserSetting', array('jdata',$jsonString) );
    }

  }//end public function saveSetting */

}// end class LibSettings

