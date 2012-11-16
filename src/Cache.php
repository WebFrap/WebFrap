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


////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var Cache
   */
  protected static $instance = null;


  /**
   * Level 1 Cache, sehr schnell, aber klein und geringe vorhaltezeit
   * Nicht zwangsläufig persistent
   * @var LibCacheAdapter
   */
  protected $level1 = null;

  /**
   * Level 2 Cache in der Regel ein File oder Datenbank Cache
   * In der Regel persistent, übersteht wahrscheinlich den reboot
   *
   * @var LibCacheAdapter
   */
  protected $level2 = null;

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Standard construktor
   */
  public function __construct( $conf = null )
  {

    if( !$conf )
      $conf = Conf::get('cache');

    if( isset($conf['adapters'][1]) )
    {
      $class = 'LibCache'.ucfirst($conf['adapters'][1]['class']);

      if( !Webfrap::loadable( $class ))
      {
        throw new WebfrapFlow_Exception( 'Wrong Configuration' );
      }
      $this->level1 = new $class($conf[1]);
    }

    if( isset($conf['adapters'][2]) )
    {
      $class = 'LibCache'.ucfirst($conf['adapters'][2]['class']);

      if( !Webfrap::loadable( $class ))
      {
        throw new WebfrapFlow_Exception( 'Wrong Configuration' );
      }

      $this->level2 = new $class($conf['adapters'][2]);
    }

  }//end public function __construct()

////////////////////////////////////////////////////////////////////////////////
// static Logic
////////////////////////////////////////////////////////////////////////////////

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
  public static function init( )
  {

    self::$instance = new Cache();

  }// end public static function init */

  /**
   * initialize The Caching System
   *
   * @return void
   */
  public static function shutdown( )
  {

  }//end public static function shutdown */

////////////////////////////////////////////////////////////////////////////////
// getter and setter
////////////////////////////////////////////////////////////////////////////////

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

////////////////////////////////////////////////////////////////////////////////
// Cache Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $key
   * @return mixed
   */
  public function get( $key )
  {

    if( $this->level1 )
    {
      $cached = $this->level1->get( $key );

      if( is_null( $cached ) && $this->level2   )
      {
        return $this->level2->get( $key );
      }

      return $cached;
    }

    return null;

  }//end public function get */

  /**
   * @param string $key
   * @param string $data
   */
  public function add( $key , $data )
  {
    
    if( $this->level1 )
    {
      $this->level1->add( $key , $data );
    }
    
    if( $this->level2 )
    {
      $this->level2->add( $key , $data );
    }
    
  }//end public function add */

  /**
   * @param string $key
   * @return mixed
   */
  public function exists( $key )
  {
    
    if( $this->level1 )
    {
      
      $cached = $this->level1->exists($key);
      
      if( !$cached && $this->level2 )
      {
        return $this->level2->exists($key);
      }
      
      return $cached;
      
    }
    
  }//end public function exists */

  /**
   * @param string $key
   * @return mixed
   */
  public function remove( $key )
  {
    
    if( $this->level1 )
    {
      $this->level1->remove( $key );
    }
    
    if( $this->level2 )
    {
      $this->level2->remove( $key );
    }
    
  }//end public function remove */


} // end class Cache


