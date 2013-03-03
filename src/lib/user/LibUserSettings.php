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
class LibUserSettings
  extends LibSettings
{

  public $user = null;


  /**
   *
   * Enter description here ...
   * @param LibDbConnection $db
   * @param User $user
   * @param LibCache_L1Adapter $cache
   */
  public function __construct($db, $user, $cache)
  {
    $this->db   = $db;
    $this->user = $user;
    $this->cache = $cache;
  }//end public function __construct */

  /**
   * @param string $key
   * @return TArray
   */
  public function getSetting( $key )
  {

    $cKey = null;
    $userId = null;


    $userId = $this->user->getId();
    $cKey = "{$key}-".$userId;

    if(!isset($this->settings[$cKey])){

      $className = EUserSettingType::getClass($key);

      $sql = <<<SQL
SELECT rowid, jdata from wbfsys_user_setting where id_user = {$userId} AND type = {$key};
SQL;

      $data = $this->db->select($sql)->get();

      if($data)
        $setting = new $className($data['jdata'],$data['rowid']);
      else
        $setting = new $className();

      $this->settings[$cKey] = $setting;

    }

    return $this->settings[$cKey];

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

    $jsonString = $data->toJson();

    $id = $data->getId();

    if( $id ){
      $this->db->getOrm()->update( 'WbfsysUserSetting', $id, array('jdata'=>$jsonString,'type'=>$key) );
    } else {
      $this->db->getOrm()->insert( 'WbfsysUserSetting', array(
      	'jdata' => $jsonString,
      	'type' => $key,
      	'id_user' => $this->user->getId()
      ));
    }

  }//end public function saveSetting */

}// end class LibUserSettings

