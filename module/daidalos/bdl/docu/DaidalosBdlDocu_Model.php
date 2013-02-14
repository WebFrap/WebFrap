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
class DaidalosBdlDocu_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * Das Modeller Model
   * @var DaidalosBdlModeller_Model
   */
  public $modeller = null;
  
  /**
   * Liste mit der vohandenen indexern
   * @var [DaidalosBdlIndexer]
   */
  public $documentor = null;
  
  /**
   * @var Liste mit den Pages
   */
  public $pages = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * 
   */
  public function syncDocu()
  {
    
    $repos = $this->modeller->getRepos();
    
    /*
    'buiz' => array
    (
      'branch' => 'modeller',
      'path' => PATH_ROOT.'WebFrap_42_Business/',
      'description' => ''
    ),
     */
    
    $this->syncBaseDocuments();
    
    /*
    foreach( $repos as $rep )
    {
      $this->syncRepoIndex( $rep['path'] );
    }
    */
    
    
  }//end public function syncIndex */
  

  
  /**
   * @param string $path
   * @return string
   */
  protected function syncRepoIndex( $path )
  {
    
    
    $files = $this->getSubModuleFiles( $path );
    
    foreach( $files as $file )
    {
      $this->syncNodeDocu( $file );
    }

    
  }//end protected function syncRepoIndex */
  
  /**
   * @param string $path
   * @return string
   */
  protected function syncNodeDocu( $fileName )
  {
    
    $bdlFile = new BdlFile( $fileName );
    $type    = $bdlFile->guessType();
    
    if (!$type )
    {
      Debug::console( "Failed to guess type for file: ".$fileName );
      return;
    }
    
    if (!isset( $this->documentor[$type] ) )
    {
      $indexClass = 'BdlDocumentor_'.SParserString::subToCamelCase($type);
      if (!Webfrap::classLoadable($indexClass) )
      {
        Debug::console( "Tried to sync index for a non supported node type: ".$type );
        return;
      }
      
      $this->documentor[$type] = new $indexClass( $this->getDb() );
    }
    
    $this->documentor[$type]->loadFile( $bdlFile );
    $this->documentor[$type]->syncDocuPage( 'de' );
  
  }//end protected function syncNodeDocu */

  /**
   * @param string $folders
   * @return array
   */
  public function getSubModuleFiles( $folders )
  {

    $repoIterator = new LibFilesystemFolder( $folders );
    return $repoIterator->getFilesByEnding( '.bdl', false, true );
    
  }//end public function getSubModuleFiles */
  
  /**
   * 
   */
  public function syncBaseDocuments()
  {
    
    $orm = $this->getOrm();
    
    $pages = array
    (
      'Wbf',
    );
    
    $languages = array
    (
      'de',
      'en'
    );
    
    foreach( $pages as $pageKey )
    {
      
      $classKey = 'DaidalosBdlDocu_Page_'.$pageKey;
      
      $page = new $classKey( $orm );
      
      foreach( $languages as $lang  )
      {
        $page->sync( $lang );
      }
    }

  }//end public function syncBaseDocuments */


}//end class DaidalosBdlDocu_Model

