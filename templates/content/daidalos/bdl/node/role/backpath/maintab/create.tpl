<?php

$thisPath = dirname(__FILE__).'/';

$domainKey   = $VAR->domainKey;
$domainClass = $VAR->domainClass;
$parentNode  = $VAR->parentNode;

$backpath = $VAR->node;

/*@var $backpath BdlNodeBaseBackpath */
$idPrefix = $domainKey.'-backpath-create';
$formId = 'wgt-form-bdl_'.$idPrefix;


$iconAdd  = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );

$langs = $this->model->getLanguages();

$langCode = array( '{"i":"0","v":"Select a language"}' );

if( $langs )
{
  foreach( $langs as $lang )
  {
    $langCode[] = '{"i":"'.$lang['id'].'","v":'.json_encode($lang['value']).'}';
  }
}

$langCode = implode( ','.NL, $langCode  );

?>

<var id="select_src-<?php echo $idPrefix ?>-lang" >
[
<?php echo $langCode; ?>
]
</var>

<var id="select_src-<?php echo $idPrefix ?>-level" >
[
{"i":"denied","v":"Denied"},
{"i":"listing","v":"Listing"},
{"i":"assign","v":"Assign"},
{"i":"access","v":"Access"},
{"i":"insert","v":"Insert"},
{"i":"update","v":"Update"},
{"i":"delete","v":"Delete"},
{"i":"publish","v":"Publish"},
{"i":"maintenance","v":"Maintenance"},
{"i":"admin","v":"Admin"}
]
</var>


<form
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_<?php echo $domainClass ?>Backpath.insert&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
  method="post"
></form>


<div id="<?php echo $this->tabId ?>" class="wcm wcm_ui_tab" >
  <div class="wgt_tab_body" >
    <!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->


  <!-- tab name:default -->
  <div
    class="wgt_tab <?php echo $this->tabId ?>"
    id="<?php echo $this->tabId ?>-tab-base_data"
    title="Base Data"

     >

    <fieldset class="wgt-space bw61" >
      <legend>Backpath Data</legend>

      <div class="left bw3" >
        <?php
        echo WgtForm::input
        (
          'Name',
          'backpath-name',
          '',
          array
          (
            'name'=>'backpath[name]'
          ),
          $formId
        );

        echo WgtForm::decorateInput
        (
          'Level',
          'wgt-select-backpath-level',
        <<<HTML
<select
      id="wgt-select-backpath-level"
      name="backpath[level]"
      data_source="select_src-{$idPrefix}-level"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option>Select a level</option>
    </select>
HTML
        );


        ?>
      </div>

      <div class="right bw3" >
        <?php


        ?>
      </div>

    </fieldset>




      <div class="wgt-clear small" ></div>

      <div
        id="wgt-tab-<?php echo $idPrefix ?>_desc"
        class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border ui-corner-top bw62"  >
        <div
          id="wgt-tab-<?php echo $idPrefix ?>_desc-head"
          class="wgt_tab_head ui-corner-top" >

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

        </div>

        <div class="wgt-panel" >
          <select
            id="wgt-select-<?php echo $idPrefix ?>-description-new-lang"
            name="label[lang]"
            data_source="select_src-<?php echo $idPrefix ?>-lang"
            class="wcm wcm_widget_selectbox wgte-lang" >
            <option>Select a language</option>
          </select>

          <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
        </div>
        <div class="wgt-clear xxsmall" ></div>

        <var id="wgt-tab-<?php echo $idPrefix ?>_desc-cfg-i18n-input-tab" >
        {
          "key":"<?php echo $idPrefix ?>-description",
          "inp_prefix":"backpath[description]",
          "form_id":"<?php echo $formId; ?>",
          "tab_id":"wgt-tab-<?php echo $idPrefix ?>_desc"
        }
        </var>

      </div>
      <div class="wgt-clear small" ></div>


    </div>

  </div>
</div>
