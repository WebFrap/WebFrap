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
 * Template für ein Modal Element
 * @package WebFrap
 * @subpackage wgt/tpl
 */
class WgtTplButtonList
{

  /**
   * @var LibTemplate $view
   * @var string $id
   * @var string $content
   * @var int $formId
   * @var string $nameEntries
   * @var array $entries
   */
  public static function render($view, $id, $inpId, $formId, $nameEntries, $entries)
  {

    $iconDel = $view->icon('control/delete.png', 'Delete'  );

    $codeEntries = '';
    foreach ($entries as $entry) {

      $codeEntries .= <<<HTML
    <li><input
      type="hidden"
      name="{$nameEntries}[{$entry['id']}]"
      class="asgd-{$formId}"
      value="{$entry['value']}" /><button
        class="wgt-button" >{$entry['label']}</button><button
        class="wgt-button append"
        onclick="\$S(this).parentX('li').remove();" >{$iconDel}</button></li>

HTML;

    }

    $code = <<<HTML

  <ul id="{$id}" class="wcm wcm_widget_inputlist" >
    {$codeEntries}
  </ul>
  <var id="{$id}-cfg-inplist" >
  {"input":"{$inpId}"}
  </var>

HTML;

    return $code;

  }//end public static function render */

}//end class WgtTplButtonList

