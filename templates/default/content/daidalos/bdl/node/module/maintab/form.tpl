<?php 

$thisPath = dirname(__FILE__).'/';
$nodeKey  = 'module';

$module = $VAR->node;
/*@var $module BdlNodeModule */

$formId = 'wgt-form-bdl_module-'.$module->getName();
$idPrefix = 'module-'.$module->getName();

$iconDel = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );

$labels       = $module->getLabels();
$descriptions = $module->getDescriptions();
$docus        = $module->getDocus();
$shortDescs   = $module->getShortDesc();

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
  action="ajax.php?c=Daidalos.BdlNode_Module.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
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
      <legend>Module Data</legend>
      
      <div class="left bw6" >
        <?php 
        echo WgtForm::input
        ( 
          'Name', 
          $idPrefix.'-name', 
          $module->getName(), 
          array
          (
            'name'=> $nodeKey.'[name]'
          ), 
          $formId 
        ); 
        ?>
      </div>
    
      
    </fieldset>

<?php include $thisPath.'block_label.tpl' ?>
<?php include $thisPath.'block_shortdesc.tpl' ?>

    </div>
    
<?php include $thisPath.'tab_docu.tpl' ?>
<?php include $thisPath.'tab_access.tpl' ?>


  </div>
</div>
