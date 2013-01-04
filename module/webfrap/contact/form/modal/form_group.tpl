<?php 

$orm = $this->getOrm();
$cntForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.ContactForm.sendGroupMessage&amp;refid='.$VAR->refId.'&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-contact_form-group',
  'post'
);
$cntForm->form();


$confidentialData = $cntForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$itemType = $cntForm->loadQuery( 'WebfrapContactItemType_Checklist' );
$itemType->fetch();

?>


<?php echo Debug::dumpToString( $VAR->groupData, true ); ?>

<table style="width:100%" >
  <tr>
    <td colspan="2" >
      <?php $cntForm->input( 'Title', 'title', null, array(), array('size'=>'xxlarge')  ); ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" >
      <?php $cntForm->input( 'Receiver', 'receiver', null, array(), array('size'=>'xxlarge')  ); ?>
    </td>
  </tr>
  <tr>
    <td valign="top" >
    <?php $cntForm->multiSelectByKey
    ( 
      'Dispatch Type', 
      'dispatch', 
      'WebfrapContactItemType_Checklist', 
      $itemType->getAll(),
      array('mail','message')
    ); ?>
    </td>
    <td valign="top" >
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
    </td>
  </td>
  <tr>
    <td colspan="2" >
      <?php $cntForm->wysiwyg( 'Message', 'message', null, array(), array('plain'=>true)); ?>
    </td>
  </td>
  <tr>
    <td>
    </td>
    <td valign="bottom" align="right" >
      <?php $cntForm->submit( 'Send Message', '$S.modal.close();' ); ?>
    </td>
  </tr>
</table>

