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
 *
 */
class Profile
  extends Base
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string
   */
  public $key      = 'default';

  /**
   * @param WgtMainmenu
   */
  public $mainMenu      = null;

  /**
   * @param string
   */
  public $mainMenuName  = 'Default';

  /**
   * @param WgtDesktop
   */
  public $desktop       = null;

  /**
   * @param string
   */
  public $desktopName   = 'Default';

  /**
   * @param WgtNavigation
   */
  public $navigation      =  null;

  /**
   * @param string
   */
  public $navigationName  =  'Default';

  /**
   * @param WgtPanel
   */
  public $panel      =  null;

  /**
   * @param string
   */
  public $panelName  =  'Default';

  /**
   * @param string
   */
  public $label  =  'Default';

  /**
   * Stateless archivieren
   */
  public function __sleep()
  {
    return array();
  }//end public function __sleep */

  /**
   * @return string
   */
  public function getKey(  )
  {
    return strtolower($this->key);
  }//end public function getKey */

  /**
   * @param string $mainMenuName
   */
  public function setMainMenuName( $mainMenuName )
  {
    $this->mainMenuName = $mainMenuName;
  }//end public function setMainMenuName */

  /**
   * @param string $desktopName
   */
  public function setDesktopMenuName( $desktopName )
  {
    $this->desktopName = $desktopName ;
  }//end public function setDesktopMenuName */

  /**
   * @param string $navigationName
   */
  public function setNavigationName( $navigationName )
  {
    $this->navigationName = $navigationName ;
  }//end public function setNavigationName */

  /**
   * @param string $menuBar
   */
  public function setPanelName( $panelName )
  {
    $this->panelName = $panelName ;
  }//end public function setPanelName */

  /**
   * @return WgtMainmenu
   */
  public function getMainMenu()
  {

    if (!$this->mainMenu) {
      $className = 'WgtDesktopMainmenu'.$this->mainMenuName;

      if ( Webfrap::classLoadable( $className ) ) {
        $this->mainMenu = new $className();
      } else {
        $this->mainMenu = new WgtDesktopMainmenuDefault();
        $this->getResponse()->addError('Missing Mainmenu '.$this->mainMenuName.', fallback to default');
      }
    }

    return $this->mainMenu;

  }//end public function getMainMenu */

  /**
   * @return WgtDesktop
   */
  public function getDesktop()
  {
    if (!$this->desktop) {
      $className = 'WgtDesktop'.$this->desktopName;

      if ( Webfrap::classLoadable( $className ) ) {
        $this->desktop = new $className();
      } else {
        $this->desktop = new WgtDesktopDefault();
        $this->getResponse()->addError('Missing Desktop '.$this->desktopName.', fallback to default');
      }
    }

    return $this->desktop;

  }//end public function getDesktop */

  /**
   * @return WgtNavigation
   */
  public function getNavigation()
  {

    if (!$this->navigation) {
      $className = 'WgtDesktopNavigation'.$this->navigationName;

      if ( Webfrap::classLoadable( $className ) ) {
        $this->navigation = new $className();
      } else {
        $this->navigation = new WgtDesktopNavigationDefault();
        $this->getResponse()->addError('Missing Navigation '.$this->desktopName.', fallback to default');
      }
    }

    return $this->navigation;

  }//end public function getNavigation */

  /**
   * @return WgtPanel
   */
  public function getPanel()
  {

    if (!$this->panel) {
      $className = 'WgtDesktopPanel'.$this->panelName;

      if ( Webfrap::classLoadable( $className ) ) {
        $this->panel = new $className();
      } else {
        $this->panel = new WgtDesktopPanelDefault();
        $this->getResponse()->addError('Missing Panel '.$this->desktopName.', fallback to default');
      }
    }

    return $this->panel;

  }//end public function getPanel */

} // end class Profile
