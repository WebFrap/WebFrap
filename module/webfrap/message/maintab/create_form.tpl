<?php

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm  = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Message.sendUserMessage'
    .'&amp;element='.$VAR->elementKey,
  'wbf-message-form',
  'post'
);
$cntForm->form();


$itemType = $cntForm->loadQuery( 'WebfrapContactItemType_Checklist' );
$itemType->fetch();

$defTextMsg = <<<HTML

HTML;


?>

<div class="bw62 wgt-space" >

  <div class="left bw6" >
    <?php $cntForm->autocomplete(
    	 'Receiver',
    	 'receiver',
      '',
      'ajax.php?c=Webfrap.Message.loadUser&key=',
      array(),
      array('size'=>'xxlarge', 'entityMode' => true )
    ); ?>
  </div>

  <div class="left bw3" >
    <?php $cntForm->multiSelectByKey(
      'Channels',
      'channels[]',
      'WebfrapContactItemType_Checklist',
      $itemType->getAll(),
      array('mail','message')
    ); ?>
  </div>

  <div class="inline bw3" >
    <?php  $cntForm->selectboxByKey(
      'Confidentiality Level',
      'confidential',
      'WbfsysConfidential_Selectbox',
      EWebfrapConfidential::$labels
    ); ?>

    <?php  $cntForm->ratingbar
    (
      'Importance',
      'importance',
      2,
      array(
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
      '',
      array(),
      array
      (
      	 'size'=>'xxlarge',
        'plain'=>true
      )
    ); ?></div>
    <div class="content bw6"  >
     <?php $cntForm->wysiwyg( 'Message', 'message', $defTextMsg, array(), array('plain'=>true)); ?>
    </div>
  </div>


  <div class="wgt-clear medium" >&nbsp;</div>

</div>