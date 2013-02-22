<!-- block name:short_desc -->
<div
  id="wgt-tab-<?php echo $idPrefix ?>_short_desc"
  class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border ui-corner-top bw62"  >
  <div id="wgt-tab-<?php echo $idPrefix ?>_short_desc-head" class="wgt_tab_head ui-corner-top" >

    <div class="wgt-container-controls">
      <div class="wgt-container-buttons" >
        <h2 style="width:120px;float:left;text-align:left;" >Short Description</h2>
      </div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container"></div>
        </div>
     </div>
    </div>
  </div>

  <div id="wgt-tab-<?php echo $idPrefix ?>_short_desc-body" class="wgt_tab_body" >

    <?php foreach( $shortDescs as $lang => $short_desc ){ ?>
    <div id="wgt-tab-<?php echo $idPrefix ?>-short_desc-<?php echo $lang ?>"  title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_short_desc">
      <fieldset id="wgt-fieldset-<?php echo $idPrefix ?>-short_desc-<?php echo $lang ?>"  class="wgt-space bw6 lang-<?php echo $lang ?>"  >
        <legend>Lang <?php echo $lang ?></legend>

        <?php echo WgtForm::wysiwyg
        (
          'Docu',
          $idPrefix.'-'.$nodeKey.'-'.$lang,
          $short_desc,
          array
          (
            'name' => $nodeKey.'[short_desc]['.$lang.']'
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

  <var id="wgt-tab-<?php echo $idPrefix ?>_short_desc-cfg-i18n-input-tab" >
  {
    "key":"<?php echo $idPrefix ?>-short_desc",
    "inp_prefix":"<?php echo $nodeKey ?>[short_desc]",
    "form_id":"<?php echo $formId; ?>",
    "tab_id":"wgt-tab-<?php echo $idPrefix ?>_short_desc"
  }
  </var>

</div>
<div class="wgt-clear small" ></div>
