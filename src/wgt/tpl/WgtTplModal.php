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
class WgtTplModal
{

  /**
   * @var string $id
   * @var string $content
   * @var boolean $out
   */
  public static function render( $id, $out = true )
  {

    $content = ob_get_contents();
    ob_end_clean();

    $html = <<<HTML
  <div id="wgt-modal-{$id}" class="wgt-modal-container" >
    {$content}
  </div>
HTML;

    if( $out )
      echo $html;

    return $html;

  }//end public static function render */

  /**
   * Starten des Modal Renderers
   */
  public static function start( )
  {

    ob_start();

  }//end public static function start */

}//end class WgtTplModal
