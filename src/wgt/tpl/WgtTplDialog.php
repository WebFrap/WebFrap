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
class WgtTplDialog
{

  /**
   * @var string $id
   * @var string $content
   * @var string $code
   * @var LibTemplate $view
   * @var boolean $out
   */
  public static function render($id, $content, $code, $view, $out = true )
  {

    $html = <<<HTML
  <div id="wgt-dialog-{$id}" class="template" >
    {$content}
  </div>
HTML;

    $view->addJsCode($code );

    if ($out )
      echo $html;

    return $html;

  }//end public static function render */

}//end class WgtTplDialog

