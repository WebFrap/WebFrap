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
class WgtElementCheckboxMatrix extends WgtAbstract
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
   * @var int
   */
  public $numCols = 3;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name = null, $view = null )
  {

    $this->texts  = new TArray();

    $this->name   = $name;
    $this->init();

    if ($view )
      $view->addElement($name, $this );

  }//end public function __construct */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null )
  {

    if ($this->html )
      return $this->html;

    $codeEntry = '';

    $numEntries = count($this->data);
    $numEntries += ($numEntries % $this->numCols);

    /**
     * title:
     * content:
     */
    if ($this->data) {
      for ($pos = 0; $pos < $numEntries; $pos ++) {
        $newCol = false;
        if (!$pos % $this->numCols )
          $newCol = true;

        if ($newCol )
          $codeEntry .= "<tr>";

        if ( isset($this->data[$pos] ) ) {
          $codeEntry .= <<<HTML

  <td><input
    class="wgt-ignore"
    name="{$this->inpName}"
    type="checkbox" value="{$this->data[$pos]['value']}" /><label>{$this->data[$pos]['label']}</label></td>

HTML;
        } else {
          $codeEntry .= '<td>&nbsp;<td>';
        }

        if ($newCol )
          $codeEntry .= "</tr>";

      }
    }


    $id       = $this->getId( );

    $settings = array();

    if ($this->refId )
      $settings[] = '"refid":"'.$this->refId.'"';

    if ($this->urlConnect )
      $settings[] = '"url_connect":"'.SFormatStrings::cleanCC($this->urlConnect).'"';

    if ($this->urlDisconnect )
      $settings[] = '"url_disconnect":"'.SFormatStrings::cleanCC($this->urlDisconnect).'"';

    $codeSetings = '{'.implode( ',', $settings ).'}';


    $html = <<<HTML

<div id="{$id}" class="wcm wcm_ui_checkbox_matrix wgt-checkbox_matrix wgt-border" >
  <var id="{$id}-cfg-ckb_matrix" >{$codeSetings}</var>

  <div class="wgt-panel title" >{$this->label}</div>

  <table>
    {$codeEntry}
  </table>

  <div class="wgt-clear" ></div>
</div>

HTML;

    return $html;

  }// end public function render */

} // end class WgtElementAttachmentList

