<?php 

$thisPath  = dirname(__FILE__).'/';

$ref       = $VAR->node;
/* @var $ref BdlNodeBaseAreaPermissionRef */

$profile   = $VAR->profile;
/* @var $profile BdlNodeProfile */

$formId   = 'wgt-form-bdl_profile-'.$profile->getName().'-ref-edit-'.$VAR->pathId;
$idPrefix = 'profile-ref-edit-'.$VAR->pathId;

$iconAdd  = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );


$descriptions = $ref->getDescriptions();


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

<var id="select_src-ref-lang-<?php echo $VAR->pathId ?>" >
[
<?php echo $langCode; ?>
]
</var>

<var id="select_src-ref-level-<?php echo $VAR->pathId ?>" >
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
  action="ajax.php?c=Daidalos.BdlNode_ProfilePermission.updateRef&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>&amp;path=<?php echo $VAR->path ?>"
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
      <legend>Reference Data</legend>
      
      <div class="left bw6" >
        <?php 
        
        $extUrl = '';
        if( $ref->isFirstChild() )
        {
          $extUrl = '&parent_key='.$ref->treeParent->getName();
        }
        else 
        {
          $extUrl = '&ref_key='.$ref->treeParent->getName();
        }
      
        echo WgtForm::autocomplete
        ( 
          'Name', 
          $idPrefix.'-name', 
          $ref->getName(), 
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
          'wgt-select-ref-level-'.$VAR->pathId, 
        <<<HTML
<select 
      id="wgt-select-ref-level-{$VAR->pathId}" 
      name="ref[level]" 
      data_source="select_src-ref-level-{$VAR->pathId}"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option value="{$ref->getLevel()}" >{$ref->getLevel()}</option>
    </select>
HTML
        ); 
        
        
        ?>
      </div>

    </fieldset>

      <div class="wgt-clear small" ></div>
      
      <div 
        id="wgt-tab-<?php echo $idPrefix ?>_desc" 
        class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
        <div 
          id="wgt-tab-<?php echo $idPrefix ?>_desc-head" 
          class="wgt_tab_head wgt-corner-top" >
      
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
                'ref-description-'.$lang, 
                $description, 
                array
                ( 
                  'name' => 'ref[description]['.$lang.']',
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
            id="wgt-select-ref-lang-<?php echo $VAR->pathId ?>" 
            name="label[lang]" 
            data_source="select_src-ref-lang-<?php echo $VAR->pathId ?>"
            class="wcm wcm_widget_selectbox wgte-lang" >
            <option>Select a language</option>
          </select>
          
          <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
        </div>
        <div class="wgt-clear xxsmall" ></div>
        
        <var id="wgt-tab-<?php echo $idPrefix ?>_desc-cfg-i18n-input-tab" >
        {
          "key":"ref-description",
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
