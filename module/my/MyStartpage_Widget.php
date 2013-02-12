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
 * @subpackage Core
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class MyStartpage_Widget
  extends WgtWidget
{

  /**
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab( $containerId, $tabId, $tabSize = 'medium' )
  {

    $user     = $this->getUser();
    $view     = $this->getView();

    $profile = $user->getProfileName();
    $modMenu = $view->newItem( 'widgetUserMenu', 'MenuFolder' );

    $modMenu->setData( DaoFoldermenu::get('profile/'.strtolower($profile)) );
    $modMenu->setId('wbf_desktop_usermenu');

    $rederer = $view->getRenderer('ProfileDefaultDashboardMenu');

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="My Menu"  >
      {$rederer->render(null)}
      <div class="clearance small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

} // end class MyStartpage_Widget
