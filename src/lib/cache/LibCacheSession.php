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
class LibCacheSession
  extends LibCacheAdapter
{

  /**
   * Testen ob ein bestimmter Wert im Cache Vorhanden ist
   *
   * @param string $name auf des zu testenden Ojektes
   * @param string $area der zu löschenden Subarea
   * @return bool
   */
  public function isInCache( $name,  $area = null )
  {

    if( !$area )
    {
      $area = 'standard';
    }

    return isset($_SESSION['CACHE'][$area][$name]) ? true:false;

  } // end public function isInCache( $name,  $area = null )

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
   * @param string Name Name des neuen Objektes
   * @param string Data Die neuen Daten
   * @param string Area Die zu verwendente Subarea
   * @return bool

   */
  public function cacheAdd( $name,  $data,  $area = null , $offSet = null )
  {

    if( !$area )
    {
      $area = 'standard';
    }

    $_SESSION['CACHE'][$area][$name] = $data;
    return true;

  } // end public function cacheAdd( $name,  $data,  $area = null , $offSet = null )

  /**
   * Einen bestimmten Wert im Cache updaten bzw ersetzen
   *
   * @param string Name Name des zu ersetzenden Datensatzes
   * @param string Data Der neue Datensatz
   * @param string Area Die zu verwendente Subarea
   * @return bool

   */
  public function cacheReplace( $name,  $data,  $area = null , $offSet = null )
  {

    if( !$area )
    {
      $area = 'standard';
    }

    $_SESSION['CACHE'][$area][$name] = $data;
    return true;

  } // end public function cacheReplace( $name,  $data,  $area = null , $offSet = null )

  /**
   * Ein Objekt aus dem Cache anfragen
   *
   * @param string Name Name der gewünschten Daten aus dem Cache
   * @param string Area Die zu verwendente Subarea
   * @return string

   */
  public function cacheGet( $name,  $area = null )
  {

    if( !$area )
    {
      $area = 'standard';
    }

    return isset( $_SESSION['CACHE'][$area][$name] )
      ?$_SESSION['CACHE'][$area][$name]
      :null;


  } // end public function cacheGet( $name,  $area = null )

  /**
   * Ein Objekt aus dem Cache löschen
   *
   * @param string Name Name des zu löschende Objektes
   * @param string Area Die zu verwendente Subarea
   * @return bool

   */
  public function cacheDelete( $name,  $area = null )
  {
    if( !$area )
    {
      $area = 'standard';
    }

    if(isset( $_SESSION['CACHE'][$area][$name] ))
    {
      unset($_SESSION['CACHE'][$area][$name]);
    }

    return true;

  } // end of member function cacheDelete

  /**
   * Incrementieren eines Wertes im Cache
   *
   * @param string Name Name des Objekts das aus dem Cache gelöscht werden soll
   * @param string Area Die zu verwendente Subarea
   * @return boolean
   */
  public function cacheInc( $name,  $area = null )
  {

    if( !$area )
    {
      $area = 'standard';
    }

    if(isset( $_SESSION['CACHE'][$area][$name] ))
    {
      ++$_SESSION['CACHE'][$area][$name];
    }
    else
    {
      $_SESSION['CACHE'][$area][$name] = 0;
    }

    return true;

  }// end public function cacheInc( $name,  $area = null )

  /**
   * Decrementieren eines Wertes im Cache
   *
   * @param string Name Name des Objekts das aus dem Cache gelöscht werden soll
   * @param string Area Die zu verwendente Subarea
   * @return bool

   */
  public function cacheDec(  $name,  $area = null  )
  {

    if( !$area )
    {
      $area = 'standard';
    }

    if(isset( $_SESSION['CACHE'][$area][$name] ))
    {
      --$_SESSION['CACHE'][$area][$name];
    }
    else
    {
      $_SESSION['CACHE'][$area][$name] = 0;
    }

    return true;

  }// ende public function cacheDec(  $name,  $area = null  )

  /**
   * Den Cache komplett leeren
   *
   * @return bool
   */
  public function cacheClean( )
  {

    if( isset($_SESSION['CACHE']) )
    {
      unset($_SESSION['CACHE']);
    }

  } // end public function cacheClean( )

  /**
   *
   * @param string Area Eine bestimmte Subarea cleanen
   * @return bool
   */
  public function cacheSubareaClean( $area )
  {

    if( isset($_SESSION['CACHE'][$area]) )
    {
      unset($_SESSION['CACHE'][$area]);
    }
    return true;

  }
/* (non-PHPdoc)
   * @see LibCacheAdapter::exists()
   */
  public function exists($key) {
    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::add()
   */
  public function add($key, $data) {
    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::replace()
   */
  public function replace($key, $data) {
    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::get()
   */
  public function get($key, $time = Cache::MEDIUM) {
    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::remove()
   */
  public function remove($key) {
    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
   * @see LibCacheAdapter::clean()
   */
  public function clean() {
    // TODO Auto-generated method stub
    
  }
 // end public function cacheSubareaClean( $area )


} // end class SysCacheSession

