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
class LibUploadImageEntity extends LibUploadEntity
{



  /**
   *
   */
  public function save()
  {

    Debug::console( 'In save of file upload' );

    $id       = $this->entity->getId();

    $filePath = PATH_GW.'data/uploads/';
    $filePath .= $this->entity->getTable().'/'.$this->attrName.'/';
    $filePath .= SParserString::idToPath($id);

    //$this->newpath = $filePath;
    //$this->newname = $id;
    Debug::console('in save name'.$id.' path:'.$filePath );

    $this->copy( $id, $filePath );

    $this->cleanThumbs();
    
  }//end public function save */

  /**
   *
   */
  public function cleanThumbs()
  {

    $id       = $this->entity->getId();

    $filePath = PATH_GW.'data/thumbs/';
    $filePath .= $this->entity->getTable().'/'.$this->attrName.'/';
    $filePath .= SParserString::idToPath($id);

    // thumbs löschen bei neuem upload
    SFilesystem::delete( $filePath );

  }//end public function cleanThumbs */
  
} // end class LibUploadEntity

