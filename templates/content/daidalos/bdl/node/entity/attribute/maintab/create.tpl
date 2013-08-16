<?php 

$thisPath = dirname(__FILE__).'/';


/*@var $backpath BdlEntityAttribute */
$idPrefix = 'entity-attribute-create';
$formId = 'wgt-form-bdl_'.$idPrefix;


$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );

// selectbox languages
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

<var id="select_src-<?php echo $idPrefix ?>-type" >
<?php echo $ELEMENT->selectType->buildJson(); ?>
</var>

<var id="select_src-<?php echo $idPrefix ?>-validator" >
<?php echo $ELEMENT->selectValidator->buildJson(); ?>
</var>

<var id="select_src-<?php echo $idPrefix ?>-is_a" >
<?php echo $ELEMENT->selectDefinition->buildJson(); ?>
</var>


<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_EntityAttribute.insert&amp;key=<?php 
    echo $VAR->key ?>&amp;bdl_file=<?php 
    echo $VAR->bdlFile ?>"
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
        <legend>Base Data</legend>
        
        <div class="left bw3" >
          <?php 
          
          echo WgtForm::input
          ( 
            'Name', 
            $idPrefix.'-name', 
            '', 
            array
            (
              'name' => 'attribute[name]'
            ), 
            $formId 
          );
          
          
          echo WgtForm::autocomplete
          ( 
            'Target', 
            $idPrefix.'-target', 
            '', 
            'ajax.php?c=Bdl.Entity_Service.autocomplete&amp;key=',
            array
            (
              'name' => 'attribute[target]'
            ), 
            $formId 
          );

          echo WgtForm::input
          ( 
            'Category', 
            $idPrefix.'-category', 
            'default', 
            array
            (
              'name' => 'attribute[category]'
            ), 
            $formId 
          );
          
          ?>
        </div>
        
        <div class="right bw3" >
          <?php 
          
          /*
          echo WgtForm::autocomplete
          ( 
            'Is A', 
            $idPrefix.'-is_a', 
            '', 
            'ajax.php?c=Bdl.Definition_Service.autocomplete&amp;key=',
            array
            (
              'name' => 'attribute[is_a]'
            ), 
            $formId 
          );
          */ 
          
          echo WgtForm::decorateInput
          ( 
            'Is A', 
            'wgt-select-'.$idPrefix.'-is_a', 
            <<<HTML
<select 
      id="wgt-select-{$idPrefix}-is_a" 
      name="attribute[is_a]" 
      data_source="select_src-{$idPrefix}-is_a"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option> </option>
    </select>
HTML
          ); 
          
          echo WgtForm::decorateInput
          ( 
            'Type', 
            'wgt-select-'.$idPrefix.'-type', 
            <<<HTML
<select 
      id="wgt-select-{$idPrefix}-type" 
      name="attribute[type]" 
      data_source="select_src-{$idPrefix}-type"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option> </option>
    </select>
HTML
          ); 

          
          echo WgtForm::input
          ( 
            'Size', 
            $idPrefix.'-size', 
            '', 
            array
            (
              'name' => 'attribute[size]'
            ), 
            $formId 
          );
          
          echo WgtForm::decorateInput
          ( 
            'Validator', 
            'wgt-select-'.$idPrefix.'-validator', 
            <<<HTML
<select 
      id="wgt-select-{$idPrefix}-validator" 
      name="attribute[validator]" 
      data_source="select_src-{$idPrefix}-validator"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option> </option>
    </select>
HTML
          ); 

          
          ?>
        </div>
        
      </fieldset>

      <fieldset class="wgt-space bw61" >
        <legend>Constraints</legend>
        
        <div class="left bw3" >
          <?php 
          echo WgtForm::checkbox
          ( 
            'Required', 
            $idPrefix.'-required', 
            false, 
            array
            (
              'name' => 'attribute[required]'
            ), 
            $formId 
          ); 
          
          echo WgtForm::checkbox
          ( 
            'Unique', 
            $idPrefix.'-unique', 
            false, 
            array
            (
              'name' => 'attribute[unique]'
            ), 
            $formId 
          );
          
          ?>
        </div>
        
        <div class="right bw3" >
          <?php 
          echo WgtForm::input
          ( 
            'Min Size', 
            $idPrefix.'-min_size', 
            '', 
            array
            (
              'name' => 'attribute[min_size]'
            ), 
            $formId 
          );
          
          echo WgtForm::input
          ( 
            'Max Size', 
            $idPrefix.'-max_size', 
            '', 
            array
            (
              'name' => 'attribute[max_size]'
            ), 
            $formId 
          );

          
          ?>
        </div>
        
      </fieldset>

      <fieldset class="wgt-space bw61" >
        <legend>Tech</legend>
        
        <div class="left bw3" >
          <?php 
          echo WgtForm::input
          ( 
            'Index', 
            $idPrefix.'-index', 
            '', 
            array
            (
              'name' => 'attribute[index]'
            ), 
            $formId 
          );
          ?>
        </div>
        
        <div class="right bw3" >
          <?php 

          
          ?>
        </div>
        
      </fieldset>

      <div class="wgt-clear small" ></div>

    </div>

  </div>
</div>
