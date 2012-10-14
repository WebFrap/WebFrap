<!-- tab name:content -->
<div 
  id="wgt-tab-<?php echo $idPrefix ?>_content" 
  class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
  <div id="wgt-tab-<?php echo $idPrefix ?>_content-head" class="wgt_tab_head wgt-corner-top" >

    <div class="wgt-container-controls">
      <div class="wgt-container-buttons" >
        <h2 style="width:120px;float:left;text-align:left;" >Content</h2>
      </div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container"></div>
        </div>
     </div>
    </div>
  </div>
  
  <div id="wgt-tab-<?php echo $idPrefix ?>_content-body" class="wgt_tab_body" >
    
    <?php foreach( $contents as $lang => $content ){ ?>
    <div id="wgt-tab-<?php echo $idPrefix ?>-content-<?php echo $lang ?>"  title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_content">
      <fieldset id="wgt-fieldset-<?php echo $idPrefix ?>-content-<?php echo $lang ?>"  class="wgt-space bw6 lang-<?php echo $lang ?>"  >
        <legend>Lang <?php echo $lang ?></legend>
        
        <?php echo WgtForm::wysiwyg
        ( 
          'Docu', 
          $idPrefix.'-'.$nodeKey.'-'.$lang, 
          $content, 
          array
          ( 
            'name' => $nodeKey.'[content]['.$lang.']',
            'wgt_mode' => 'cms'
          ), 
          $formId,
          null,
          true
        ); 
        ?>
      </fieldset>
    </div>
    <?php } ?>

  </div>
  
  <div class="wgt-panel" >
    <select 
      id="wgt-select-<?php echo $idPrefix ?>-new-lang" 
      name="label[lang]" 
      data_source="select_src-<?php echo $idPrefix ?>-lang"
      class="wcm wcm_widget_selectbox wgte-lang" >
      <option>Select a language</option>
    </select>
    
    <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
  </div>
  
  <div class="wgt-clear xxsmall" ></div>
  
  <var id="wgt-tab-<?php echo $idPrefix ?>_content-cfg-i18n-input-tab" >
  {
    "key":"<?php echo $idPrefix ?>-content",
    "inp_prefix":"<?php echo $nodeKey ?>[content]",
    "form_id":"<?php echo $formId; ?>",
    "tab_id":"wgt-tab-<?php echo $idPrefix ?>_content"
  }
  </var>
  
</div>
<div class="wgt-clear small" ></div>
