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
 * Data Access Object zum laden der Daten aus einer Conf Map
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class DaoAdapterLoader
  extends Dao
{

  /**
   * @var [[]]
   */
  protected static $pool = array();

  /**
   * @param string $mapName
   * @return []
   */
  public static function getModList( $mapName, $modName )
  {

    if( isset(self::$pool[$mapName.'/'.$modName]) )
      return self::$pool[$mapName.'/'.$modName];
    else
      return DaoAdapterLoader::load( $mapName, $modName);

  }//end public static function getModList

  /**
   * @param string $mapName
   * @return []
   */
  public static function get( $mapName, $modName )
  {

    if( isset(self::$pool[$mapName.'/'.$modName]) )
      return self::$pool[$mapName.'/'.$modName];
    else
      return DaoAdapterLoader::load( $mapName, $modName );

  }//end public static function get

  /**
   * @param string $mapName
   * @param string $modName
   * @return array
   */
  public static function load( $mapName, $modName )
  {
    
    $subModules  = array();
    $modules     = array();

    ///TODO find a solution how to add a hirachie
    if( is_dir( PATH_GW.'conf/include/'.$mapName )  )
    {
      $dModules = opendir( PATH_GW.'conf/include/'.$mapName );

      if( $dModules )
      {
         while( $mod = readdir($dModules) )
         {
            if( $mod[0] == '.' )
              continue;
     
            $subModules[] =  $mod;
         }

         // close the directory
         closedir($dModules);
      }
    }
    
    foreach( $subModules as $subMod )
    {
      if( is_dir( PATH_ROOT.$subMod.'/conf/adapter/'.$modName ) )
      {
        $dModules = opendir( PATH_ROOT.$subMod.'/conf/adapter/'.$modName  );

        if( $dModules )
        {
           while( $mod = readdir($dModules) )
           {
              if( $mod[0] == '.' )
                continue;
       
              $modules[] =  $mod;
           }
  
           // close the directory
           closedir($dModules);
        }
      }
    }
    
    self::$pool[$mapName.'/'.$modName] = $modules;
    
    return $modules;

  }//end public static function load */


}//end class DaoAdapterLoader

