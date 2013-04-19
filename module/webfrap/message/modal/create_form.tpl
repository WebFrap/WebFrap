<?php 

// sicher stellen, dass die benötigten Resourcen vorhanden sind
$orm  = $this->getOrm();
$user = $this->getUser();

$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.ContactForm.sendUserMessage'
    .'&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-message-form',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'WebfrapContactItemType_Checklist' );
$itemType->fetch();



$defTextMsg = <<<HTML

HTML;


?>
<fieldset>
  <legend>Message</legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $cntForm->input
          ( 
          	 'Subject', 
          	 'subject', 
            '', 
            array(), 
            array
            (
            	 'size'=>'xxlarge'
              )  
          ); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" >
          <?php $cntForm->input
          ( 
          	 'Receiver', 
          	 'receiver', 
            '', 
            array(), 
            array('size'=>'xxlarge',)  
          ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
        <?php $cntForm->multiSelectByKey
        ( 
          'Channels', 
          'channels[]', 
          'WebfrapContactItemType_Checklist', 
          $itemType->getAll(),
          array('mail','message')
        ); ?>
        </td>
        <td valign="top" >
        <?php  $cntForm->selectboxByKey
        ( 
          'Confidentiality Level', 
          'confidential', 
          'WbfsysConfidentiality_Selectbox', 
          $confidentialData->getAll(),
          $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'public' ) 
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
        </td>
      </td>
      <tr>
        <td colspan="2" >
          <?php $cntForm->wysiwyg( 'Message', 'message', $defTextMsg, array(), array('plain'=>true)); ?>
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right"  >
          <div style="padding-top:15px;" >
            <?php $cntForm->submit( 'Send Message', '$S.modal.close();' ); ?>
          </div>
        </td>
      </tr>
    </table>

</fieldset>