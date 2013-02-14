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
final class SParserColor
{

  /** 
   * Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /**
   * 
   * @param string $color
   */
  public static function html2rgb( $color )
  {
    
    $color = strtolower($color);
    
    // remove # if exists
    if ($color[0] === '#' )
        $color = substr( $color, 1 );
  
    $length = strlen($color);
    if ($length === 6 )
    {
      list( $r, $g, $b ) = array
      (
        $color[0].$color[1],
        $color[2].$color[3],
        $color[4].$color[5]
      );
    }
    elseif ($length === 3 )
    {
      list($r, $g, $b) = array
      (
        $color[0].$color[0], 
        $color[1].$color[1], 
        $color[2].$color[2]
      );
    }
    else
    {
      return false;
    }

    $r = hexdec($r); 
    $g = hexdec($g); 
    $b = hexdec($b);

    return array( $r, $g, $b );
    
  }//end public static function html2rgb */
  
  /**
   * @param int $r
   * @param int $g
   * @param int $b
   */
  public static function rgb2html( $r, $g=-1, $b=-1 )
  {
    
    if (is_array($r) && sizeof($r) === 3)
        list($r, $g, $b) = $r;

    $r = intval($r); 
    $g = intval($g);
    $b = intval($b);

    $r = dechex( $r<0?0:($r>255?255:$r) );
    $g = dechex( $g<0?0:($g>255?255:$g) );
    $b = dechex( $b<0?0:($b>255?255:$b) );

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    
    return '#'.$color;
    
  }//end public static function rgb2html */

}// end final class SParserString


