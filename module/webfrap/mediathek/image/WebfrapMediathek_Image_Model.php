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
class WebfrapMediathek_Image_Model
  extends Model
{

  /**
   * @param int $mediaId
   * @param LibUploadEntity $file
   * @param object $dataNode
   * @return WbfsysImage_Entity
   */
  public function insert( $mediaId, $file, $dataNode )
  {

    $orm = $this->getOrm();

    $checkSum = $file->getChecksum();
    $fileSize = $file->getSize();

    $imgAdapter = LibImage::newAdapter();
    $imgAdapter->open( $file->getTempname() );

    $imageNode = $orm->newEntity( "WbfsysImage" );
    $imageNode->file = $file->getNewname();
    $imageNode->file_hash = $checkSum;
    $imageNode->file_size = $fileSize;

    $imageNode->width  = $imgAdapter->width;
    $imageNode->height = $imgAdapter->height;

    $imageNode->mimetype = $imgAdapter->type;

    //$imageNode->versioning = $dataNode->confidentiality;
    $imageNode->title = $dataNode->title;
    $imageNode->id_mediathek = $mediaId;
    $imageNode->id_licence = $dataNode->id_licence;
    $imageNode->id_confidentiality = $dataNode->id_confidentiality;
    $imageNode->description = $dataNode->description;

    $imageNode = $orm->insert( $imageNode );

    if( !$imageNode )
      throw new LibDb_Exception( "Failed to save the image" );

    $fileId = $imageNode->getId();

    $filePath = PATH_GW.'data/uploads/wbfsys_image/file/'.SParserString::idToPath($fileId);
    $file->copy( $fileId, $filePath );

    return $imageNode;

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

    $imageNode = $orm->get( "WbfsysImage", $objid );

    if ( $file && is_object($file) ) {
      $checkSum = $file->getChecksum();
      $fileSize = $file->getSize();

      $imageNode->file = $file->getNewname();
      $imageNode->file_hash = $checkSum;
      $imageNode->file_size = $fileSize;

      $imgAdapter = LibImage::newAdapter();
      $imgAdapter->open( $file->getTempname() );

      $imageNode->width  = $imgAdapter->width;
      $imageNode->height = $imgAdapter->height;
      $imageNode->mimetype = $imgAdapter->type;

      $fileId   = $imageNode->getId();
      $filePath = SParserString::idToPath( $fileId );

      $tumbPath = PATH_GW.'data/thumbs/wbfsys_image/file/'.$filePath.'/'.$fileId.'/';
      SFilesystem::delete( $tumbPath );

      $filePath = PATH_GW.'data/uploads/wbfsys_image/file/'.$filePath;
      $file->copy( $fileId, $filePath );

    }

    $imageNode->title = $dataNode->title;
    $imageNode->id_mediathek = $mediaId;
    $imageNode->id_licence = $dataNode->id_licence;
    $imageNode->id_confidentiality = $dataNode->id_confidentiality;
    $imageNode->description = $dataNode->description;

    $imageNode = $orm->update( $imageNode );

    return $imageNode;

  }//end public function updateImage */

  /**
   * @param int $imageId
   * @return WbfsysImage_Entity
   */
  public function loadImage( $imageId )
  {

    $orm = $this->getOrm();
    $imageNode = $orm->get( 'WbfsysImage', $imageId );

    return $imageNode;

  }//end public function loadImage */

  /**
   * @param int $mediaId
   * @return int
   */
  public function cleanImages( $mediaId )
  {

  }//end public function cleanImages */

  /**
   * @param int $imgId
   * @return int
   */
  public function delete( $imgId )
  {

    $orm    = $this->getOrm(  );

    // löschen der varianten
    $imgVariants = $orm->getListWhere( 'WbfsysImageVariant', "id_image = {$imgId}" );

    foreach ($imgVariants as $variant) {
      $variantId = $variant->getId();
      $filePath  = PATH_GW.'data/uploads/wbfsys_image_variant/file/'.SParserString::idToPath($variantId).$variantId;

      // löschen des hochgeladenen files
      SFilesystem::delete( $filePath );
      $orm->delete( $variant );
    }

    // datei löschen
    $orm->delete( 'WbfsysImage', $imgId );

    $dataPath = SParserString::idToPath($imgId);

    $tumbPath = PATH_GW.'data/thumbs/wbfsys_image/file/'.$dataPath.'/'.$imgId.'/';
    SFilesystem::delete( $tumbPath );

    $filePath = PATH_GW.'data/uploads/wbfsys_image/file/'.$dataPath.$imgId;
    SFilesystem::delete( $filePath );

  }//end public function delete */

} // end class WebfrapMediathek_Image_Model
