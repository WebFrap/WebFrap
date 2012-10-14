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
 * @subpackage tech_core
 */
class LibCacheSqlite
  extends LibCacheAdapter
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  protected $db = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der Standard Konstruktor
   *
   * @param array
   */
  public function __construct( $conf )
  {

    if( !isset($conf['db']) )
    {
      $conf['db'] = PATH_GW.'cache/cache.db';
    }

    if( !isset($conf['expire']) )
    {
      $conf['expire'] = 360;
    }

    $this->expire = $conf['expire'];

    if(!$this->db = sqlite_open( $conf['db'] ))
    {
      throw new LibCache_Exception('Failed to open Cachedb');
    }

  }// end public function __construct */


  /**
   * Testen ob ein bestimmter Wert im Cache Vorhanden ist
   *
   * @param string Name Name auf des zu testenden Ojektes
   * @param string Area Name der zu löschenden Subarea
   * @return bool
   */
  public function exists( $key )
  {

    if(isset($this->cache[$key])) return true;

    $sql = "select cid as numb from defcache where cid = '$key' and expires < ".time().";";

    if(!$result = sqlite_query( $this->db , $sql ))return false;
    if(!$data = sqlite_fetch_array($result))return false;

    return $data['numb']?true:false;

  } // end public function exists( $key )

  /**
   * Testen ob noch genug Platz im Cache ist
   *
   * @return bool
   */
  public function enoughFree( )
  {
    return true;

  } // end public function enoughFree( )

  /**
   * Neune Eintrag in den Cache werfen
   *
   * @param string $name Name des neuen Objektes
   * @param string $data Die neuen Daten
   * @param string $area Die zu verwendente Subarea
   * @param int $offset
   * @return bool
   */
  public function add( $key,  $data )
  {

    $this->cache[$key] = $data;

    $data = serialize($data);

    if(!sqlite_exec($this->db, "INSERT INTO defcache (cid , cached , expires)
        values ('$key','$data','".(time()+$this->expire)."');"))
    {
      return sqlite_exec( $this->db, "UPDATE defcache set cid = '$key', cached = '$data',
        expires = '".(time()+$this->expire)."' WHERE  cid = '$key' ");
    }
    else
    {
      return true;
    }

  }//end public function add( $key,  $data )

  /**
   * Einen bestimmten Wert im Cache updaten bzw ersetzen
   *
   * @param string Name Name des zu ersetzenden Datensatzes
   * @param string Data Der neue Datensatz
   * @param string Area Die zu verwendente Subarea
   * @return bool

   */
  public function replace( $key,  $data )
  {
    return $this->add( $key,  $data);
  } // end public function replace( $key,  $data )

  /**
   * Ein Objekt aus dem Cache anfragen
   *
   * @param string Name Name der gewünschten Daten aus dem Cache
   * @param string Area Die zu verwendente Subarea
   * @return string
   */
  public function get( $key  )
  {

    if(isset( $this->cache[$key] ))return $this->cache[$key];

    $sql = "select * from defcache where cid = '$key' and expires < ".time().";";

    if(!$result = sqlite_query( $this->db , $sql ))return null;
    if(!$data = sqlite_fetch_array($result))return null;

    $data = unserialize($data);
    $this->cache[$key] = $data;
    return $data;

  } // end public function get( $key  )

  /**
   * Ein Objekt aus dem Cache löschen
   *
   * @param string Name Name des zu löschende Objektes
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function remove( $key )
  {

    if( $this->cache[$key] ) unset($this->cache[$key]);

    return sqlite_exec($this->db, "DELETE from defcache where cid = '$key' ;");

  } // end public function remove( $key )


  /**
   * clean the cache
   *
   * @return bool
   */
  public function clean( )
  {
    $this->cache = array();
    return sqlite_exec($this->db, "DELETE from defcache;");
  } // end public function clean( )

  /**
   *
   * @param string $area Eine bestimmte Subarea cleanen
   * @return bool
   */
  public function cleanSubarea( $key )
  {
    $this->cache = array();
    return sqlite_exec($this->db, "DELETE from defcache;");
  } // end public function cleanSubarea( $key )


} // end class LibCacheSqlite

