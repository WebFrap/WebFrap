<?php 


$thisPath = dirname(__FILE__).'/';
$basePath = realpath(dirname(__FILE__).'/../../base/maintab/').'/';

$profile = $VAR->node;
/*@var $profile BdlNodeProfile */

$nodeKey = 'profile';
$idPrefix = 'profile-'.$profile->getName();
$formId = 'wgt-form-bdl_'.$idPrefix;

$iconDel = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );
$iconEdit = Wgt::icon( 'control/edit.png', 'xsmall', 'Edit' );

$labels = $profile->getLabels();
$shortDescs = $profile->getShortDesc();
$docus = $profile->getDocus();

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

<var id="select_src-profile-lang" >
[
<?php echo $langCode; ?>
]
</var>


<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_Profile.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
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
  <legend>Profile Data</legend>
  
  <div class="left bw3" >
    <?php 
    echo WgtForm::input
    ( 
      'Name', 
      'profile-name', 
      $profile->getName(), 
      array
      (
        'name'=>'profile[name]'
      ), $formId 
    );
      
    echo WgtForm::input
    ( 
      'Extends', 
      'profile-extends', 
      $profile->getExtends(), 
      array
      (
        'name'=>'profile[extends]'
      ), 
      $formId 
    );
    
    echo WgtForm::input
    ( 
      'Module', 
      'profile-module', 
      $profile->getExtends(), 
      array
      (
        'name' => 'profile[module]'
      ), $formId 
    );
    
    ?>
  </div>
  
  <div class="right bw3" >
    <?php 
    echo WgtForm::input
    ( 
      'Panel', 
      'profile-panel', 
      $profile->getPanel(), 
      array
      (
        'name'=>'profile[panel]'
      ), 
      $formId 
    );
    
    echo WgtForm::input
    ( 
      'Desktop', 
      'profile-desktop', 
      $profile->getDesktop(), 
      array
      (
        'name'=>'profile[desktop]'
      ), 
      $formId 
    );
    
    echo WgtForm::input
    ( 
      'Mainmenu', 
      'profile-mainmenu', 
      $profile->getMainmenu(), 
      array
      (
        'name'=>'profile[mainmenu]'
      ), 
      $formId 
    );
    
    echo WgtForm::input
    ( 
      'Navigation', 
      'profile-navigation', 
      $profile->getNavigation(), 
      array
      (
        'name'=>'profile[navigation]'
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
<?php include $thisPath.'tab_permission.tpl' ?>
<?php include $thisPath.'tab_backpath.tpl' ?>
<?php include $thisPath.'tab_process.tpl' ?>

    
  </div>
</div>
