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
{

  public $db = null;

  public $cache = null;

  public $user = null;

  public $settings = array();

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

  public function getSetting( $key )
  {

  }

  public function saveSetting( $key, $data )
  {

  }

}// end class LibUserSettings

