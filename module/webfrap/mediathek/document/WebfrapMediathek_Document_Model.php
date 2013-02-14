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
 * @licence BSD
 */
class WebfrapMediathek_Document_Model extends Model
{

  /**
   * @param int $mediaId
   * @param LibUploadEntity $file
   * @param object $dataNode
   * @return WbfsysDocument_Entity
   */
  public function insert( $mediaId, $file, $dataNode )
  {
    
    $orm = $this->getOrm();
    
    $checkSum = $file->getChecksum();
    $fileSize = $file->getSize();
    

    $fileNode = $orm->newEntity( "WbfsysDocument" );
    $fileNode->name = $file->getNewname();
    $fileNode->file_hash = $checkSum;
    $fileNode->file_size = $fileSize;
    
    $fileNode->mimetype = $file->getFiletype();
    
    //$fileNode->versioning = $dataNode->confidentiality;
    $fileNode->id_mediathek = $mediaId;
    $fileNode->id_licence   = $dataNode->id_licence;
    $fileNode->id_confidentiality = $dataNode->id_confidentiality;
    $fileNode->description   = $dataNode->description;
    
    $fileNode = $orm->insert( $fileNode );
    
    if( is_null( $fileNode ) )
      throw new LibDb_Exception( "Failed to save the file" );
    
    $fileId = $fileNode->getId();
    
    $filePath = PATH_GW.'data/uploads/wbfsys_document/file/'.SParserString::idToPath( $fileId );
    $file->copy( $fileId, $filePath );

    return $fileNode;

  }//end public function insert */

  
  /**
   * @param int $objid
   * @param int $mediaId
   * @param LibUploadEntity $file
   * @param object $dataNode
   * @return void
   */
  public function update( $objid, $mediaId, $file, $dataNode )
  {
    
    $orm = $this->getOrm();
    
    $fileNode = $orm->get( "WbfsysDocument", $objid );
    
    if( $file && is_object($file) )
    {
      $checkSum = $file->getChecksum();
      $fileSize = $file->getSize();
      
      $fileNode->name = $file->getNewname();
      $fileNode->file_hash = $checkSum;
      $fileNode->file_size = $fileSize;

      $fileNode->mimetype = $file->getFiletype();
      
      $fileId   = $fileNode->getId();
      $filePath = SParserString::idToPath( $fileId );
      
      $filePath = PATH_GW.'data/uploads/wbfsys_document/file/'.$filePath;
      $file->copy( $fileId, $filePath );
    }

    $fileNode->id_mediathek = $mediaId;
    $fileNode->id_licence = $dataNode->id_licence;
    $fileNode->id_confidentiality = $dataNode->id_confidentiality;
    $fileNode->description = $dataNode->description;
    
    $fileNode = $orm->update( $fileNode );
    
    return $fileNode;

  }//end public function update */
  
  
  /**
   * @param int $fileId
   * @return WbfsysDocument_Entity
   */
  public function loadFile( $fileId )
  {
    
    $orm = $this->getOrm();
    $fileNode = $orm->get( 'WbfsysDocument', $fileId );
    
    return $fileNode;
    
  }//end public function loadFile */

  
  /**
   * @param int $mediaId
   * @return int
   */
  public function clean( $mediaId )
  {

  }//end public function clean */

  
  /**
   * @param int $documentId
   * @return int
   */
  public function delete( $documentId )
  {
    
    $orm    = $this->getOrm(  );

    // datei löschen
    $orm->delete( 'WbfsysDocument', $documentId );
    
    $dataPath = SParserString::idToPath($documentId);

    $filePath = PATH_GW.'data/uploads/wbfsys_document/file/'.$dataPath.$documentId;
    SFilesystem::delete( $filePath );

  }//end public function delete */

  
} // end class WebfrapMediathek_Document_Model


