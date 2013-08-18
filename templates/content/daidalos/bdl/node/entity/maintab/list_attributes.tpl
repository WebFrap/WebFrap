<?php 

$attributes = $entity->getAttributes();

?>

      
<div class="wgt-panel wgt-border-top" >
  <div class="left bw1" ><h3>Attributes</h3></div>
  <div class="inline bw2" >
    <button class="wgt-button wgtac_append_attribute" ><?php echo $iconAdd ?> Add Attribute</button>
  </div>
</div>

<div id="wgt-grid-<?php echo $idPrefix; ?>-attributes" class="wgt-grid" >
  <var></var>
  <table id="wgt-grid-<?php echo $idPrefix; ?>-attributes-table" class="wcm wcm_widget_grid hide-head full" >
    <thead>
      <tr>
        <th class="pos" >Pos:</th>
        <th>Name</th>
        <th>Is A</th>
        <th>Type</th>
        <th>Size</th>
        <th>FK/U/R/IDX</th>
        <th>Description</th>
        <th style="width:55px;" >Nav:</th>
      </tr>
    </thead>
    <tbody>
    <?php $pos = 1; foreach( $attributes as $idx => $attribute ){ 
      
      /*@var $attribute BdlNodeEntityAttribute */
      
      $target = $attribute->getTarget();
      
      $targetVal = '';
      
      if( $target )
        $targetVal = '::'.$target;
      
    ?>

      <tr id="wgt-grid-<?php echo $idPrefix; ?>-attr-<?php echo $idx; ?>" >
        <td class="pos" ><?php echo $pos; ?></td>
        <td><?php echo $attribute->getName().$targetVal; ?></td>
        <td><?php echo $attribute->getIsA(); ?></td>
        <td><?php echo $attribute->getType(); ?></td>
        <td><?php echo $attribute->getSize(); ?></td>
        <td><?php 
        
        if( '' != trim($target)  )
          echo $iconAttrKey;
          
        if( 'true' == $attribute->getUnique() )
          echo $iconAttrUnique;
          
        if( 'true' ==  $attribute->getRequired() )
          echo $iconAttrRequired;
          
        if( '' != trim($attribute->getIndex())  )
          echo $iconAttrIndex;

        ?></td>
        <td><?php echo $attribute->getDescriptionByLang('de'); ?></td>
        <td><button 
            
            class="wgt-button wgtac_edit_attribute"
            wgt_idx="<?php echo $idx; ?>" ><?php echo $iconEdit; ?></button><button 
            
            class="wgt-button wgtac_delete_attribute"
            wgt_idx="<?php echo $idx; ?>" ><?php echo $iconDel; ?></button>
        
        </td>
      </tr>
    <?php ++$pos; } ?>
    </tbody>
  </table>
</div>


