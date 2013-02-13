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
class WgtMenuMainmenu
  extends WgtMenuAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the name of the submenu
   *
   * @var string
   */
  protected $subMenuName = 'SubMenu';

/*//////////////////////////////////////////////////////////////////////////////
// logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $name
   */
  public function setSubmenuName( $name )
  {
    $this->subMenuName = $name ;
  }//end public function setSubmenuName */

  /**
   * @return string
   */
  public function build()
  {


    $this->load();

    $html = '<ul class="wgtMenu sidebar" >';

    foreach( $this->data as $entry )
    {
      $html .= '
      <li>
        <a href="'.TUrl::asUrl($entry[0],$entry[1],$entry[2]).'">'.$entry[3].'</a>
      </li>';

    }
    $html .= '</ul>';

    return $html;
  }//end public function build */

  /**
   * @return string
   */
  public function buildJs()
  {

    $this->load();

    $baseFolder = View::$webIcons.'/xsmall/';

    $html = '$S(document).ready(function(){ '.NL;

    $html .= '
  // create menubar
  $S("div#wgtid_Topmenu").menubar();

  // show menubar
  $S("div#wgtid_Topmenu").getMenubar().getJQuery().css("top",0);
  $S("div#wgtid_Topmenu").getMenubar().openMenubar();
  extendMainmenuWebfrap(); '.NL;

    $html .= ' var mBarWid'.$this->name
      .' = $S("div#'.$this->menuId.'").getMenubar().createWidgetMenu( null, dummy, true );'.NL;

    $html .= 'var mBarWidSub'.$this->name
      .' = mBarWid'.$this->name.'.createSubmenu( "'.$this->subMenuName.'", "", dummy );'.NL;

    foreach( $this->data as $entry )
    {
      if( isset($entry[4]) and trim($entry[4]) != '' )
      {
        $icon = $baseFolder.$entry[4];
      }
      else
      {
        $icon = '';
      }

      $html .= 'mBarWidSub'.$this->name.'.addButton( "'.$entry[3].'", "'.$icon.'", "'.TUrl::asUrl($entry[0],$entry[1],$entry[2]).'" );'.NL;
    }

    $html .= '});'.NL;

    return $html;

  }//end public function buildJs */

  /**
   * @return string
   */
  public function buildJsFunction()
  {

    $this->load();


    $baseFolder = View::$iconsWeb.'xsmall/';

    $html = NL.'function extendMainmenu'.$this->name.'(){ '.NL;
    $html .= ' var mBarWid'.$this->name
      .' = $S("div#'.$this->menuId.'").getMenubar().createWidgetMenu( null, dummy, true );'.NL;
    $html .= 'var mBarWidSub'.$this->name
      .' = mBarWid'.$this->name.'.createSubmenu( "'.$this->subMenuName.'", "", dummy );'.NL;

    foreach( $this->data as $entry )
    {
      if( isset($entry[4]) and trim($entry[4]) != '' )
      {
        $icon = $baseFolder.$entry[4];
      }
      else
      {
        $icon = '';
      }

      $html .= 'mBarWidSub'.$this->name.'.addButton( "'.$entry[3].'", "'.$icon.'", "'.TUrl::asUrl($entry[0],$entry[1],$entry[2]).'" );'.NL;
    }

    $html .= '}'.NL;

    return $html;

  }//end public function buildJsFunction */

  /**
   *
   */
  public function buildAjax()
  {
    ///TODO find a better way than that to prevent sending as item
    return '';
  }


} // end class WgtMenuMainmenu


