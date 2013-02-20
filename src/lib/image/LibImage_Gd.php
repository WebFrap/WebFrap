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
class LibImage_Gd extends LibImageAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $imagePath
   * @throws LibImage_Exception
   * @return boolean
   */
  public function open($imagePath )
  {

    Debug::console( 'opening image '.$imagePath );

    $this->imagePath = SFilesystem::dirname($imagePath );
    $this->imageName = SFilesystem::dirname($imagePath );

    try {
      $imgdata      = getimagesize ($imagePath );

      $this->width   = $imgdata[0];
      $this->height  = $imgdata[1];
      $type         = $imgdata[2];

      switch ($type) {
        case IMG_GIF :
        {
          if (!$this->resource = ImageCreateFromGIF($imagePath ) ) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          $this->type = 'image/gif';
          break;
        } // ENDE CASE

        case IMG_JPEG :
        {
          if (!$this->resource = ImageCreateFromJPEG($imagePath ) ) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          $this->type = 'image/jpeg';
          break;
        } // ENDE CASE

        case IMG_PNG :
        {
          if (!$this->resource = ImageCreateFromPNG($imagePath ) ) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          $this->type = 'image/png';
          break;
        } // ENDE CASE

        case IMG_WBMP :
        {
          if (!$this->resource = imagecreatefromwbmp($imagePath ) ) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          $this->type = 'image/wbpm';
          break;
        } // ENDE CASE

        // Erstellen eines eigenen Vorschaubilds
        default:
        {
          // Standartbild hinkopieren

          if (!$this->pathErrorImage )
            return false;

          if (!$this->resource = ImageCreateFromJPEG($this->pathErrorImage ) ) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }

          // Neueinlesen der benötigten Daten
          $imgdata = getimagesize ($errorpic);
          $this->width = $imgdata[0];
          $this->height = $imgdata[1];
          $this->type = 'image/jpeg';

        }

      } // ENDE SWITCH

      return true;

    } catch ( LibImage_Exception $e ) {
      Debug::console($e->getMessage() );

      return false;
    }

  }//end public function open */

  /**
   * @param unknown_type $thumbName
   * @param unknown_type $thumbWidth
   * @param unknown_type $thumbHeight
   * @param unknown_type $quality
   * @throws LibImage_Exception
   * @return boolean
   * /
  public function genThumb($thumbName, $thumbWidth, $thumbHeight, $quality = 90 )
  {

    $errorpic = View::$themeWeb."/images/wgt/not_available.png";

    if ( file_exists($this->origName ) ) {
      $pic = $this->origName;
    } else {
      $pic = $errorpic;
    }

    try {
      $imgdata      = getimagesize ($pic );
      $org_width    = $imgdata[0];
      $org_height   = $imgdata[1];
      $type         = $imgdata[2];

      // Errechnen der neuen Größe
      if ($org_width > $org_height) {
        $verhaltnis = $org_width / $org_height;
        $new_width = $this->maxWidth;
        $new_height = round( ($new_width / $verhaltnis)  ) ;
      } else {
        $verhaltnis = $org_height / $org_width ;
        $new_height = $this->maxHeight;
        $new_width = round( ($new_height / $verhaltnis)  ) ;
      }

      // neugenerieren des THUMBS
      $thumb = imagecreatetruecolor($new_width, $new_height );

      imagecopyresampled
      (
      $thumb,
      $im,
      0,0,0,0,
      $new_width,$new_height,$org_width,$org_height
      );

      if (!imagejpeg($thumb, $this->thumbName , 95 )) {
        throw new LibImage_Exception('Failed to create '.$this->thumbName);
      }

      return true;

    } catch ( LibImage_Exception $e ) {
      return false;
    }

  }//end public function genThumb */

}// end class LibImage_Gd
