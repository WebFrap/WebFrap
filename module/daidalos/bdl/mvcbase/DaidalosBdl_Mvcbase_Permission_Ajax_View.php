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
class DaidalosBdl_Mvcbase_Permission_Ajax_View
  extends LibTemplateAjaxView
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

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
  
////////////////////////////////////////////////////////////////////////////////
// Default Permission
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param $permission BdlNodeBasePermission
   * @param $index int
   * @param $pNodeName string
   */
  public function displayInsert( $permission, $index, $pNodeName )
  {
    
    $iconEdit   = Wgt::icon( 'control/edit.png', 'xsmall' );
    $iconDelete = Wgt::icon( 'control/delete.png', 'xsmall' );
    $iconAdd    = Wgt::icon( 'control/add.png', 'xsmall' );

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission" action="append" ><![CDATA[
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$index}" >
    <span>{$permission->getName( true )}</span>
    <div class="right" style="width:90px;" >
      <button 
        class="wgt-button wgtac_add_permission_ref"
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
    
    $this->setAreaContent( 'childCode', <<<XML
<htmlArea selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission" action="function" ><![CDATA[

    self.find(".wgtac_add_permission_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_permission_ref');

    self.find(".wgtac_edit_permission").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_permission');
    
    self.find(".wgtac_delete_permission").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_permission');
    
]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param $permission BdlNodeBasePermission
   * @param $index int
   * @param $pNodeName string
   */
  public function displayUpdate( $permission, $index, $pNodeName )
  {
    
    $iconEdit   = Wgt::icon( 'control/edit.png', 'xsmall' );
    $iconDelete = Wgt::icon( 'control/delete.png', 'xsmall' );
    $iconAdd    = Wgt::icon( 'control/add.png', 'xsmall' );
    
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
      
      /* @var $ref BdlNodeBaseAreaPermissionRef */
      $references = $ref->getReferences();
      
      if( !$references )
        return '';
      
      $code = '<ul id="wgt-list-'.$this->domainKey.'-'.$pNodeName.'-permission-'.str_replace('.', '-', $path).'" >';
      
      $idx = 0;
      
      foreach( $references as $ref )
      {
      
        $subNodes = $subRednerer( $ref, "{$path}.{$idx}", $subRednerer );
        
        $code .= <<<HTML
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$idx}" >
    <span>{$ref->getName( true )}</span>
    <div class="right" style="width:90px;" ><button
     
        class="wgt-button wgtac_add_permission_ref"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconAdd}</button><button
         
        class="wgt-button wgtac_edit_permission_ref"
        wgt_idx="{$idx}" wgt_path="{$path}" >{$iconEdit}</button><button
         
        class="wgt-button wgtac_delete_permission_ref"
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
    
    $subNodes = $renderSubNode( $permission, $index, $renderSubNode );

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$index}" action="replace" ><![CDATA[
  <li id="wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$index}" >
    <span>{$permission->getName( true )}</span>
    <div class="right" style="width:90px;" >
      <button 
        class="wgt-button wgtac_add_permission_ref"
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
    
    $this->setAreaContent( 'childCode', <<<XML
<htmlArea selector="ul#wgt-list-{$this->domainKey}-{$pNodeName}-permission" action="function" ><![CDATA[

    self.find(".wgtac_add_permission_ref").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.createRef'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_permission_ref');

    self.find(".wgtac_edit_permission").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.edit'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_edit_permission');
    
    self.find(".wgtac_delete_permission").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_{$this->domainClass}Permission.delete'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;idx='+\$S(this).attr('wgt_idx')
      );
    }).removeClass('wgtac_delete_permission');
    
]]></htmlArea>
XML
    );

  }//end public function displayUpdate */
  
  /**
   * @param $index int
   * @param $pNodeName string
   */
  public function displayDelete( $index, $pNodeName )
  {
    
    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="li#wgt-node-{$this->domainKey}-{$pNodeName}-permission-{$index}" action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */
  

}//end class DaidalosBdlNode_MvcbasePermission_Ajax_View

