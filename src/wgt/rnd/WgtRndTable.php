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
 * Statischer Table renderer
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtRndTable
{

  /**
   * Enter description here...
   *
   * @param string $data
   * @return string
   */
  public static function table( $data , $label = array() )
  {

    $table = '<table class="wgt-table">'.NL;

    if ($label) {
      if ( is_array($label) ) {
        $table .= '<thead>'.NL.'<tr>'.NL;
        foreach( $label as $name )
          $table .= '<th>'.$name.'</th>'.NL;

        $table .= '</tr>'.NL.'</thead>'.NL;
      } else {
        $label = array_keys($data[0]);

        $table .= '<thead>'.NL.'<tr>'.NL;
        foreach( $label as $name )
          $table .= '<th>'.$name.'</th>'.NL;

        $table .= '</tr>'.NL.'</thead>'.NL;

        $label = null;
      }

    }

    $table .= '<tbdoy>'.NL;
    if ($label) {
      foreach ($data as $row) {
        $table .= '<tr>'.NL;
        foreach( array_keys($label) as $col )
          $table .= '<td>'.$row[$col].'</td>'.NL;

        $table .= '</tr>'.NL;
      }
    } else {
      foreach ($data as $row) {
        $table .= '<tr>'.NL;
        foreach(  $row as $col )
          $table .= '<td>'.$col.'</td>'.NL;

        $table .= '</tr>'.NL;
      }
    }
    $table .= '</tbdoy>'.NL;

    $table .= '</table>'.NL;

    return $table;

  }//end public static function table */

  /**
   * @param string $linkTarget
   * @param string $start
   * @param string $dataSize
   * @param string $stepSize
   * @param string $anzMenuNumbers
   */
  public static function pagingMenu( $linkTarget, $start, $dataSize, $stepSize , $anzMenuNumbers  )
  {

    if( $dataSize <= $stepSize )

      return '';

    $activPos = $start;

    $activPos = floor($activPos / $stepSize);
    $startPos = $activPos - floor( $anzMenuNumbers / 2 );

    if( $startPos < 0 )
      $startPos = 0;

    $endPos = $startPos + $anzMenuNumbers;

    $last = floor( $dataSize / $stepSize );

    if( $activPos >  $last )
      $activPos = $last;

    if( $endPos >  $last )
      $endPos = $last + 1;

    $oneVor     = $activPos + 1;
    $oneZurueck = $activPos - 1;

    if( $oneVor > $last )
      $oneVor = $last;

    if( $oneZurueck < $startPos )
      $oneZurueck = $startPos;

    $html = '<a title="'.I18n::s('Back to start').'" href="'.$linkTarget.'&amp;start=0">
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/back.png"
            style="border:0px"
            alt="'.I18n::s('Back to start').'" />
      </a>&nbsp;&nbsp;';

    $html .= '<a title="'.I18n::s($stepSize.' entries back').'" href="'.$linkTarget.'&amp;start='.($oneZurueck * $stepSize).'">
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/toStart.png"
            style="border:0px"
            alt="'.I18n::s($stepSize.' entries back').'" />
      </a>&nbsp;&nbsp;';

    for ($nam = $startPos; $nam < $endPos ; ++$nam) {

      $urlClass = ($nam == $activPos) ? 'class="wgtActiv"':'';

      $html .='<a '.$urlClass.' title="'.I18n::s('show the nex '.$nam.' '.$stepSize.' entires').'"
        href="'.$linkTarget.'&amp;start='.($nam * $stepSize).'" >'.$nam.'</a>&nbsp;' ;

      $urlClass ='';
    }

    $html .= '&nbsp;...&nbsp;&nbsp;';

    // Testen ob die Letze Zahl notwendig ist
    $html .='<a title="'.I18n::s('show the last '.$stepSize.' entries').'"
      href="'.$linkTarget.'&amp;start='.($last * $stepSize).'" >'.$last.'</a>&nbsp;' ;

    $html .= '<a title="'.I18n::s('show the next '.$stepSize.' entries').'"
      href="'.$linkTarget.'&amp;start='.($oneVor * $stepSize).'" >
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/forward.png"
            style="border:0px"
            alt="'.I18n::s('show the next '.$stepSize.' entries').'" /></a>&nbsp;&nbsp;';

    $html .= '<a title="'.I18n::s('go to the last entry').'"
      href="'.$linkTarget.'&amp;start='.($last * $stepSize).'" >
      <img  src="'.View::$iconsWeb.'xsmall/webfrap/toEnd.png"
            style="border:0px"
            alt="'.I18n::s('go to the last entry').'" /></a>';

    return '<div style="width:250px;margin: 0px auto;text-align:center;" >'.$html.'</div>';

  }//end public function pagingMenu */

}//end class Wgt
