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
 * Ein Link auf Google Maps
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
class FormatLinkGoogleMaps
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param float $number
   */
  public static function format( $label, $coordX, $cordY = null, $zoom = 13 )
  {
    
    // wenn start oder ende fehlen, dann 0 per definition
    if ( '' == trim($coordX))
      return '';
    
    if ($cordY)
      $coordX = $coordX.','.$cordY;

    return '<a href="http://maps.google.de/maps?q='.$coordX.'&z='.$zoom.'" target="'.Wgt::EXTERN_WIN_NAME.'" >'.$label.'</a>';
    
  }//end public static function format */

} // end class FormatLinkGoogleMaps
