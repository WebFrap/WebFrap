<?php 


// Sub render function
$renderSubNode = function( $ref, $path, $subRednerer ) use ( $idPrefix, $iconAdd, $iconEdit, $iconDel )
{
  
  /* @var $ref BdlNodeProfileAreaPermissionRef */
  $references = $ref->getReferences();
  
  if( !$references )
    return '';
  
  $code = '<ul id="wgt-list-'.$idPrefix.'-permission-'.str_replace('.', '-', $path).'" >';
  
  $idx = 0;
  
  $idPath = str_replace('.', '-', $path);
  
  foreach( $references as $ref )
  {

    $subNodes = $subRednerer( $ref, "{$path}.{$idx}", $subRednerer );

    $code .= <<<HTML
  <li id="wgt-node-{$idPrefix}-permission-{$idPath}-{$idx}" >
    <span>{$ref->getName()}</span>
    <div class="right" style="width:90px;" ><button
     
        class="wgt-button wgtac_add_permission_ref"
        wgt_path="{$path}.{$idx}" >{$iconAdd}</button><button
         
        class="wgt-button wgtac_edit_permission_ref"
        wgt_idx="{$idx}" wgt_path="{$path}.{$idx}" >{$iconEdit}</button><button
         
        class="wgt-button wgtac_delete_permission_ref"
        wgt_idx="{$idx}" wgt_path="{$path}.{$idx}" >{$iconDel}</button>
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


$areas = $role->getAreaPermissions();

?>

<!-- tab name:permission -->
<div
  class="wgt_tab <?php echo $this->tabId ?>"
  id="<?php echo $this->tabId ?>-tab-permission"
  title="Permission"
  
   >
   
  <div class="wgt-panel title" >
    <div class="left bw2" ><h2>Permission</h2></div>
    <div class="inline bw3" ><button class="wgtac_create_permission wgt-button" ><?php echo $iconAdd; ?></button></div>
  </div>
  
  <div class="wgt-clear small" >&nbsp;</div>
  
  <div class="wgt-space" >
    <div class="wgt-head bw62" >
      <span>Area</span>
      <div class="right" style="width:90px;" >Nav</div>
      <div class="right bw3" >Description</div>
      <div class="right bw1" >Level</div>
      <div class="wgt-clear small" >&nbsp;</div>
    </div>
    
    <ul id="wgt-list-<?php echo $idPrefix ?>-permission" class="wcm wcm_ui_tree bw62" >
    <?php $idx = 0; foreach( $areas as $area ){ ?>
      <li id="wgt-node-<?php echo $idPrefix ?>-permission-<?php echo $idx; ?>" >
        <span><?php echo $area->getName(); ?></span>
        <div class="right" style="width:90px;" >
          <button 
            class="wgt-button wgtac_add_permission_ref"
            wgt_idx="<?php echo $idx; ?>" wgt_path="<?php echo $idx; ?>" ><?php echo $iconAdd; ?></button><button 
            
            class="wgt-button wgtac_edit_permission"
            wgt_idx="<?php echo $idx; ?>" ><?php echo $iconEdit; ?></button><button 
            
            class="wgt-button wgtac_delete_permission"
            wgt_idx="<?php echo $idx; ?>" ><?php echo $iconDel; ?></button>
        </div>
        <div class="right bw3" ><?php echo $area->getDescriptionByLang('de'); ?>&nbsp;</div>
        <div class="right bw1" ><?php echo $area->getLevel(); ?></div>
        <div class="wgt-clear tiny" >&nbsp;</div>
        <?php echo $renderSubNode( $area, "$idx", $renderSubNode ); ?>
      </li>
    <?php ++$idx; } ?>
    </ul>
  </div>


  <div class="wgt-clear small" ></div>

</div><!-- END tab name:permission -->