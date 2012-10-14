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
class WgtItemDashboard
  extends WgtItemAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Parser
////////////////////////////////////////////////////////////////////////////////

  /**
   * Parser for the input field
   *
   * @return string
   */
  public function build( )
  {

    $html = <<<HTML
    
  <div id="{$this->id}" class="dashboard wcm wcm_ui_dashboard" >
    <!-- this HTML covers all layouts. The 5 different layouts are handled by setting another layout classname -->
    <div class="layout">
      <div class="column first column-first"></div>
      <div class="column second column-second"></div>
      <div class="column third column-third"></div>
    </div>
  </div>
    
HTML;

    return $html;

  }// end public function build */

}// end class WgtItemDashboard


