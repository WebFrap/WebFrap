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
class LibCacheFile extends LibCacheAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var unknown_type
   */
  protected $folder = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Standard Konstruktor
   *
   * @param array
   */
  public function __construct($conf)
  {

    if (!isset($conf['folder'])) {
      $conf['folder'] = PATH_GW.'cache/';
    }
    if (!isset($conf['expire'])) {
      $conf['expire'] = 240;
    }

    $this->folder = $conf['folder'];
    $this->expire = $conf['expire'];

  } // end public function __construct */

  /**
   * Testen ob ein bestimmter Wert im Cache Vorhanden ist
   *
   * @param string Name Name auf des zu testenden Ojektes
   * @param string Area Name der zu löschenden Subarea
   * @return bool
   */
  public function exists($key, $time = Cache::MEDIUM  )
  {

    if (isset($this->cache[$key])    )
      return true;

    $fName = $this->folder.'/'.$key;

    if (!is_readable($fName)  )
      return false;

    if (is_file($fName) && filemtime($fName) < (time() - $time)) {
      unlink($fName);

      return false;
    }

    return true;

  } // end public function exists */

  /**
   * Testen ob noch genug Platz im Cache ist
   *
   * @return bool
   */
  public function enoughFree()
  {
    return true;

  } // end public function enoughFree */

  /**
   * Neune Eintrag in den Cache werfen
   *
   * @param string $name Name des neuen Objektes
   * @param string $data Die neuen Daten
   * @param string $area Die zu verwendente Subarea
   * @param int $offset
   * @return bool
   */
  public function add($key,  $data)
  {

    // zwischenspeichern
    $this->cache[$key] = $data;

    $path = SParserString::getFileFolder($this->folder.'/'.$key);

    if (!is_dir($path)) {
      if (!SFilesystem::mkdir($path)) {
        throw new LibCache_Exception
        (
          I18n::s('Failed to create the cache Folder {@folder@}', 'wbf.message' , array('folder' => $key))
        );
      }
    }

    if (!SFiles::writeCache($this->folder.'/'.$key,  $data)) {
      throw new LibCache_Exception
      (
        I18n::s('Failed to write in the Cache {@folder@}', 'wbf.message' , array('folder' => $key))
      );
    }

  } // end public function add */

  /**
   * Einen bestimmten Wert im Cache updaten bzw ersetzen
   *
   * @param string Name Name des zu ersetzenden Datensatzes
   * @param string Data Der neue Datensatz
   * @param string Area Die zu verwendente Subarea
   * @return bool

   */
  public function replace($key,  $data)
  {
    return $this->add($key,  $data);
  } // end public function replace */

  /**
   * Ein Objekt aus dem Cache anfragen
   *
   * @param string Name Name der gewünschten Daten aus dem Cache
   * @param string Area Die zu verwendente Subarea
   * @return string
   */
  public function get($key, $time = Cache::MEDIUM)
  {

    if (isset($this->cache[$key]))
      return $this->cache[$key];

    $fName = $this->folder.'/'.$key;

    // temporary
    if (is_file($fName) && filemtime($fName) < (time() - $time)) {
      unlink($fName);

      return null;
    }

    if (!is_readable($fName)) {
      return null;
    } else {
      $this->cache[$key] = SFiles::readCache ($fName);

      return $this->cache[$key];
    }

  }//end public function get */

  /**
   * Ein Objekt aus dem Cache löschen
   *
   * @param string Name Name des zu löschende Objektes
   * @param string Area Die zu verwendente Subarea
   * @return bool
   */
  public function remove($key)
  {
    SFilesystem::delete($this->folder.'/'.$key);
  } // end public function remove */

  /**
   * clean the cache
   *
   * @return bool
   */
  public function clean()
  {
    SFilesystem::cleanFolder($this->folder);
  } // end public function clean */

  /**
   *
   * @param string $area Eine bestimmte Subarea cleanen
   * @return bool
   */
  public function cleanSubarea($key)
  {
    SFilesystem::cleanFolder($this->folder.'/'.$key);
  } // end public function cleanSubarea */

} // end class LibCacheFile

