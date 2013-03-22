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
class WgtElementContentBox extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var string
   */
  public $content = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render($params = null)
  {

    /**
    <div class="right">
      <button class="wgt-button ui-state-default controls hidden" style="display: none;"><span class="ui-icon ui-icon-gear"></span></button>
      <button class="wgt-button ui-state-default controls hidden" style="display: none;"><span class="ui-icon ui-icon-help"></span></button>
    </div>
     */

    $id = $this->getId();

    $html = <<<HTML

<div class="wgt-content_box inline wgt-space">
  <div class="head">
    <h2>{$this->label}</h2>

  </div>
  <div class="content">
{$this->content}
  </div>
</div>

HTML;

    return $html;

  } // end public function render */

} // end class WgtElementContentBox

