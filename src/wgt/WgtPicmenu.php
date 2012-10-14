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
class WgtPicmenu
  extends WgtMenu
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var int
   */
  const DEF_ROWS = 8;

  /**
   * @var int
   */
  protected $numRows = 8;

  /**
   * @var string
   */
  protected $baseFolder = null;

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * constructor
   *
   * @return string
   */
  public function __construct( $name = null )
  {
    if( $name )
      $this->name = $name;

  }//end public function __construct */

  /** set the number of Menupoints in one row
   *
   * @return void
   */
  public function setRows( $num )
  {

    if( ctype_digit( (string)$num ) )
      $this->numRows = (int)$num;

    else
      $this->numRows = self::DEF_ROWS;

  } // end public function setRows */



  /**
   *
   * @return string
   */
  public function build( )
  {

    $this->load();

    $this->baseFolder = View::$iconsWeb.'large/';

    $anz = count( $this->data );

    $modulo = ( $anz + $this->numRows ) % $this->numRows;
    $top = $this->numRows - $modulo;

    if ( $modulo  != 0 )
      for ( $num = 0 ; $num < $top ; $num ++ )
        $this->data[] = array(null,null,null,null,null);

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

    if( $pic[WgtMenu::ICON] != '' || trim($pic[WgtMenu::TEXT]) != '' )
    {

      $text = trim( $pic[WgtMenu::TEXT] ) != '' ? $pic[WgtMenu::TEXT].'<br />' : '';

      if( Wgt::ACTION == $pic[WgtMenu::TYPE] )
      {
        $link = $text.'<img class="icon large cursor" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' onclick="'.$pic[WgtMenu::ACTION].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';
      }
      else
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" >'.$icon.$text.'</a>';
      }

    }
    else
    {
      $link =  '&nbsp;';
    }

    return '<td valign="top" >'.$link.'</td>'.NL;

  }//end protected function genTabrow */

} // end class WgtPicmenu


