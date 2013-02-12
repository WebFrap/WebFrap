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
class LibArchiveZip2
  extends LibArchive
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Die Archive Klasse
   * @var ZipArchive
   */
  protected $resource = null;
  
  /**
   * Der Dateiname des ZIP Archives
   * @var string
   */
  protected $fileName = null;
  
  protected $writeCounter = 0;

////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $fileName
   */
  public function __construct( $fileName )
  {
    
    $this->resource = new ZipArchive();
    $this->fileName = $fileName;
    
    SFilesystem::touchFileFolder( $fileName );

    $opened = $this->resource->open( $fileName, ZipArchive::CREATE );
    
    if( $opened !== true )
    {
      throw new LibArchive_Exception( 'Failed to open Archive '.$fileName.' code '.$opened );
    }
 
  }//end public function __construct */
  
  
  public function tmpSave()
  {
    $this->writeCounter = 0;
    
    $this->resource->close();
    $this->resource = new ZipArchive();
    $this->resource->open( $this->fileName );
    
  }
  
  /**
   * @param string $fileName
   */
  public function __destruct()
  {

    $this->resource->close();
 
  }//end public function __construct */
  
  /**
   * Schliesen des Archives
   */
  public function close()
  {
    return $this->resource->close();
  }//end public function close */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Einen Ordner dem Archive hinzufügen
   * @param string $folderName
   * @param string $relativePath
   */
  public function addFolder( $folderName, $relativePath = null )
  {
    
    $files = new IoFileIterator( $folderName );
    
    if( $relativePath )
      $relativePath = '/'.$relativePath;
    
    foreach( $files as $file )
    {
      
      if( !file_exists( $file ) )
      {
        Debug::console("Tried to add nonexisting file: $file to archive");
        continue;
      }
      
      if( $this->resource->addFile( $file, $relativePath.$file ) )
      {
        if( $this->writeCounter >= 100 )
        {
          $this->tmpSave();
        }
        ++$this->writeCounter;
      }
    }
    
  }//end public function addFolder */
  
  /**
   * Eine Datei dem Ordner hinzufügen
   * @param string $fileName
   * @param string $innerName
   */
  public function addFile( $fileName, $innerName = null )
  {
    
    if( $this->writeCounter >= 100 )
    {
      $this->tmpSave();
    }    
    ++$this->writeCounter;

    if( !$innerName )
      $innerName = $fileName;
      
    if( !file_exists( $fileName ) )
    {
      Debug::console("Tried to add nonexisting file: $fileName to archive");
      return;
    }
    
    $this->resource->addFile( $fileName, $innerName );
    
  }//end public function addFolder */

} // end class LibArchiveZip2


