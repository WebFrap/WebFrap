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
class WgtMenuSubmenu
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the text of the submenu
   *
   * @var string
   */
  protected $text = 'SubMenu';

  /**
   * the name of the submenu
   *
   * @var string
   */
  protected $action = 'dummy';

  /**
   * the icon for the submenu
   *
   * @var string
   */
  protected $icon = null;

  /**
   * id of the Menu
   *
   * @var string
   */
  protected $name = null;

  /**
   * the menu pool
   *
   * @var array
   */
  protected $menuPool = array();

////////////////////////////////////////////////////////////////////////////////
// Magic
////////////////////////////////////////////////////////////////////////////////


  /**
   * the constructor
   *
   * @param string $name
   */
  public function __construct( $name = null )
  {
    if(Log::$levelVerbose)
      Log::create(get_class($this),array($name));

    $this->name = $name;
  }//end public function __construct( $name = null )

////////////////////////////////////////////////////////////////////////////////
// getter and setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * add a button to the menu bar
   *
   * @param string $name
   * @param WgtMenuButton $button
   * @return WgtMenuButton
   */
  public function addButton( $name , $button = null )
  {
    if( is_null($button)  )
    {
      $button = new WgtMenuButton();
    }

    $this->menuPool[$name] = $button;

    return $button;

  }//end public function addButton( $name , $button = null )

  /**
   * Enter description here...
   *
   * @param string $name
   * @param string $subMenu
   * @return WgtMenuSubmenu
   */
  public function addSubmenu( $name , $subMenu = null )
  {
    if(Log::$levelDebug)
     Log::start( __file__ , __line__ ,__method__,array($name , $subMenu));

    if( is_null($subMenu) )
    {
      if( is_null($name) )
      {
        $subMenuCname = 'WgtMenuSubmenu';
      }
      else
      {
        $subMenuCname = 'WgtMenu'.ucfirst($name).'Submenu';
      }

      if( WebFrap::loadable($subMenuCname) )
      {
        $subMenu = new $subMenuCname($name);
      }
      else
      {
        Error::addError
        (
          'No Submenutype: '.$subMenuCname
        );
        return null;
      }
    }

    $this->pool[$name] = $subMenu;

    return $subMenu;
  }//end public function addSubmenu( $name , $subMenu = null )

  /**
   * Enter description here...
   *
   * @param string $name
   * @param string $html
   * @return WgtMenuHtml
   */
  public function addHtml( $name , $html = null )
  {
    if(Log::$levelDebug)
     Log::start( __file__ , __line__ ,__method__,array($name , $html));

    if( is_null($html)  )
    {
      $html = new WgtMenuHtml();
    }
    elseif( is_string($html) )
    {
      $html = new WgtMenuHtml($html);
    }

    $this->menuPool[$name] = $html;

    return $html;
  }//end public function addContent( $name , $content = null )

  /**
   * set the menu name
   *
   * @param string $text
   */
  public function setText( $text )
  {
    if(Log::$levelDebug)
     Log::start( __file__ , __line__ ,__method__,array($text));

    $this->text = $text ;
  }//end public function setText( $text )

  /**
   * set the menu name
   *
   * @param string $name
   */
  public function setName( $name )
  {
    if(Log::$levelDebug)
     Log::start( __file__ , __line__ ,__method__,array($name));

    $this->name = $name ;
  }//end public function setName( $name )

  /**
   * set the menu name
   *
   * @param string $icon
   */
  public function setIcon( $icon )
  {
    if(Log::$levelDebug)
     Log::start( __file__ , __line__ ,__method__,array($icon));

    $this->icon = $icon ;
  }//end public function setIcon( $icon )

  /**
   * set the menu name
   *
   * @param string $name
   */
  public function setAction( $action )
  {
    if(Log::$levelDebug)
     Log::start( __file__ , __line__ ,__method__,array($action));

    $this->action = $action ;
  }//end public function setAction( $action )

////////////////////////////////////////////////////////////////////////////////
// buildr methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the Load function
   *
   */
  public function load()
  {
    // debug is here ok despire of that this will give a warning

  }//end public function load()

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function toXml()
  {

    $this->load();

    $baseFolder = View::$iconsWeb.'/xsmall/';

    $xml = '<submenu  action="replace"  id="submenu_'.$this->name.'" icon="'.$baseFolder.$this->icon.'" value="'.$this->text.'" callback="'.$this->action.'" >'.NL;

    foreach( $this->menuPool as $entry )
    {
      $xml .= $entry->toXml();
    }

    $xml .= '</submenu>'.NL;

    return $xml;

  }//end public function asXml()

  /**
   * @return string
   */
  public function build( $bar )
  {


    $this->load();

    if( $this->icon )
    {
      $icon = "'".View::$iconsWeb.'/xsmall/'.$this->icon."'";
    }
    else
    {
      $icon = 'null';
    }

    $subMenuName = 'subMenu'.$this->name;

    $html = 'var '.$subMenuName
      .' = '.$bar.'.createSubmenu( "'.$this->text.'", '.$icon.', '.$this->action.' , \'submenu_'.$this->name.'\' );'.NL;

    foreach( $this->menuPool as $entry )
    {
      $html .= $entry->build($subMenuName);
    }

    return $html;

  }//end public function build()


} // end class WgtMenuSubmenu


