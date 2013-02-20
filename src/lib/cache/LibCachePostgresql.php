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
class LibCachePostgresql extends LibCache_L1Adapter
{

  public $type = 'memcache';

  /**
   * Der Standard Konstruktor zum Initialisieren des Systems
   * @param array $conf
   *  - host:
   *  - port
   */
  public function __construct($conf )
  {

    $this->connectMemached($conf );

  } // end public function __construct */

  /**
   *
   */
  public function __destruct()
  {
    $this->closeMemcached();
  }//end public function __destruct()

  /**
   * Testen ob ein bestimmter Wert im cache Vorhanden ist
   *
   * @param string Name Name auf des zu testenden Ojektes
   * @param string Area Name der zu löschenden Subarea
   * @return bool
   */
  public function isIncache($name,  $area = null )
  {

    if (trim($area) == "" ) {
      $area = "default";
    }
    if ($this->cache->get($area."_".$name )) {
      return true;
    } else {
      return false;
    }

  } // end public function isIncache

  /**
   * Testen ob noch genug Platz im cache ist
   *
   * @return bool
   */
  public function enoughFree( )
  {
    return true;

  } // end public function enoughFree */

  /**
   * Neune Eintrag in den cache werfen
   *
   * @param string Name Name des neuen Objektes
   * @param string Data Die neuen Daten
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function add($name,  $data,  $area = null , $offset = null )
  {

    if (trim($area) == "" ) {
      $area = "default";
    }
    if ($this->cache->set($area."_".$name , $data ) ) {
      return true;
    }

    return false;

  } // end public function add */

  /**
   * Einen bestimmten Wert im cache updaten bzw ersetzen
   *
   * @param string $key Name des zu ersetzenden Datensatzes
   * @param string $data Der neue Datensatz
   * @return bool
   */
  public function replace($key, $data, $subKey = null  )
  {

    if (trim($subKey) == "" ) {
      $subKey = "default";
    }

    if ($this->cache->replace($key."_".$subKey, $data ) ) {
      return true;
    }

    return false;

  } // end public function replace */

  /**
   * Ein Objekt aus dem cache anfragen
   *
   * @param string Name Name der gewünschten Daten aus dem cache
   * @param string Area Die zu verwendente Subarea
   * @return string
   */
  public function get($name,  $area = null )
  {

    if (trim($area) == "" ) {
      $area = "default";
    }
    if ($data = $this->cache->get($area."_".$name )) {
      return $data;
    }

    return false;

  } // end public function get */

  /**
   * Ein Objekt aus dem cache löschen
   *
   * @param string Name Name des zu löschende Objektes
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function delete($name,  $area = null )
  {

    if (trim($area) == "" ) {
      $area = "default";
    }
    if ( !$this->cache->delete($area."_".$name )) {
      return false;
    }

    return true;

  } // end public function delete */

  /**
   * Incrementieren eines Wertes im cache
   *
   * @param string Name Name des Objekts das aus dem cache gelöscht werden soll
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function increment($name,  $area = null )
  {

    if (trim($area) == "" ) {
      $area = "default";
    }
    if ( !$this->cache->increment(  $area."_".$name )) {
      return false;
    }

    return true;

  }// end public function increment */

  /**
   * Decrementieren eines Wertes im cache
   *
   * @param string Name Name des Objekts das aus dem cache gelöscht werden soll
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function decrement(  $name,  $area = null  )
  {

    if (is_null($area) ) {
      $area = "default";
    }

    if ( !$this->cache->decrement($area."_".$name )) {
      return false;
    }

    return true;

  }// end public function decrement */

  /**
   * Den cache komplett leeren
   *
   * @return bool
   */
  public function cacheClean( )
  {

    if (!$this->cache->flush()) {
      return false;
    }

    return true;

  } // end public function cacheClean */

  /**
   * Zum Memcache Server Connecten
   * @param array $conf
   * @return bool
   */
  public function connectMemached($conf )
  {

    if ( WebFrap::loadable('Memcache') ) {
      $this->cache = new Memcache();
    } else {
      throw new LibCache_Exception('the Memcached modul not exists!');
    }

    $this->cache->connect($conf['server'] , (int) $conf['port'] );

  } //end protected function connectMemached */

  /** Verbindung zum Memcache Server schliesen
   *
   * @return bool
  */
  public function closeMemcached( )
  {
    $this->cache->close();

  }

  /* (non-PHPdoc)
   * @see LibCacheAdapter::exists()
   */
  public function exists($key)
  {
    // TODO Auto-generated method stub

  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::remove()
   */
  public function remove($key)
  {
    // TODO Auto-generated method stub

  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::clean()
   */
  public function clean()
  {
    // TODO Auto-generated method stub

  }
 // end public function closeMemcached */

} // end class LibCacheMemcache

