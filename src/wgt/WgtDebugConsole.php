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
 * class WgtItemAbstract
 * Abstraktes Factory class
 * @package WebFrap
 * @subpackage wgt
 */
class WgtDebugConsole
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * Enter description here ...
   */
  public function build( $type = 'dialog' )
  {

    $content = Debug::consoleHtml();
    
    if( 'data' !== $type )
    {

    $html = <<<HTML
  <div  id="wgt_debug_console" title="DEBUG Console" class="wcm wcm_ui_dialog" style="width:400px;height:200px;" >

    <div id="wgt-debug_console-tabs" class="wcm wcm_ui_tab" style="height:300px;" >
    <div id="wgt-debug_console-tabs-head" class="wgt_tab_head" ></div>

      <div id="wgt-debug_console-tabs-body" class="wgt_tab_body" >

        <div id="debug-console" title="console" class="wgt_tab wgt-debug_console-tabs" >
          <div class="content" >
          {$content}
          </div>
        </div>

        <div id="debug-actions" title="actions" class="wgt_tab wgt-debug_console-tabs" >
          <button onclick="\$R.get('');" class="wcm wcm_ui_button" >Clean Full Cache</button>
          <button onclick="\$R.get('');" class="wcm wcm_ui_button" >Clean Css Cache</button>
          <button onclick="\$R.get('');" class="wcm wcm_ui_button" >Clean Theme Cache</button>
          <button onclick="\$R.get('');" class="wcm wcm_ui_button" >Clean Js Cache</button>
        </div>

      </div>

    </div>

  </div>
HTML;

    }
    else 
    {
      
    $html = <<<HTML
  <var  id="wgt_debug_console-content" >
    {$content}
  </var>
HTML;
      
    }

    return $html;

  }





} // end class WgtSlice

