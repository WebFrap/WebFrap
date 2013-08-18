<?php 

$thisPath = dirname(__FILE__).'/';
$basePath = realpath(dirname(__FILE__).'/../../base/maintab/').'/';

$desktop = $VAR->node;
/*@var $enum BdlNodeDesktop */


$idPrefix = 'desktop-'.$desktop->getName();
$nodeKey = 'desktop';
$formId = 'wgt-form-bdl_'.$idPrefix;

$iconDel = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );

$labels = $desktop->getLabels();
$shortDescs = $desktop->getShortDesc();
$docus = $desktop->getDocus();

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

<var id="select_src-desktop-lang" >
[
<?php echo $langCode; ?>
]
</var>

<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_Desktop.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
  method="put"
></form>

<div id="<?php echo $this->tabId ?>" class="wcm wcm_ui_tab" >
  <div class="wgt_tab_body" >

  <!-- tab name:default -->
  <div
    class="wgt_tab <?php echo $this->tabId ?>"
    id="<?php echo $this->tabId ?>-tab-base_data"
    title="Base Data" >

<fieldset class="wgt-space bw61" >
  <legend>Desktop Data</legend>
  
  <div class="left bw3" >
    <?php 
    echo WgtForm::input
    ( 
      'Name', 
      $idPrefix.'-name', 
      $desktop->getName(), 
      array
      (
        'name'=> $nodeKey.'[name]'
      ), 
      $formId 
    );  
    
    echo WgtForm::input
    ( 
      'Extends', 
      $idPrefix.'-extends', 
      $desktop->getExtends(), 
      array
      (
        'name' => $nodeKey.'[extends]'
      ), 
      $formId 
    );  
    
    echo WgtForm::autocomplete
    ( 
      array(
      'Module',
      <<<TEXT
Über das Modul Feld kann eine explizite Zuordnung zu einem bestimmten Modul
vorgenommen werden.
TEXT
      ),
      $idPrefix.'-module', 
      $desktop->getModule(), 
      'ajax.php?c=Bdl.Module_Service.autocomplete&amp;key=',
      array
      (
        'name' => $nodeKey.'[module]'
      ), 
      $formId 
    ); 
    
    ?>
  </div>
  
  <div class="right bw3" >
    <?php 
    
    echo WgtForm::input
    ( 
      'Navigation', 
      $idPrefix.'-navigation', 
      $desktop->getNavigationName(), 
      array
      (
        'name'=> $nodeKey.'[navigation]'
      ), 
      $formId 
    );  
    
    echo WgtForm::input
    ( 
      'Tree', 
      $idPrefix.'-tree', 
      $desktop->getTreeName(), 
      array
      (
        'name'=> $nodeKey.'[tree]'
      ), 
      $formId 
    );  
    
    echo WgtForm::input
    ( 
      'Workarea', 
      $idPrefix.'-workarea', 
      $desktop->getWorkareaName(), 
      array
      (
        'name'=> $nodeKey.'[workarea]'
      ), 
      $formId 
    ); 
    
    ?>
  </div>
  
</fieldset>

<?php include $basePath.'block_label.tpl' ?>
<?php include $basePath.'block_shortdesc.tpl' ?>


    </div>
    
<?php include $basePath.'tab_docu.tpl' ?>

    
    
  </div>
</div>
