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
 * class Cache
 * @package WebFrap
 * @subpackage tech_core
 */
class Cache
{

  /**
   * an hour is average long
   * @var int
   */
  const SHORT   = 600;

  /**
   * an hour is average long
   * @var int
   */
  const MEDIUM  = 3600;

  /**
   * a week is long
   * @var int
   */
  const LONG    = 604800;

  /**
   * @var int
   */
  const MINUTE  = 60;

  /**
   * @var int
   */
  const HOUR    = 3600;

  /**
   * @var int
   */
  const DAY     = 86400;

  /**
   * @var int
   */
  const WEEK    = 604800;

  /**
   * @var int
   */
  const MONTH   = 2592000;

  /**
   * @var int
   */
  const YEAR    = 31536000;

  /**
   * @var int
   */
  const INFINITIY = 'inf';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var Cache
   */
  protected static $instance = null;

  /**
   * Level 1 Cache, sehr schnell, aber klein und geringe vorhaltezeit
   * Nicht zwangsläufig persistent
   * Kein löschen von hirachien möglich
   * @var LibCacheAdapter
   */
  protected $level1 = null;

  /**
   * Löschen von hirachien möglich
   * Ist normalerweise eine Datenbank wie Postgresql oder Casandra
   *
   * @var LibCacheAdapter
   */
  protected $level2 = null;

  /**
   * Ist immer der File cache
   * Ist nur lokal kann nicht über mehrere Installationen skaliert werden.
   *
   * @var LibCacheAdapter
   */
  protected $level3 = null;

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard construktor
   */
  public function __construct($conf = null)
  {

    if (!$conf)
      $conf = Conf::get('cache');

    if (isset($conf['adapters']['level1'])) {
      $class = 'LibCache'.ucfirst($conf['adapters']['level1']['class']);

      if (!Webfrap::classExists($class)) {
        throw new WebfrapConfig_Exception('Wrong Configuration');
      }
      $this->level1 = new $class($conf['adapters']['level1']);
    }

    if (isset($conf['adapters']['level2'])) {
      $class = 'LibCache'.ucfirst($conf['adapters']['level2']['class']);

      if (!Webfrap::classExists($class)) {
        throw new WebfrapConfig_Exception('Wrong Configuration');
      }

      $this->level2 = new $class($conf['adapters']['level2']);
    }

    // gibts immer, wenn nicht anders definiert ein lokaler filecache
    // das ist der Teil der auch vom Template verwendet wird
    if (isset($conf['adapters']['level3'])) {
      $class = 'LibCache'.ucfirst($conf['adapters']['level3']['class']);

      if (!Webfrap::classExists($class)) {
        throw new WebfrapConfig_Exception('Wrong Configuration');
      }

      $this->level3 = new $class($conf['adapters']['level3']);
    } else {

      $this->level3 = new LibCacheFile(array(
        'class'  => 'File',
        'folder' => PATH_GW.'cache/',
        'expire' => Cache::MONTH,
      ));
    }

  }//end public function __construct()

/*//////////////////////////////////////////////////////////////////////////////
// static Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibCacheAdapter
   */
  public static function getInstance()
  {

    self::$instance
      ? self::$instance
      : self::createInstance();

    return self::$instance;

  }//end public static function getInstance */

  /**
   * @return LibCacheAdapter
   */
  public static function getActive()
  {

    self::$instance
      ? self::$instance
      : self::createInstance();

    return self::$instance;

  }//end public static function getActive */

  /**
   *
   */
  public static function createInstance()
  {

    self::$instance = new Cache();

  }//end public static function createInstance */

  /**
   * initialize The Caching System
   *
   * @return void
   */
  public static function init()
  {

    self::$instance = new Cache();

  }// end public static function init */

  /**
   * initialize The Caching System
   *
   * @return void
   */
  public static function shutdown()
  {

  }//end public static function shutdown */

/*//////////////////////////////////////////////////////////////////////////////
// getter and setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return LibCacheAdapter
   */
  public function getLevel1()
  {
    return $this->level1;

  }//end public function getLevel1 */

  /**
   *
   * @return LibCacheAdapter
   */
  public function getLevel2()
  {
    return $this->level2;

  }//end public function getLevel2 */

  /**
   *
   * @return LibCacheAdapter
   */
  public function getLevel3()
  {
    return $this->level3;

  }//end public function getLevel3 */

/*//////////////////////////////////////////////////////////////////////////////
// Cache Methodes, immer auf level 3
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @return mixed
   */
  public function get($key)
  {
   return $this->level3->get($key);

  }//end public function get */

  /**
   * @param string $key
   * @param string $data
   */
  public function add($key , $data)
  {

    $this->level3->add($key , $data);

  }//end public function add */

  /**
   * @param string $key
   * @return mixed
   */
  public function exists($key)
  {
    return $this->level3->exists($key);

  }//end public function exists */

  /**
   * @param string $key
   * @return mixed
   */
  public function remove($key)
  {
    return $this->level3->remove($key);

  }//end public function remove */

} // end class Cache

