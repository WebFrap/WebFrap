<?php 

$thisPath = dirname(__FILE__).'/';

$backpath = $VAR->node;
$profile  = $VAR->profile;

/*@var $profile BdlEntity */
$idPrefix = 'profile-'.$profile->getName().'-backpath-edit-'.$VAR->idx;
$formId   = 'wgt-form-bdl_'.$idPrefix;


$iconAdd  = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );


$descriptions = $backpath->getDescriptions();


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
  action="ajax.php?c=Daidalos.BdlNode_ProfileBackpath.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>&amp;idx=<?php echo $VAR->idx ?>"
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
          'backpath-name-'.$VAR->idx, 
          $backpath->getName(), 
          array
          (
            'name'=>'backpath[name]'
          ), 
          $formId 
        );

        ?>
      </div>
      
      <div class="right bw3" >

      </div>
      
    </fieldset>
    
    <fieldset class="wgt-space bw61" >
      <legend>Set Permissions</legend>
      
      <div class="left bw3" >
        <?php 
        
        echo WgtForm::decorateInput
        ( 
          'Level', 
          'wgt-select-backpath-level-'.$VAR->idx, 
        <<<HTML
<select 
      id="wgt-select-backpath-level-{$VAR->idx}" 
      name="backpath[level]" 
      data_source="select_src-{$idPrefix}-level"
      class="wcm wcm_widget_selectbox asgd-{$formId}"
        >
        <option value="{$backpath->getLevel()}" >{$backpath->getLevel()}</option>
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
      
      <div class="wgt-panel wgt-border-top" >
        <div class="left bw1" ><h3>Checks</h3></div>
        <div class="inline bw2" >
          <button class="wgt-button wgta-append-check" ><?php echo $iconAdd ?> Add Check</button>
        </div>
      </div>

    </div>

<?php include $thisPath.'tab_description.tpl' ?>

  </div>
</div>
