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
class WgtMenuPicmenu
  extends WgtMenuAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  const DEF_ROWS = 4;

  /**
   * @var int
   */
  protected $numRows = 4;

  /**
   * @var string
   */
  protected $baseFolder = null;

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /** set the number of Menupoints in one row
   *
   * @return void
   */
  public function setRows( $num )
  {

    if( ctype_digit( (string)$num ) )
    {
      $this->numRows = (int)$num;
    }
    else
    {
      $this->numRows = self::DEF_ROWS;
    }

  } // end public function setRows( $num )

  /**
   * Enter description here...
   *
   */
  public function load()
  {
    if(Log::$levelDebug)
     Log::startOverride( __file__ , __line__ ,__method__);

  }//end public function load()

  /**
   *
   * @return string
   */
  public function build( )
  {

    $this->load();

    $this->baseFolder = View::$iconsWeb.'/large/';

    $anz = count( $this->data );


    $modulo = ( $anz + $this->numRows ) % $this->numRows;
    $top = $this->numRows - $modulo;
    if ( $modulo  != 0 )
    {
      for ( $num = 0 ; $num < $top ; $num ++ )
      {
        //$newpic['idmenuentry'] = '';
        $newpic['menutext'] = '';
        $newpic['menulink'] = '';
        $newpic['menutitel'] = '';
        $newpic['menuicon'] = '';
        $newpic['menuiconalt'] = '';
        $this->data[] = $newpic;
      }
    }

    $html = '<table class="wgtMenu explorer" >'.NL;

    $pos = 0;

    // Generieren der Rows
    for ( $nam = 0 ; $nam < $anz ; ( $nam += $this->numRows ) )
    {

      $html .= '<tr>';
      for( $num = 0 ; $num < $this->numRows  ; ++$num )
      {
        $pos = $nam + $num;
        $html .= $this->genTabrow( $this->data[$pos] );
      }
      $html .= '</tr>'.NL;

      $html .= '<tr>
          <td colspan="'.$this->numRows.'" class="wgtSpaceSmall"></td>
        </tr>'.NL;
    }
    $html .= '</table>'.NL;

    $this->html = $html;

    return $html;

  } // end  public function build( )

  /**
   *
   * @return
   */
  protected function genTabrow( $pic )
  {


    if( $pic['menuicon'] != '' or trim($pic['menutext']) != '' )
    {
      $icon = '<img class="icon large" '.
                  ' src="'.$this->baseFolder.$pic['menuicon'].'" '.
                  " alt=\"".$pic["menuiconalt"]."\" ".
                  " title=\"".$pic['menutitel']."\" />";

      $text = trim( $pic['menutext'] ) != '' ? $pic['menutext'].'<br />' : '';

      $link = '<a class="ajax_window" href="'.$pic["menulink"].'" >'.$text.$icon.'</a>';
    }
    else
    {
      $link =  '&nbsp;';
    }

    $html = '<td valign="top" >'.NL;
    $html .= $link.NL;
    $html .= '</td>'.NL;

    return $html;
  }//end protected function genTabrow( $pic )

} // end class WgtMenuPicmenu


