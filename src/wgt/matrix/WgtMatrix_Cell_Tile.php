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
 * @lang de:
 *
 *
 * @package WebFrap
 * @subpackage wgt
 */
class WgtMatrix_Cell_Tile
 extends WgtMatrix_Cell
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Type des cell values
   * @var string
   */
  public $type = 'tile';

  /**
   * Url zum adressieren eines Datensatzes
   * @var string
   */
  public $openUrl = null;

  /**
   * Key des Feldes mit der ID für die URL
   * @var string
   */
  public $keyField = null;

  /**
   * Das Feld mit dem Inhalt für Title
   * @var string
   */
  public $titleField = null;

  /**
   * Felder links
   * @var [key:label]
   */
  public $leftFields = array();

  /**
   * Felder rechts
   * @var [key:label]
   */
  public $rightFields = array();

  /**
   * Content
   * @var string
   */
  public $contentFields = array();

  /**
   * Bottom Field
   * @var string
   */
  public $bottomField = null;

  /**
   * @param array $data
   */
  public function render($dataList )
  {

    $html = '';

    foreach ($dataList as $node) {

      $bottomCode = '';
      if ($this->bottomField )
        $bottomCode = '<div class="bottom" >'.$node[$this->bottomField].'</div>';

      $contentCode = '';
      if ($this->contentFields) {
        $contentCode = '<div class="full" >';
        foreach ($this->contentFields as $key => $label) {
          $contentCode .= '<div class="wgt-tile-kv" ><label>'.$label.'</label>'
            .'<span>'.$node[$key].'</span></div>'.NL;
        }

        $contentCode .= '</div>';
      } else {
        $contentCode = '<div class="left" >';
        foreach ($this->leftFields as $key => $label) {
          $contentCode .= '<div class="wgt-tile-kv" ><label>'.$label.'</label>'
            .'<span>'.$node[$key].'</span></div>'.NL;
        }
        $contentCode .= '</div>';

        $contentCode .= '<div class="right" >';
        foreach ($this->rightFields as $key => $label) {
          $contentCode .= '<div class="wgt-tile-kv" ><label>'.$label.'</label>'
            .'<span>'.$node[$key].'</span></div>'.NL;
        }
        $contentCode .= '</div>';
      }

      $html .= <<<HTML
  <div class="wgt-tile ui-widget-content ui-corner-all" >
    <h3><a
      class="wcm wcm_req_ajax"
      href="{$this->openUrl}{$node[$this->keyField]}" >{$node[$this->titleField]}</a></h3>
    {$contentCode}
    {$bottomCode}
    <div class="wgt-clear" >&nbsp;</div>
  </div>
HTML;

    }

    return $html;

  }//end public function render */

}//end class WgtMatrix_Cell_Tile

