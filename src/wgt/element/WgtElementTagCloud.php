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
 * Eine Tagcloud
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtElementTagCloud
  extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = 'Tags';

  /**
   * @var string
   */
  public $width = 400;

  /**
   * @var string
   */
  public $urlAutoComplete = 'ajax.php?c=Webfrap.Tag.autocomplete';

  /**
   * @var string
   */
  public $urlCreate = 'ajax.php?c=Webfrap.Tag.add';

  /**
   * @var string
   */
  public $urlDisconnect = 'ajax.php?c=Webfrap.Tag.disconnect';

  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $refId = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $name = null, $view = null )
  {

    $this->texts  = new TArray();

    $this->name   = $name;
    $this->init();

    if( $view )
      $view->addElement( $name, $this );

  } // end public function __construct */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {


    if( $this->html )
      return $this->html;

    $codeEntr = '';

    /**
     * title:
     * content:
     */
    if( $this->data )
    {
      foreach( $this->data as $entry )
      {

        $codeEntr .= <<<HTML

  <span class="tag" wgt_eid="{$entry['ref_id']}" wgt_tid="{$entry['tag_id']}" >{$entry['label']}</span>

HTML;

      }
    }

    $id       = $this->getId( );
    $iconAdd  = $this->icon( 'control/add.png', 'Add' );

    $settings = array();

    if( $this->refId )
      $settings[] = '"refid":"'.$this->refId.'"';

    if( $this->urlAutoComplete )
      $settings[] = '"url_auto_complete":"'.SFormatStrings::cleanCC($this->urlAutoComplete).'"';

    if( $this->urlCreate )
      $settings[] = '"url_tag_create":"'.SFormatStrings::cleanCC($this->urlCreate).'"';

    if( $this->urlDisconnect )
      $settings[] = '"url_tag_disconnect":"'.SFormatStrings::cleanCC($this->urlDisconnect).'"';

    $codeSetings = '{'.implode( ',', $settings ).'}';


    $settingsAuto  = '';
    $classAuto     = '';

    if( $this->urlAutoComplete )
    {
      $urlAutoComplete = SFormatStrings::cleanCC($this->urlAutoComplete);

      $settingsAuto = <<<HTML

  <var class="wgt-settings" >{
    "url":"{$urlAutoComplete}&amp;refid={$this->refId}&amp;key=",
    "type":"entity"}
  </var>

  <input
    type="hidden"
    id="{$id}-autoc" />

HTML;

      $classAuto     = 'wcm wcm_ui_autocomplete ';
    }

    $html = <<<HTML

<div
  class="wgt-content_box wgt-tag_cloud wcm wcm_widget_tag_cloud"
  id="{$id}"
  style="width:{$this->width}px;" >

  <div class="head" >
    <table border="0" cellspacing="0" cellpadding="0" width="100%" >
      <tr>
        <td width="210px;" ><h2>{$this->label}</h2></td>
        <td width="190px;" >
          <div class="search" >
            <input
              type="text"
              class="{$classAuto}wgt-overlay c_input_add embed medium wgt-ignore"
              id="{$id}-autoc-tostring" />
            {$settingsAuto}

            <button
            	id="{$id}-trigger"
            	tabindex="-1"
            	class="wgt-button c_cntrl_add append wgt-overlay embed" >{$iconAdd}</button>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="content" >
    {$codeEntr}
  </div>

  <var id="{$id}-cfg-tag_cloud" >{$codeSetings}</var>
</div>

HTML;


    return $html;

  } // end public function render */

} // end class WgtElementTagcloud


