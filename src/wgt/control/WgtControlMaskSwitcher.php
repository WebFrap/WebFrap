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
 * @subpackage wgt
 */
class WgtControlMaskSwitcher
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Rendern des Menüs
   * @param WgtMaintab $view
   * @param WgtDropmenu $menu
   * @param string $context
   * @param Entity $entity
   * @param string $maskName
   */
  public function renderMenu($view, $menu, $context, $entity, $maskName)
  {

  }//end public function renderMenu */

  /**
   * Render des Javascripts
   * @param WgtMaintab $view
   * @param WgtDropmenu $menu
   */
  public function renderActions($view,  $menu)
  {

    $html = <<<HTML

    self.getObject().find('.{$menu->id}-maskswitcher').change(function(){
      \$R.get(\$S(this).val());
    });

HTML;

    return $html;

  }//end public function renderActions */

} // end class WgtControlMaskSwitcher

