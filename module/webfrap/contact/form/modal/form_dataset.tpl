<?php 

$orm = $this->getOrm();
$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.ContactForm.sendDsetMessage&amp;refid='.$VAR->refId.'&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-contact_form-dset',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'WebfrapContactItemType_Checklist' );
$itemType->fetch();

$iconDel = $this->icon('control/delete.png','Delete');
//echo Debug::dumpToString( $VAR->groupData, true );

?>
<div class="wgt-panel title" ><h2>All Participants for: <?php echo $VAR->entity->text() ?></h2></div>

<div class="wgt-layout-grid" >

  <?php $cntForm->input( 'Subject', 'subject', null, array(), array('size'=>'xxlarge')  ); ?>
  <?php // $cntForm->input( 'Receiver', 'receiver', null, array(), array('size'=>'xxlarge')  ); ?>
  <div class="wgt-input-list" >
    <label>Receivers</label>
    <ul 
      class="wgt-input-list" 
      style="margin-left:0px;" >
      <?php foreach( $VAR->users as $user ){ ?>
      <li id="wgt-contact_form-dset-<?php echo $user->id ?>" >
        <label><?php echo $user->nickname ?> &lt;<?php echo $user->lastname ?>, <?php echo $user->firstname ?>&gt;</label>
        <div><button 
          class="wgt-button"
          onclick="$S('#wgt-contact_form-dset-<?php echo $user->id ?>').remove();" ><?php echo $iconDel ?></button></div>
        <input 
          type="hidden" 
          class="<?php echo $cntForm->asgd() ?>" 
          name="user[]" 
          value="<?php echo $user->id ?>" />
      </li>
      <?php } ?>
    </ul>
    <div class="wgt-clear" >&nbsp;</div>
  </div>
  
  <div>
    <div class="left bw25" >
    <?php $cntForm->multiSelectByKey
    ( 
      'Channels', 
      'channels[]', 
      'WebfrapContactItemType_Checklist', 
      $itemType->getAll(),
      array('mail','message')
    ); ?>
    </div>
    <div  class="inline bw3"  >
    <?php  $cntForm->selectboxByKey
    ( 
      'Confidentiality Level', 
      'id_confidentiality', 
      'WbfsysConfidentialityLevel_Selectbox', 
      $confidentialData->getAll(),
      $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'restricted' ) 
    ); ?>
    
    <?php  $cntForm->ratingbar
    ( 
      'Importance', 
      'importance', 
      2,
      array
      ( 
        1 => 'Low',
        2 => 'Medium',
        3 => 'High',
      ),
      array(),
      array( 'starParts' => 1 )
    ); ?>
    </div>
  </div>
  
  <div class="left" > 
    <?php $cntForm->wysiwyg( 'Message', 'message', null, array(), array('plain'=>true)); ?>
  </div>
  
  <div class="wgt-clear medium" >&nbsp;</div>
  
  <div class="left bw4" >
    <!--  Attachments-->
  </div>
  
  <div class="right" >
    <?php $cntForm->submit( 'Send Message', '$S.modal.close();' ); ?>
  </div>
  
  <div class="wgt-clear" >&nbsp;</div>
  
</div>

