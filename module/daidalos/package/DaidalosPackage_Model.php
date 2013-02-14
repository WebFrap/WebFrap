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
class DaidalosPackage_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return DaidalosPackage_Iterator
   */
  public function getPackages()
  {
    
    return new DaidalosPackage_Iterator( PATH_ROOT );
    
  }//end public function getPackages */
  
  /**
   * @return DaidalosPackage_Iterator
   */
  public function getAppPackages()
  {
    
    return new DaidalosPackage_Iterator( PATH_GW.'data/apps/' );
    
  }//end public function getAppPackages */
  
  /**
   * @param string $packageKey
   * @param string $type
   * @return int
   */
  public function syncPackageFiles($packageKey, $type = 'module' )
  {
      
    if ( 'app' == $type )
    {
      $packagePath = PATH_GW.'data/apps/'.$packageKey.'/package.bdl';
    } else {
      $packagePath = PATH_ROOT.$packageKey.'/package.bdl';
    }
    
    $package = new DaidalosPackage_File($packagePath );
    return $package->syncFiles( PATH_ROOT );
    
  }//end public function syncPackageFiles */
  
  /**
   * @param string $packageKey
   * @param string $type
   * @return int
   */
  public function getPackageFile($packageKey, $type = 'module' )
  {
    
    if ( 'app' == $type )
    {
      $packagePath = PATH_GW.'data/apps/'.$packageKey.'/package.bdl';
    } else {
      $packagePath = PATH_ROOT.$packageKey.'/package.bdl';
    }

    return new DaidalosPackage_File($packagePath );
 
  }//end public function syncPackageFiles */
  
  /**
   * @param string $packageKey
   * @param string $type
   * @return IoFileIterator
   */
  public function getPackageList($packageKey, $type = 'module' )
  {
    
    if ( 'app' == $type )
    {
      $packagePath = PATH_GW.'data/apps/'.$packageKey.'/package.bdl';
    } else {
      $packagePath = PATH_ROOT.$packageKey.'/package.bdl';
    }
    
    $ioFiles = new IoFileIterator
    ( 
      PATH_GW.'data/package/'.$type.'/'.$packageKey.'/', 
      IoFileIterator::FILE_ONLY 
    );

    return $ioFiles;
    
  }//end public function getPackageList */
  
  /**
   * @param string $packageKey
   * @param string $fileName
   * @param string $type
   * @throws Io_Exception
   */
  public function deletePackage($packageKey, $fileName, $type = 'module' )
  {
    
    $delPath = PATH_GW.'data/package/'.$type.'/'.$packageKey.'/'.$fileName;

    if ( file_exists($delPath ) )
      SFiles::delete($delPath );
    
  }//end public function getPackageList */
  
  
  /**
   * @param string $packageName
   * @param string $packageKey
   * @param string $type
   */
  public function buildPackage($packageName, $packageKey, $type = 'module' )
  {
    
    $pFile      = $this->getPackageFile($packageName, $type );
    $folders    = $pFile->getFolders( true );
    $components = $pFile->getComponentIterator();
    
    $path = PATH_GW.'data/package/'.$type.'/'.$packageName.'/'.$packageName.'-'.$packageKey.'.package' ;

    $package = new LibArchiveZip($path, LibArchiveZip::MODE_HUGE  );
    
    foreach($folders as $folder )
    {
      $files = new IoFileIterator
      (
        PATH_ROOT.$packageName.'/'.$folder['name'],
        IoFileIterator::RELATIVE,
        (trim($folder['recursive'])=='false'?false:true),
        (trim($folder['filter'])!=''?trim($folder['filter']):null)
      );
      
      foreach($files as $file )
      {
        $package->addFile( PATH_ROOT.$file, 'code/'.SParserString::shiftXTokens($file, '/', 2) );
      }
    }
    
    foreach($components as $target => $componentPath )
    {
      $package->addFile($componentPath, $target );
    }
    
    if ( 'module' == $type )
    {
      $package->addMetaFile( PATH_ROOT.$packageName.'/package.bdl', 'package.bdl' );
    } else {
      $package->addMetaFile( PATH_GW.'data/apps/'.$packageName.'/package.bdl', 'package.bdl' );
    }
    
    $package->close();

  }//end public function buildPackage */
  
  protected function buildFullApplication()
  {
    
  }
  
  
}//end class DaidalosPackage_Model */

