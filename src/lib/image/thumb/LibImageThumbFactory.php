<?php
/*******************************************************************************

/**
 * class LibImageThumbFactory
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibImageThumbFactory
{

  /**
   * Erstellen einer Thumb Library
   *
   * @return LibImageThumbAdapter
   */
  public static function getThumb( $origName   = null ,$thumbName  = null ,$maxWidth   = null ,$maxHeight  = null)
  {

    if ( defined('WBF_IMAGE_LIB') ) {
      $type = WBF_IMAGE_LIB;
    } else {
      $type = 'Gd';
    }

    $className = 'LibImageThumb'.$type;

    return new $className($origName,$thumbName,$maxWidth,$maxHeight);

  }//end ublic static function getThumb

}// end class LibImageThumbFactory
