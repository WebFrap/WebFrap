<?php

$thisPath = dirname(__FILE__).'/';

$permission = $VAR->node;
/*@var $permission BdlNodeBasePermission */
$parentNode = $VAR->parentNode;
/*@var $parentNode BdlBaseNode */

$domainKey = $VAR->domainKey;
$domainClass = $VAR->domainClass;

$idPrefix = $domainKey.'-'.$parentNode->getName().'-permission-edit-'.$VAR->idx;
$formId = 'wgt-form-bdl_'.$idPrefix;


// icons
$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );


// data
$descriptions = $permission->getDescriptions();


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
  action="ajax.php?c=Daidalos.BdlNode_<?php echo $domainClass ?>Permission.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>&amp;idx=<?php echo $VAR->idx ?>"
  method="put"
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
      <legend>Permission Data</legend>

      <div class="left bw3" >
        <?php
        echo WgtForm::input
        (
          'Name',
          $idPrefix.'-name',
          $permission->getName(),
          array
          (
            'name'=>'permission[name]'
          ),
          $formId
        );

        ?>
      </div>

      <div class="right bw3" >
        <?php

        echo WgtForm::decorateInput
        (
          'Level',
          'wgt-select-'.$idPrefix.'-level',
        <<<HTML
<select
      id="wgt-select-{$idPrefix}-level"
      name="permission[level]"
      data_source="select_src-{$idPrefix}-level"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option value="{$permission->getLevel()}" >{$permission->getLevel()}</option>
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

          <?php foreach( $descriptions as $lang => $description ){ ?>
          <div
            id="wgt-tab-<?php echo $idPrefix ?>-desc-<?php echo $lang ?>"
            title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"
            class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_desc">
            <fieldset
              id="wgt-fieldset-<?php echo $idPrefix ?>-desc-<?php echo $lang ?>"
              class="wgt-space bw6 lang-<?php echo $lang ?>"  >
              <legend>Description <?php echo $lang ?></legend>

              <?php echo WgtForm::wysiwyg
              (
                'Description',
                $idPrefix.'-description-'.$lang,
                $description,
                array
                (
                  'name' => 'permission[description]['.$lang.']',
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
            id="wgt-select-<?php echo $idPrefix; ?>-lang"
            name="label[lang]"
            data_source="select_src-<?php echo $idPrefix; ?>-lang"
            class="wcm wcm_widget_selectbox wgte-lang" >
            <option>Select a language</option>
          </select>

          <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
        </div>
        <div class="wgt-clear xxsmall" ></div>

        <var id="wgt-tab-<?php echo $idPrefix ?>_desc-cfg-i18n-input-tab" >
        {
          "key":"<?php echo $idPrefix; ?>-description",
          "inp_prefix":"permission[description]",
          "form_id":"<?php echo $formId; ?>",
          "tab_id":"wgt-tab-<?php echo $idPrefix ?>_desc"
        }
        </var>

      </div>
      <div class="wgt-clear small" ></div>


    </div>

  </div>
</div>
