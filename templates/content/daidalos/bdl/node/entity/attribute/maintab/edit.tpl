<?php 

$thisPath = dirname(__FILE__).'/';

$attribute = $VAR->node;
/*@var $attribute BdlNodeEntityAttribute */

$entityNode  = $VAR->entityNode;
/*@var $entityNode BdlNodeEntity */

$idPrefix = 'entity-'.$entityNode->getName().'-attribute-edit-'.$VAR->idx;
$formId   = 'wgt-form-bdl_'.$idPrefix;
$fKeyName = 'attribute';


$iconAdd  = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );
$iconDel  = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );

$labels       = $attribute->getLabels(); 
$descriptions = $attribute->getDescriptions();
$docus        = $attribute->getDocus();


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

<var id="select_src-<?php echo $idPrefix ?>-isa" >
<?php echo $ELEMENT->selectDefinition->buildJson(); ?>
</var>

<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_EntityAttribute.update&amp;key=<?php 
    echo $VAR->key ?>&amp;bdl_file=<?php 
    echo $VAR->bdlFile ?>&amp;idx=<?php 
    echo $VAR->idx ?>"
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
        <legend>Base Data</legend>
        
        <div class="left bw3" >
          <?php 
          
          echo WgtForm::input
          ( 
            'Name', 
            $idPrefix.'-name', 
            $attribute->getName(), 
            array
            (
              'name' => $fKeyName.'[name]'
            ), 
            $formId 
          );
          
          
          echo WgtForm::autocomplete
          ( 
            'Target', 
            $idPrefix.'-target', 
            $attribute->getTarget(), 
            'ajax.php?c=Bdl.Entity_Service.autocomplete&amp;key=',
            array
            (
              'name' => $fKeyName.'[target]'
            ), 
            $formId 
          );

          echo WgtForm::input
          ( 
            'Category', 
            $idPrefix.'-category', 
            $attribute->getCategory(), 
            array
            (
              'name' => $fKeyName.'[category]'
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
              'name' => $fKeyName.'[is_a]'
            ), 
            $formId 
          );
          */ 
          
          echo WgtForm::decorateInput
          ( 
            'Definition', 
            'wgt-select-'.$idPrefix.'-is_a', 
            <<<HTML
<select 
      id="wgt-select-{$idPrefix}-is_a" 
      name="{$fKeyName}[is_a]" 
      data_source="select_src-{$idPrefix}-isa"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option selected="selected" value="{$attribute->getIsA()}" >{$attribute->getIsA()}</option>
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
      name="{$fKeyName}[type]" 
      data_source="select_src-{$idPrefix}-type"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option selected="selected" value="{$attribute->getType()}" >{$attribute->getType()}</option>
    </select>
HTML
          ); 

          
          echo WgtForm::input
          ( 
            'Size', 
            $idPrefix.'-size', 
            $attribute->getSize(), 
            array
            (
              'name' => $fKeyName.'[size]'
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
      name="{$fKeyName}[validator]" 
      data_source="select_src-{$idPrefix}-validator"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option selected="selected" value="{$attribute->getValidator()}" >{$attribute->getValidator()}</option>
    </select>
HTML
          ); 

          
          ?>
        </div>
        
      </fieldset>
      
      <fieldset class="wgt-space bw61" >
        <legend>Labels</legend>
        
        <div id="wgt-i18n-list-<?php echo $idPrefix ?>-label" class="wcm wcm_widget_i18n-input-list bw6" >
      
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
                  $idPrefix.'-label-'.$lang, 
                  $label, array
                  (
                    'name'  => $fKeyName.'[label]['.$lang.']',
                    'class' => 'medium lang-'.$lang
                  ), 
                  $formId,
                  '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
                ).'</li>';
              }
            ?>
            </ul>
          </div>
  
          <var id="wgt-i18n-list-entity-label-cfg-i18n-input-list" >
          {
            "key":"<?php echo $idPrefix ?>-label",
            "inp_prefix":"attribute[label]",
            "form_id":"<?php echo $formId; ?>"
          }
          </var>
        
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
            $attribute->getRequired(true), 
            array
            (
              'name' => $fKeyName.'[required]'
            ), 
            $formId 
          ); 
          
          echo WgtForm::checkbox
          ( 
            'Unique', 
            $idPrefix.'-unique', 
            $attribute->getUnique(), 
            array
            (
              'name' => $fKeyName.'[unique]'
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
            $attribute->getMinSize(), 
            array
            (
              'name' => $fKeyName.'[min_size]'
            ), 
            $formId 
          );
          
          echo WgtForm::input
          ( 
            'Max Size', 
            $idPrefix.'-max_size', 
            $attribute->getMaxSize(), 
            array
            (
              'name' => $fKeyName.'[max_size]'
            ), 
            $formId 
          );

          
          ?>
        </div>
        
      </fieldset>

      <fieldset class="wgt-space bw61" >
        <legend>Search</legend>
        
        <div class="left bw3" >
          <?php 
          echo WgtForm::checkbox
          ( 
            'Search Free', 
            $idPrefix.'-search_free', 
            $attribute->getSearchFree(), 
            array
            (
              'name' => $fKeyName.'[search_free]'
            ), 
            $formId 
          ); 
          
          echo WgtForm::input
          ( 
            'Search Type', 
            $idPrefix.'-search_type', 
            $attribute->getSearchType(), 
            array
            (
              'name' => $fKeyName.'[search_type]'
            ), 
            $formId 
          );
          ?>
        </div>
        
        <div class="right bw3" >
          <?php 
          echo WgtForm::input
          ( 
            'Index', 
            $idPrefix.'-index', 
            $attribute->getIndex(), 
            array
            (
              'name' => $fKeyName.'[index]'
            ), 
            $formId 
          );
          ?>
        </div>
        
      </fieldset>

      <div class="wgt-clear small" ></div>


    </div>

<?php include $thisPath.'tab_description.tpl' ?>
<?php include $thisPath.'tab_docu.tpl' ?>

  </div>
</div>
