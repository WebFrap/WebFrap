<?php 

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm  = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Contact.insert',
  'webfrap-contact-create',
  'post'
);
$cntForm->form();



?>
<fieldset class="wgt-space bw62" style="height:530px;" >
  <legend>Create new Contact</legend>
  
  <div class="bw3 left" >
    <h3>Data</h3>
  	<?php $cntForm->input( 'Surname', 'person[firstname]', null ); ?>
    <?php $cntForm->input( 'Lastname', 'person[lastname]', null ); ?>
    <?php $cntForm->input( 'Academic title', 'person[academic_title]', null ); ?>
    <?php $cntForm->input( 'Noblesse title', 'person[noblesse_title]', null ); ?>
  </div>
  
  <div class="bw3 inline" >
    <h3>Image</h3>
    <div style="height:90px;" >Image</div>
    <?php $cntForm->upload( 'Image', 'person[image]', null ); ?>
  </div>
  
  <div class="wgt-clear small wgt-border-bottom" style="width:96%;margin:0px auto;" >&nbsp;</div>
  <div class="wgt-clear small" >&nbsp;</div>
  
  <div class="bw3 left" >
    <h3>Personal Data</h3>
    <?php $cntForm->input( 'Birthday', 'person[birthday]', null ); ?>
    <?php $cntForm->input( 'Language', 'person[id_preflang]', null ); ?>
    <?php $cntForm->input( 'Nationality', 'person[id_nationality]', null ); ?>
    <?php $cntForm->textarea( 
    	'Comment', 
    	'contact[description]', 
      null, 
      array( 'style'=>"width:265px;" ), 
      array('size'=>'large') 
    );?>
  </div>
  
  <div class="bw3 inline" >
    <div class="bw3 left" >
      <div class="left" ><h3>Contact Items</h3></div>
      <div class="right" ><button class="wgt-button" ><i class="icon-plus-sign" ></i></button></div>
    </div>
    <div class="left" style="height:250px;overflow:auto;" >
    <?php $cntForm->input( 'E-Mail', 'contact_item[email][birthday]', null ); ?>
    <?php $cntForm->input( 'Mobile', 'contact_item[mobile][birthday]', null ); ?>
    <?php $cntForm->input( 'Skype', 'contact_item[skype][birthday]', null ); ?>
    </div>
  </div>
  
  <div class="wgt-clear small wgt-border-bottom" style="width:96%;margin:0px auto;" >&nbsp;</div>
  <div class="wgt-clear small" >&nbsp;</div>
  
  <div class="bw61 left alr" style="text-align:right;" >
    <button 
      class="wgt-button" ><i class="icon-remove" ></i> Chancel</button> 
    | 
    <?php $cntForm->submit( '<i class="icon-save" > </i> Create Contact', '$S.modal.close();' ); ?>
  </div>
  
</fieldset>