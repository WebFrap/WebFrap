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
 * Ein Double List Selector
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtElementDblListSelector extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = 'Selection';

  /**
   * @var string
   */
  public $inpName = 'entry[]';

  /**
   * @var string
   */
  public $urlConnect = null;

  /**
   * @var string
   */
  public $urlDisconnect = null;

  /**
   * Die ID des Datensatzes mit welchem die Elemente verknüpft werden sollen
   * @var int
   */
  public $refId = null;

  /**
   * Enträge welche mit dem Element connecte sind
   * @var array
   */
  public $connectedEntries = array();

  /**
   * Einträge für die keine Verknüpfung besteht
   * @var unknown_type
   */
  public $unConnectedEntries = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $both
   * @param array $unConnectedEntries
   */
  public function setData($both, $unConnectedEntries = null  )
  {

    if (is_null($unConnectedEntries)) {
      $this->unConnectedEntries = $both[0];
      $this->connectedEntries = $both[1];
    } else {
      $this->unConnectedEntries = $both;
      $this->connectedEntries = $unConnectedEntries;
    }

  }//end public function setData */

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name = null, $view = null)
  {

    $this->texts  = new TArray();

    $this->name   = $name;
    $this->init();

    if ($view)
      $view->addElement($name, $this);

  }//end public function __construct */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    if ($this->html)
      return $this->html;

    $codeConnected = '';

    /**
     * title:
     * content:
     */
    if ($this->connectedEntries) {
      foreach ($this->connectedEntries as $entry) {

        $codeConnected .= <<<HTML

  <li>{$entry['label']}<input class="wgt-ignore" name="{$this->inpName}" type="hidden" value="{$entry['value']}" /></li>

HTML;

      }
    }

    $codeUnConnectedEntries = '';

    /**
     * title:
     * content:
     */
    if ($this->unConnectedEntries) {
      foreach ($this->unConnectedEntries as $entry) {

        $codeUnConnectedEntries .= <<<HTML

  <li>{$entry['label']}<input class="wgt-ignore" name="{$this->inpName}" type="hidden" value="{$entry['value']}" /></li>

HTML;

      }
    }

    $id       = $this->getId();

    $settings = array();

    if ($this->refId)
      $settings[] = '"refid":"'.$this->refId.'"';

    if ($this->urlConnect)
      $settings[] = '"url_connect":"'.SFormatStrings::cleanCC($this->urlConnect).'"';

    if ($this->urlDisconnect)
      $settings[] = '"url_disconnect":"'.SFormatStrings::cleanCC($this->urlDisconnect).'"';

    $codeSetings = '{'.implode(',', $settings).'}';


    $html = <<<HTML

<div id="{$id}" class="wcm wcm_ui_dbl_list_selector wgt-dbl_list_selector bw5 wgt-border" >
  <var id="{$id}-cfg-dbl_list" >{$codeSetings}</var>

  <div class="wgt-panel title" >{$this->label}</div>

  <table>

    <tr>
      <td>All {$this->label}</td>
      <td></td>
      <td>Assigned {$this->label}</td>
    </tr>

    <tr>

      <td valign="top" >
        <ul class="out bw2 dbl_list" >
          {$codeUnConnectedEntries}
        </ul>
      </td>

      <td align="center" >
        <div class="menu bw05" >
          <div class="entry" >
            <button
              class="wgt-button all_in ui-icon ui-icon-arrowthickstop-1-e"
              tabindex="-1" >&nbsp;&nbsp;</button>
          </div>
          <div class="entry" >
            <button
              class="wgt-button seleted_in ui-icon ui-icon-arrowthick-1-e"
              tabindex="-1" >&nbsp;&nbsp;</button>
          </div>
          <div class="wgt-clear small" >&nbsp;</div>
          <div class="entry" >
            <button
              class="wgt-button seleted_out ui-icon ui-icon-arrowthick-1-w"
              tabindex="-1" >&nbsp;&nbsp;</button>
          </div>
          <div class="entry" >
            <button
              class="wgt-button all_out ui-icon ui-icon-arrowthickstop-1-w"
              tabindex="-1" >&nbsp;&nbsp;</button>
          </div>
        </div>
      </td>

      <td valign="top" >
        <ul class="in bw2 dbl_list" >
          {$codeConnected}
        </ul>
      </td>

    </tr>
  </table>

  <div class="wgt-clear" ></div>
</div>

HTML;

    return $html;

  }// end public function render */

} // end class WgtElementDblListSelector

