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
class DaidalosBdlNode_ProfilePermission_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Default Permission
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $permission BdlNodeEntityAttribute
   * @param $index int
   * @param $profileName string
   */
  public function displayInsert($permission, $index, $profileName)
  {

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');
    $iconAdd    = Wgt::icon('control/add.png', 'xsmall');

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-permission" action="append" ><![CDATA[
  <li id="wgt-node-profile-{$profileName}-permission-{$index}" >
    <span>{$permission->getName(true)}</span>
    <div class="right" style="width:90px;" >
      <button
        class="wgt-button wgtac_add_permission_base_ref"
        wgt_key="{$permission->getName()}"
        wgt_path="{$index}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_permission"
        wgt_idx="{$index}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_permission"
        wgt_idx="{$index}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$permission->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$permission->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
  </li>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childCode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-permission" action="function" ><![CDATA[

    self.find(".wgtac_add_permission_base_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfilePermission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
          +'&parent_key='+\$S(this).attr('wgt_key')
      );
    }).removeClass('wgtac_add_permission_base_ref');

    self.find(".wgtac_edit_permission").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfilePermission.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_permission');

    self.find(".wgtac_delete_permission").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfilePermission.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_permission');

]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param $permission BdlNodeEntityAttribute
   * @param $index int
   * @param $profileName string
   */
  public function displayUpdate($permission, $index, $profileName)
  {

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');
    $iconAdd    = Wgt::icon('control/add.png', 'xsmall');

    // Sub render function
    $renderSubNode = function($ref, $path, $subRednerer) use ($profileName, $iconAdd, $iconEdit, $iconDelete) {

      /* @var $ref BdlNodeProfileAreaPermissionRef */
      $references = $ref->getReferences();

      if (!$references)
        return '';

      $code = '<ul id="wgt-list-profile-'.$profileName.'-permission-'.str_replace('.', '-', $path).'" >';

      $idx = 0;

      foreach ($references as $ref) {

        $subNodes = $subRednerer($ref, "{$path}.{$idx}", $subRednerer);

        $code .= <<<HTML
  <li id="wgt-node-profile-{$profileName}-permission-{$idx}" >
    <span>{$ref->getName(true)}</span>
    <div class="right" style="width:90px;" ><button

        class="wgt-button wgtac_add_permission_ref"
        wgt_key="{$ref->getName()}"
        wgt_path="{$path}.{$idx}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_permission_ref"
        wgt_path="{$path}.{$idx}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_permission_ref"
        wgt_path="{$path}.{$idx}" >{$iconDelete}</button>
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

    $subNodes = $renderSubNode($permission, $index, $renderSubNode);

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="li#wgt-node-profile-{$profileName}-permission-{$index}" action="replace" ><![CDATA[
  <li id="wgt-node-profile-{$profileName}-permission-{$index}" >
    <span>{$permission->getName(true)}</span>
    <div class="right" style="width:90px;" >
      <button
        class="wgt-button wgtac_add_permission_base_ref"
        wgt_key="{$permission->getName()}"
        wgt_path="{$index}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_permission"
        wgt_idx="{$index}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_permission"
        wgt_idx="{$index}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$permission->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$permission->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
    {$subNodes}
  </li>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childCode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-permission" action="function" ><![CDATA[

    self.find(".wgtac_add_permission_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfilePermission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
          +'&ref_key='+\$S(this).attr('wgt_key')
      );
    }).removeClass('wgtac_add_permission_ref');

    self.find(".wgtac_add_permission_base_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfilePermission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
          +'&parent_key='+\$S(this).attr('wgt_key')
      );
    }).removeClass('wgtac_add_permission_base_ref');

    self.find(".wgtac_edit_permission").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfilePermission.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_permission');

    self.find(".wgtac_delete_permission").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfilePermission.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_permission');

    self.find(".wgtac_edit_permission_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfilePermission.editRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_edit_permission_ref');

    self.find(".wgtac_delete_permission_ref").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfilePermission.deleteRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_delete_permission_ref');

]]></htmlArea>
XML
    );

  }//end public function displayUpdate */

  /**
   * @param $index int
   * @param $profileName string
   */
  public function displayDelete($index, $profileName)
  {

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="li#wgt-node-profile-{$profileName}-permission-{$index}" action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */

}//end class DaidalosBdlNode_ProfilePermission_Ajax_View

