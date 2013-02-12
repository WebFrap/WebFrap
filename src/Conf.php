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
 * Static Interface to get the activ configuration object
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Conf
{
////////////////////////////////////////////////////////////////////////////////
// static attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * instance of the configuration object
   * @var LibConf
   */
  private static $instance = null;

  /**
   * list of pathes to possible conffile locations like acl / menu ...
   * @var array
   */
  public static $confPath = array();

  /**
   * list of pathes to possible conffile locations like acl / menu ...
   * @var array
   */
  public static $confFiles  = array();

  /**
   * list of pathes to possible conffile locations like acl / menu ...
   * @var array
   */
  public static $confMaps   = array();


////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Singleton Instance
   *
   * @return LibConfPhp
   */
  public static function getInstance()
  {
    if(!self::$instance)
      self::init();

    return self::$instance;
  }//end public static function getInstance */

  /**
   * Singleton Instance
   *
   * @return LibConfPhp
   */
  public static function getActive()
  {
    if(!self::$instance)
      self::init();

    return self::$instance;
  }//end public static function getActive */

  /**
   * Das Conf Objekt initialisieren
   * Sollte idealerweise Direkt beim Script Start passieren, da so gut
   * wie jedes Subsystem von der Konfiguration abhängt
   *
   * @return void
   */
  public static function init()
  {

    if(!self::$instance)
    {

      if(!defined( 'WBF_CONF_TYPE' ) )
        $classname = 'LibConf';
      else
        $classname = 'LibConf'.WBF_CONF_TYPE;

      self::$instance = new $classname();

    }

  }//end public static function init */


  /**
   * statische mappermethode um von der Instance
   * @param string $key
   * @return array
   */
  public static function status( $key )
  {
    return isset(self::$instance->status[$key])
      ? self::$instance->status[$key]
      : null;
  }//end public static function status */

  /**
   * statische mappermethode um von der Instance
   * @param string $key
   * @return array
   */
  public static function setStatus( $key , $value )
  {
    self::$instance->status[$key] = $value ;
  }//end public static function setStatus */

  /**
   * statische mappermethode um von der Instance
   * @param string $key
   * @return array
   */
  public static function get( $key  , $subKey = null )
  {
    return self::$instance->getConf( $key , $subKey );
  }//end public static function get */

  /**
   * @param string $key
   */
  public static function getAppConf( $key )
  {
    return self::$instance->getAppConf( $key  );
  }//end public static function getModule */


  /**
   * statische mappermethode um von der Instance
   * @param string $key
   * @return array
   */
  public static function objid( $key )
  {
    return self::$instance->getObjid( $key  );
  }//end public static function objid */

}// end class Conf
