<?php

$thisPath = dirname(__FILE__).'/';

$permission = $VAR->node;

/*@var $permission BdlProfilePermission */
$idPrefix = 'profile-permission-ref-create';
$formId   = 'wgt-form-bdl_'.$idPrefix;


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

<var id="select_src-profile-prem-ref-lang" >
[
<?php echo $langCode; ?>
]
</var>

<var id="select_src-profile-prem-ref-level" >
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
  action="ajax.php?c=Daidalos.BdlNode_ProfilePermission.insertRef&amp;key=<?php
    echo $VAR->key ?>&amp;bdl_file=<?php
    echo $VAR->bdlFile ?>&amp;path=<?php echo $VAR->path ?>"
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
      <legend>Reference Data</legend>

      <div class="left bw6" >
        <?php

        $extUrl = '';
        if( $VAR->params->refKey )
        {
          $extUrl = '&ref_key='.$VAR->params->refKey;
        }
        else
        {
          $extUrl = '&parent_key='.$VAR->params->parentKey;
        }

        echo WgtForm::autocomplete
        (
          'Name',
          $idPrefix.'-name',
          '',
          'ajax.php?c=Bdl.ManagementReference_Service.autocomplete&'.$extUrl.'&amp;key=',
          array
          (
            'name' => 'ref[name]'
          ),
          $formId,
          null,
          'xxlarge'
        );

        echo WgtForm::decorateInput
        (
          'Level',
          'wgt-select-permission-ref-level',
        <<<HTML
<select
      id="wgt-select-permission-level"
      name="ref[level]"
      data_source="select_src-profile-prem-ref-level"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option>Select a level</option>
    </select>
HTML
        );

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
            id="wgt-select-profile-prem-ref-new-lang"
            name="label[lang]"
            data_source="select_src-profile-prem-ref-lang"
            class="wcm wcm_widget_selectbox wgte-lang" >
            <option>Select a language</option>
          </select>

          <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
        </div>
        <div class="wgt-clear xxsmall" ></div>

        <var id="wgt-tab-<?php echo $idPrefix ?>_desc-cfg-i18n-input-tab" >
        {
          "key":"profile-perm-ref-description",
          "inp_prefix":"ref[description]",
          "form_id":"<?php echo $formId; ?>",
          "tab_id":"wgt-tab-<?php echo $idPrefix ?>_desc"
        }
        </var>

      </div>
      <div class="wgt-clear small" ></div>


    </div>

  </div>
</div>
