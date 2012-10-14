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
class DaidalosPackage_File
  extends LibXmlDocument
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return srtring
   */
  public function getName()
  {
    return $this->getAttribute('name');
  }//end public function getName */
  
  /**
   * @return srtring
   */
  public function getLabel()
  {
    return $this->getNodeValue('label');
  }//end public function getLabel */
  
  /**
   * @return string
   */
  public function getFullName()
  {
    return $this->getNodeValue('full_name');
  }//end public function getFullName */
  
  
  /**
   * @return string
   */
  public function getType()
  {
    return $this->getNodeValue('type');
  }//end public function getType */
  
  
  /**
   * @return string
   */
  public function getVersion()
  {
    return $this->getNodeValue('version');
  }//end public function getVersion */
  
  /**
   * @return string
   */
  public function getRevision()
  {
    return $this->getNodeValue('revision');
  }//end public function getRevision */
  
  /**
   * @return string
   */
  public function getAuthor()
  {
    return $this->getNodeValue('author');
  }//end public function getAuthor */
  
  /**
   * @return string
   */
  public function getProjectManager()
  {
    return $this->getNodeValue('project_manager');
  }//end public function getProjectManager */
  
  /**
   * @return string
   */
  public function getCopyright()
  {
    return $this->getNodeValue('copyright');
  }//end public function getCopyright */
  
  /**
   * @return [string]
   */
  public function getFolders( $asArray = false )
  {
    
    $tmp = $this->xpath( '/package/folders/folder' );
    
    $folders = array();
    
    if( $asArray )
    {
      foreach( $tmp as $folder )
      {
        $folders[] = array
        (
          'name'       => $folder->getAttribute('name'),
          'recursive'  => ($folder->getAttribute('recursive')?:'true'),
          'filter'     => ($folder->getAttribute('filter')?:''),
        );
      }
    }
    else 
    {
      foreach( $tmp as $folder )
      {
        $folders[] = $folder->getAttribute('name');
      }
    }

    
    return $folders;
    
  }//end public function getFolders */
  
  /**
   * @return DaidalosPackage_Component_Iterator
   */
  public function getComponentIterator( )
  {
    
    $tmp     = $this->xpath( '/package/components/component' );
    
    return new DaidalosPackage_Component_Iterator( $tmp, '/code/' );
    
  }//end public function getComponentIterator */
  
  /**
   * @return [string]
   */
  public function getLicences()
  {
    
    $tmp = $this->xpath( '/package/licences/licence' );
    
    $licences = array();
    
    foreach( $tmp as $licence )
    {
      $licences[] = $licence->nodeValue;
    }
    
    return $licences;
    
  }//end public function getLicences */
  
  /**
   * @return [string]
   */
  public function getFiles()
  {
    
    $tmp = $this->xpath( '/package/files/file' );
    
    $files = array();
    
    foreach( $tmp as $file )
    {
      $files[] = $file->nodeValue;
    }
    
    return $files;
    
  }//end public function getFiles */
  
  /**
   * @return [string]
   */
  public function getLanguages()
  {
    
    $tmp = $this->xpath( '/package/languages/lang' );
    
    $languages = array();
    
    foreach( $tmp as $lang )
    {
      $languages[] = $lang->nodeValue;
    }
    
    return $languages;
    
  }//end public function getLanguages */
  
  
  /**
   * @param string $rootPath
   */
  public function syncFiles( $rootPath )
  {
    
    $name = $this->getName();
    
    $folders = $this->getFolders(true);
    
    $this->removeNode('files');
    $filesNode = $this->touchNode('files');

    $fileC = 0;
    
    foreach( $folders as $folder )
    {
      $filesIterator = new IoFileIterator
      ( 
        $rootPath.$name.'/'.$folder['name'].'/',
        IoFileIterator::RELATIVE,
        (trim($folder['recursive'])=='true'?true:false),
        (trim($folder['filter'])!=''?trim($folder['filter']):null)
      );
      
      foreach( $filesIterator as $file )
      {
        $this->addNode( 'file', $file, array(), $filesNode );
        ++$fileC;
      }
      
    }
    
    $this->save();
    
    return $fileC;
    
  }//end public function syncFiles */
  
}//end class DaidalosPackage_File */

