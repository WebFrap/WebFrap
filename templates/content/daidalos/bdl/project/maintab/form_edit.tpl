<?php 
$proj = $VAR->project;
/*@var $proj BdlProject */
$formId = 'wgt-form-bdl_project-'.$VAR->key;

?>

<form 
  id="wgt-form-bdl_project-<?php echo $VAR->key ?>"
  action="ajax.php?c=Daidalos.BdlModeller.update"
></form>

<fieldset class="wgt-space bw61" >
  <legend>Project Data</legend>
  
  <div class="left bw3" >
    <?php echo WgtForm::input( 'Name', 'project[name]', $proj->getName(), array(), $formId ); ?>
    <?php echo WgtForm::input( 'Title', 'project[title]', $proj->getTitle(), array(), $formId ); ?>
    <?php echo WgtForm::input( 'Key', 'project[key]', $proj->getKey(), array(), $formId ); ?>
  </div>
  
  <div class="right bw3" >
    <?php echo WgtForm::input( 'Copyright', 'project[copyright]', $proj->getCopyright(), array(), $formId ); ?>
    <?php echo WgtForm::input( 'Author', 'project[author]', $proj->getAuthor(), array(), $formId ); ?>
    <?php echo WgtForm::input( 'Licence', 'project[licence]', $proj->getLicence(), array(), $formId ); ?>
    <?php echo WgtForm::input( 'Url', 'project[url]', $proj->getUrl(), array(), $formId ); ?>
    <?php echo WgtForm::input( 'Header', 'project[header]', $proj->getHeader(), array(), $formId ); ?>
  </div>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Variables</legend>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Settings</legend>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Concepts</legend>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Languages</legend>
  
</fieldset>


<fieldset class="wgt-space bw61" >
  <legend>Paths</legend>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Databases</legend>

</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Import</legend>

</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Repositories</legend>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Deployment</legend>

</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Architecture Nodes</legend>

</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Architecture Cartridges</legend>

</fieldset>