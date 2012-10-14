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
class WgtItemPicmenu
  extends WgtItemAbstract
{


  /**
   * Der Systemcontroller

   */
  protected $numRows = 3;

  /**
   * Das Systemtemplate

   */
  protected $baseFolder = null;


  /** Setzten Der Anzahl von Menüpunkten
   *
   * @return

   */
  public function setRows( $Num )
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ ,__method__ );

    if( ctype_digit( "$Num" ) )
    {
      $this->numRows = (int)$Num;
    }

  } // end of member function setNumRows

  public function load()
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ ,__method__ );

  }

  /**
   *
   * @return

   */
  public function build( )
  {


    $this->load();

    $sys = Webfrap::getActive();

    // Setzten des Basispfads für das Picmenu
    $template = $sys->getSysStatus('systemplate');
    $this->baseFolder = WEB_THEME.'templates/'.$template.'/icons/large/';

    $html = '<table class="wgtMenu explorer" >'.NL;

    $Anzahl = count( $this->data );


    $modulo = ( $Anzahl + $this->numRows ) % $this->numRows;
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

    // Generieren der Rows
    for ( $nam = 0 ; $nam < $Anzahl ; ( $nam += $this->numRows ) )
    {
      $html .= '<tr>';
      for( $num = 0 ; $num < $this->numRows  ; ++$num )
      {
        $anz = $nam + $num;
        $html .= $this->genTabrow( $this->data[$anz] );
      }
      $html .= "</tr>\n";

      $html .= "<tr>
          <td colspan=\"".$this->numRows."\" class=\"wgtSpaceSmall\"></td>
        </tr>\n";
    }
    $html .= "</table>\n";

    $this->html = $html;

    return $html;
  } // end of member function build

  /**
   *
   * @return

   */
  protected function genTabrow( $Pic )
  {


    if( $Pic['menuicon'] != '' or trim($Pic['menutext']) != '' )
    {
      $Icon = "<img class=\"icon large\" ".
                  " src=\"".$this->baseFolder.$Pic["menuicon"]."\" ".
                  " alt=\"".$Pic["menuiconalt"]."\" ".
                  " title=\"".$Pic['menutitel']."\" />";

      $Text = trim( $Pic['menutext'] ) != '' ? $Pic['menutext'].'<br />' : '';

      $Link = "<a href=\"".$Pic["menulink"]."\" >".$Icon.$Text.'</a>';
    }
    else
    {
      $Link =  '&nbsp;';
    }

    $html = "<td valign=\"top\" class=\"PicMenu\" >".NL;
    $html .= $Link."\n";
    $html .= "</td>\n";

    return $html;
  }//end protected function genTabrow */




} // end of WgtItemPicmenu


