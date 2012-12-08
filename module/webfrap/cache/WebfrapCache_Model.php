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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapCache_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return [{label,folder,description}]
   */
  public function getCaches()
  {
    
    $caches = array();
    
    $cssCache = new stdClass();
    $cssCache->label = 'CSS Cache';
    $cssCache->folder = 'css';
    $cssCache->description = 'The CSS Structure';
    
    $caches[] = $cssCache;
    
    $themeCache = new stdClass();
    $themeCache->label = 'Theme Cache';
    $themeCache->folder = 'theme';
    $themeCache->description = 'The Theme Informations';
    
    $caches[] = $themeCache;
    
    
    return $caches;
    
  }
  

  /**
   * leeren des cache folders
   * @return void
   */
  public function cleanCache()
  {
    
    $response = $this->getResponse();

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      'App Cache' => PATH_GW.'cache/'
    );

    foreach( $toClean as $name => $folder )
    {
      if( SFilesystem::cleanFolder($folder) )
      {
        $response->addMessage( $response->i18n->l
        (
          'Successfully cleaned {@name@}',
          'wbf.message',
          array( 'name' => $name )
        ));
      }
      else
      {
        $response->addError( $response->i18n->l
        (
          'Failed to cleane {@name@}',
          'wbf.message',
          array( 'name' => $name )
        ));
      }
    }
  }//end public function cleanCache */
  
  /**
   * neu bauen des JS Caches
   */
  public function rebuildJs( $key )
  {
    
    $cache    = new LibCacheRequestJavascript();
    $cache->rebuildList( $key );
    
  }//end public function rebuildJs */
  
  /**
   * neu bauen des JS Caches
   */
  public function rebuildCss( $key )
  {
    
    $cache    = new LibCacheRequestCss();
    $cache->rebuildList( $key );
    
  }//end public function rebuildCss */
  
  /**
   * neu bauen des Theme Caches
   */
  public function rebuildTheme( $key )
  {
    
    $cache    = new LibCacheRequestTheme();
    $cache->rebuildList( $key );
    
  }//end public function rebuildTheme */
  
}//end class MaintenanceCache_Model */

