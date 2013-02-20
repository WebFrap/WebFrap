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
 * class LibImageThumbGd
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibImageThumbGd extends LibImageThumbAdapter
{

  /**
   * Enter description here...
   *
   */
  public function genThumb( )
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

      switch ($type) {
        case 1 :
        {
          if (!$im = ImageCreateFromGIF($pic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          break;
        } // ENDE CASE

        case 2 :
        {
          if (!$im = ImageCreateFromJPEG($pic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          break;
        } // ENDE CASE

        case 3 :
        {
          if (!$im = ImageCreateFromPNG($pic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          break;
        } // ENDE CASE

        // Erstellen eines eigenen Vorschaubilds
        default:
        {
          // Standartbild hinkopieren
          if (!$im = ImageCreateFromJPEG($errorpic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          // Neueinlesen der benötigten Daten
          $imgdata = getimagesize ($errorpic);
          $org_width = $imgdata[0];
          $org_height = $imgdata[1];
        }

      } // ENDE SWITCH

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

  }//end public function genThumb

}// end class LibImageThumbGd
