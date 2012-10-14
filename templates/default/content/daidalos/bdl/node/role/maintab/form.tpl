<?php 

$thisPath = dirname(__FILE__).'/';

$role = $VAR->node;
/*@var $role BdlRole */


$idPrefix = 'role-'.$role->getName();
$formId = 'wgt-form-bdl_'.$idPrefix;

$iconAdd  = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );
$iconEdit = Wgt::icon( 'control/edit.png', 'xsmall', 'Edit' );
$iconDel  = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );

$labels       = $role->getLabels();
$descriptions = $role->getDescriptions();
$docus        = $role->getDocus();

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

<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_Role.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
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
  <legend>Role Data</legend>
  
  <div class="left bw3" >
    <?php 
    echo WgtForm::input
    ( 
      'Name', 
      $idPrefix.'-name', 
      $role->getName(), 
      array
      (
        'name'=>'role[name]'
      ), $formId 
    );  
    
    echo WgtForm::input
    ( 
      'Module', 
      $idPrefix.'-module', 
      $role->getModule(), 
      array
      (
        'name' => 'role[module]'
      ), $formId 
    ); 
    ?>
  </div>
  
  <div class="right bw3" >
    
  </div>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Labels</legend>
  
  <div id="wgt-i18n-list-role-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    <?php 
      echo WgtForm::input
      ( 
        'Label', 
        $idPrefix.'-new-label-text', 
        '',
        array
        ( 
          'name'  => 'label[text]',
          'class' => 'medium wgte-text'
        )  
      ); 
    ?>
    
    <?php 
      echo WgtForm::decorateInput
      ( 
        'Lang', 
        'wgt-select-'.$idPrefix.'-new-label-lang', 
        <<<HTML
<select 
      id="wgt-select-{$idPrefix}-new-label-lang" 
      name="label[lang]" 
      data_source="select_src-{$idPrefix}-lang"
      class="wcm wcm_widget_selectbox wgte-lang"
        >
        <option>Select a language</option>
    </select>
HTML
      ); 
    ?>

    <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
  </div>
  
  <div class="right bw3" >
    <ul class="wgte-list"  >
    <?php 
      foreach( $labels as $lang => $label )
      {
        echo '<li class="lang-'.$lang.'" >'. WgtForm::input
        ( 
          'Lang '.Wgt::icon( 'flags/'.$lang.'.png', 'xsmall', array(), '' ), 
          'role-label-'.$lang, 
          $label, array
          (
            'name'  => 'role[label]['.$lang.']',
            'class' => 'medium lang-'.$lang
          ), 
          $formId,
          '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
        ).'</li>';
      }
    ?>
    </ul>
  </div>
  
  <var id="wgt-i18n-list-role-label-cfg-i18n-input-list" >
  {
    "key":"role-label",
    "inp_prefix":"role[label]",
    "form_id":"<?php echo $formId; ?>"
  }
  </var>
  
  </div>
  
</fieldset>



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
      title="<?php echo $lang ?>" 
      wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  
      class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_desc" >
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
            'name' => 'role[description]['.$lang.']',
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
    "inp_prefix":"role[description]",
    "form_id":"<?php echo $formId; ?>",
    "tab_id":"wgt-tab-<?php echo $idPrefix ?>_desc"
  }
  </var>
  
</div>
<div class="wgt-clear small" ></div>


    </div>
    
<?php include $thisPath.'tab_docu.tpl' ?>
<?php include $thisPath.'tab_permission.tpl' ?>
<?php include $thisPath.'tab_backpath.tpl' ?>

  </div>
</div>
