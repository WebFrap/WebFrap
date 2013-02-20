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
class Error_Widget extends WgtWidget
{

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($view, $tabId, $tabSize = 'medium' )
  {

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="error"  >
      <h2>The Widget you requested was not loadable</h2>
      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */


  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function reload($view, $tabId )
  {

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="error"  >
      <h2>The Widget you requested was not loadable</h2>
      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

} // end class Error_Widget

