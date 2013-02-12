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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlNode_ProfileBackpath_Ajax_View
  extends LibTemplateAjaxView
{
////////////////////////////////////////////////////////////////////////////////
// Default Permission
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param $backpath BdlNodeProfileBackpath
   * @param $index int
   * @param $profileName string
   */
  public function displayInsert( $backpath, $index, $profileName )
  {

    $iconEdit   = Wgt::icon( 'control/edit.png', 'xsmall' );
    $iconDelete = Wgt::icon( 'control/delete.png', 'xsmall' );
    $iconAdd    = Wgt::icon( 'control/add.png', 'xsmall' );

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-backpath" action="append" ><![CDATA[
  <li id="wgt-node-profile-{$profileName}-backpath-{$index}" >
    <span>{$backpath->getName( true )}</span>
    <div class="right" style="width:90px;" >
      <button
        class="wgt-button wgtac_add_backpath_node"
        wgt_path="{$index}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_backpath"
        wgt_idx="{$index}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_backpath"
        wgt_idx="{$index}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$backpath->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$backpath->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
  </li>
]]></htmlArea>
XML
    );

    $this->setAreaContent( 'childCode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-backpath" action="function" ><![CDATA[

    self.find(".wgtac_add_backpath_node").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfileBackpath.createNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_backpath_node');

    self.find(".wgtac_edit_backpath").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfileBackpath.edit&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_backpath');

    self.find(".wgtac_delete_backpath").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfileBackpath.delete&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_backpath');
]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param $backpath BdlNodeProfileBackpath
   * @param $index int
   * @param $profileName string
   */
  public function displayUpdate( $backpath, $index, $profileName )
  {

    $iconEdit   = Wgt::icon( 'control/edit.png', 'xsmall' );
    $iconDelete = Wgt::icon( 'control/delete.png', 'xsmall' );
    $iconAdd    = Wgt::icon( 'control/add.png', 'xsmall' );

    // Sub render function
    $renderSubNode = function( $ref, $path, $subRednerer ) use ( $profileName, $iconAdd, $iconEdit, $iconDelete ) {

      /* @var $ref BdlNodeProfileAreaPermissionRef */
      $references = $ref->getReferences();

      if( !$references )

        return '';

      $code = '<ul id="wgt-list-profile-'.$profileName.'-backpath-'.str_replace('.', '-', $path).'" >';

      $idx = 0;

      foreach ($references as $ref) {

        $subNodes = $subRednerer( $ref, "{$path}.{$idx}", $subRednerer );

        $code .= <<<HTML
  <li id="wgt-node-profile-{$profileName}-backpath-{$idx}" >
    <span>{$ref->getName( true )}</span>
    <div class="right" style="width:90px;" ><button

        class="wgt-button wgtac_add_backpath_node"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_backpath_node"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_backpath_node"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$ref->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$ref->getLevel()}</div>
    <div class="wgt-clear tiny" >&nbsp;</div>
    {$subNodes}
  </li>
HTML;

        ++$idx;
      }

      $code .= '</ul>';

      return $code;
    };

    //$subNodes = $renderSubNode( $backpath, $index, $renderSubNode );
    $subNodes = '';

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="li#wgt-node-profile-{$profileName}-backpath-{$index}" action="replace" ><![CDATA[
  <li id="wgt-node-profile-{$profileName}-backpath-{$index}" >
    <span>{$backpath->getName( true )}</span>
    <div class="right" style="width:90px;" >
      <button
        class="wgt-button wgtac_add_backpath_node"
        wgt_path="{$index}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_backpath"
        wgt_idx="{$index}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_backpath"
        wgt_idx="{$index}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$backpath->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$backpath->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
    {$subNodes}
  </li>
]]></htmlArea>
XML
    );

    $this->setAreaContent( 'childCode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-backpath" action="function" ><![CDATA[
    self.find(".wgtac_edit_backpath").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfileBackpath.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_backpath');

    self.find(".wgtac_delete_backpath").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfileBackpath.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_backpath');
]]></htmlArea>
XML
    );

  }//end public function displayUpdate */

  /**
   * @param $index int
   * @param $profileName string
   */
  public function displayDelete( $index, $profileName )
  {

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="li#wgt-node-profile-{$profileName}-backpath-{$index}" action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */

}//end class DaidalosBdlNode_ProfileBackpath_Ajax_View
