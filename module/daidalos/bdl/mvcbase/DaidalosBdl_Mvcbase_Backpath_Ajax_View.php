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
class DaidalosBdl_Mvcbase_Backpath_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der domainkey
   * eg: role
   * @var string
   */
  public $domainKey = null;

  /**
   * Domain Class Part
   * eg: Role
   * @var string
   */
  public $domainClass = null;

/*//////////////////////////////////////////////////////////////////////////////
// Default Permission
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $backpath BdlNodeBaseAreaBackpath
   * @param $index int
   * @param $pNodeName string
   */
  public function displayInsert($backpath, $index, $pNodeName)
  {

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');
    $iconAdd    = Wgt::icon('control/add.png', 'xsmall');

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-backpath" action="append" ><![CDATA[
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-backpath-{$index}" >
    <span>{$backpath->getName(true)}</span>
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

    $this->setAreaContent('childCode', <<<XML
<htmlArea selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-backpath" action="function" ><![CDATA[

    self.find(".wgtac_add_backpath_node").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Backpath.createNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_backpath_node');

    self.find(".wgtac_edit_backpath").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Backpath.edit&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_backpath');

    self.find(".wgtac_delete_backpath").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_{$this->domainClass}Backpath.delete&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_backpath');
]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param $backpath BdlNodeBaseAreaBackpath
   * @param $index int
   * @param $pNodeName string
   */
  public function displayUpdate($backpath, $index, $pNodeName)
  {

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');
    $iconAdd    = Wgt::icon('control/add.png', 'xsmall');

    // Sub render function
    $renderSubNode = function
    (
      $pathNode,
      $path,
      $subRednerer
    )
    use
    (
      $pNodeName,
      $iconAdd,
      $iconEdit,
      $iconDelete
    )
    {

      /* @var $pathNode BdlNodeBaseAreaBackpathNode */
      $pathNodes = $pathNode->getReferences();

      if (!$pathNodes)
        return '';

      $code = '<ul id="wgt-list-'.$this->domainKey.'-'.$pNodeName.'-backpath-'.str_replace('.', '-', $path).'" >';

      $idx = 0;

      foreach ($pathNodes as $pathNode) {

        $subNodes = $subRednerer($pathNode, "{$path}.{$idx}", $subRednerer);

        $code .= <<<HTML
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-backpath-{$idx}" >
    <span>{$pathNode->getName(true)}</span>
    <div class="right" style="width:90px;" ><button

        class="wgt-button wgtac_add_backpath_node"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_backpath_node"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_backpath_node"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$pathNode->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$pathNode->getLevel()}</div>
    <div class="wgt-clear tiny" >&nbsp;</div>
    {$subNodes}
  </li>
HTML;

        ++$idx;
      }

      $code .= '</ul>';

      return $code;
    };

    //$subNodes = $renderSubNode($backpath, $index, $renderSubNode);
    $subNodes = '';

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-backpath-{$index}" action="replace" ><![CDATA[
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-backpath-{$index}" >
    <span>{$backpath->getName(true)}</span>
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

    $this->setAreaContent('childCode', <<<XML
<htmlArea selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-backpath" action="function" ><![CDATA[
    self.find(".wgtac_edit_backpath").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Backpath.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_backpath');

    self.find(".wgtac_delete_backpath").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_{$this->domainClass}Backpath.delete'
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
   * @param $pNodeName string
   */
  public function displayDelete($index, $pNodeName)
  {

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-backpath-{$index}" action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */

}//end class DaidalosBdl_Mvcbase_Backpath_Ajax_View

