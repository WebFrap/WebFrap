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
 * Die Dauer eines Vorgangs aus dem Start und Endedatum heraus berechnen
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
class FormatDateDuration
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param string:Date $start
   * @param string:Date $end
   * @param string $format
   */
  public static function format($start, $end, $format = 'month')
  {
    
    $formData = array(
      'day' => 1,
      'week' => 7,
      'month' => 30,
      'year' => 365,
    );
    
    
    // wenn start oder ende fehlen, dann 0 per definition
    if (!$start ||!$end)
      return '0';
    
    $startDate = new DateTime($start);
    $endDate = new DateTime($end);
    
    $dur = $startDate->diff($endDate);
    
    return floor($dur->format('%a')/$formData[$format]) ;
    
  }//end public static function format */

} // end class FormatDateDuration
