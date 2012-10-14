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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapNavigation_Subwindow_Menu
  extends WgtDropmenu
{

  /**
   * build the window menu
   * @param TArray $params
   */
  public function build( $params )
  {

    $iconMenu         = $this->view->icon('control/menu.png'      ,'Menu');
    $iconMisc         = $this->view->icon('control/misc.png'      ,'Misc');
    $iconClose        = $this->view->icon('control/close.png'     ,'Close');
    $iconEntity       = $this->view->icon('control/entity.png'    ,'Entity');

    $entries = new TArray();

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" style="z-index:500;height:16px;"  >
  <li class="wgt-root" >
    <button class="wgt-button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
</ul>
HTML;

  }//end public function build */

}//end class WebfrapNavigation_Subwindow_Menu

