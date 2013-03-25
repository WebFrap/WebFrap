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
 * Dato zum laden con PHP Maps
 * @package WebFrap
 * @subpackage tech_core
 */
class DaoSelectbox extends Dao
{

  /**
   *
   * @var unknown_type
   */
  protected static $pool = array();

  /**
   *
   * @param $mapName
   * @return unknown_type
   */
  public static function get($mapName)
  {

    if (isset(self::$pool[$mapName]))
      return self::$pool[$mapName];
    else
      return DaoSelectbox::load($mapName);

  }//end public static function get

  /**
   *
   * @param unknown_type $mapName
   * @return unknown_type
   */
  public static function load($mapName)
  {

    foreach (Conf::$confPath as $path) {

      if (!$this->source)
        $menuPath = $path.'/selectbox/'.$this->name.'/';
      else
        $menuPath = $path.'/selectbox/'.$this->source.'/';

      if (!file_exists($menuPath))
        continue;

      $folder = new LibFilesystemFolder($menuPath);

      foreach($folder->getFiles() as $file)
        include $file->getName(true);

       // break after found data
       break;
    }

  }//end public static function load

}//end class DaoNative

