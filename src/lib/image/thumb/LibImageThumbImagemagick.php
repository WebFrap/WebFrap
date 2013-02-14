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
 * class LibmageThumbImagemagick
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibmageThumbImagemagick extends LibImageThumbAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public function genThumb( )
  {


    $thumb = new Imagick();

    $thumb->readImage($this->origName);
    $thumb->resizeImage($this->maxWidth,$this->maxHeight,Imagick::FILTER_LANCZOS,1);
    $thumb->writeImage($this->thumbName);
    $thumb->clear();
    $thumb->destroy();

  }//end public function genThumb


}// end class ObjImageThumbgen

?>