<?php 

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm  = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Message.sendReply&amp;objid='.$VAR->msgNode->msg_id.'&amp;element='.$VAR->elementKey,
  'wbf-message-reply-form',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'WebfrapContactItemType_Checklist' );
$itemType->fetch();

?>

<div class="bw62 wgt-space" >
 
  <div class="left bw6" >
    <?php $cntForm->input('Receiver', '_receiver', $VAR->msgNode->sender_name, array( 'readonly' => 'readonly' ), array('size'=>'xxlarge') ); ?>
    <?php $cntForm->hidden( 'receiver', $VAR->msgNode->sender_id  ); ?>
  </div>

  <div class="left bw3" >
    <?php $cntForm->multiSelectByKey
    ( 
      'Channels', 
      'channels[]', 
      'WebfrapContactItemType_Checklist', 
      $itemType->getAll(),
      array('mail','message')
    ); ?>
  </div>
  
  <div class="inline bw3" >
    <?php  $cntForm->selectboxByKey
    ( 
      'Confidentiality Level', 
      'id_confidentiality', 
      'WbfsysConfidentialityLevel_Selectbox', 
      $confidentialData->getAll(),
      $VAR->msgNode->priority
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
  
  <div class="left wgt-content_box bw6 wgt-space">
    <div class="head" ><label>Subject: </label><?php $cntForm->input
    ( 
    	'Subject', 
    	'subject', 
      'Re: '.$VAR->msgNode->title, 
      array(), 
      array
      (
      	'size'=>'xxlarge',
        'plain'=>true
      )  
    ); ?></div>
    <div class="content bw6"  >
     <?php $cntForm->wysiwyg( 'Message', 'message', '<em>'.$VAR->msgNode->message.'</em>', array(), array('plain'=>true)); ?>
    </div>
  </div>
   
  
  <div class="wgt-clear medium" >&nbsp;</div>

</div>