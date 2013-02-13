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
 * @subpackage tech_core/cache
 */
abstract class LibCache_L1Adapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  public $type = null;

  public $level = 1;

  /**
   * bereits geholte daten
   * @var array
   */
  protected $cache = array();

  /**
   * Default expire time
   * @var timestamp
   */
  protected $expire = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   */
  public function __construct( $xml  )
  {

  } //end public function __construct( $xml )

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * checken if the cached element is still valid from the duration
   * @param int
   * @param int
   * @return bool
   */
  public function checkTime( $elementTime, $duration )
  {
    if( CACHE::INFINITY ==  $duration )
      return true;

    return ( $elementTime > (time() - $duration ) );

  }//end public function checkTime */

  /**
   * check if a key exists in the cache
   *
   * @param string $name key to test
   * @param string[optinal] $area name of the area to test
   * @return bool
   */
  abstract public function exists( $key  );

  /**
   * check if we have enough space in the cache
   *
   * @return bool
   */
  abstract public function enoughFree( );

  /**
   * add Data to the cache
   *
   * @param string Name Name des neuen Objektes
   * @param string Data Die neuen Daten
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  abstract public function add( $key,  $data );

  /**
   * Einen bestimmten Wert im cache updaten bzw ersetzen
   *
   * @param string Name Name des zu ersetzenden Datensatzes
   * @param string Data Der neue Datensatz
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  abstract public function replace( $key, $data );

  /**
   * Ein Objekt aus dem cache anfragen
   *
   * @param string Name Name der gewünschten Daten aus dem cache
   * @param string Area Die zu verwendente Subarea
   * @return string
   */
  abstract public function get( $key, $time = Cache::MEDIUM  );

  /**
   * Ein Objekt aus dem cache löschen
   *
   * @param string Name Name des zu löschende Objektes
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  abstract public function remove( $key  );


  /**
   * Den cache komplett leeren
   *
   * @return bool
   */
  abstract public function clean( );

} // end abstract class LibCacheAdapter


