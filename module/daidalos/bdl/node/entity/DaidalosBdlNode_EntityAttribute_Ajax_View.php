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
class DaidalosBdlNode_EntityAttribute_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Default Permission
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BdlNodeEntityAttribute $attribute
   * @param int $index
   * @param string $entityName
   */
  public function displayInsert($attribute, $index, $entityName)
  {

    $target = $attribute->getTarget();

    $targetVal = '';

    if ($target)
      $targetVal = '::'.$target;

    if ('' !=  trim($target))
      $iconAttrKey = Wgt::icon('daidalos/table/key.png', 'xsmall', 'Key');
    else
      $iconAttrKey = '';

    if ('' != $attribute->getIndex())
      $iconAttrIndex = Wgt::icon('daidalos/table/index.png', 'xsmall', 'Index');
    else
      $iconAttrIndex = '';

    if ('true' == $attribute->getRequired())
      $iconAttrRequired = Wgt::icon('daidalos/table/required.png', 'xsmall', 'Required');
    else
      $iconAttrRequired = '';

    if ('true' == $attribute->getUnique())
      $iconAttrUnique = Wgt::icon('daidalos/table/unique.png', 'xsmall', 'Unique');
    else
      $iconAttrUnique = '';

    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');

    $pos = $index +1;

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="table#wgt-grid-entity-{$entityName}-attributes-table>tbody" action="append" ><![CDATA[
      <tr id="wgt-grid-entity-{$entityName}-attr-{$index}" >
        <td class="pos" >{$pos}</td>
        <td>{$attribute->getName()}{$targetVal}</td>
        <td>{$attribute->getIsA()}</td>
        <td>{$attribute->getType()}</td>
        <td>{$attribute->getSize()}</td>
        <td>{$iconAttrKey}{$iconAttrUnique}{$iconAttrRequired}{$iconAttrIndex}</td>
        <td>{$attribute->getDescriptionByLang('de')}</td>
        <td><button

            class="wgt-button wgtac_edit_attribute"
            wgt_idx="{$index}" >{$iconEdit}</button><button

            class="wgt-button wgtac_delete_attribute"
            wgt_idx="{$index}" >{$iconDelete}</button>

        </td>
      </tr>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childCode', <<<XML
<htmlArea selector="tr#wgt-grid-entity-{$entityName}-attr-{$index}" action="function" ><![CDATA[

    self.find(".wgtac_edit_attribute").click(function() {
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_EntityAttribute.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_attribute');

    self.find(".wgtac_delete_attribute").click(function() {
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_EntityAttribute.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_attribute');

]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param BdlNodeEntityAttribute $attribute
   * @param int $index
   * @param string $entityName
   */
  public function displayUpdate($attribute, $index, $entityName)
  {

    $target = $attribute->getTarget();

    $targetVal = '';

    if ($target)
      $targetVal = '::'.$target;

    if ('' !=  trim($target))
      $iconAttrKey = Wgt::icon('daidalos/table/key.png', 'xsmall', 'Key');
    else
      $iconAttrKey = '';

    if ('' != $attribute->getIndex())
      $iconAttrIndex = Wgt::icon('daidalos/table/index.png', 'xsmall', 'Index');
    else
      $iconAttrIndex = '';

    if ('true' == $attribute->getRequired())
      $iconAttrRequired = Wgt::icon('daidalos/table/required.png', 'xsmall', 'Required');
    else
      $iconAttrRequired = '';

    if ('true' == $attribute->getUnique())
      $iconAttrUnique = Wgt::icon('daidalos/table/unique.png', 'xsmall', 'Unique');
    else
      $iconAttrUnique = '';


    $iconEdit   = Wgt::icon('control/edit.png', 'xsmall');
    $iconDelete = Wgt::icon('control/delete.png', 'xsmall');

    $pos = $index +1;

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="tr#wgt-grid-entity-{$entityName}-attr-{$index}" action="replace" ><![CDATA[
      <tr id="wgt-grid-entity-{$entityName}-attr-{$index}" >
        <td class="pos" >{$pos}</td>
        <td>{$attribute->getName()}{$targetVal}</td>
        <td>{$attribute->getIsA()}</td>
        <td>{$attribute->getType()}</td>
        <td>{$attribute->getSize()}</td>
        <td>{$iconAttrKey}{$iconAttrUnique}{$iconAttrRequired}{$iconAttrIndex}</td>
        <td>{$attribute->getDescriptionByLang('de')}</td>
        <td><button

            class="wgt-button wgtac_edit_attribute"
            wgt_idx="{$index}" >{$iconEdit}</button><button

            class="wgt-button wgtac_delete_attribute"
            wgt_idx="{$index}" >{$iconDelete}</button>

        </td>
      </tr>
]]></htmlArea>
XML
    );

    $this->setAreaContent('childCode', <<<XML
<htmlArea selector="tr#wgt-grid-entity-{$entityName}-attr-{$index}" action="function" ><![CDATA[

    self.find(".wgtac_edit_attribute").click(function() {
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_EntityAttribute.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_attribute');

    self.find(".wgtac_delete_attribute").click(function() {
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_EntityAttribute.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_attribute');

]]></htmlArea>
XML
    );

  }//end public function displayUpdate */

  /**
   * @param $index int
   * @param $entityName string
   */
  public function displayDelete($index, $entityName)
  {

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="tr#wgt-grid-entity-{$entityName}-attr-{$index}" action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */

}//end class DaidalosBdlNode_EntityAttribute_Ajax_View

