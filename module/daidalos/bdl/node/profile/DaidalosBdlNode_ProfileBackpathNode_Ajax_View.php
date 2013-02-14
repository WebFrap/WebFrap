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
class DaidalosBdlNode_ProfileBackpathNode_Ajax_View extends LibTemplateAjaxView
{  
/*//////////////////////////////////////////////////////////////////////////////
// Permission Reference
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $backpath BdlNodeEntityAttribute
   * @param $path string
   * @param $index int Der neue Index
   * @param $profileName string
   */
  public function displayInsert($backpath, $path, $idx, $profileName )
  {
    
    $iconEdit   = Wgt::icon( 'control/edit.png', 'xsmall' );
    $iconDelete = Wgt::icon( 'control/delete.png', 'xsmall' );
    $iconAdd    = Wgt::icon( 'control/add.png', 'xsmall' );
    
    $pathId = str_replace('.', '-', $path);
    
    // nur anhängen wenn es nicht schon existiert
    $this->setAreaContent( 'treeNode', <<<XML
<htmlArea 
  selector="li#wgt-node-profile-{$profileName}-backpath-{$pathId}" 
  action="append"
  check="ul#wgt-list-profile-{$profileName}-backpath-{$pathId}"
  not="true" ><![CDATA[
  <ul id="wgt-list-profile-{$profileName}-backpath-{$pathId}" ></ul>
]]></htmlArea>
XML
    );

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-backpath-{$pathId}" action="append" ><![CDATA[
  <li id="wgt-node-profile-{$profileName}-backpath-{$pathId}-{$idx}" >
    <span>{$backpath->getName( true )}</span>
    <div class="right" style="width:90px;" >
      <button 
        class="wgt-button wgtac_add_backpath_node"
        wgt_path="{$path}.{$idx}" >{$iconAdd}</button><button 
        
        class="wgt-button wgtac_edit_backpath"
        wgt_path="{$path}.{$idx}" >{$iconEdit}</button><button 
        
        class="wgt-button wgtac_delete_backpath"
        wgt_path="{$path}.{$idx}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$backpath->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$backpath->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
  </li>
]]></htmlArea>
XML
    );
    
    $this->setAreaContent( 'childCode', <<<XML
<htmlArea selector="ul#wgt-list-profile-{$profileName}-backpath-{$pathId}" action="function" ><![CDATA[

    self.find(".wgtac_add_backpath_node").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfileBackpath.createNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_add_backpath_node');

    self.find(".wgtac_edit_backpath").click(function(){
      \$R.get(
        'maintab.php?c=Daidalos.BdlNode_ProfileBackpath.editNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_edit_backpath');
    
    self.find(".wgtac_delete_backpath").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfileBackpath.deleteNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_delete_backpath');
    
]]></htmlArea>
XML
    );

  }//end public function displayInsert */

  /**
   * @param BdlNodeEntityAttribute $pathNode 
   * @param int $index 
   * @param string $profileName 
   */
  public function displayUpdate($pathNode, $path, $profileName )
  {
    
    $iconEdit   = Wgt::icon( 'control/edit.png', 'xsmall' );
    $iconDelete = Wgt::icon( 'control/delete.png', 'xsmall' );
    $iconAdd    = Wgt::icon( 'control/add.png', 'xsmall' );
    
    // Sub render function
    $renderSubNode = function($pathNode, $path, $subRednerer ) use ($profileName, $iconAdd, $iconEdit, $iconDelete )
    {
      
      $pathId = str_replace('.', '-', $path);
      
      /* @var $pathNode BdlNodeProfileAreaBackpathNode */
      $pathNodes = $pathNode->getPathNodes();
      
      if (!$pathNodes )
        return '';
      
      $code = '<ul id="wgt-list-profile-'.$profileName.'-backpath-'.$pathId.'" >';
      
      $idx = 0;
      
      foreach($pathNodes as $pathNode )
      {
      
        $subNodes = $subRednerer($pathNode, "{$path}.{$idx}", $subRednerer );
        
        $code .= <<<HTML
  <li id="wgt-node-profile-{$profileName}-backpath-{$pathId}" >
    <span>{$pathNode->getName( true )}</span>
    <div class="right" style="width:90px;" ><button
     
        class="wgt-button wgtac_add_backpath_node"
        wgt_path="{$path}" >{$iconAdd}</button><button
         
        class="wgt-button wgtac_edit_backpath_node"
        wgt_path="{$path}" >{$iconEdit}</button><button
         
        class="wgt-button wgtac_delete_backpath_node"
        wgt_path="{$path}" >{$iconDelete}</button>
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
    
    $pathId = str_replace('.', '-', $path);
    
    $subNodes = $renderSubNode($pathNode, $path, $renderSubNode );

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="li#wgt-node-profile-{$profileName}-backpath-{$pathId}" action="replace" ><![CDATA[
  <li id="wgt-node-profile-{$profileName}-backpath-{$pathId}" >
    <span>{$pathNode->getName( true )}</span>
    <div class="right" style="width:90px;" >
      <button 
        class="wgt-button wgtac_add_backpath_node"
        wgt_path="{$path}" >{$iconAdd}</button><button 
        
        class="wgt-button wgtac_edit_backpath"
        wgt_path="{$path}" >{$iconEdit}</button><button 
        
        class="wgt-button wgtac_delete_backpath"
        wgt_path="{$path}" >{$iconDelete}</button>
    </div>
    <div class="right bw3" >{$pathNode->getDescriptionByLang('de')}&nbsp;</div>
    <div class="right bw1" >{$pathNode->getlevel()}</div>
    <div class="wgt-clear" >&nbsp;</div>
    {$subNodes}
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
        'maintab.php?c=Daidalos.BdlNode_ProfileBackpath.editNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_edit_backpath');
    
    self.find(".wgtac_delete_backpath").click(function(){
      \$R.del(
        'ajax.php?c=Daidalos.BdlNode_ProfileBackpath.deleteNode'
          +'&amp;key={$this->model->modeller->key}&amp;bdl_file={$this->model->modeller->bdlFileName}'
          +'&amp;path='+\$S(this).attr('wgt_path')
      );
    }).removeClass('wgtac_delete_backpath');
    
]]></htmlArea>
XML
    );

  }//end public function displayUpdate */
  
  /**
   * @param $path string
   * @param $profileName string
   */
  public function displayDelete($path,  $profileName )
  {
    
    $pathId = str_replace('.', '-', $path);
    
    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="li#wgt-node-profile-{$profileName}-backpath-{$pathId}" action="remove" ></htmlArea>
XML
    );

  }//end public function displayDelete */
  
}//end class DaidalosBdlNode_ProfileBackpathNode_Ajax_View

