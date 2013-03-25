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
class DaidalosBdl_Mvcbase_PermissionRef_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der domainkey
   * eg: profile
   * @var string
   */
  public $domainKey = null;

  /**
   * Domain Class Part
   * eg: Profile
   * @var string
   */
  public $domainClass = null;

/*//////////////////////////////////////////////////////////////////////////////
// Permission Reference
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $permission BdlNodeBasePermission
   * @param $path string
   * @param $index int Der neue Index
   * @param $pNodeName string
   */
  public function displayInsert($permission, $path, $idx, $pNodeName)
  {

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');
    $iconAdd    = Wgt::icon('control/add.png', 'xsmall');

    $pathId = str_replace('.', '-', $path);

    // nur anhängen wenn es nicht schon existiert
    $this->setAreaContent('treeNode', <<<XML
<htmlArea
  selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$pathId}"
  action="append"
  check="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission-{$pathId}"
  not="true" ><![CDATA[
  <ul id="wgt-list-{$this->domainKey}-{$pNodeName}-permission-{$pathId}" ></ul>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childNode', <<<XML
<htmlArea
  selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission-{$pathId}"
  action="append" ><![CDATA[
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$pathId}-{$idx}" >
    <span>{$permission->getName(true)}</span>
    <div class="right" style="width:90px;" >
      <button
        class="wgt-button wgtac_add_permission_ref"
        wgt_path="{$path}.{$idx}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_permission"
        wgt_path="{$path}.{$idx}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_permission"
        wgt_path="{$path}.{$idx}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$permission->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$permission->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
  </li>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childCode', <<<XML
<htmlArea
  selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission"
  action="function" ><![CDATA[

    self.find(".wgtac_add_permission_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_permission_ref');

    self.find(".wgtac_edit_permission").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.editRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_edit_permission');

    self.find(".wgtac_delete_permission").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.deleteRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_delete_permission');

]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param BdlNodeBaseAreaPermissionRef $ref
   * @param int $index
   * @param string $pNodeName
   */
  public function displayUpdate($ref, $path, $pNodeName)
  {

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');
    $iconAdd    = Wgt::icon('control/add.png', 'xsmall');

    // Sub render function
    $renderSubNode = function
    (
      $ref,
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

      $pathId = str_replace('.', '-', $path);

      /* @var $ref BdlBaseAreaPermissionRef */
      $references = $ref->getReferences();

      if (!$references)
        return '';

      $code = '<ul id="wgt-list-'.$this->domainKey.'-'.$pNodeName.'-permission-'.$pathId.'" >';

      $idx = 0;

      foreach ($references as $ref) {

        $subNodes = $subRednerer($ref, "{$path}.{$idx}", $subRednerer);

        $code .= <<<HTML
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$pathId}" >
    <span>{$ref->getName(true)}</span>
    <div class="right" style="width:90px;" ><button

        class="wgt-button wgtac_add_permission_ref"
        wgt_path="{$path}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_permission_ref"
        wgt_path="{$path}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_permission_ref"
        wgt_path="{$path}" >{$iconDelete}</button>
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

    $pathId = str_replace('.', '-', $path);

    $subNodes = $renderSubNode($ref, $path, $renderSubNode);

    $this->setAreaContent('childNode', <<<XML
<htmlArea
  selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$pathId}"
  action="replace" ><![CDATA[
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$pathId}" >
    <span>{$ref->getName(true)}</span>
    <div class="right" style="width:90px;" >
      <button
        class="wgt-button wgtac_add_permission_ref"
        wgt_path="{$path}" >{$iconAdd}</button><button

        class="wgt-button wgtac_edit_permission"
        wgt_path="{$path}" >{$iconEdit}</button><button

        class="wgt-button wgtac_delete_permission"
        wgt_path="{$path}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$ref->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$ref->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
    {$subNodes}
  </li>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childCode', <<<XML
<htmlArea
  selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission"
  action="function" ><![CDATA[

    self.find(".wgtac_add_permission_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_permission_ref');

    self.find(".wgtac_edit_permission").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.editRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_edit_permission');

    self.find(".wgtac_delete_permission").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.deleteRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_delete_permission');

]]></htmlArea>
XML
    );

  }//end public function displayUpdate */

  /**
   * @param $path string
   * @param $pNodeName string
   */
  public function displayDelete($path,  $pNodeName)
  {

    $pathId = str_replace('.', '-', $path);

    $this->setAreaContent('childNode', <<<XML
<htmlArea
  selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$pathId}"
  action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */

}//end class DaidalosBdl_Mvcbase_PermissionRef_Ajax_View

