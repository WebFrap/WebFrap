    <!-- tab name:description-->
    <div
      class="wgt_tab <?php echo $this->tabId ?>"
      id="<?php echo $this->tabId ?>-tab-description"
      title="Description"
      
       >
    
<div id="wgt-tab-<?php echo $idPrefix ?>_desc" class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
  <div id="wgt-tab-<?php echo $idPrefix ?>_desc-head" class="wgt_tab_head wgt-corner-top" >

    <div class="wgt-container-controls">
      <div class="wgt-container-buttons" >
        <h2 style="width:120px;float:left;text-align:left;" >Description</h2>
      </div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container"></div>
        </div>
     </div>
    </div>
  </div>
  <div id="wgt-tab-<?php echo $idPrefix ?>_desc-body" class="wgt_tab_body" >
    
    <?php foreach( $descriptions as $lang => $description ){ ?>
    <div id="wgt-tab-<?php echo $idPrefix ?>-desc-<?php echo $lang ?>"  title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_desc">
      <fieldset id="wgt-fieldset-<?php echo $idPrefix ?>-desc-<?php echo $lang ?>"  class="wgt-space bw6 lang-<?php echo $lang ?>"  >
        <legend>Description <?php echo $lang ?></legend>
        
        <?php echo WgtForm::wysiwyg
        ( 
          'Description', 
          'entity-description-'.$lang, 
          $description, 
          array
          ( 
            'name' => 'entity[description]['.$lang.']',
            'style' => 'width:740px;'
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
      id="wgt-select-entity-description-new-lang" 
      name="label[lang]" 
      data_source="select_src-entity-lang"
      class="wcm wcm_widget_selectbox wgte-lang" >
      <option>Select a language</option>
    </select>
    
    <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
  </div>
  <div class="wgt-clear xxsmall" ></div>
  
  <var id="wgt-tab-<?php echo $idPrefix ?>_desc-cfg-i18n-input-tab" >
  {
    "key":"entity-description",
    "inp_prefix":"entity[description]",
    "form_id":"<?php echo $formId; ?>",
    "tab_id":"wgt-tab-<?php echo $idPrefix ?>_desc"
  }
  </var>
  
</div>
    
        <div id="wgt-tab-<?php echo $idPrefix ?>_docu" class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
          <div id="wgt-tab-<?php echo $idPrefix ?>_docu-head" class="wgt_tab_head wgt-corner-top" >
        
            <div class="wgt-container-controls">
              <div class="wgt-container-buttons" >
                <h2 style="width:120px;float:left;text-align:left;" >Docu</h2>
              </div>
              <div class="tab_outer_container">
                <div class="tab_scroll" >
                  <div class="tab_container"></div>
                </div>
             </div>
            </div>
          </div>
          
          <div id="wgt-tab-<?php echo $idPrefix ?>_docu-body" class="wgt_tab_body" >
            
            <?php foreach( $docus as $lang => $docu ){ ?>
            <div id="wgt-tab-<?php echo $idPrefix ?>-docu-<?php echo $lang ?>"  title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_docu">
              <fieldset id="wgt-fieldset-<?php echo $idPrefix ?>-docu-<?php echo $lang ?>"  class="wgt-space bw6 lang-<?php echo $lang ?>"  >
                <legend>Docu <?php echo $lang ?></legend>
                
                <?php echo WgtForm::wysiwyg
                ( 
                  'Docu', 
                  'entity-docu-'.$lang, 
                  $docu, 
                  array
                  ( 
                    'name' => 'entity[docu]['.$lang.']'
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
              id="wgt-select-entity-docu-new-lang" 
              name="label[lang]" 
              data_source="select_src-entity-lang"
              class="wcm wcm_widget_selectbox wgte-lang" >
              <option>Select a language</option>
            </select>
            
            <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
          </div>
          
          <div class="wgt-clear xxsmall" ></div>
          
          <var id="wgt-tab-<?php echo $idPrefix ?>_docu-cfg-i18n-input-tab" >
          {
            "key":"entity-docu",
            "inp_prefix":"entity[docu]",
            "form_id":"<?php echo $formId; ?>",
            "tab_id":"wgt-tab-<?php echo $idPrefix ?>_docu"
          }
          </var>
          
        </div>
        <div class="wgt-clear small" ></div>
    
    </div><!-- END tab name:description -->