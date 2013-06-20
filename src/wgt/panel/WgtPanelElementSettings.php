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

/** Form Class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtPanelElementSettings extends WgtPanelElement
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * die id des formulars an welches die Prozessdaten gehängt werden
   * @var string
   */
  public $formId  = null;


  /**
   * Die Settings Felder
   * @var string
   */
  public $fields = array();

  /**
   * @var Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param array $entities
   * @param array $fields
   * @param LibTemplate $view
   */
  public function __construct($model, $view)
  {

    $this->env = Webfrap::$env;
    $this->model = $model;
    $this->view = $view;
    $this->init();

  } // end public function __construct */

  /**
   * @param string $formId
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    $i18n         = $this->getI18n();

    $html = <<<HTML

    <button
        class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button"
        id="{$this->id}-settings"
        title="Click to edit the Settings"
      ><i class="icon-cog" ></i><var>{"size":"big"}</var></button><div class="{$this->id}-settings hidden" >
      <div class="wgt-space" >
      <h2>Settings</h2>
      <ul>
HTML;

      foreach ($this->fields as $nameKey => $field) {
        $html .= '<li><input type="checkbox" name="'.$nameKey.'" '.Wgt::asmAttributes($field[1]).'  />&nbsp;&nbsp;<label>'.$field[0].'</label></li>'.NL;
      }

    $html .= <<<HTML
      </ul>
      </div>
    </div>
HTML;

    return $html;

  }//end public function render */



}//end class WgtPanelElementSettings

