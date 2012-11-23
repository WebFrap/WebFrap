<?php 

$thisPath = dirname(__FILE__).'/';
$basePath = realpath(dirname(__FILE__).'/../../base/maintab/').'/';

$docu = $VAR->node;
/*@var $docu BdlNodeEnum */


$idPrefix   = 'docu-'.$docu->getName();
$nodeKey    = 'docu';
$formId     = 'wgt-form-bdl_'.$idPrefix;

$iconDel = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );

$titles     = $docu->getTitles();
$contents   = $docu->getContents();

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
  action="ajax.php?c=Daidalos.BdlNode_Docu.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
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
  <legend>Docu Data</legend>
  
  <div class="left bw3" >
    <?php 
    echo WgtForm::input
    ( 
      'Name', 
      $idPrefix.'-name', 
      $docu->getName(), 
      array
      (
        'name'=> $nodeKey.'[name]'
      ), 
      $formId 
    );  
    


    ?>
  </div>
  
  <div class="right bw3" >
    <?php 
    echo WgtForm::autocomplete
    ( 
      'Module', 
      $idPrefix.'-module', 
      $docu->getModule(), 
      'ajax.php?c=Bdl.Module_Service.autocomplete&amp;key=',
      array
      (
        'name' => $nodeKey.'[module]'
      ), 
      $formId 
    ); 
    ?>
  </div>
  
</fieldset>

<?php include $thisPath.'block_title.tpl' ?>
<?php include $thisPath.'block_content.tpl' ?>


    </div>

  </div>
</div>
