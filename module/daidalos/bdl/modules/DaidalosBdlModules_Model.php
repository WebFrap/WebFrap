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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlModules_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var string
   */
  public $key = null;
  
  /**
   * @var string
   */
  public $nodeKey = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @return array
   */
  public function getModules()
  {

    $conf = $this->getConf();
    
    $repos = $conf->getResource( 'bdl', 'core_repos' );
    
    $repoPath = $repos[$this->key]['path'];
    
    $repoIterator = new LibFilesystemFolder($repoPath );

    return $repoIterator->getPlainFolders( true );
    
  }//end public function getModules */
  
  /**
   * @return array
   */
  public function getSubModulePath()
  {

    $conf = $this->getConf();
    
    $repos = $conf->getResource( 'bdl', 'core_repos' );
    
    $repoPath = $repos[$this->key]['path'];

    return $repoPath.'/'.$this->nodeKey;
    
  }//end public function getSubModulePath */
  
  /**
   * @return array
   */
  public function getSubModuleFolders($folders )
  {

    $repoIterator = new LibFilesystemFolder($folders );

    return $repoIterator->getPlainFolders( true );
    
  }//end public function getSubModuleFolders */
  
  /**
   * @return array
   */
  public function getSubModuleFiles($folders )
  {

    $repoIterator = new LibFilesystemFolder($folders );

    return $repoIterator->getPlainFiles( true );
    
  }//end public function getSubModuleFiles */

  

}//end class DaidalosBdlModules_Model

