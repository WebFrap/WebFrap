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
 * A Menu that looks like a filesystem folder
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtGrid extends WgtList
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $baseFolder   = null;

/*//////////////////////////////////////////////////////////////////////////////
// logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return string
   */
  public function build( )
  {

    $this->baseFolder = View::$iconsWeb.'large/';

    $html = '<div class="wgt-menu folder" >'.NL;

    // Generieren der Rows
    foreach ( $this->data as $entry )
    {
      $html .= $this->renderListEntry( $entry );
    }
    $html .= '</div>'.NL;

    $this->html = $html;

    return $html;

  }//end public function build */

  /**
   * @param $pic
   * @return
   */
  protected function renderListEntry( $pic )
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
      else if( Wgt::URL == $pic[WgtMenu::TYPE] )
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" ><p>'.$text.'</p>'.$icon.'</a>';
      }
      else if( Wgt::AJAX == $pic[WgtMenu::TYPE] )
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" ><p>'.$text.'</p>'.$icon.'</a>';
      }
      else
      {
        $icon = '<img class="icon large" '.
                    ' src="'.$this->baseFolder.$pic[WgtMenu::ICON].'" '.
                    ' alt="'.$pic[WgtMenu::TITLE].'" '.
                    ' title="'.$pic[WgtMenu::TITLE].'" />';

        $link = '<a class="wcm wcm_req_ajax" style="border:0px;" href="'.$pic[WgtMenu::ACTION].'" ><p>'.$text.'</p>'.$icon.'</a>';
      }

    }
    else
    {
      $link =  '&nbsp;';
    }

    return '<div class="wgt-entry" >'.$link.'<div class="" > </div></div>'.NL;

  }//end protected function renderListEntry */

} // end class WgtGrid


